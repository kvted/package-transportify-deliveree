<?php

use Orchestra\Testbench\TestCase;
use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Validation\ExtraService;

class ExtraServiceValidationTest extends TestCase
{
    /**
     * @test
     * @testdox it should validate time type
     * @return void
     * @throws InvalidArgumentException
     */
    public function setTimeType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new ExtraService();
        $delivery->setTimeType('TYPE');
    }
}