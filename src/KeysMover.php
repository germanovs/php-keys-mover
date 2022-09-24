<?php
namespace KeysMover;

class KeysMover {

	public $message = '';

	public function move(array &$array, $what, $where, bool $swap = false):bool
	{
		$keys = array_keys($array);

		// check and setup target
		$sourceIndex = $this->checkAndGetIndex($keys, $what);
		if ($sourceIndex < 0) {
			return false;
		}

		// check and setup target
		$targetIndex = $this->checkAndGetIndex($keys, $where);
		if ($targetIndex < 0) {
			return false;
		}
		
		/* 
		if target index === 0, move key max up
		if target index === array length, move key max in the end
		else make sorting with rules
		*/

		if ($targetIndex === 0) {
			$this->sortMaxUp($array, $what);
			return true;
		} elseif ($targetIndex === (count($keys) - 1)) {
			$this->sortMaxDown($array, $what);
			return true;
		}
		
		// define sorting direction
		if ($sourceIndex > $targetIndex) {
			// move key up
			$sortingDirection = 1;
			$stopIndex = $targetIndex - 1;
			$stopKey = $keys[$stopIndex];
		}
		elseif ($sourceIndex < $targetIndex) {
			// move key down
			$sortingDirection = -1;
			$stopIndex = $targetIndex + 1;
			$stopKey = $keys[$stopIndex];
		}
		else {
			$this->message = 'Key in place, no actions needed';
			return true;
		}

		if ($sortingDirection === 1) {
			$this->sortUp($array, $what, $stopKey);
		} else {
			$this->sortDown($array, $what, $stopKey);
		}
		
		return true;
	}

	private function checkAndGetIndex(array $keysSet, $key):int
	{
		if (is_string($key)) {
			// $targetKey = $where;
			$index = array_search($key, $keysSet);
			if ($index === false) {
				$this->message = "Key '${key}' does not exist";
				return -1;
			}
		} elseif (is_integer($key)) {
			if ($key < 0) {
				$this->message = 'Index must be > 0';
				return -1;
			}
			// $targetKey = $keys[$where];
			$index = $key;
		} else {
			$this->message = "Key '${key}' must be string or integer";
			return -1;
		}
		$length = count($keysSet);
		if ($index > ($length - 1)) {
			$this->message = "Key '${key}' is out of array scope";
			return -1;
		}
		return $index;
	}	

	private function sortMaxUp(array &$array, string $key): void
	{
		uksort($array, function ($prev, $next) use ($key) {
			if ($next === $key) {
				return 1;
			}
			return 0;
		});
	}

	private function sortMaxDown(array &$array, string $key): void
	{
		uksort($array, function ($prev, $next) use ($key) {
			if ($prev === $key) {
				return 1;
			}
			return 0;
		});
	}

	private function sortUp(array &$array, string $key, string $stopKey): void
	{
		uksort($array, function ($prev, $next) use ($key, $stopKey) {
			if ($next === $key) {
				if ($prev !== $stopKey) {
					return 1;
				}
			}
			return 0;
		});
	}

	private function sortDown(array &$array, string $key, string $stopKey): void
	{
		uksort($array, function ($prev, $next) use ($key, $stopKey) {
			if ($prev === $key) {
				if ($next !== $stopKey) {
					return 1;
				}
			}
			return 0;
		});
	}
}
