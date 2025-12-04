<?php

declare(strict_types=1);

namespace App2025\Assignments;

use Illuminate\Support\Collection;

final class Day4 extends \App2025\BaseAssignment
{
    private const array DIRECTIONS = [
        [0, 1],  // right
        [0, -1], // left
        [1, 0],  // down
        [1, 1],  // down-right
        [1, -1], // down-left
        [-1, 0], // up
        [-1, 1], // up-right
        [-1, -1], // up-left
    ];

    protected int $day = 4;

    protected function parseInput(string $input): ?Collection
    {
        return collect(explode(PHP_EOL, $input))
            ->map(fn($line): array => str_split($line));
    }

    protected function part1(): int|string
    {
        return $this->countReachableRolls($this->parsedDataArray);
    }

    protected function part2(): int|string
    {
        $input = $this->parsedDataArray;
        $reachableRolls = 0;
        do {
            $currentResult = $this->countReachableRolls($input, $input);
            $reachableRolls += $currentResult;
        } while ($currentResult > 0);

        return $reachableRolls;
    }

    private function countReachableRolls(array $input, array &$cleaned = []): int
    {
        $reachableRolls = 0;
        foreach ($input as $x => $row) {
            foreach ($row as $y => $cell) {
                if ($cell !== '@') {
                    continue;
                }

                $inArea = 0;
                foreach (self::DIRECTIONS as [$dx, $dy]) {
                    if (($input[$x + $dx][$y + $dy] ?? '.') === '@') {
                        $inArea++;
                    }
                }

                if ($inArea < 4) {
                    $cleaned[$x][$y] = '.';
                    $reachableRolls++;
                }
            }
        }

        return $reachableRolls;
    }
}
