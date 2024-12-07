<?php

declare(strict_types=1);

namespace App2024\Assignments;

use Illuminate\Support\Collection;

final class Day2 extends \App2024\BaseAssignment
{
    public function __construct(bool $isTest = false, int $day = 2)
    {
        parent::__construct($isTest, $day);
    }

    public function parseInput(string $input): Collection
    {
        return collect(explode(PHP_EOL, $input))
            ->map(fn (string $v): Collection => collect(explode(' ', $v))->map(fn ($v) => (int)$v));
    }

    public function run(): array
    {
        return [
            $this->run1(),
            $this->run2(),
        ];
    }

    private function run1(): int|string
    {
        return $this->parsedData
            ->filter(fn (Collection $v): bool => $this->isValidRoute($v))
            ->count();
    }

    private function run2(): int|string
    {
        return $this->parsedData
            ->filter(function (Collection $route): bool {
                if ($this->isValidRoute($route)) {
                    return true;
                }

                foreach ($route as $index => $item) {
                    $shortRoute = $route->toArray();
                    unset($shortRoute[$index]);
                    if ($this->isValidRoute(array_values($shortRoute))) {
                        return true;
                    }
                }

                return false;
            })
            ->count();
    }

    private function isValidRoute(Collection|array $route): bool
    {
        $lastDiff = null;

        for ($i = 1, $iMax = count($route); $i < $iMax; $i++) {
            $diff = $route[$i] - $route[$i - 1];
            if (
                $diff === 0
                || ($lastDiff !== null && $diff * $lastDiff < 0)
                || abs($diff) > 3
            ) {
                return false;
            }

            $lastDiff = $diff;
        }

        return true;
    }
}
