[Russian version](README.md)

## Question/problem

How to test a function in PHPUnit that multiplies an argument by a random number
and returns the result of the multiplication? (see ``Randomizer``).

## Answer/solution

To test a function that uses random numbers,
in PHPUnit, you can use a mock object and replace the random generator
numbers to a test-controlled source of pseudo-random numbers.

For example:
see ``MutlTest.php``

Here:
- create a Class with a pseudo-random number Randomizer
- Tested function multiplyByRandom
- write a testMultiply() test for phpunit
    - Create a mock
    - Set the sequence of values
    - Inject mock into function
    - Checking the "non-random" result

This way we mimic the behavior of ``Randomizer`` and can test
function for different fixed random values.

## Run
```
phpunit .\Multtest.php
```