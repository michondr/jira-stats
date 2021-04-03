<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    public static function assertEquals($expected, $actual, string $message = ''): void
    {
        parent::assertEquals($expected, $actual, $message);
    }
}