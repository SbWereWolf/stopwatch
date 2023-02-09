<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

class HRTimeStopwatch extends Stopwatch
{
    /** @var int time moment when measurement was ended */
    protected $lastEndedAt;

    /** @inheritdoc */
    protected function getReadings()
    {
        return hrtime(true);
    }

    /**
     * @param int $moment
     * @return int
     */
    protected function calcDiffNowWith($moment): int
    {
        $duration = $this->getReadings() - $moment;

        return $duration;
    }

    /**
     * @param int $moment
     * @return int
     */
    protected function calcDiffLastEndWith($moment): int
    {
        $duration = $this->lastEndedAt - $moment;

        return $duration;
    }
}