<?php

declare(strict_types=1);

namespace App\Telegram\Middleware;

use App\Domain\Reminder\Repository\ReminderRepositoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

final readonly class ListRemindersMiddleware
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ReminderRepositoryInterface $reminderRepository,
    ) {
    }

    public function __invoke(Nutgram $bot, Link $next): void
    {
        $botUser = $bot->user();
        if ($botUser === null) {
            throw new \RuntimeException('Bot user is not defined');
        }

        $bot->sendMessage(
            text: $this->getText($botUser->id),
            chat_id: $botUser->id,
            parse_mode: ParseMode::MARKDOWN,
        );

        $next($bot);
    }

    private function getText(int $userId): string
    {
        $user = $this->userRepository->getByTelegramId($userId);
        $reminders = $this->reminderRepository->findAllByUserId($user->getId());

        $text = '';
        foreach ($reminders as $reminder) {
            $text .= sprintf("%s, %s \\\n", $reminder->getSubject(), $reminder->getDate());
        }

        return $this->escapeMarkdown($text);
    }

    private function escapeMarkdown(string $text): string
    {
        return preg_replace_callback(
            '/[\\_*[\]()~`><&#+\-=|{}.!]/',
            fn(array $matches): string => '\\' . $matches[0],
            $text,
        );
    }
}
