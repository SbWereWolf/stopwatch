<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

class MicroTimeStopwatch extends Stopwatch
{
    /** @var int time moment when measurement was ended */
    protected $lastEndedAt;

    /** @inheritdoc */
    protected function getReadings()
    {
        return microtime();
    }

    /**
     * @param int $moment
     * @return int
     */
    protected function calcDiffNowWith($moment): int
    {
        $start = static::readingsToNanoseconds($moment);
        $now = static::readingsToNanoseconds($this->getReadings());

        $duration = $now - $start;

        return $duration;
    }

    /**
     * @param int $moment
     * @return int
     */
    protected function calcDiffLastEndWith($moment): int
    {
        $start = static::readingsToNanoseconds($moment);
        $end = static::readingsToNanoseconds($this->lastEndedAt);

        $duration = $end - $start;

        return $duration;
    }

    /**
     * @param $readings
     * @return int
     */
    private static function readingsToNanoseconds($readings): int
    {
        list($mcs, $s) = explode(' ', $readings);
        $moment =
            (
                ((int)$s) * ITimerReadings::TO_SECONDS +
                (int)(((float)$mcs) * ITimerReadings::TO_SECONDS)
            );

        return $moment;
    }
}