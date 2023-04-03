<?php

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Foundation\Application;
use MsysCorp\TransportifyDeliveree\Client;
use MsysCorp\TransportifyDeliveree\ServiceProvider;
use MsysCorp\TransportifyDeliveree\TransportifyDeliveree;
use MsysCorp\TransportifyDeliveree\Exception\BadRequestException;
use MsysCorp\TransportifyDeliveree\Exception\TransportifyDelivereeServerException;

class ExceptionTest extends TestCase
{
    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = require __DIR__ . '/../config/msyscorp_transportify_deliveree.php';
        $app['config']->set('msyscorp_transportify_deliveree', $config);
    }

    /**
     * @return Client
     */
    protected function service(): Client
    {
        return $this->app->make(TransportifyDeliveree::class);
    }

    /**
     * @param Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    /**
     * Mock response
     *
     * @param string $response
     * @param int $status
     * @param array $headers
     *
     * @return void
     */
    protected function mockResponse(
        string $response,
        int    $status = 200,
        array  $headers = []
    ): void
    {
        $mock = new MockHandler([new Response($status, $headers, $response)]);
        $handlerStack = HandlerStack::create($mock);
        $this->app['config']->set('msyscorp_transportify_deliveree.guzzle', ['handler' => $handlerStack]);
    }

    /**
     * @test
     * @testdox it should get response from server error exception
     */
    public function validateServerError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 500);
        try {
            $this->service()->fetchVehicleType();
        } catch (TransportifyDelivereeServerException $exception) {
            $this->assertNotEmpty($exception->getResponse());
        }
    }

    /**
     * @test
     * @testdox it should get response from bad request error exception
     */
    public function validateBadRequestError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 400);
        try {
            $this->service()->fetchVehicleType();
        } catch (BadRequestException $exception) {
            $this->assertNotEmpty($exception->getResponse());
        }
    }
}