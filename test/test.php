<?php

declare(strict_types=1);

$pathParts = [__DIR__, '..', 'vendor', 'autoload.php',];
$path = implode(DIRECTORY_SEPARATOR, $pathParts);
require_once($path);

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