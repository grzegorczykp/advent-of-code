<?php

declare(strict_types=1);

namespace App2025\Assignments;

use Illuminate\Support\Collection;
use InvalidArgumentException;

final class Day1 extends \App2025\BaseAssignment
{
    protected int $day = 1;

    protected function parseInput(string $input): ?Collection
    {
        return collect(explode(PHP_EOL, $input))
            ->map(fn($line): array => [$line[0], (int) substr($line, 1)]);
    }

    protected function part1(): int|string
    {
        $rotation = 50;
        $zeroCounter = 0;
        foreach ($this->parsedData as $move) {
            [$direction, $angle] = $move;
            match ($direction) {
                'R' => $rotation = ($rotation + $angle) % 100,
                'L' => $rotation = ($rotation - $angle % 100 + 100) % 100,
                default => throw new InvalidArgumentException('Invalid direction'),
            };
            if ($rotation === 0) {
                $zeroCounter++;
            }
        }

        return $zeroCounter;
    }

    protected function part2(): int|string
    {
        $rotation = 50;
        $zeroCounter = 0;
        foreach ($this->parsedData as $move) {
            [$direction, $angle] = $move;
            switch ($direction) {
                case 'R':
                    $rotated = $rotation + $angle;
                    $zeroCounter += (int) ($rotated / 100);
                    $rotation = $rotated % 100;

                    break;
                case 'L':
                    $zeroCounter += (int) ((99 - ($rotation + 99) % 100 + $angle) / 100);
                    $rotation = ($rotation - $angle % 100 + 100) % 100;

                    break;
                default:
                    throw new InvalidArgumentException('Invalid direction');
            }
        }

        return $zeroCounter;
    }
}
