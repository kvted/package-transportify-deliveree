<?php

namespace MsysCorp\TransportifyDeliveree\Validation;

use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Lookups\TimeType;

class DeliveryQuote
{
    use Validation;

    protected string $timeType;
    protected ?string $pickupTime;
    protected int $vehicleTypeId;
    protected array $locations;
    protected array $packs;
    protected ?array $extraServices;

    /**
     *
     */
    public function __construct(){}

    /**
     * @return string
     */
    public function getTimeType(): string
    {
        return $this->timeType;
    }

    /**
     * @param string $timeType
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setTimeType(string $timeType): DeliveryQuote
    {
        if (!$this->validateTimeType($timeType)) {
            throw new InvalidArgumentException('Invalid Selected Time Type ff. ('. implode(',' ,TimeType::TIME_TYPE) .').');
        }

        $this->timeType = $timeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPickupTime(): string
    {
        return $this->timeType;
    }

    /**
     * @param string $pickupTime
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setPickupTime(string $pickupTime): DeliveryQuote
    {
        if (!$this->validatePickUpTime($pickupTime)) {
            throw new InvalidArgumentException('Invalid Date Format');
        }

        $this->pickupTime = $pickupTime;

        return $this;
    }


    /**
     * @return int|null
     */
    public function getVehicleTypeId(): ?int
    {
        return $this->vehicleTypeId ?? null;
    }

    /**
     * @param string|null $vehicleTypeId
     * @return $this
     */
    public function setVehicleTypeId(?string $vehicleTypeId): DeliveryQuote
    {
        $this->vehicleTypeId = $vehicleTypeId;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getPacks() : ?array
    {
        return $this->packs ?? null;
    }

    /**
     * @param array $packs
     * @return DeliveryQuote
     * @throws InvalidArgumentException
     */
    public function setPacks(array $packs) : DeliveryQuote
    {
        if (!empty($packs) && !$this->validatePacksArray($packs)) {
            throw new InvalidArgumentException();
        }

        $this->packs = $packs;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getLocations() : ?array
    {
        return $this->locations ?? null;
    }

    /**
     * @param array $locations
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setLocations(array $locations) : DeliveryQuote
    {
        if (!empty($packs) || !$this->validateLocationArray($locations)) {
            throw new InvalidArgumentException();
        }
        $this->locations = $locations;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getExtraServices() : ?array
    {
        return $this->extraServices ?? [];
    }

    /**
     * @param array $extraServices
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setExtraServices(array $extraServices) : DeliveryQuote
    {
        if (!empty($packs) || !$this->validateExtraServicesArray($extraServices)) {
            throw new InvalidArgumentException();
        }
        $this->extraServices = $extraServices;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'time_type' => $this->getTimeType(),
            'pickup_time' => $this->getPickupTime(),
            'vehicle_type_id' => $this->getVehicleTypeId(),
            'packs' => $this->getPacks(),
            'locations' => $this->getLocations(),
            'extra_services' => $this->getExtraServices()
        ]);
    }
}