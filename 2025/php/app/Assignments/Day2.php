<?php

declare(strict_types=1);

namespace App2025\Assignments;

use Illuminate\Support\Collection;

final class Day2 extends \App2025\BaseAssignment
{
    protected int $day = 2;

    protected function parseInput(string $input): ?Collection
    {
        return collect(explode(',', $input))
            ->map(fn($line): array => array_map('intval', explode('-', $line)));
    }

    protected function part1(): int|string
    {
        $sum = 0;

        foreach ($this->parsedDataArray as $idRange) {
            [$start, $end] = $idRange;
            for ($id = $start; $id <= $end;) {
                $str = (string) $id;
                $digitCount = strlen($str);

                if ($digitCount % 2 !== 0) {
                    $id = 10 ** $digitCount;

                    continue;
                }

                if (str_starts_with($str, substr($str, $digitCount / 2))) {
                    $sum += $id;
                }

                $id++;
            }
        }

        return $sum;
    }

    protected function part2(): int|string
    {
        $sum = 0;
        foreach ($this->parsedDataArray as $idRange) {
            [$start, $end] = $idRange;
            for ($id = $start; $id <= $end; $id++) {
                if ($this->isInvalidIdOptimized($id)) {
                    $sum += $id;
                }
            }
        }

        return $sum;
    }

    private function isInvalidId(int $id): bool
    {
        $strId = (string) $id;
        $strIdLength = strlen($strId);
        $limit = intdiv($strIdLength, 2);
        for ($divisor = 1; $divisor <= $limit; $divisor++) {
            if ($strIdLength % $divisor === 0) {
                $a = str_split($strId, $divisor);
                $b = array_unique($a);

                if (count($b) === 1) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isInvalidIdOptimized(int $id): bool
    {
        $strId = (string) $id;
        $ss = $strId . $strId;
        $inner = substr($ss, 1, -1);

        return str_contains($inner, $strId);
    }
}
