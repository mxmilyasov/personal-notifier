<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Shared\ValueObject\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class IdType extends Type
{
    public const string NAME = 'uuid_type';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Id ? $value->getValue() : (is_string($value) ? $value : null);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Id
    {
        return !empty($value) && is_string($value) ? new Id($value) : null;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }
}
