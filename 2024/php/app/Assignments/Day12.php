<?php

declare(strict_types=1);

namespace App2024\Assignments;

use Illuminate\Support\Collection;

final class Day12 extends \App2024\BaseAssignment
{
    private const array MOVE_DIRECTIONS = [
        'Up' => [0, -1],
        'Down' => [0, 1],
        'Left' => [-1, 0],
        'Right' => [1, 0],
    ];

    protected int $day = 12;

    private array $map;

    private int $mapXSize;

    private int $mapYSize;

    protected function parseInput(string $input): Collection
    {
        $this->map = collect(explode(PHP_EOL, $input))
            ->map(fn(string $line): array => str_split($line))
            ->toArray();
        $this->mapXSize = count($this->map[0]);
        $this->mapYSize = count($this->map);

        $seen = [];
        $spotStats = [];

        foreach ($this->map as $y => $row) {
            foreach ($row as $x => $value) {
                if ($seen["$x,$y"] ?? false) {
                    continue;
                }

                $spotStats["$x,$y:" . $this->map[$y][$x]] = $this->getSpotStats($x, $y, $seen);
            }
        }

        return collect([
            'spotStats' => $spotStats,
        ]);
    }

    protected function part1(): int
    {
        return array_reduce(
            $this->parsedDataArray['spotStats'],
            fn(int $carry, array $spotStats): int => $carry + $spotStats['area'] * $spotStats['perimeter'],
            0
        );
    }

    protected function part2(): int|string
    {
        return array_reduce(
            $this->parsedDataArray['spotStats'],
            fn(int $carry, array $spotStats): int => $carry + $this->countSides($spotStats['spotLocation']) * $spotStats['area'],
            0
        );
    }

    /**
     * @return array{area: int, perimeter: int, spotLocation: list<array{x: int, y: int}>}
     */
    private function getSpotStats(int $x, int $y, array &$seen): array
    {
        $seen["$x,$y"] = true;
        $map = $this->map;

        $perimeter = 0;
        $area = 1;
        $spotLocations = [
            [compact('x', 'y')],
        ];

        foreach (self::MOVE_DIRECTIONS as [$dx, $dy]) {
            [$nextX, $nextY] = [$x + $dx, $y + $dy];

            if (
                $nextX < 0 || $nextY < 0
                || $nextX >= $this->mapXSize
                || $nextY >= $this->mapYSize // Out of map
                || $map[$y][$x] !== $map[$nextY][$nextX] // Different plant
            ) {
                $perimeter++;
            } else {
                if ($seen["$nextX,$nextY"] ?? false) {
                    continue;
                }

                $stats = $this->getSpotStats($nextX, $nextY, $seen);
                $area += $stats['area'];
                $perimeter += $stats['perimeter'];
                $spotLocations[] = $stats['spotLocation'];
            }
        }
        $spotLocation = array_merge(...$spotLocations);

        return compact('area', 'perimeter', 'spotLocation');
    }

    private function countSides(array $spotLocations): int
    {
        $diagonalVectors = [
            'Up-Left' => [-1, -1],
            'Up-Right' => [1, -1],
            'Down-Left' => [-1, 1],
            'Down-Right' => [1, 1],
        ];
        $diagonalMoves = array_keys($diagonalVectors);
        $moveVectorsWithDiag = array_merge(
            self::MOVE_DIRECTIONS,
            $diagonalVectors
        );

        $corners = 0;

        foreach ($spotLocations as $spotLocation) {
            foreach ($diagonalMoves as $corner) {
                $x = $spotLocation['x'] + $moveVectorsWithDiag[$corner][0];
                $y = $spotLocation['y'] + $moveVectorsWithDiag[$corner][1];

                $adjacent1 = $moveVectorsWithDiag[explode('-', $corner)[0]];
                $adjacent2 = $moveVectorsWithDiag[explode('-', $corner)[1]];

                $adjacent1Location = ['x' => $spotLocation['x'] + $adjacent1[0], 'y' => $spotLocation['y'] + $adjacent1[1]];
                $adjacent2Location = ['x' => $spotLocation['x'] + $adjacent2[0], 'y' => $spotLocation['y'] + $adjacent2[1]];
                $cornerLocation = ['x' => $x, 'y' => $y];

                // Check inner corner
                if (!in_array($adjacent1Location, $spotLocations, true) && !in_array($adjacent2Location, $spotLocations, true)) {
                    $corners++;
                }

                // Check outer corner
                if (
                    in_array($adjacent1Location, $spotLocations, true)
                    && in_array($adjacent2Location, $spotLocations, true)
                    && !in_array($cornerLocation, $spotLocations, true)
                ) {
                    $corners++;
                }
            }
        }

        return $corners;
    }
}
