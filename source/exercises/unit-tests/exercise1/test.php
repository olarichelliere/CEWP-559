<?php

use PHPUnit\Framework\TestCase;


final class CalculatorTest extends TestCase
{
    public function testSum()
    {
        $calc = new Calculator();
        $this->assertEquals(4, $calc->sum(1, 3));
    }
    
        public function testMultiply()
    {
        $calc = new Calculator();
        $this->assertEquals(40, $calc->multiply(4, 10));
    }
}