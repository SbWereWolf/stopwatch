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
Duration is 6800 ns
```

Stopwatch available with `hrtime()` and with `microtime()` engines.

`\SbWereWolf\Stopwatch\MicroTimeStopwatch` implements
`microtime()` engine.

`\SbWereWolf\Stopwatch\HRTimeStopwatch` implements
`hrtime()` engine.

## Advanced usage

```php
$stopwatch = new \SbWereWolf\Stopwatch\HRTimeStopwatch();
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
```

```bash
Duration is 6800 ns
24.003953
24.003993 Period duration: 20300 ns
24.004022 Period duration: 6300 ns

24.004031 Periods summary duration: 26600 ns
24.004046 Whole process duration: 50900 ns
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