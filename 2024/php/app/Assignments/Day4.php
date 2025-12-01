<?php

declare(strict_types=1);

namespace App2024\Assignments;

use Illuminate\Support\Collection;

final class Day4 extends \App2024\BaseAssignment
{
    protected int $day = 4;

    public function parseInput(string $input): Collection
    {
        return collect(explode(PHP_EOL, $input))
            ->map(fn(string $line): array => str_split($line));
    }

    protected function part1(): int
    {
        $matrix = $this->parsedData->all();
        $rows = count($matrix);
        $cols = count($matrix[0]);
        $count = 0;

        $directions = [
            [0, 1],  // right
            [1, 0],  // down
            [1, 1],  // down-right
            [1, -1], // down-left
        ];

        for ($row = 0; $row < $rows; $row++) {
            for ($col = 0; $col < $cols; $col++) {
                foreach ($directions as $direction) {
                    if ($this->searchWordInDirection($matrix, 'XMAS', $row, $col, $direction)) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    protected function part2(): int
    {
        $matrix = $this->parsedData->all();
        $rows = count($matrix);
        $cols = count($matrix[0]);
        $count = 0;

        for ($row = 0; $row < $rows - 2; $row++) {
            for ($col = 0; $col < $cols - 2; $col++) {
                if ($this->checkCrossPattern($matrix, 'MAS', $row, $col)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    private function searchWordInDirection(array $matrix, string $word, int $startRow, int $startCol, array $direction): bool
    {
        return $this->searchWord($matrix, $word, $startRow, $startCol, $direction)
               || $this->searchWord($matrix, strrev($word), $startRow, $startCol, $direction);
    }

    private function checkCrossPattern(array $matrix, string $word, int $row, int $col): bool
    {
        return ($this->searchWordInDirection($matrix, $word, $row, $col, [1, 1])
                && $this->searchWordInDirection($matrix, $word, $row, $col + 2, [1, -1]));
    }

    private function searchWord(array $matrix, string $word, int $startRow, int $startCol, array $direction): bool
    {
        if ($word[0] !== $matrix[$startRow][$startCol]) {
            return false;
        }

        $wordLength = strlen($word);

        for ($i = 1; $i < $wordLength; $i++) {
            $row = $startRow + $i * $direction[0];
            $col = $startCol + $i * $direction[1];

            if (($matrix[$row][$col] ?? null) !== $word[$i]) {
                return false;
            }
        }

        return true;
    }
}
