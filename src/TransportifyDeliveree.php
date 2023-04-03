<?php

namespace MsysCorp\TransportifyDeliveree;

use MsysCorp\TransportifyDeliveree\Validation\Delivery;
use MsysCorp\TransportifyDeliveree\Validation\DeliveryQuote;
use MsysCorp\TransportifyDeliveree\Validation\ExtraService;
use MsysCorp\TransportifyDeliveree\Validation\Paginate;

interface TransportifyDeliveree
{
    /**
     * @return array
     */
    public function fetchVehicleType(): array;

    /**
     * @param DeliveryQuote $payload
     * @return array
     */
    public function createDeliveryQuote(DeliveryQuote $payload): array;

    /**
     * @param Delivery $payload
     * @return array
     */
    public function createDelivery(Delivery $payload) : array;

    /**
     * @param string $deliveryId
     * @return array
     */
    public function fetchDeliveryDetails(string $deliveryId) : array;

    /**
     * @param string $deliveryId
     * @return array
     */
    public function cancelDelivery(string $deliveryId) : array;

    /**
     * @param Paginate $payload
     * @return array
     */
    public function fetchDeliveryList(Paginate $payload) : array;

    /**
     * @param ExtraService $payload
     * @param int $vehicleTypeId
     * @return array
     */
    public function fetchExtraServices(ExtraService $payload, int $vehicleTypeId) : array;

    /**
     * @return array
     */
    public function fetchUserProfile() : array;
}