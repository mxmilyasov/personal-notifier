<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserCreator
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(
        int $telegramId,
        string $username,
        string $firstName,
        ?string $lastName,
    ): void {
        $user = $this->userRepository->findByTelegramId($telegramId);
        if ($user === null) {
            $user = new User(
                id: Id::create(),
                telegramId: $telegramId,
                username: $username,
                firstName: $firstName,
                lastName: $lastName,
            );

            $this->userRepository->add($user);

            $this->entityManager->flush();
        }
    }
}
