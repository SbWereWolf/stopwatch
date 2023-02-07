<?php

declare(strict_types=1);

use SbWereWolf\Stopwatch\TimerReadings;

$pathParts = [__DIR__, '..', 'vendor', 'autoload.php',];
$path = implode(DIRECTORY_SEPARATOR, $pathParts);
require_once($path);

$sw = (new SbWereWolf\Stopwatch\HRTimeStopwatch())->start();

$readings = new TimerReadings(1);
$results = [
    'asNanoSeconds' => $readings->asNanoSeconds(),
    'asMicroSeconds' => $readings->asMicroSeconds(),
    'asMilliSeconds' => $readings->asMilliSeconds(),
    'asSeconds' => $readings->asSeconds(),
    'jsonSerialize' => json_encode($readings->jsonSerialize(), JSON_PRETTY_PRINT),
];
echo json_encode($results, JSON_PRETTY_PRINT) . PHP_EOL;

$readings = new TimerReadings(1_000);
$results = [
    'asNanoSeconds' => $readings->asNanoSeconds(),
    'asMicroSeconds' => $readings->asMicroSeconds(),
    'asMilliSeconds' => $readings->asMilliSeconds(),
    'asSeconds' => $readings->asSeconds(),
    'jsonSerialize' => json_encode($readings->jsonSerialize(), JSON_PRETTY_PRINT),
];
echo json_encode($results, JSON_PRETTY_PRINT) . PHP_EOL;

$readings = new TimerReadings(1_000_000);
$results = [
    'asNanoSeconds' => $readings->asNanoSeconds(),
    'asMicroSeconds' => $readings->asMicroSeconds(),
    'asMilliSeconds' => $readings->asMilliSeconds(),
    'asSeconds' => $readings->asSeconds(),
    'jsonSerialize' => json_encode($readings->jsonSerialize(), JSON_PRETTY_PRINT),
];
echo json_encode($results, JSON_PRETTY_PRINT) . PHP_EOL;

$readings = new TimerReadings(1_000_000_000);
$results = [
    'asNanoSeconds' => $readings->asNanoSeconds(),
    'asMicroSeconds' => $readings->asMicroSeconds(),
    'asMilliSeconds' => $readings->asMilliSeconds(),
    'asSeconds' => $readings->asSeconds(),
    'jsonSerialize' => json_encode($readings->jsonSerialize(), JSON_PRETTY_PRINT),
];
echo json_encode($results, JSON_PRETTY_PRINT) . PHP_EOL;

echo
    'Duration is ' .
    $sw->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;