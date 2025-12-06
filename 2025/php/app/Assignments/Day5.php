<?php

declare(strict_types=1);

namespace App2025\Assignments;

use Illuminate\Support\Collection;

final class Day5 extends \App2025\BaseAssignment
{
    protected int $day = 5;

    protected function parseInput(string $input): ?Collection
    {
        [$freshRanges, $ingredients] = explode(PHP_EOL . PHP_EOL, $input);

        $freshRanges = $this->parseRanges($freshRanges);

        $ingredients = collect(explode(PHP_EOL, $ingredients))
            ->map('intval')
            ->sort();

        return collect(compact('freshRanges', 'ingredients'));
    }

    protected function part1(): int
    {
        $freshRanges = $this->parsedData['freshRanges'];
        $ingredients = $this->parsedData['ingredients'];

        return $ingredients
            ->filter(
                fn(int $ingredient): bool => array_any(
                    $freshRanges,
                    fn(array $range): bool => $ingredient >= $range[0] && $ingredient <= $range[1]
                )
            )
            ->count();
    }

    protected function part2(): int
    {
        return collect($this->parsedData['freshRanges'])
            ->sum(fn(array $range): int => ($range[1] - $range[0]) + 1);
    }

    private function parseRanges(string $ranges): array
    {
        $merged = [];
        $range = [0, 0];

        collect(explode(PHP_EOL, $ranges))
            ->map(fn(string $line): array => array_map('intval', explode('-', $line)))
            ->sortBy('0')
            ->each(function (array $currentRange) use (&$range, &$merged) {
                [$from, $to] = $currentRange;

                if ($from <= $range[1]) {
                    $range[1] = max($range[1], $to);
                } else {
                    $merged[] = $range;
                    $range = [$from, $to];
                }
            });

        $merged[] = $range;

        return array_slice($merged, 1);
    }
}
