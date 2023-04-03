<?php

namespace MsysCorp\TransportifyDeliveree\Lookups;

class BookingPaymentType
{
    const CASH = 'cash';
    const CREDIT = 'credit';
    const ENUM = [
        self::CASH,
        self::CREDIT
    ];
}