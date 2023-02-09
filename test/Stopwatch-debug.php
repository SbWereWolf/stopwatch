<?php

declare(strict_types=1);

use SbWereWolf\Stopwatch\IStopwatch;

/**
 * @param $sw
 * @param string $message
 * @return void
 */
function echoLastTime($sw, string $message): void
{
    $lt = $sw->getLastTime();

    echo
        (new DateTimeImmutable())->format('s.u') .
        $message .
        $lt->asNanoSeconds() . ' ns, ' .
        $lt->asMicroSeconds() . ' mcs, ' .
        $lt->asMilliSeconds() . ' ms, ' .
        $lt->asSeconds() . ' s' .
        PHP_EOL;
}

function echoWholeTime($sw, string $message): void
{
    /** @var IStopwatch $sw */
    $lt = $sw->getWholeTime();

    echo
        (new DateTimeImmutable())->format('s.u') .
        $message .
        $lt->asNanoSeconds() . ' ns, ' .
        $lt->asMicroSeconds() . ' mcs, ' .
        $lt->asMilliSeconds() . ' ms, ' .
        $lt->asSeconds() . ' s' .
        PHP_EOL;
}

function echoSummaryTime($sw, string $message): void
{
    /** @var IStopwatch $sw */
    $lt = $sw->getSummaryTime();

    echo
        (new DateTimeImmutable())->format('s.u') .
        $message .
        $lt->asNanoSeconds() . ' ns, ' .
        $lt->asMicroSeconds() . ' mcs, ' .
        $lt->asMilliSeconds() . ' ms, ' .
        $lt->asSeconds() . ' s' .
        PHP_EOL;
}

$pathParts = [__DIR__, '..', 'vendor', 'autoload.php',];
$path = implode(DIRECTORY_SEPARATOR, $pathParts);
require_once($path);

/* starting OP Cache warm up */
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
/* finish OP Cache warm up */

/* Starting benchmark*/
echo 'Duration is ' .
    (new SbWereWolf\Stopwatch\HRTimeStopwatch())
        ->start()
        ->stop()
        ->getLastTime()
        ->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

$stopwatch = new SbWereWolf\Stopwatch\HRTimeStopwatch();
echo (new DateTimeImmutable())->format('s.u') . PHP_EOL;

$stopwatch->start();
time_nanosleep(0, 100);
$stopwatch->stop();

$d1 = $stopwatch->getLastTime()->asNanoSeconds();
echo (new DateTimeImmutable())->format('s.u') .
    ' Period 1 duration: ' . $d1 . ' ns' . PHP_EOL;

assert(
    $d1 > 100,
    'Duration of period #1 is less then delay'
);

time_nanosleep(0, 100);

$stopwatch->start();
time_nanosleep(0, 100);
$stopwatch->stop();

$d2 = $stopwatch->getLastTime()->asNanoSeconds();
echo (new DateTimeImmutable())->format('s.u') .
    ' Period 2 duration: ' . $d2 . ' ns' . PHP_EOL;

assert(
    $d2 > 100,
    'Duration of period #2 is less then delay'
);

$total = $stopwatch->getSummaryTime()->asNanoSeconds();
echo (new DateTimeImmutable())->format('s.u') .
    ' Periods 1 + 2 summary duration: ' . $total . ' ns' . PHP_EOL;

assert(
    $total === $d1 + $d2,
    'summa of period durations not equal to summary'
);

$whole = $stopwatch->getWholeTime()->asNanoSeconds();
echo (new DateTimeImmutable())->format('s.u') .
    ' Whole process duration: ' . $whole . ' ns' . PHP_EOL;

assert(
    $whole > $total,
    'Duration whole is less then periods summary'
);
/* Finish benchmark*/

$sw1 = (new SbWereWolf\Stopwatch\MicroTimeStopwatch());
$sw2 = (new SbWereWolf\Stopwatch\HRTimeStopwatch());
$sw3 = (new SbWereWolf\Stopwatch\DateTimeStopwatch());
/*$handlers = [];*/
$handlers = ['MICRO' => $sw1, 'HI RES' => $sw2, 'DATETIME' => $sw3];

foreach ($handlers as $type => $sw) {
    echo $type . PHP_EOL;

    echoLastTime($sw, ' Duration of LastTime at instanting is ');

    $sw->start();
    echoLastTime($sw, ' Duration of LastTime at START is ');

    echo 'starting time_nanosleep(0, 999_999);' . PHP_EOL;
    time_nanosleep(0, 999_999);
    echo 'finish time_nanosleep(0, 999_999);' . PHP_EOL;
    echoLastTime($sw, ' Duration of LastTime after time_nanosleep is ');

    echo 'starting usleep(999);' . PHP_EOL;
    usleep(999);
    echo 'finish usleep(999);' . PHP_EOL;
    echoLastTime($sw, ' Duration of LastTime after usleep is ');

    $sw->stop();
    echoLastTime($sw, ' Duration of LastTime after STOP is ');

    echo 'starting sleep(1);' . PHP_EOL;
    sleep(1);
    echo 'finish sleep(1);' . PHP_EOL;
    echoLastTime($sw, ' Duration of LastTime after STOP is ');

    $sw->start();
    echoLastTime($sw, ' Duration of LastTime after START is ');

    echo 'starting usleep(999);' . PHP_EOL;
    usleep(999);
    echo 'finish usleep(999);' . PHP_EOL;
    echoLastTime($sw, ' Duration of LastTime after usleep is ');

    echo 'starting time_nanosleep(0, 999_999);' . PHP_EOL;
    time_nanosleep(0, 999_999);
    echo 'finish time_nanosleep(0, 999_999);' . PHP_EOL;
    echoLastTime($sw, ' Duration of LastTime after time_nanosleep is ');

    $sw->stop();
    echoLastTime($sw, ' Duration of LastTime after STOP is ');

    echoWholeTime($sw, ' Duration of WholeTime is ');
    echoSummaryTime($sw, ' Summary Time of all measured periods is ');
}