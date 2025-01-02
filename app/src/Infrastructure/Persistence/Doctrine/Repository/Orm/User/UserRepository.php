<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Orm\User;

use App\Domain\Shared\Exception\EntityNotFoundException;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class UserRepository implements UserRepositoryInterface
{
    /** @var EntityRepository<User> */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function findByTelegramId(int $telegramId): ?User
    {
        return $this->repository->findOneBy(['telegramId' => $telegramId]);
    }

    public function getByTelegramId(int $telegramId): User
    {
        $user = $this->repository->findOneBy(['telegramId' => $telegramId]);

        if ($user === null) {
            throw new EntityNotFoundException('User not found');
        }

        return $user;
    }
}
