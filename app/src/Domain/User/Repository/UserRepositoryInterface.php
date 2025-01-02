<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function findByTelegramId(int $telegramId): ?User;

    public function getByTelegramId(int $telegramId): User;
}
