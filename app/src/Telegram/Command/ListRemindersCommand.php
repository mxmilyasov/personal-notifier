<?php

declare(strict_types=1);

namespace App\Telegram\Command;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

final class ListRemindersCommand extends Command
{
    protected string $command = 'list';

    protected ?string $description = 'List reminders';

    public function handle(Nutgram $bot): void
    {
    }
}
