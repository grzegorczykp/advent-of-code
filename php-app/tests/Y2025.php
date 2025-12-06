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

    public function testDay2(): void
    {
        $assignment = new \App2025\Assignments\Day2(true);
        $result = $assignment->run();
        $this->assertIsArray($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(1227775554, $result[0]);
        $this->assertArrayHasKey(1, $result);
        $this->assertEquals(4174379265, $result[1]);
    }

    public function testDay3(): void
    {
        $assignment = new \App2025\Assignments\Day3(true);
        $result = $assignment->run();
        $this->assertIsArray($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(357, $result[0]);
        $this->assertArrayHasKey(1, $result);
        $this->assertEquals(3121910778619, $result[1]);
    }

    public function testDay4(): void
    {
        $assignment = new \App2025\Assignments\Day4(true);
        $result = $assignment->run();
        $this->assertIsArray($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(13, $result[0]);
        $this->assertArrayHasKey(1, $result);
        $this->assertEquals(43, $result[1]);
    }

    public function testDay5(): void
    {
        $assignment = new \App2025\Assignments\Day5(true);
        $result = $assignment->run();
        $this->assertIsArray($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(3, $result[0]);
        $this->assertArrayHasKey(1, $result);
        $this->assertEquals(14, $result[1]);
    }

    public function testDay6(): void
    {
        $assignment = new \App2025\Assignments\Day6(true);
        $result = $assignment->run();
        $this->assertIsArray($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(4277556, $result[0]);
        $this->assertArrayHasKey(1, $result);
        $this->assertEquals(3263827, $result[1]);
    }
}
