### Source
https://www.codewars.com/kata/55de8eabd9bef5205e0000ba

## Task title
5 kyu Emirps

### Task
If you reverse the word "emirp" you will have the word "prime". 
That idea is related with the purpose of this kata: we should select 
all the primes that when reversed are a different prime (so palindromic 
primes should be discarded).

For example: 13, 17 are prime numbers and the reversed respectively are 31, 71 
which are also primes, so 13 and 17 are "emirps". But primes 757, 787, 797 
are palindromic primes, meaning that the reversed number is the same as the original,
so they are not considered as "emirps" and should be discarded.

The emirps sequence is registered in OEIS as A006567: https://oeis.org/A006567

#### Your task
Create a function that receives one argument n, as an upper limit, 
and the return the following array:

```
[number_of_emirps_below_n, largest_emirp_below_n, sum_of_emirps_below_n]
```

### Examples
```
find_emirp(10)
[0, 0, 0] ''' no emirps below 10 '''

find_emirp(50)
[4, 37, 98] ''' there are 4 emirps below 50: 13, 17, 31, 37; largest = 37; sum = 98 '''

find_emirp(100)
[8, 97, 418] ''' there are 8 emirps below 100: 13, 17, 31, 37, 71, 73, 79, 97; largest = 97; sum = 418 '''
```

## My solutions

### Simplest (#1): emirps.php

The algorithmic complexity of the find_emirp function depends on the complexity of the is_prime nested function, which tests a number for primeness.

The is_prime function iterates over the divisors from 2 to the square root of a number. This gives O(sqrt(n)) complexity.

The find_emirp function calls is_prime for every number from 2 to n. So the total difficulty will be:

O(n*sqrt(n))

This can also be simplified as O(n^1.5).

Thus, the algorithmic complexity of find_emirp is O(n^1.5).

This is pretty good, since enumeration of all numbers up to n has O(n) complexity. But using more optimal primality testing algorithms, such as the sieve of Eratosthenes, will reduce the complexity.

### Perfomance (#2): emirps2.php

Here we are pre-calculate prime sequence,
to skip multiple call is_prime function.

(*) Also, here we use **static** methods to
remember perviously calulated results 
(no need to calulate it again for second test).

It speeds up our caluclations significantly!

## Check
```
php emirps.php
php emirps2.php
```

## Test results

*All tests are passed!*

