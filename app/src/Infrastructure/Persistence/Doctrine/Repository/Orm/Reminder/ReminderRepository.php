<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Orm\Reminder;

use App\Domain\Reminder\Model\Reminder;
use App\Domain\Reminder\Repository\ReminderRepositoryInterface;
use App\Domain\Shared\ValueObject\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class ReminderRepository implements ReminderRepositoryInterface
{
    /** @var EntityRepository<Reminder> */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(Reminder::class);
    }

    public function add(Reminder $reminder): void
    {
        $this->entityManager->persist($reminder);
    }

    public function findOneByUserId(Id $userId): ?Reminder
    {
        return $this->repository->findOneBy(['user' => $userId->getValue()]);
    }

    public function findAllByUserId(Id $userId): array
    {
        return $this->repository->findBy(['user' => $userId->getValue()]);
    }
}
