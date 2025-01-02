<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Reminder\ValueObject\RepeatInterval;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class RepeatIntervalType extends Type
{
    public const string NAME = 'repeat_interval_type';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value instanceof RepeatInterval ? $value->getValue() : (is_string($value) ? $value : null);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?RepeatInterval
    {
        return !empty($value) && is_string($value) ? new RepeatInterval($value) : null;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }
}
