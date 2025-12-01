<?php

declare(strict_types=1);

namespace App2024\Helpers\Day9;

final class File
{
    public readonly int $size;

    public readonly int $spaceAfter;

    public int $remainingSize;

    public int $memoryEndIndex {
        get => $this->memoryIndex + $this->size;
    }

    public function __construct(
        public readonly int $id,
        public readonly int $mapIndex,
        string              $map,
        public ?int $memoryIndex = null,
    ) {
        $this->size = (int) $map[$this->mapIndex];
        $this->remainingSize = $this->size;
        $this->spaceAfter = (int) ($map[$this->mapIndex + 1] ?? 0);
    }

    public function moveBytes(int $bytes = 1): void
    {
        $this->remainingSize -= $bytes;
    }

    public function moveEntire(): void
    {
        $this->remainingSize = 0;
    }
}
