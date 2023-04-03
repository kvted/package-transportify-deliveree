<?php

namespace MsysCorp\TransportifyDeliveree;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use MsysCorp\TransportifyDeliveree\Exception\BadRequestException;
use MsysCorp\TransportifyDeliveree\Exception\TransportifyDelivereeServerException;
use MsysCorp\TransportifyDeliveree\Validation\Delivery;
use MsysCorp\TransportifyDeliveree\Validation\DeliveryQuote;
use MsysCorp\TransportifyDeliveree\Validation\ExtraService;
use MsysCorp\TransportifyDeliveree\Validation\Paginate;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Client implements TransportifyDeliveree
{
    protected string $authKey;
    protected array $guzzle;
    protected $httpClient;
    private string $apiBaseUri;
    private string $languge;

    /**
     * Client constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->apiBaseUri = $config['api_base_uri'];
        $this->authKey = $config['api_key'];
        $this->languge = 'en';
        $this->guzzle = $config['guzzle'] ?? [];
    }

    /**
     * Get an instance of the Guzzle HTTP client.
     *
     * @param string $baseUri
     * @return HttpClient
     */
    protected function httpClient(string $baseUri): HttpClient
    {
        $this->guzzle['base_uri'] = $baseUri;
        $this->httpClient = new HttpClient($this->guzzle);
        return $this->httpClient;
    }

    /**
     * @param DeliveryQuote $payload
     * @return array
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function createDeliveryQuote(DeliveryQuote $payload): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->post('/deliveries/get_quote', [
                RequestOptions::JSON => $payload->toArray(),
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return $this->responseToArray($response);
    }

    /**
     * @param Delivery $payload
     * @return array
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function createDelivery(Delivery $payload): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->post('/deliveries', [
                RequestOptions::JSON => $payload->toArray(),
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return $this->responseToArray($response);
    }

    /**
     * @param string $deliveryId
     * @return array
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function fetchDeliveryDetails(string $deliveryId): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->get('/deliveries/'.$deliveryId, [
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return $this->responseToArray($response);
    }

    /**
     * @param string $deliveryId
     * @return array[]
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function cancelDelivery(string $deliveryId): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->post('/deliveries/'.$deliveryId.'/cancel', [
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return [
            'data' => [
                'message' => 'Delivery canceled!',
                'status' => $response->getStatusCode()
            ]
        ];
    }

    /**
     * @param Paginate $payload
     * @return array
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function fetchDeliveryList(Paginate $payload): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->get('/deliveries', [
                RequestOptions::JSON => $payload->toArray(),
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return $this->responseToArray($response);
    }

    /**
     * @param ExtraService $payload
     * @param int $vehicleTypeId
     * @return array
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function fetchExtraServices(ExtraService $payload, int $vehicleTypeId): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->get('/vehicle_types/'.$vehicleTypeId.'/extra_services', [
                RequestOptions::JSON => $payload->toArray(),
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return $this->responseToArray($response);
    }

    /**
     * @return array
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function fetchVehicleType(): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->get('/vehicle_types', [
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return $this->responseToArray($response);
    }


    /**
     * @return array
     * @throws BadRequestException
     * @throws GuzzleException
     * @throws TransportifyDelivereeServerException
     */
    public function fetchUserProfile(): array
    {
        try {
            $response = $this->httpClient($this->apiBaseUri)->post('/customers/user_profile', [
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authKey,
                    'Accept-Language' => $this->languge,
                ],
            ]);
        } catch (ClientException $error) {
            $this->throwBadRequest($error);
        } catch (ServerException $error) {
            $this->throwGeneralError($error);
        }
        return $this->responseToArray($response);
    }


    /**
     * @param Exception|ServerException $error
     * @return void
     * @throws TransportifyDelivereeServerException
     */
    private function throwGeneralError(Exception|ServerException $error): void
    {
        $response = $this->responseToArray($error->getResponse());
        $exception = new TransportifyDelivereeServerException($response['error'] ?? $response['message'] ?? "");
        $exception->setResponse($response);
        throw $exception;
    }

    /**
     * @param ClientException|Exception $error
     * @return void
     * @throws BadRequestException
     */
    private function throwBadRequest(ClientException|Exception $error): void
    {
        $response = $this->responseToArray($error->getResponse());
        $exception = new BadRequestException(Arr::get($response, 'message'), $error->getCode());
        $exception->setResponse($response);
        throw $exception;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function responseToArray(ResponseInterface $response): array
    {
        $contents = $response->getBody()->getContents();
        return json_decode($contents, true);
    }
}