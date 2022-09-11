<?php

use PHPUnit\Framework\TestCase;

class KeysMoverTest extends TestCase {

	public function testMoveKey()
	{
		$mover = new KeysMover\KeysMover;
		$source = [
			'one' => 1,
			'two' => 2,
			'three' => 3,
			'four' => 4,
			'five' => 5
		];
		
		// test 1: common, up, targets by names
		$test = $source;
		$mover->moveKey($test, 'four', 'two');
		$expected = [
			'one' => 1,
			'four' => 4,
			'two' => 2,
			'three' => 3,
			'five' => 5
		];
		$this->assertSame($expected, $test);
		
		// test 2: common, down, targets by names
		$test = $source;
		$mover->moveKey($test, 'two', 'four');
		$expected = [
			'one' => 1,
			'three' => 3,
			'four' => 4,
			'two' => 2,
			'five' => 5
		];
		$this->assertSame($expected, $test);
	}

}