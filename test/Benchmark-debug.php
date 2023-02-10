<?php

declare(strict_types=1);

$pathParts = [__DIR__, '..', 'vendor', 'autoload.php',];
$path = implode(DIRECTORY_SEPARATOR, $pathParts);
require_once($path);

$stopwatch = new SbWereWolf\Stopwatch\HRTimeStopwatch();
$benchmark = new SbWereWolf\Stopwatch\Benchmark($stopwatch);

$delay = 100;
echo "Variable value before step z callback `$delay`" . PHP_EOL;
/* Variable value before step z callback `100` */
$benchmark->step('z', function () use ($delay) {
    time_nanosleep(0, $delay);
    $delay++;
});
echo "after step z callback `$delay`" . PHP_EOL;
/* after step z callback `100` */
/* Variable does not change its value */
assert($delay === 100, 'Variable MUST NOT change its value');

$benchmark->step('x', function () use (&$delay) {
    time_nanosleep(0, $delay);
    $delay += 999;
});
echo "after step x callback `$delay`" . PHP_EOL;
/* after step x callback `1099` */
/* Variable does change its value */
assert($delay === 1099, 'Variable MUST change its value');

$benchmark->step('c', function () use (&$delay) {
    $delay -= 999;
    time_nanosleep(0, $delay);
});
echo "after step c callback `$delay`" . PHP_EOL;
/* after step c callback `100` */
/* Variable does change its value */
assert($delay === 100, 'Variable MUST change its value');

echo "Benchmark steps measurement is:" . PHP_EOL;
$i = 0;
foreach ($benchmark->report() as $desc => $val) {
    /** @var SbWereWolf\Stopwatch\ITimerReadings $val */
    echo "$desc => {$val->asNanoSeconds()} ns" . PHP_EOL;
    $i++;
}
assert($i === 3, 'Period numbers MUST BE 3');

$totalNanoseconds = $benchmark->total()->asNanoSeconds();
echo "Total is $totalNanoseconds ns";
assert($totalNanoseconds > 1300, 'Overall duration MUST BE greater than all periods summ');