<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

class HRTimeStopwatch extends Stopwatch
{

    protected function getCurrentMeasurementAsNanoseconds(): int
    {
        return hrtime(true);
    }
}