<?php

use Orchestra\Testbench\TestCase;
use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Validation\Paginate;

class PaginateValidationTest extends TestCase
{
    /**
     * @test
     * @testdox it should validate from date
     * @return void
     * @throws InvalidArgumentException
     */
    public function setFromDate(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Paginate();
        $delivery->setFromDate(now()->format('d-m-y'));
    }

    /**
     * @test
     * @testdox it should validate to date
     * @return void
     * @throws InvalidArgumentException
     */
    public function setToDate(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Paginate();
        $delivery->setToDate(now()->format('d-m-y'));
    }

    /**
     * @test
     * @testdox it should validate status
     * @return void
     * @throws InvalidArgumentException
     */
    public function setStatus(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Paginate();
        $delivery->setStatus('TEST');
    }

    /**
     * @test
     * @testdox it should validate order by
     * @return void
     * @throws InvalidArgumentException
     */
    public function setOrderBy(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Paginate();
        $delivery->setOrderBy('TEST');
    }

    /**
     * @test
     * @testdox it should validate sort by
     * @return void
     * @throws InvalidArgumentException
     */
    public function setSortBy(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $delivery = new Paginate();
        $delivery->setSortBy('TEST');
    }
}