<?php

use Orchestra\Testbench\TestCase;
use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Validation\DeliveryQuote;

class DeliveryQuoteValidationTest extends TestCase
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
        $delivery = new DeliveryQuote();
        $delivery->setTimeType('TYPE');
    }

    /**
     * @test
     * @testdox it should validate pickup time
     * @return void
     * @throws InvalidArgumentException
     */
    public function setPickupTime(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new DeliveryQuote();
        $delivery->setPickupTime(now()->format('d/m/y'));
    }

    /**
     * @test
     * @testdox it should validate packs
     * @return void
     * @throws InvalidArgumentException
     */
    public function setPacks(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new DeliveryQuote();
        $delivery->setPacks([
            []
        ]);
    }

    /**
     * @test
     * @testdox it should validate location
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLocations(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new DeliveryQuote();
        $delivery->setLocations([
            []
        ]);
    }

    /**
     * @test
     * @testdox it should validate extra services
     * @return void
     * @throws InvalidArgumentException
     */
    public function setExtraServices(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new DeliveryQuote();
        $delivery->setExtraServices([
            []
        ]);
    }
}