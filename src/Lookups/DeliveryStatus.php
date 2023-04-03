<?php

namespace MsysCorp\TransportifyDeliveree\Lookups;

class DeliveryStatus
{
    const LOCATING_DRIVER = 'locating_driver';
    const DRIVER_ACCEPT_BOOKING = 'driver_accept_booking';
    const DELIVERY_IN_PROGRESS = 'delivery_in_progress';
    const DELIVERY_COMPLETED = 'delivery_completed';
    const CANCELED = 'canceled';
    const LOCATING_DRIVER_TIMEOUT = 'locating_driver_timeout';
    const ENUM = [
        self::LOCATING_DRIVER,
        self::DRIVER_ACCEPT_BOOKING,
        self::DELIVERY_IN_PROGRESS,
        self::DELIVERY_COMPLETED,
        self::CANCELED,
        self::LOCATING_DRIVER_TIMEOUT
    ];
}