<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\Shared\ValueObject\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME)]
class User
{
    final public const string TABLE_NAME = 'users';

    #[ORM\Id]
    #[ORM\Column(type: Id::TYPE)]
    private Id $id;

    #[ORM\Column(type: Types::INTEGER)]
    private int $telegramId;

    #[ORM\Column(type: Types::STRING)]
    private string $username;

    #[ORM\Column(type: Types::STRING)]
    private string $firstName;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $lastName;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Id $id,
        int $telegramId,
        string $username,
        string $firstName,
        ?string $lastName,
    ) {
        $this->id = $id;
        $this->telegramId = $telegramId;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getTelegramId(): int
    {
        return $this->telegramId;
    }
}
