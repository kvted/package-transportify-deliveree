<?php

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Application;
use MsysCorp\TransportifyDeliveree\Client;
use MsysCorp\TransportifyDeliveree\TransportifyDeliveree;
use Orchestra\Testbench\TestCase;
use MsysCorp\TransportifyDeliveree\ServiceProvider;
use MsysCorp\TransportifyDeliveree\Exception\BadRequestException;
use MsysCorp\TransportifyDeliveree\Exception\TransportifyDelivereeServerException;
use MsysCorp\TransportifyDeliveree\Validation\DeliveryQuote;
use MsysCorp\TransportifyDeliveree\Lookups\TimeType;
use MsysCorp\TransportifyDeliveree\Validation\Delivery;
use MsysCorp\TransportifyDeliveree\Validation\Paginate;
use MsysCorp\TransportifyDeliveree\Lookups\DeliveryStatus;
use MsysCorp\TransportifyDeliveree\Validation\ExtraService;
use MsysCorp\TransportifyDeliveree\Lookups\BookingPaymentType;

class ClientTest extends TestCase
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
     * @testdox it should create complete delivery quote
     * @return void
     */
    public function createCompleteDeliveryQuote(): void
    {
        $payload = $this->createDeliveryQuote();
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuote.json'));

        $response = $this->service()->createDeliveryQuote($payload)['data'][0];

        $this->assertIsArray($response);
        $payload = $payload->toArray();
        $this->assertEquals($payload['time_type'], $response['vehicle_type']['quick_choices'][0]['time_type']);
        $this->assertEquals($payload['vehicle_type_id'], $response['vehicle_type']['id']);
    }

    /**
     * @test
     * @testdox it should handle error
     */
    public function createCompleteDeliveryQuoteError(): void
    {
        $payload = $this->createDeliveryQuote();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->createDeliveryQuote($payload);
    }

    /**
     * @test
     * @testdox it should handle server error
     */
    public function createCompleteDeliveryQuoteServerError(): void
    {
        $payload = $this->createDeliveryQuote();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->createDeliveryQuote($payload);
    }

    /**
     * @test
     * @testdox it should create complete delivery
     * @return void
     */
    public function createCompleteDelivery(): void
    {
        $payload = $this->createDelivery();
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDelivery.json'));

        $response = $this->service()->createDelivery($payload);

        $this->assertIsArray($response);
        $payload = $payload->toArray();
        $this->assertEquals($payload['time_type'], $response['time_type']);
        $this->assertEquals($payload['vehicle_type_id'], $response['vehicle_type_id']);
        $this->assertEquals($payload['note'], $response['note']);
        $this->assertEquals($payload['job_order_number'], $response['job_order_number']);
    }


    /**
     * @test
     * @testdox it should handle delivery error
     */
    public function createCompleteDeliveryError(): void
    {
        $payload = $this->createDelivery();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->createDelivery($payload);
    }

    /**
     * @test
     * @testdox it should handle delivery server error
     */
    public function createCompleteDeliveryServerError(): void
    {
        $payload = $this->createDelivery();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->createDelivery($payload);
    }

    /**
     * @test
     * @testdox it should fetch delivery details
     * @return void
     */
    public function fetchDeliveryDetails() : void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getDeliveryDetails.json'));

        $response = $this->service()->fetchDeliveryDetails(100);

        $this->assertIsArray($response);
        $this->assertEquals(100, $response['id']);
    }

    /**
     * @test
     * @testdox it should handle delivery details error
     */
    public function fetchDeliveryDetailsError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->fetchDeliveryDetails(100);
    }

    /**
     * @test
     * @testdox it should handle delivery details server error
     */
    public function fetchDeliveryDetailsServerError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->fetchDeliveryDetails(100);
    }

    /**
     * @test
     * @testdox it should cancel delivery
     * @return void
     */
    public function cancelDelivery() : void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/cancelDelivery.json'),204);

        $response = $this->service()->cancelDelivery(100);

        $this->assertIsArray($response);
        $this->assertEquals('Delivery canceled!', $response['data']['message']);
        $this->assertEquals(204, $response['data']['status']);
    }

    /**
     * @test
     * @testdox it should handle cancelling delivery error
     */
    public function cancelDeliveryError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->cancelDelivery(100);
    }

    /**
     * @test
     * @testdox it should handle canceling delivery server error
     */
    public function cancelDeliveryServerError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->cancelDelivery(100);
    }

    /**
     * @test
     * @testdox it should fetch delivery list with pagination payload
     * @return void
     */
    public function fetchDeliveryListWithPaginatePayload() : void
    {
        $payload = $this->createPaginateData();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getDeliveryList.json'));

        $response = $this->service()->fetchDeliveryList($payload);

        $this->assertIsArray($response);
        $this->assertEquals($response, json_decode(file_get_contents(__DIR__ . '/Responses/getDeliveryList.json'),true));
    }

    /**
     * @test
     * @testdox it should handle error on delivery list with pagination payload
     */
    public function fetchDeliveryListWithPaginateError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->fetchDeliveryList($this->createEmptyPaginateData());
    }

    /**
     * @test
     * @testdox it should handle server error on delivery list with pagination payload
     */
    public function fetchDeliveryListWithPaginateServerError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/createDeliveryQuoteFail.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->fetchDeliveryList($this->createEmptyPaginateData());
    }

    /**
     * @test
     * @testdox it should fetch vehicle types
     */
    public function fetchVehicleTypes(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'));

        $response = $this->service()->fetchVehicleType();

        $this->assertEquals($response, json_decode(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'),true));
    }

    /**
     * @test
     * @testdox it should handle error on vehicle types
     */
    public function fetchVehicleTypesError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->fetchVehicleType();
    }

    /**
     * @test
     * @testdox it should handle server error on vehicle types
     */
    public function fetchVehicleTypesServerError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->fetchVehicleType();
    }

    /**
     * @test
     * @testdox it should fet extra services
     */
    public function fetchExtraServices(): void
    {
        $payload = $this->createExtraServices();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getExtraService.json'));

        $response = $this->service()->fetchExtraServices($payload,21);

        $this->assertEquals($response, json_decode(file_get_contents(__DIR__ . '/Responses/getExtraService.json'),true));
    }

    /**
     * @test
     * @testdox it should handle error on extra services
     */
    public function fetchExtraServicesError(): void
    {
        $payload = $this->createExtraServices();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->fetchExtraServices($payload, 21);
    }

    /**
     * @test
     * @testdox it should handle server error on extra services
     */
    public function fetchExtraServerError(): void
    {
        $payload = $this->createExtraServices();

        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->fetchExtraServices($payload, 21);
    }

    /**
     * @test
     * @testdox it should fetch user profile
     */
    public function fetchUserProfile(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getUserProfile.json'));

        $response = $this->service()->fetchUserProfile();

        $this->assertEquals($response, json_decode(file_get_contents(__DIR__ . '/Responses/getUserProfile.json'),true));
    }

    /**
     * @test
     * @testdox it should handle error on user profile
     */
    public function fetchUserProfileError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'), 400);

        $this->expectException(BadRequestException::class);

        $this->service()->fetchUserProfile();
    }

    /**
     * @test
     * @testdox it should handle server error on user profile
     */
    public function fetchUserServerError(): void
    {
        $this->mockResponse(file_get_contents(__DIR__ . '/Responses/getVehicleTypes.json'), 500);

        $this->expectException(TransportifyDelivereeServerException::class);

        $this->service()->fetchUserProfile();
    }


    /**
     * @return DeliveryQuote
     * @throws \MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException
     */
    private function createDeliveryQuote(): DeliveryQuote
    {
        $payload = new DeliveryQuote();
        $payload->setTimeType(TimeType::NOW);
        $payload->setPickupTime(now());
        $payload->setVehicleTypeId('21');
        $payload->setPacks([
            [
                'dimensions' => [1,2,3],
                'weigth' => 100,
                'quantity' => 2
            ],
            [
                'dimensions' => [2,2,5],
                'weigth' => 20,
                'quantity' => 1
            ]
        ]);
        $payload->setLocations([
            [
                'address' => 'Sample address',
                'latitude' => -6.2608232,
                'longitude' => 106.7884168
            ],
            [
                'address' => 'Test address',
                'latitude' => -6.248446679393533,
                'longitude' => 106.84431951392108,
                'recipient_name' => 'Test name',
                'recipient_phone' => '+84903856534',
                'note' => 'Office test tower, 19th floor'
            ]
        ]);
        $payload->setExtraServices([
            [
                'extra_requirement_id' => 140,
                'selected_amount' => 1
            ],
            [
                'extra_requirement_id' => 416,
                'selected_amount' => 1,
                'extra_requirement_pricing_id' => 2146
            ]
        ]);


        return $payload;
    }

    /**
     * @return Delivery
     * @throws \MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException
     */
    private function createDelivery(): Delivery
    {
        $payload = new Delivery();
        $payload->setTimeType(TimeType::NOW);
        $payload->setPickupTime(now());
        $payload->setVehicleTypeId('1');
        $payload->setNote('Just a note');
        $payload->setJobOrderNumber('66666');
        $payload->setAllowParkingFees(true);
        $payload->setAllowTollsFees(true);
        $payload->setAllowWaitingTimeFees(true);
        $payload->setOptimizeRoute(true);
        $payload->setSendFirstToFavorite(true);
        $payload->setRequireSignature(true);
        $payload->setQuickChoice(true);
        $payload->setQuickChoiceId(1);
        $payload->setCustomerId(1);
        $payload->setBookingPaymentType(BookingPaymentType::CASH);
        $payload->setLocations([
            [
                'address' => 'Sample address',
                'latitude' => -6.2608232,
                'longitude' => 106.7884168
            ],
            [
                'address' => 'Test address',
                'latitude' => -6.248446679393533,
                'longitude' => 106.84431951392108,
                'recipient_name' => 'Test name',
                'recipient_phone' => '+84903856534',
                'note' => 'Office test tower, 19th floor'
            ]
        ]);
        $payload->setExtraServices([
            [
                'extra_requirement_id' => 140,
                'selected_amount' => 1
            ],
            [
                'extra_requirement_id' => 416,
                'selected_amount' => 1,
                'extra_requirement_pricing_id' => 2146
            ]
        ]);

        return $payload;
    }

    /**
     * @return Paginate
     * @throws \MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException
     */
    private function createPaginateData(): Paginate
    {
        $payload = new Paginate();
        $payload->setPage(1);
        $payload->setPerPage(1);
        $payload->setStatus(DeliveryStatus::DELIVERY_IN_PROGRESS);
        $payload->setFromDate(now()->format('d-m-Y'));
        $payload->setToDate(now()->format('d-m-Y'));
        $payload->setSearch('Search anything');
        $payload->setSortBy(\MsysCorp\TransportifyDeliveree\Lookups\Paginate::ID);
        $payload->setOrderBy(\MsysCorp\TransportifyDeliveree\Lookups\Paginate::ASC);

        return $payload;
    }

    /**
     * @return Paginate
     */
    private function createEmptyPaginateData(): Paginate
    {
        return new Paginate();
    }

    /**
     * @return ExtraService
     * @throws \MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException
     */
    private function createExtraServices(): ExtraService
    {
        $payload = new ExtraService();
        $payload->setTimeType(TimeType::NOW);
        $payload->setDropOffCount(1);

        return $payload;
    }
}