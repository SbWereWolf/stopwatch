<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

class MicroTimeStopwatch extends Stopwatch
{
    protected function getCurrentMeasurementAsNanoseconds(): int
    {
        list($mcs, $s) = explode(' ', microtime());
        $moment =
            ((int)$s) * ITimerReadings::TO_SECONDS +
            (int)(((float)$mcs) * ITimerReadings::TO_SECONDS);

        return $moment;
    }
}