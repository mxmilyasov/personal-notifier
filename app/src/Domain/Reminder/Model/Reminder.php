<?php

declare(strict_types=1);

namespace App\Domain\Reminder\Model;

use App\Domain\Reminder\ValueObject\ReminderType;
use App\Domain\Reminder\ValueObject\RepeatInterval;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\User\Model\User;
use App\Infrastructure\Persistence\Doctrine\Type\ReminderTypeType;
use App\Infrastructure\Persistence\Doctrine\Type\RepeatIntervalType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME)]
final readonly class Reminder
{
    final public const string TABLE_NAME = 'reminders';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid_type')]
    private Id $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $subject;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $date;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text;

    #[ORM\Column(type: ReminderTypeType::NAME, length: 20)]
    private ReminderType $type;

    #[ORM\Column(type: RepeatIntervalType::NAME, length: 20)]
    private RepeatInterval $repeatInterval;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isCompleted;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        User $user,
        string $subject,
        \DateTimeImmutable $date,
        ReminderType $type,
        RepeatInterval $repeatInterval,
        ?string $text = null,
    ) {
        $this->id = Id::create();
        $this->user = $user;
        $this->subject = $subject;
        $this->date = $date;
        $this->type = $type;
        $this->repeatInterval = $repeatInterval;
        $this->text = $text;
        $this->isCompleted = false;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDate(): string
    {
        return $this->date->format('Y-m-d H:i:s');
    }
}
