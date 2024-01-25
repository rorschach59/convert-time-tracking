<?php

namespace App\Services;

class DateService
{

    private const ONE_HOUR_IN_MAN_DAY = 0.14;

    /**
     * @param int $duration
     * @return int
     */
    public function getHoursFromSeconds(int $duration): float
    {
        return $duration / 3600;
    }

    public function convertTimeInManDay(int|float $hour): int|float
    {
        return number_format($hour * self::ONE_HOUR_IN_MAN_DAY, 2);
    }
}
