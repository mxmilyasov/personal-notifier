<?php

declare(strict_types=1);

namespace App\Telegram\Command;

use App\Telegram\Conversation\CreateReminderConversation;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

final class StartCommand extends Command
{
    protected string $command = 'start';

    protected ?string $description = 'A lovely start command';

    public function handle(Nutgram $bot): void
    {
        $username = $bot->user()?->username ?? 'Mr. Nobody';

        $bot->sendMessage(sprintf('Привет, %s! Я помогу тебе с напоминаниями.', $username));

        CreateReminderConversation::begin($bot);
    }
}
