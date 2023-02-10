<?php

declare(strict_types=1);

$pathParts = [__DIR__, '..', 'vendor', 'autoload.php',];
$path = implode(DIRECTORY_SEPARATOR, $pathParts);
require_once($path);

/* starting OP Cache warm up */
echo 'starting OP Cache warm up' . PHP_EOL;

echo (new DateTimeImmutable())->format('s.u') . PHP_EOL;

$stopwatch = new SbWereWolf\Stopwatch\MicroTimeStopwatch();
echo 'MicroTime duration: ' .
    $stopwatch->start()->stop()->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

$stopwatch = new SbWereWolf\Stopwatch\HRTimeStopwatch();
echo 'HRTime duration: ' .
    $stopwatch->start()->stop()->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

$stopwatch = new SbWereWolf\Stopwatch\DateTimeStopwatch();
echo 'DateTime duration: ' .
    $stopwatch->start()->stop()->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

echo 'finish OP Cache warm up' . PHP_EOL . PHP_EOL;
/* finish OP Cache warm up */

echo 'Duration is ' .
    (new SbWereWolf\Stopwatch\HRTimeStopwatch())
        ->start()->stop()->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

$stopwatch = new SbWereWolf\Stopwatch\HRTimeStopwatch();
echo (new DateTimeImmutable())->format('s.u') . PHP_EOL;

$stopwatch->start();
time_nanosleep(0, 100);
$stopwatch->stop();

echo (new DateTimeImmutable())->format('s.u') .
    ' Period 1 duration: ' .
    $stopwatch->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

time_nanosleep(0, 100);

$stopwatch->start();
time_nanosleep(0, 100);
$stopwatch->stop();

echo (new DateTimeImmutable())->format('s.u') .
    ' Period 2 duration: ' .
    $stopwatch->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

echo (new DateTimeImmutable())->format('s.u') .
    ' Periods 1 + 2 summary duration: ' .
    $stopwatch->getSummaryTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

echo (new DateTimeImmutable())->format('s.u') .
    ' Whole process duration: ' .
    $stopwatch->getWholeTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;