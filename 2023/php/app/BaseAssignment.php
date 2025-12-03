<?php

declare(strict_types=1);

namespace App2023;

use Illuminate\Support\Collection;

abstract class BaseAssignment
{
    protected string $inputData;

    protected Collection $parsedData;

    private string $basePath = __DIR__ . '/../../data/';

    private int $day;

    private bool $isTest;

    public function __construct(bool $isTest = false, int $day = 0)
    {
        $this->day = $day;
        $this->isTest = $isTest;
        $this->loadData();
        $this->parsedData = $this->parseInput($this->inputData);
    }

    protected function loadData(): void
    {
        $extension = $this->isTest ? '/test' : '/input';

        $this->inputData = file_get_contents($this->basePath . str_pad((string) $this->day, 2, '0', STR_PAD_LEFT) . $extension);
    }

    abstract public function parseInput(string $input): Collection;

    abstract public function run(): array;
}
