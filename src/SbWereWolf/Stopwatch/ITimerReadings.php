<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

/** Class to obtain measured time in desired units of measures */
interface ITimerReadings
{
    /** @var int Ratio for convert to seconds */
    public const TO_SECONDS = 1_000_000_000;
    /** @var int Ratio for convert to milliseconds */
    public const TO_MILLISECONDS = 1_000_000;
    /** @var int Ratio for convert to microseconds */
    public const TO_MICROSECONDS = 1_000;

    /** Get duration of time period as seconds  */
    public function asSeconds(): float;

    /** Get duration of time period as milliseconds  */
    public function asMilliSeconds(): float;

    /** Get duration of time period as microseconds  */
    public function asMicroSeconds(): float;

    /** Get duration of time period as nanoseconds  */
    public function asNanoSeconds(): float;
}