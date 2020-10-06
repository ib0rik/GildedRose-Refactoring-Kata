# GildedRose Kata (Solution) - PHP Version

See the [top level readme](../README.md) for general information about this exercise. This is the PHP version of the
 GildedRose Kata. 

## Installation & use

The kata uses:

- PHP 7.2+
- [Composer](https://getcomposer.org)

Clone the repository


```shell script
git clone --single-branch --branch solution https://github.com/ib0rik/GildedRose-Refactoring-Kata.git
```

Install all the dependencies using composer

```shell script
cd ./GildedRose-Refactoring-Kata/php
composer install
```

Now run tests to check if the code works

```shell script
composer test
```

## Folders

- `src` - contains the two classes:
  - `enum` - this folder contains enums
    - `ItemName.php` - this class enumerates all possible item's names.
  - `strategies` - this folder contains update strategies
  - `Item.php` - this class should not be changed.
  - `GildedRose.php` - this class has been refactored, and the new feature is present and working.
- `tests` - contains the tests
  - `GildedRoseTest.php` - Starter test.
  - `ApprovalTest.php` - alternative approval test (set to 30 days)
- `Fixture`
  - `texttest_fixture.php` used by the approval test, or can be run from the command line

**Happy analyse**!
Don't hesitate to let me a message if you want to talk code :)