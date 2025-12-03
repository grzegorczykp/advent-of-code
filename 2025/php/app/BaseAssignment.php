<?php

declare(strict_types=1);

namespace App2025;

use Closure;
use Illuminate\Support\Collection;

abstract class BaseAssignment
{
    public private(set) array $runStats;

    protected int $day;

    protected readonly string $inputData;

    protected readonly ?Collection $parsedData;

    protected readonly ?array $parsedDataArray;

    private readonly string $basePath;

    public function __construct(private readonly bool $isTest = false)
    {
        $this->basePath = dirname(__DIR__, 2) . '/data/';
        if (!isset($this->day)) {
            preg_match('/Day(\d+)/', static::class, $matches);
            $this->day = (int) $matches[1];
        }
        $this->benchamrk(fn() => $this->loadData(), 'loadData');
        $this->parsedData = $this->benchamrk(fn() => $this->parseInput($this->inputData), 'parseInput');
        $this->parsedDataArray = $this->parsedData?->toArray();
    }

    private function formatTime(float $nanoseconds): string
    {
        $timeUnits = ['ns', 'μs', 'ms', 's', 'm', 'h'];
        $i = floor(log($nanoseconds, 1000));

        return round($nanoseconds / (1000 ** $i), 2) . $timeUnits[$i];
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $i = floor(log($bytes, 1024));

        return round($bytes / (1024 ** $i), 2) . $units[$i];
    }

    private function benchamrk(Closure $closure, string $label): mixed
    {
        memory_reset_peak_usage();
        $startTime = hrtime(true);
        $result = $closure();
        $elapsedTime = hrtime(true) - $startTime;
        $memoryPeak = memory_get_peak_usage();
        $this->runStats[$label] = [
            'time' => $elapsedTime,
            'timeFormatted' => $this->formatTime($elapsedTime),
            'memoryPeak' => $memoryPeak,
            'memoryPeakFormatted' => $this->formatBytes($memoryPeak),
        ];

        return $result;
    }

    private function loadData(): void
    {
        $extension = $this->isTest ? '/test' : '/input';

        $this->inputData = file_get_contents($this->basePath . str_pad((string) $this->day, 2, '0', STR_PAD_LEFT) . $extension);
    }

    protected function parseInput(string $input): ?Collection
    {
        return null;
    }

    /**
     * @return array{0: int|string, 1: int|string}
     */
    final public function run(): array
    {
        $part1 = $this->benchamrk(fn() => $this->part1(), 'part1');
        $part2 = $this->benchamrk(fn() => $this->part2(), 'part2');

        return [
            $part1,
            $part2,
        ];
    }

    abstract protected function part1(): int|string;

    abstract protected function part2(): int|string;
}
