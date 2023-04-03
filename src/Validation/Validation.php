<?php

namespace MsysCorp\TransportifyDeliveree\Validation;

use DateTime;
use DateTimeInterface;
use MsysCorp\TransportifyDeliveree\Lookups\BookingPaymentType;
use MsysCorp\TransportifyDeliveree\Lookups\DeliveryStatus;
use MsysCorp\TransportifyDeliveree\Lookups\TimeType;
use MsysCorp\TransportifyDeliveree\Lookups\Paginate;

trait Validation
{
    /**
     * @param string $string
     * @return bool
     */
    public function validateTimeType(string $string) : bool
    {
        return in_array($string,TimeType::TIME_TYPE);
    }

    /**
     * @param string $string
     * @return bool
     */
    public function validateBookingPaymentType(string $string) : bool
    {
        return in_array($string, BookingPaymentType::ENUM);
    }

    /**
     * @param string $dateTIme
     * @return bool|DateTime
     */
    public function validatePickUpTime(string $dateTIme) : bool|DateTime
    {
        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $dateTIme);

        return $dt && $dt->format('Y-m-d H:i:s') === $dateTIme;
    }

    /**
     * @param string $dateTIme
     * @return bool|DateTime
     */
    public function validateDateTime(string $dateTIme) : bool|DateTime
    {
        $dt = DateTime::createFromFormat('d-m-Y', $dateTIme);

        return $dt && $dt->format('d-m-Y') === $dateTIme;
    }

    /**
     * @param string $string
     * @return bool
     */
    public function validateSortBy(string $string) : bool
    {
        return in_array($string,Paginate::SORT_BY);
    }

    /**
     * @param string $string
     * @return bool
     */
    public function validateOrderBy(string $string) : bool
    {
        return in_array($string,Paginate::ORDER_BY);
    }

    /**
     * @param string $string
     * @return bool
     */
    public function validateDeliveryStatus(string $string) : bool
    {
        return in_array($string,DeliveryStatus::ENUM);
    }

    /**
     * @param array $array
     * @return bool
     */
    public function validatePacksArray(array $array) : bool
    {
        foreach ($array as $detail) {
            if (is_null(array_key_exists('dimensions', $detail) ? $detail['dimensions'] : null)
                || is_null(array_key_exists('weigth', $detail) ? $detail['weigth'] : null)
                || is_null(array_key_exists('quantity', $detail) ? $detail['quantity'] : null)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $array
     * @return bool
     */
    public function validateLocationArray(array $array) : bool
    {
        foreach ($array as $detail) {
            if (is_null(array_key_exists('address', $detail) ? $detail['address'] : null)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $array
     * @return bool
     */
    public function validateExtraServicesArray(array $array) : bool
    {
        foreach ($array as $detail) {
            if (is_null(array_key_exists('extra_requirement_id', $detail) ? $detail['extra_requirement_id'] : null)) {
                return false;
            }
        }
        return true;
    }
}
