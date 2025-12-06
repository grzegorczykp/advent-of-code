<?php

declare(strict_types=1);

namespace App2025\Assignments;

use Illuminate\Support\Collection;

final class Day6 extends \App2025\BaseAssignment
{
    protected int $day = 6;

    protected function parseInput(string $input): ?Collection
    {
        $lines = collect(explode(PHP_EOL, $input))
            ->map(fn(string $line): array => str_split($line));

        $lineMaxLen = $lines->max(fn(array $line): int => count($line));

        $lines = $lines->map(fn(array $line): array => array_pad($line, $lineMaxLen, ' '))
            ->all();

        $operators = array_pop($lines);
        $data = [];
        for ($i = 0, $columns = count($operators); $i < $columns;) {
            $numbers = [];
            do {
                $column = array_column($lines, $i);
                $numbers[] = $column;
            } while (($operators[++$i] ?? ' ') === ' ' && $i < $columns);

            $data[] = $numbers;
        }

        $operators = array_values(array_filter($operators, fn(string $operator): bool => $operator !== ' '));

        return collect(compact('operators', 'data'));
    }

    protected function part1(): int
    {
        $data = $this->parsedDataArray['data'];
        $operators = $this->parsedDataArray['operators'];

        $result = 0;

        foreach ($data as $index => $numbers) {
            $columnResult = $operators[$index] === '+' ? 0 : 1;
            $count = count($numbers[0]);
            for ($i = 0; $i < $count; $i++) {
                $combinedNumber = (int) implode('', array_column($numbers, $i));
                if ($operators[$index] === '+') {
                    $columnResult += $combinedNumber;
                } else {
                    $columnResult *= $combinedNumber;
                }

            }
            $result += $columnResult;
        }

        return $result;
    }

    protected function part2(): int
    {
        $data = $this->parsedDataArray['data'];
        $operators = $this->parsedDataArray['operators'];

        $result = 0;

        foreach ($data as $index => $numbers) {
            $columnResult = $operators[$index] === '+' ? 0 : 1;
            for ($i = count($numbers) - 1; $i >= 0; $i--) {
                $combinedNumber = (int) implode('', $numbers[$i]);
                if ($combinedNumber === 0) {
                    continue;
                }
                if ($operators[$index] === '+') {
                    $columnResult += $combinedNumber;
                } else {
                    $columnResult *= $combinedNumber;
                }
            }

            $result += $columnResult;
        }

        return $result;
    }
}
