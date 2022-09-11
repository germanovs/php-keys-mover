<?php
namespace KeysMover;

class KeysMover {

	public $message = '';

	public function moveKey(array &$array, $what, $where, bool $swap = false):bool
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
		если таргетИндекс = 0, просто поднимаем ключ максимально вверх
		если таргерИндекс = длине массива, т.е. он должен стоять в конце, опускаем максимально вниз
		иначе сортируем
		*/

		if ($targetIndex === 0) {
			// echo '<pre>';
			// print_r('move max up');
			// echo '</pre>';
			uksort($array, function ($prev, $next) use ($what) {
				// echo '<pre>';
				// print_r('Prev is: ' . $prev . '<br>');
				// print_r('Next is: ' . $next);
				// echo '</pre>';

				if ($next === $what) {
					return 1;
				}

				return 0;
			});
			return true;
		} elseif ($targetIndex === (count($keys) - 1)) {
			// echo '<pre>';
			// print_r('move max down');
			// echo '</pre>';
			uksort($array, function ($prev, $next) use ($what) {
				// echo '<pre>';
				// print_r('Prev is: ' . $prev . '<br>');
				// print_r('Next is: ' . $next);
				// echo '</pre>';

				if ($prev === $what) {
					return 1;
				}

				return 0;
			});
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

		// echo '<pre>';
		// print_r($sortingDirection);
		// print_r($stopKey);
		// echo '</pre>';

		if ($sortingDirection === 1) {
			uksort($array, function($prev, $next) use ($what, $stopKey)
			{
				// echo '<pre>';
				// print_r('Prev is: '.$prev.'<br>');
				// print_r('Next is: '.$next);
				// echo '</pre>';
	
				if ($next === $what) {
					if ($prev !== $stopKey) {
						// echo '<pre>';
						// print_r('sort up');
						// echo '</pre>';
						return 1;
					}
				}
				
				return 0;
			});
		} else {
			uksort($array, function($prev, $next) use ($what, $stopKey)
			{
				// echo '<pre>';
				// print_r('Prev is: '.$prev.'<br>');
				// print_r('Next is: '.$next);
				// echo '</pre>';
	
				if ($prev === $what) {
					if ($next !== $stopKey) {
						// echo '<pre>';
						// print_r('sort down');
						// echo '</pre>';
						return 1;
					}
				}
				
				return 0;
			});
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

}
