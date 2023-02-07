<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

abstract class Stopwatch implements IStopwatch, JsonSerializable
{
    use JsonSerializeTrait;

    /** @var int time moment when measurement was started first time */
    private int $firstStaredAt = 0;
    /** @var int time moment when measurement was started */
    private int $staredAt = 0;
    /** @var int time moment when measurement was ended */
    private int $endedAt = 0;
    /** @var int summary time of all time periods has measured */
    private int $summary = 0;

    /** @var bool state of measurement, is running or was stopped */
    private bool $isRunning = false;

    /* @inheritdoc */
    public function start(): IStopwatch
    {
        $moment = $this->getCurrentMeasurementAsNanoseconds();
        if ($this->staredAt === 0) {
            $this->firstStaredAt = $moment;
        }
        $this->staredAt = $moment;

        $this->isRunning = true;

        return $this;
    }

    /** Get current time moment as nanoseconds
     * @return int
     */
    abstract protected function
    getCurrentMeasurementAsNanoseconds(): int;

    /* @inheritdoc */
    public function stop(): IStopwatch
    {
        if ($this->isRunning) {
            $this->endedAt = $this->getCurrentMeasurementAsNanoseconds();

            $this->isRunning = false;
            $this->summary += $this->calculateLastPeriodDuration();
        }

        return $this;
    }

    /**
     * @return int
     */
    private function calculateLastPeriodDuration(): int
    {
        $finish = $this->getFinishMoment();
        $duration = $finish - $this->staredAt;

        return $duration;
    }

    /**
     * @return int
     */
    private function getFinishMoment(): int
    {
        if ($this->isRunning) {
            $moment = $this->getCurrentMeasurementAsNanoseconds();
        } else {
            $moment = $this->endedAt;
        }
        return $moment;
    }

    /* @inheritdoc */
    public function reset(): IStopwatch
    {
        $moment = $this->getCurrentMeasurementAsNanoseconds();
        if ($this->isRunning) {
            $this->firstStaredAt = $moment;
            $this->staredAt = $moment;
        } else {
            $this->staredAt = 0;
        }

        $this->summary = 0;


        return $this;
    }

    /* @inheritdoc */
    public function getLastTime(): ITimerReadings
    {
        $duration = $this->calculateLastPeriodDuration();
        $measurement = new TimerReadings($duration);

        return $measurement;
    }

    /* @inheritdoc */
    public function getSummaryTime(): ITimerReadings
    {
        $measurement = new TimerReadings($this->summary);

        return $measurement;
    }

    /* @inheritdoc */
    public function getWholeTime(): ITimerReadings
    {
        $finish = $this->getFinishMoment();
        $duration = $finish - $this->firstStaredAt;

        $measurement = new TimerReadings($duration);

        return $measurement;
    }

    /* @inheritdoc */
    public function isRunning(): bool
    {
        return $this->isRunning;
    }
}