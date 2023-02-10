<?php

namespace SbWereWolf\Stopwatch;

class Benchmark
{
    private $periods = [];
    private IStopwatch $stopwatch;

    public function __construct(IStopwatch $stopwatch)
    {
        $this->stopwatch = $stopwatch;
    }

    public function step(string $description, callable $someFunction)
    {
        $this->stopwatch->start();
        $someFunction();
        $this->stopwatch->stop();

        $duration = $this->stopwatch->getLastTime();
        $this->periods[$description] = $duration;

        return $this;
    }

    public function total()
    {
        $total = $this->stopwatch->getSummaryTime();

        return $total;
    }

    public function report()
    {
        foreach ($this->periods as $description => $period) {
            yield $description => $period;
        }
    }
}