<?php

use Orchestra\Testbench\TestCase;
use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Validation\Delivery;

class DeliveryValidationTest extends TestCase
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
        $delivery = new Delivery();
        $delivery->setTimeType('TYPE');
    }

    /**
     * @test
     * @testdox it should validate pickup time
     * @return void
     * @throws InvalidArgumentException
     */
    public function setPickUpTime(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Delivery();
        $delivery->setPickupTime(now()->format('Y/d/m'));
    }

    /**
     * @test
     * @testdox it should validate location
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLocation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Delivery();
        $delivery->setLocations([[]]);
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
        $delivery = new Delivery();
        $delivery->setExtraServices([[]]);
    }

    /**
     * @test
     * @testdox it should validate booking payment type
     * @return void
     * @throws InvalidArgumentException
     */
    public function setBookingPaymentType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Delivery();
        $delivery->setBookingPaymentType('DEBIT');
    }
}