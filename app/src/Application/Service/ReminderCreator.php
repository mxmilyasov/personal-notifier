<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Reminder\Model\Reminder;
use App\Domain\Reminder\Repository\ReminderRepositoryInterface;
use App\Domain\Reminder\ValueObject\ReminderType;
use App\Domain\Reminder\ValueObject\RepeatInterval;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ReminderCreator
{
    public function __construct(
        private ReminderRepositoryInterface $reminderRepository,
        private UserRepositoryInterface $userRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(
        int $telegramId,
        string $subject,
        \DateTimeImmutable $date,
        ReminderType $type,
        RepeatInterval $repeatInterval,
        string $text,
    ): void {
        $user = $this->userRepository->getByTelegramId($telegramId);
        $reminder = new Reminder(
            user: $user,
            subject: $subject,
            date: $date,
            type: $type,
            repeatInterval: $repeatInterval,
            text: $text,
        );

        $this->reminderRepository->add($reminder);

        $this->entityManager->flush();
    }
}
