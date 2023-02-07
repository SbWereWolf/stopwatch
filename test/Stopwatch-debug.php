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

echo 'Duration is ' .
    (new SbWereWolf\Stopwatch\HRTimeStopwatch())->start()->stop()->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

$stopwatch = new SbWereWolf\Stopwatch\HRTimeStopwatch();
echo (new DateTimeImmutable())->format('s.u') . PHP_EOL;

$stopwatch->start();
time_nanosleep(0, 100);
$stopwatch->stop();

echo (new DateTimeImmutable())->format('s.u') .
    ' Period duration: ' .
    $stopwatch->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

time_nanosleep(0, 100);

$stopwatch->start();
time_nanosleep(0, 100);
$stopwatch->stop();

echo (new DateTimeImmutable())->format('s.u') .
    ' Period duration: ' .
    $stopwatch->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

echo (new DateTimeImmutable())->format('s.u') .
    ' Periods summary duration: ' .
    $stopwatch->getSummaryTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;

echo (new DateTimeImmutable())->format('s.u') .
    ' Whole process duration: ' .
    $stopwatch->getWholeTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;


$sw1 = (new SbWereWolf\Stopwatch\MicroTimeStopwatch());
$sw2 = (new SbWereWolf\Stopwatch\HRTimeStopwatch());

foreach (['micro' => $sw1, 'hi res' => $sw2] as $type => $sw) {
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