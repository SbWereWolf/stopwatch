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
        $start = $this->readingsToNanoseconds($moment);
        $now = $this->readingsToNanoseconds($this->getReadings());

        $duration = $now - $start;

        return $duration;
    }

    /**
     * @param int $moment
     * @return int
     */
    protected function calcDiffLastEndWith($moment): int
    {
        $start = $this->readingsToNanoseconds($moment);
        $end = $this->readingsToNanoseconds($this->lastEndedAt);

        $duration = $end - $start;

        return $duration;
    }

    /**
     * @param $readings
     * @return float|int
     */
    private function readingsToNanoseconds($readings)
    {
        list($mcs, $s) = explode(' ', $readings);
        $moment =
            ((float)$s + (float)$mcs) * ITimerReadings::TO_SECONDS;

        return (int)$moment;
    }
}