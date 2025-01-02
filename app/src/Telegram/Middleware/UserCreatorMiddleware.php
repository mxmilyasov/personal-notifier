<?php

declare(strict_types=1);

namespace App\Telegram\Middleware;

use App\Application\Service\UserCreator;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;

final readonly class UserCreatorMiddleware
{
    public function __construct(
        private UserCreator $userCreator,
    ) {
    }

    public function __invoke(Nutgram $bot, Link $next): void
    {
        $botUser = $bot->user();
        if ($botUser === null || $botUser->username === null) {
            throw new \RuntimeException('Bot user is not defined');
        }

        $this->userCreator->create(
            telegramId: $botUser->id,
            username: $botUser->username,
            firstName: $botUser->first_name,
            lastName: $botUser->last_name,
        );

        $next($bot);
    }
}
