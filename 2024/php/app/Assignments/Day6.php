<?php

declare(strict_types=1);

namespace App2024\Assignments;

use Exception;
use Illuminate\Support\Collection;
use RuntimeException;

final class Day6 extends \App2024\BaseAssignment
{
    protected int $day = 6;

    public function parseInput(string $input): Collection
    {
        $directionRegex = '/[\^<>v]/';
        $lineLength = strpos($input, PHP_EOL) + 1;

        preg_match($directionRegex, $input, $matches, PREG_OFFSET_CAPTURE);

        [$direction, $offset] = $matches[0];
        $row = (int) floor($offset / $lineLength);
        $position = [
            $offset - $row * $lineLength,
            $row,
        ];

        $map = collect(explode(PHP_EOL, $input))
            ->map(fn(string $line): array => str_split($line));

        return collect([
            'map' => $map,
            'position' => $position,
            'direction' => match ($direction) {
                '^' => [0, -1],
                '>' => [1, 0],
                'v' => [0, 1],
                '<' => [-1, 0],
            },
        ]);
    }

    protected function part1(): int
    {
        $traversedMap = $this->exploreMap($this->parsedDataArray['map']);

        return substr_count(implode(array_map('implode', $traversedMap)), 'o');
    }

    protected function part2(): int
    {
        $loopCount = 0;

        $mapSize = count($this->parsedDataArray['map']);

        for ($i = 0; $i < $mapSize; $i++) {
            for ($j = 0; $j < $mapSize; $j++) {
                if ($this->parsedDataArray['map'][$i][$j] !== '.') {
                    continue;
                }
                $changedMap = $this->parsedDataArray['map'];
                $changedMap[$i][$j] = '#';

                try {
                    $this->exploreMap($changedMap);
                } catch (Exception $e) {
                    $loopCount++;
                }
            }
        }

        return $loopCount;
    }

    private function rotateClockwise90(array $vector): array
    {
        return [-$vector[1], $vector[0]];
    }

    /**
     * @return array<int, int[]>
     */
    public function exploreMap(array $map): array
    {
        $visited = $map;
        $position = $this->parsedDataArray['position'];
        $mapSize = count($map);
        $direction = $this->parsedDataArray['direction'];
        $visitsDirection = array_fill(0, $mapSize, array_fill(0, $mapSize, 0));

        do {
            if ($visited[$position[1]][$position[0]] !== '#') {
                $visited[$position[1]][$position[0]] = 'o';

                $positionKey = match ($direction) {
                    [0, -1] => 1,
                    [1, 0] => 1 << 1,
                    [0, 1] => 1 << 2,
                    [-1, 0] => 1 << 3,
                };

                if ($visitsDirection[$position[1]][$position[0]] & $positionKey) {
                    throw new RuntimeException('Infinite loop');
                }
                $visitsDirection[$position[1]][$position[0]] |= $positionKey;
            } else {
                $position[0] -= $direction[0];
                $position[1] -= $direction[1];
                $direction = $this->rotateClockwise90($direction);
            }

            $position[0] += $direction[0];
            $position[1] += $direction[1];
        } while ($position[0] >= 0 && $position[0] < $mapSize && $position[1] >= 0 && $position[1] < $mapSize);

        return $visited;
    }
}
