# PHP Keys Mover

## Purpose
This class is intended to change keys order in associative arrays with one line of code.

## Installation

```
composer require germanovs/php-keys-mover
```

## Properties

`string $message`
Contains information about last operation. You can read this to find what excatly went wrong, if any methods returned false.

## Methods

`move(array &$array, string|integer $key, string|integer $where): bool`

- Moves `$key` in `$where` position inside `$array`.
- `$key` can be string as key or integer as index.
- Modifies source array directly.
- Returns `true` in case of success, `false` on failure.

Usage
```php
$keyMover = new KeysMover\KeysMover();
$array = [
    'one' => 1,
    'two' => 2,
    'three' => 3
];
```
```php
$keyMover->move($array, 'one', 'two');
/*
result:
[
    'two' => 2,
    'one' => 1,
    'three' => 3
]
*/
```
```php
$keyMover->move($array, 'two', 2);
/*
result:
[
    'one' => 1,
    'three' => 3,
    'two' => 2
]
*/
```

## Future methods
These methods will be available in future versions
- `shift(array &$array, string|integer $key, integer $shift): bool`
Moves `$key` by `$shift` positions
Ex: ```$keysMover->shift($array, 'three', -2);```

- `moveAfter(array &$array, string|integer $key, string|integer $target): bool`
Puts `$key` after `$target`
Ex: ```$keysMover->moveAfter($array, 'three', 'one');```

- `moveBefore(array &$array, string|integer $key, string|integer $target): bool`
Puts `$key` before `$target`
Ex: ```$keysMover->moveAfter($array, 'three', 'two');```

- `rearrange(array &$array, array $order): bool`
Rearranges keys in `$array`, using `$order` as pattern
Ex: ```$keysMover->rearrange($array, ['two', 'three', 'one']);```

## License
MIT

**Free Software, Hell Yeah!**