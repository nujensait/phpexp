<?php

use PHPUnit\Framework\TestCase;

require_once("run.php");

final class SameStructureAsTest extends TestCase {
    public function testDescriptionExamples() {
        $this->assertTrue(same_structure_as([1, 1, 1], [2, 2, 2]));         // T
        $this->assertTrue(same_structure_as([1, [1, 1]], [2, [2, 2]]));     // T
        $this->assertFalse(same_structure_as([1, [1, 1]], [[2, 2], 2]));    // F
        $this->assertFalse(same_structure_as([1, [1, 1]], [[2], 2]));       // F
        $this->assertTrue(same_structure_as([[[], []]], [[[], []]]));       // T
        $this->assertFalse(same_structure_as([[[], []]], [[1, 1]]));        // F
    }
}