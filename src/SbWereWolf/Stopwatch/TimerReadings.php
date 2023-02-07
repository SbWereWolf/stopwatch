<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class TimerReadings implements ITimerReadings
{
    use JsonSerializeTrait;

    private int $nanoseconds;

    public function __construct(int $nanoseconds)
    {
        $this->nanoseconds = $nanoseconds;
    }

    /**
     * @inheritDoc
     */
    public function asSeconds(): float
    {
        return $this->nanoseconds / static::TO_SECONDS;
    }

    /**
     * @inheritDoc
     */
    public function asMilliSeconds(): float
    {
        return $this->nanoseconds / static::TO_MILLISECONDS;
    }

    /**
     * @inheritDoc
     */
    public function asMicroSeconds(): float
    {
        return $this->nanoseconds / static::TO_MICROSECONDS;
    }

    /**
     * @inheritDoc
     */
    public function asNanoSeconds(): float
    {
        return $this->nanoseconds;
    }
}