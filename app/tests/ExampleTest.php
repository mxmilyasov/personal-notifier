<?php

declare(strict_types=1);

namespace App\Tests;

use App\Example;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testOne(): void
    {
        $example = new Example(400, 4);
        $result = $example->test();

        $this->assertEquals(404, $result);
    }
}
