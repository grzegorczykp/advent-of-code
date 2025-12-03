<?php

declare(strict_types=1);

namespace App2024\Assignments;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class Day10 extends \App2024\BaseAssignment
{
    private const array MOVE_DIRECTIONS = [
        'Up' => [0, -1],
        'Down' => [0, 1],
        'Left' => [-1, 0],
        'Right' => [1, 0],
    ];

    protected int $day = 10;

    public function parseInput(string $input): Collection
    {
        $map = Str::of($input)
            ->explode(PHP_EOL)
            ->map(fn(string $line): array => array_map('intval', str_split($line)));

        return collect([
            'map' => $map,
            'mapXSize' => count($map[0]),
            'mapYSize' => count($map),
        ]);
    }

    protected function part1(): int
    {
        $reachedTops = 0;
        foreach ($this->parsedDataArray['map'] as $y => $row) {
            foreach ($row as $x => $level) {
                if ($level === 0) {
                    $reachedTops += $this->hikeToTop($x, $y, false);
                }
            }
        }

        return $reachedTops;
    }

    protected function part2(): int|string
    {
        $reachedTops = 0;
        foreach ($this->parsedDataArray['map'] as $y => $row) {
            foreach ($row as $x => $level) {
                if ($level === 0) {
                    $reachedTops += $this->hikeToTop($x, $y, true);
                }
            }
        }

        return $reachedTops;
    }

    /**
     * @return int Returns count of unique reachable tops if `$countPaths = false`, else count of unique paths to top
     */
    private function hikeToTop(int $fromX, int $fromY, bool $countPaths, ?array &$visitedTops = null): int
    {
        $visitedTops ??= [];

        if ($this->parsedDataArray['map'][$fromY][$fromX] === 9) {
            if (!($visitedTops[$fromY][$fromX] ?? false)) {
                $visitedTops[$fromY][$fromX] = true;

                return 1;
            }

            return $countPaths ? 1 : 0;
        }

        $reachableTops = 0;

        foreach (self::MOVE_DIRECTIONS as $move) {
            $newX = $fromX + $move[0];
            $newY = $fromY + $move[1];

            if (
                $newX < 0
                || $newY < 0
                || $newX >= $this->parsedDataArray['mapXSize']
                || $newY >= $this->parsedDataArray['mapYSize']
                || $this->parsedDataArray['map'][$newY][$newX] - $this->parsedDataArray['map'][$fromY][$fromX] !== 1
            ) {
                continue;
            }

            $reachableTops += $this->hikeToTop($newX, $newY, $countPaths, $visitedTops);
        }

        return $reachableTops;
    }
}
