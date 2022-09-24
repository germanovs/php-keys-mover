<?php

use PHPUnit\Framework\TestCase;

class KeysMoverTest extends TestCase {

	public function testMove()
	{

		$this->moveUp();
		$this->moveUpMax();
		$this->moveDown();
		$this->moveDownMax();

		/*
		to add:
		- non-existing named positions
		- integer positions
		- wrong and non-existing integer positions
		- with swap
		*/
	}

	protected function moveUp()
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
		$mover->move($source, 'four', 'two');
		$expected = [
			'one' => 1,
			'four' => 4,
			'two' => 2,
			'three' => 3,
			'five' => 5
		];
		$this->assertSame($expected, $source);
	}

	protected function moveDown()
	{
		// test 2: common, down, targets by names
		$mover = new KeysMover\KeysMover;
		$source = [
			'one' => 1,
			'two' => 2,
			'three' => 3,
			'four' => 4,
			'five' => 5
		];

		$mover->move($source, 'two', 'four');
		$expected = [
			'one' => 1,
			'three' => 3,
			'four' => 4,
			'two' => 2,
			'five' => 5
		];
		$this->assertSame($expected, $source);
	}
	
	protected function moveUpMax()
	{
		// test 3: common, max down, targets by names
		$mover = new KeysMover\KeysMover;
		$source = [
			'one' => 1,
			'two' => 2,
			'three' => 3,
			'four' => 4,
			'five' => 5
		];

		$mover->move($source, 'five', 'one');
		$expected = [
			'five' => 5,
			'one' => 1,
			'two' => 2,
			'three' => 3,
			'four' => 4
		];
		$this->assertSame($expected, $source);
	}

	protected function moveDownMax()
	{
		// test 4: common, max down, targets by names
		$mover = new KeysMover\KeysMover;
		$source = [
			'one' => 1,
			'two' => 2,
			'three' => 3,
			'four' => 4,
			'five' => 5
		];

		$mover->move($source, 'one', 'five');
		$expected = [
			'two' => 2,
			'three' => 3,
			'four' => 4,
			'five' => 5,
			'one' => 1
		];
		$this->assertSame($expected, $source);
	}

}