<?php

namespace MsysCorp\TransportifyDeliveree\Validation;

use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Lookups\TimeType;

class ExtraService
{
    use Validation;

    protected ?int $dropOffCount;
    protected ?string $timeType;

    /**
     *
     */
    public function __construct(){}


    /**
     * @return int|null
     */
    public function getDropOffCount() : ?int
    {
        return $this->dropOffCount ?? [];
    }

    /**
     * @param int $dropOffCount
     * @return $this
     */
    public function setDropOffCount(int $dropOffCount) : ExtraService
    {
        $this->dropOffCount = $dropOffCount;

        return $this;
    }

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
    public function setTimeType(string $timeType): ExtraService
    {
        if (!$this->validateTimeType($timeType)) {
            throw new InvalidArgumentException(
                'Invalid Selected Time Type ff. ('. implode(',' ,TimeType::TIME_TYPE) .').');
        }

        $this->timeType = $timeType;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'time_type' => $this->getTimeType(),
            'dropoff_count' => $this->getDropOffCount(),
        ]);
    }
}