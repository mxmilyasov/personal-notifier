<?php

declare(strict_types=1);

namespace App\Port\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: self::class, methods: ['GET'])]
final class IndexAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['success' => true]);
    }
}
