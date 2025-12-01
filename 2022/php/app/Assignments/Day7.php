<?php

declare(strict_types=1);

namespace App2022\Assignments;

use App2022\BaseAssignment;
use Illuminate\Support\Collection;

final class Day7 extends BaseAssignment
{
    public function __construct(bool $isTest = false, int $day = 7)
    {
        parent::__construct($isTest, $day);
    }

    public function parseInput(string $input): Collection
    {
        foreach (explode(PHP_EOL, $input) as $line) {
            $tok = explode(' ', $line);
            if ($tok[0] === '$') {
                if ($tok[1] === 'cd') {
                    $path = match ($tok[2]) {
                        '/' => 'root/',
                        '..' => (
                            strrpos($path, '/', -1) === false
                            ? 'root/'
                            : substr($path, 0, strrpos($path, '/', -1) - 1)
                        ),
                        default => $path . $tok[2] . '/',
                    };
                }
            } elseif ($tok[0] !== 'dir') {
                $dirs[$path][$tok[1]] = $tok[0];
            }
        }
        $totals = [];
        foreach ($dirs as $path => $files) {
            $pathWalk = '';
            foreach (explode('/', $path) as $segment) {
                if ($segment === '') {
                    continue;
                }
                $pathWalk .= '/' . $segment;
                if (array_key_exists($pathWalk, $totals)) {
                    $totals[$pathWalk] += array_sum($files);
                } else {
                    $totals[$pathWalk] = array_sum($files);
                }
            }
        }

        return collect($totals);
    }

    public function run(): array
    {
        return [
            $this->run1(),
            $this->run2(),
        ];
    }

    private function run1(): int
    {
        return $this->parsedData->where(fn($v) => $v < 100000)->sum();
    }

    private function run2(): int
    {
        $availSpace = 70_000_000 - $this->parsedData->first();

        return $this->parsedData
            ->sort()
            ->first(fn($v) => $availSpace + $v >= 30_000_000);
    }
}
