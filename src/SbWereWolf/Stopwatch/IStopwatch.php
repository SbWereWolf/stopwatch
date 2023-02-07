<?php

declare(strict_types=1);

namespace SbWereWolf\Stopwatch;

/** Class for measure time periods  */
interface IStopwatch
{
    /** Start stopwatch, resume previously stopped measurement */
    public function start(): IStopwatch;

    /** Stop stopwatch, stop time measuring */
    public function stop(): IStopwatch;

    /** Reset timer to zero, not affected time measuring,
     * this not stop timer and this not start timer
     */
    public function reset(): IStopwatch;

    /** Get current time period duration,
     * since last start() or since last reset()
     */
    public function getLastTime(): ITimerReadings;

    /** Get whole time period duration,
     * since first start() or since last reset()
     */
    public function getWholeTime(): ITimerReadings;

    /** Get summary time of all time periods has measured,
     * between each start() and stop()
     */
    public function getSummaryTime(): ITimerReadings;

    /** Check is stopwatch running */
    public function isRunning(): bool;
}