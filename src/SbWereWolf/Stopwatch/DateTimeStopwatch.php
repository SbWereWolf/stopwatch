<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

use DateInterval;
use DateTimeImmutable;

class DateTimeStopwatch extends Stopwatch
{
    /** @var DateTimeImmutable time moment when measurement was ended */
    protected $lastEndedAt;

    /**
     * @param int $moment
     * @return int
     */
    protected function calcDiffNowWith($moment): int
    {
        /** @var DateTimeImmutable $readings */
        $readings = $this->getReadings();
        $delta = $readings->diff($moment);
        $duration = $this->toNanoSeconds($delta);

        return $duration;
    }

    /** @inheritdoc */
    protected function getReadings()
    {
        return new DateTimeImmutable();
    }

    /**
     * @param DateInterval $delta
     * @return float|int
     */
    private function toNanoSeconds(DateInterval $delta)
    {
        $duration =
            ($delta->s + $delta->f) * ITimerReadings::TO_SECONDS +
            $delta->i * ITimerReadings::TO_SECONDS * 60 +
            $delta->h * ITimerReadings::TO_SECONDS * 60 * 60;
        if ($delta->days) {
            $duration +=
                $delta->days * ITimerReadings::TO_SECONDS * 60 * 60 * 24;
        }

        return (int)$duration;
    }

    /**
     * @param int $moment
     * @return int
     */
    protected function calcDiffLastEndWith($moment): int
    {
        $delta = $this->lastEndedAt->diff($moment);
        $duration = $this->toNanoSeconds($delta);

        return $duration;
    }
}