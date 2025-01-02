<?php

declare(strict_types=1);

namespace App\Domain\Reminder\ValueObject;

use App\Domain\Shared\Interface\ValueObjectInterface;
use Webmozart\Assert\Assert;

final readonly class ReminderType implements ValueObjectInterface, \Stringable
{
    public const string ONE_TIME = 'one-time';

    public const string REPEATABLE = 'repeatable';

    public const array VALUES = [
        self::ONE_TIME,
        self::REPEATABLE,
    ];

    public function __construct(
        private string $value,
    ) {
        Assert::notEmpty($value);
        Assert::oneOf($value, self::VALUES);
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
