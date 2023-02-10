<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

abstract class Stopwatch implements IStopwatch, JsonSerializable
{
    use JsonSerializeTrait;

    /** @var mixed time moment when measurement was started first time */
    private $firstStaredAt;
    /** @var mixed time moment when measurement was started */
    private $staredAt;
    /** @var mixed time moment when measurement was ended */
    protected $lastEndedAt;
    /** @var int summary time of all time periods has measured */
    private int $summary = 0;

    /** @var bool state of measurement, is running or was stopped */
    private bool $isRunning = false;
    /** @var bool indicates is stopwatch was started */
    private bool $isStarted = false;

    /* @inheritdoc */
    public function start(): IStopwatch
    {
        $readings = $this->getReadings();
        if (!$this->isStarted) {
            $this->isStarted = true;
            $this->firstStaredAt = $readings;
        }
        $this->staredAt = $readings;

        $this->isRunning = true;

        return $this;
    }

    /* @inheritdoc */
    public function stop(): IStopwatch
    {
        if ($this->isRunning) {
            $this->lastEndedAt = $this->getReadings();

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
        if ($this->isRunning) {
            $duration = $this->calcDiffNowWith($this->staredAt);
        } else {
            $duration = $this->calcDiffLastEndWith($this->staredAt);
        }

        return $duration;
    }

    /* @inheritdoc */
    public function reset(): IStopwatch
    {
        if ($this->isRunning) {
            $readings = $this->getReadings();
            $this->firstStaredAt = $readings;
            $this->staredAt = $readings;
        } else {
            $this->isStarted = false;
        }

        $this->summary = 0;


        return $this;
    }

    /* @inheritdoc */
    public function getLastTime(): ITimerReadings
    {
        $duration = 0;
        if ($this->isStarted) {
            $duration = $this->calculateLastPeriodDuration();
        }

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
        $duration = 0;
        if ($this->isStarted && $this->isRunning) {
            $duration = $this->calcDiffNowWith($this->firstStaredAt);
        }
        if ($this->isStarted && !$this->isRunning) {
            $duration = $this->calcDiffLastEndWith($this->firstStaredAt);
        }

        $measurement = new TimerReadings($duration);

        return $measurement;
    }

    /* @inheritdoc */
    public function isRunning(): bool
    {
        return $this->isRunning;
    }

    /** Get readings of stopwatch driver */
    abstract protected function getReadings();

    /** Get time difference between current time and given $moment
     * @param int $moment
     * @return int
     */
    abstract protected function calcDiffNowWith($moment): int;

    /** Get time difference between
     * last period end time and given $moment
     * @param int $moment
     * @return int
     */
    abstract protected function calcDiffLastEndWith($moment): int;
}