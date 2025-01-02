<?php

declare(strict_types=1);

namespace App\Domain\Reminder\ValueObject;

use App\Domain\Shared\Interface\ValueObjectInterface;
use Webmozart\Assert\Assert;

final readonly class RepeatInterval implements ValueObjectInterface, \Stringable
{
    public const string HOURLY = 'hourly';

    public const string DAILY = 'daily';

    public const string WEEKLY = 'weekly';

    public const string NONE = 'none';

    public const array VALUES = [
        self::HOURLY,
        self::DAILY,
        self::WEEKLY,
        self::NONE,
    ];

    public function __construct(
        private string $value,
    ) {
        Assert::notEmpty($value);
        Assert::oneOf($value, self::VALUES);
    }

    public static function createNone(): self
    {
        return new self(self::NONE);
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
