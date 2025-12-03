<?php

declare(strict_types=1);

namespace App2025\Assignments;

use Illuminate\Support\Collection;

final class Day3 extends \App2025\BaseAssignment
{
    protected int $day = 3;

    protected function parseInput(string $input): ?Collection
    {
        return collect(explode(PHP_EOL, $input))
            ->map(fn($line): array => str_split($line));
    }

    protected function part1(): int|string
    {
        $sum = 0;
        foreach ($this->parsedData as $batteries) {
            $sum += $this->findLargestBank($batteries, 2);
        }

        return $sum;
    }

    protected function part2(): int|string
    {
        $sum = 0;
        foreach ($this->parsedData as $batteries) {
            $sum += $this->findLargestBank($batteries, 12);
        }

        return $sum;
    }

    /**
     * Variant 1 for part 1
     */
    private function findLargestBankP1(array $batteries): int
    {
        $max = 0;
        $lineLength = count($batteries);
        for ($i = 0; $i < $lineLength - 1; $i++) {
            $first = $batteries[$i];
            $second = max(array_slice($batteries, $i + 1));
            $combination = (int) ($first . $second);
            if ($combination > $max) {
                $max = $combination;
            }
        }

        return $max;
    }

    private function findLargestBank(array $batteries, int $targetLength): int
    {
        $bank = [];
        $remainingBatteries = $batteries;

        for ($i = $targetLength - 1; $i >= 0; $i--) {
            $searchArea = array_slice($remainingBatteries, 0, count($remainingBatteries) - $i);

            $maxChar = max($searchArea);
            $bank[] = $maxChar;

            $pos = array_search($maxChar, $remainingBatteries, true);
            $remainingBatteries = array_slice($remainingBatteries, $pos + 1);
        }

        return (int) implode('', $bank);
    }
}
