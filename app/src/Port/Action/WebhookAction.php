<?php

declare(strict_types=1);

namespace App\Port\Action;

use App\Telegram\Command\ListRemindersCommand;
use App\Telegram\Command\StartCommand;
use App\Telegram\Middleware\ListRemindersMiddleware;
use App\Telegram\Middleware\UserCreatorMiddleware;
use SergiX44\Nutgram\Nutgram;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/webhook', name: self::class, methods: ['POST'])]
final readonly class WebhookAction
{
    public function __invoke(Nutgram $bot): JsonResponse
    {
        $bot
            ->onCommand('start', StartCommand::class)
            ->middleware(UserCreatorMiddleware::class);

        $bot
            ->onCommand('list', ListRemindersCommand::class)
            ->middleware(ListRemindersMiddleware::class);

        $bot->run();

        return new JsonResponse();
    }
}
