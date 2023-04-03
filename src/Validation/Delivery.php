<?php

namespace MsysCorp\TransportifyDeliveree\Validation;

use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Lookups\TimeType;

class Delivery
{
    use Validation;

    protected string $timeType;
    protected ?string $pickupTime;
    protected int $vehicleTypeId;
    protected array $locations;
    protected array $packs;
    protected ?array $extraServices;
    protected ?int $customerId;
    protected string $bookingPaymentType;
    protected ?string $jobOrderNumber;
    protected ?bool $allowParkingFees;
    protected ?bool $allowTollsFees;
    protected ?bool $allowWaitingTimeFees;
    protected ?bool $optimizeRoute;
    protected ?bool $sendFirstToFavorite;
    protected ?bool $requireSignature;
    protected ?bool $quickChoice;
    protected ?int $quickChoiceId;
    protected ?string $note;

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
    public function setTimeType(string $timeType): Delivery
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
    public function setPickupTime(string $pickupTime): Delivery
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
    public function setVehicleTypeId(?string $vehicleTypeId): Delivery
    {
        $this->vehicleTypeId = $vehicleTypeId;
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
    public function setLocations(array $locations) : Delivery
    {
        if (!empty($locations) && !$this->validateLocationArray($locations)) {
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
    public function setExtraServices(array $extraServices) : Delivery
    {
        if (!empty($packs) || !$this->validateExtraServicesArray($extraServices)) {
            throw new InvalidArgumentException();
        }
        $this->extraServices = $extraServices;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getCustomerId() : ?int
    {
        return $this->customerId ?? null;
    }

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId(int $customerId) : Delivery
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBookingPaymentType() : ?string
    {
        return $this->bookingPaymentType ?? null;
    }

    /**
     * @param string $bookingPaymentType
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setBookingPaymentType(string $bookingPaymentType) : Delivery
    {
        if (!is_null($bookingPaymentType) && !$this->validateBookingPaymentType($bookingPaymentType)) {
            throw new InvalidArgumentException();
        }

        $this->bookingPaymentType = $bookingPaymentType;

        return $this;
    }

    /**
     * @param string $note
     * @return $this
     */
    public function setNote(string $note) : Delivery
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getNote() : ?string
    {
        return $this->note ?? null;
    }

    /**
     * @param string $jobOrderNumber
     * @return $this
     */
    public function setJobOrderNumber(string $jobOrderNumber) : Delivery
    {
        $this->jobOrderNumber = $jobOrderNumber;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getJobOrderNumber() : ?string
    {
        return $this->jobOrderNumber ?? null;
    }

    /**
     * @param string $allowParkingFees
     * @return Delivery
     */
    public function setAllowParkingFees(string $allowParkingFees) : Delivery
    {
        $this->allowParkingFees = $allowParkingFees;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAllowParkingFees() : ?bool
    {
        return $this->allowParkingFees ?? null;
    }

    /**
     * @param string $allowParkingFees
     * @return Delivery
     */
    public function setAllowTollsFees(string $allowParkingFees) : Delivery
    {
        $this->allowTollsFees = $allowParkingFees;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAllowTollsFees() : ?bool
    {
        return $this->allowTollsFees ?? null;
    }

    /**
     * @param string $allowWaitingTimeFees
     * @return $this
     */
    public function setAllowWaitingTimeFees(string $allowWaitingTimeFees) : Delivery
    {
        $this->allowWaitingTimeFees = $allowWaitingTimeFees;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAllowWaitingTimeFees() : ?bool
    {
        return $this->allowWaitingTimeFees ?? null;
    }

    /**
     * @param string $optimizeRoute
     * @return $this
     */
    public function setOptimizeRoute(string $optimizeRoute) : Delivery
    {
        $this->optimizeRoute = $optimizeRoute;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptimizeRoute() : ?bool
    {
        return $this->optimizeRoute ?? null;
    }

    /**
     * @param string $sendFirstToFavorite
     * @return $this
     */
    public function setSendFirstToFavorite(string $sendFirstToFavorite) : Delivery
    {
        $this->sendFirstToFavorite = $sendFirstToFavorite;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSendFirstToFavorite() : ?bool
    {
        return $this->sendFirstToFavorite ?? null;
    }

    /**
     * @param string $requireSignature
     * @return $this
     */
    public function setRequireSignature(string $requireSignature) : Delivery
    {
        $this->requireSignature = $requireSignature;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRequireSignature() : ?bool
    {
        return $this->requireSignature ?? null;
    }

    /**
     * @param string $quickChoice
     * @return Delivery
     */
    public function setQuickChoice(string $quickChoice) : Delivery
    {
        $this->quickChoice = $quickChoice;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getQuickChoice() : ?bool
    {
        return $this->quickChoice ?? null;
    }

    /**
     * @param string $quickChoiceId
     * @return $this
     */
    public function setQuickChoiceId(string $quickChoiceId) : Delivery
    {
        $this->quickChoiceId = $quickChoiceId;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getQuickChoiceId() : ?bool
    {
        return $this->quickChoiceId ?? null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = array_filter([
            'vehicle_type_id' => $this->getVehicleTypeId(),
            'customer_id' => $this->getCustomerId(),
            'booking_payment_type' => $this->getBookingPaymentType(),
            'note' => $this->getNote(),
            'time_type' => $this->getTimeType(),
            'pickup_time' => $this->getPickupTime(),
            'job_order_number' => $this->getJobOrderNumber(),
            'allow_parking_fees' => $this->getAllowParkingFees(),
            'allow_tolls_fees' => $this->getAllowTollsFees(),
            'allow_waiting_time_fees' => $this->getAllowWaitingTimeFees(),
            'optimize_route' => $this->getOptimizeRoute(),
            'send_first_to_favorite' => $this->getSendFirstToFavorite(),
            'require_signatures' => $this->getRequireSignature(),
            'quick_choice' => $this->getQuickChoice(),
            'quick_choice_id' => $this->getQuickChoiceId(),
            'locations' => $this->getLocations(),
            'extra_services' => $this->getExtraServices()
        ]);
        $data['data'] = $data['data'] ?? new \stdClass();
        return $data;
    }
}