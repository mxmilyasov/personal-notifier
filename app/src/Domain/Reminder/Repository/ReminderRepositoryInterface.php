<?php

declare(strict_types=1);

namespace App\Domain\Reminder\Repository;

use App\Domain\Reminder\Model\Reminder;
use App\Domain\Shared\ValueObject\Id;

interface ReminderRepositoryInterface
{
    public function add(Reminder $reminder): void;

    /**
     * @return Reminder[]
     */
    public function findAllByUserId(Id $userId): array;

    public function findOneByUserId(Id $userId): ?Reminder;
}
