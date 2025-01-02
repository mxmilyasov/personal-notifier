<?php

declare(strict_types=1);

namespace App\Telegram\Conversation;

use App\Application\Service\ReminderCreator;
use App\Domain\Reminder\ValueObject\ReminderType;
use App\Domain\Reminder\ValueObject\RepeatInterval;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

final class CreateReminderConversation extends Conversation
{
    public function __construct(
        private readonly ReminderCreator $reminderCreator,
        protected Nutgram $bot,
        protected ?string $step = 'askReminderType',
        public string $reminderType = '',
        public string $reminderSubject = '',
        public string $reminderDate = '',
    ) {
    }

    public function askReminderType(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: 'Выбери тип напоминания',
            reply_markup: InlineKeyboardMarkup::make()
                ->addRow(
                    InlineKeyboardButton::make('Единоразовое', callback_data: ReminderType::ONE_TIME),
                    InlineKeyboardButton::make('Повторяющееся', callback_data: ReminderType::REPEATABLE),
                ),
        );
        $this->next('askSubject');
    }

    public function askSubject(Nutgram $bot): void
    {
        if (!$bot->isCallbackQuery()) {
            $this->askReminderType($bot);

            return;
        }

        $this->reminderType = $bot->callbackQuery()?->data ?? '';

        $bot->sendMessage('Выбери название');
        $this->next('askDate');
    }

    public function askDate(Nutgram $bot): void
    {
        $this->reminderSubject = $bot->message()?->text ?? '';

        $bot->sendMessage('Выбери дату напоминания');
        $this->next('complete');
    }

    public function complete(Nutgram $bot): void
    {
        $this->reminderDate = $bot->message()?->text ?? '';

        $msg = sprintf(
            'You reminder is: subject - %s, type - %s, date - %s.',
            $this->reminderSubject,
            $this->reminderType,
            $this->reminderDate,
        );

        $bot->sendMessage($msg);

        $this->end();

        $botUser = $bot->user();
        if ($botUser === null) {
            throw new \RuntimeException('Bot user is not defined');
        }

        $this->reminderCreator->create(
            telegramId: $botUser->id,
            subject: $this->reminderSubject,
            date: new \DateTimeImmutable($this->reminderDate),
            type: new ReminderType($this->reminderType),
            repeatInterval: RepeatInterval::createNone(),
            text: '',
        );
    }
}
