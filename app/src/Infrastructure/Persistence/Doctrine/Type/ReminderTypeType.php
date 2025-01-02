<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Reminder\ValueObject\ReminderType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ReminderTypeType extends Type
{
    public const string NAME = 'reminder_type_type';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ReminderType ? $value->getValue() : (is_string($value) ? $value : null);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?ReminderType
    {
        return !empty($value) && is_string($value) ? new ReminderType($value) : null;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }
}
