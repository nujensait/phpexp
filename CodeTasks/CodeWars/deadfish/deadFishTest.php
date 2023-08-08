<?php

use PHPUnit\Framework\TestCase;

require_once("run.php");

class deadFishTest extends TestCase
{
    public function testSampleTests() {
        $this->assertSame([ 8, 64 ], parse("iiisdoso"));
        $this->assertSame([ 8, 64 ], parse("iiisxxxdoso"));
    }
}