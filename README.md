# Simple stopwatch

Primitive stopwatch, with simple start and stop methods,
for measurement of every single time periods and all time whole.

## How to install

`composer require sbwerewolf/stopwatch`

## How to use

```php
echo 'Duration is ' .
    (new \SbWereWolf\Stopwatch\HRTimeStopwatch())
    ->start()->stop()->getLastTime()->asNanoSeconds() .
    ' ns' .
    PHP_EOL;
```

```bash
Duration is 300 ns
```

Stopwatch available with different engines:

- `hrtime()`
- `microtime()`
- `DateTimeImmutable`

`\SbWereWolf\Stopwatch\HRTimeStopwatch` implements
`hrtime()` engine.

`\SbWereWolf\Stopwatch\MicroTimeStopwatch` implements
`microtime()` engine.

`\SbWereWolf\Stopwatch\DateTimeStopwatch` implements
`DateTimeImmutable` engine.

## Advanced usage

```php
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
```

```bash
02.380004
02.380020 Period 1 duration: 12400 ns
02.380032 Period 2 duration: 3600 ns
02.380035 Periods 1 + 2 summary duration: 16000 ns
02.380044 Whole process duration: 24000 ns
```

## Contacts

```
Volkhin Nikolay
e-mail ulfnew@gmail.com
phone +7-902-272-65-35
Telegram @sbwerewolf
```

Chat with me via messenger

- [Telegram chat with me](https://t.me/SbWereWolf)
- [WhatsApp chat with me](https://wa.me/79022726535) 