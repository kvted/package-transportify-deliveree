<?php

namespace MsysCorp\TransportifyDeliveree\Lookups;

class Paginate
{
    const ID = 'id';
    const TIME_TYPE = 'time_type';
    const VEHICLE_TYPE = 'vehicle_type';
    const PICKUP_TIME = 'pickup_time';
    const CUSTOMER_NAME = 'customer_name';
    const SORT_BY = [
        self::ID,
        self::TIME_TYPE,
        self::VEHICLE_TYPE,
        self::PICKUP_TIME,
        self::CUSTOMER_NAME
    ];

    const ASC = 'asc';
    const DESC = 'desc';
    CONST ORDER_BY = [
        self::ASC,
        self::DESC,
    ];
}