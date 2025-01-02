<?php

declare(strict_types=1);

namespace App\Domain\Shared\Interface;

interface ValueObjectInterface
{
    public function getValue(): string|int|bool|array|float;
}
