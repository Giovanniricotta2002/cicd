<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    public function testAddition()
    {
        $this->assertSame(8, 4+4);
    }

    public function testMultiplication()
    {
        $this->assertSame(32, 8*4);
    }
}