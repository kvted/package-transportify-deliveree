<?php

namespace MsysCorp\TransportifyDeliveree\Lookups;

class TimeType
{
    const NOW = 'now';
    const SCHEDULE = 'schedule';
    const TIME_TYPE = [
        self::NOW,
        self::SCHEDULE
    ];

}
