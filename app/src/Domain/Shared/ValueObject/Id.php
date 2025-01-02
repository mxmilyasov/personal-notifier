<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Interface\ValueObjectInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final readonly class Id implements ValueObjectInterface, \Stringable
{
    public const string TYPE = 'uuid_type';

    public const string DEFAULT = '00000000-0000-0000-0000-000000000000';

    public function __construct(
        private string $value,
    ) {
        Assert::notEmpty($value);
        Assert::uuid($value);
    }

    public static function create(): self
    {
        return new self(Uuid::v7()->toString());
    }

    public static function createDefault(): self
    {
        return new self(self::DEFAULT);
    }

    /**
     * @param string[] $ids
     *
     * @return self[]
     */
    public static function createForArray(array $ids): array
    {
        return array_map(static fn(string $id): Id => new self($id), $ids);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
