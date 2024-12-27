<?php

declare(strict_types=1);

namespace App;

final readonly class Example
{
    public function __construct(
        private int $numOne,
        private int $numTwo,
    ) {
    }

    public function test(): int
    {
        return $this->numOne + $this->numTwo;
    }
}
