<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

final class Y2025 extends TestCase
{
    public function testDay1(): void
    {
        $assignment = new \App2025\Assignments\Day1(true);
        $result = $assignment->run();
        $this->assertIsArray($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(3, $result[0]);
        $this->assertArrayHasKey(1, $result);
        $this->assertEquals(6, $result[1]);
    }
}
