[Rus version](README.MD)

## What is this?

Tasks from a live-coding interview for the position of php/golang backend developer at AvitoTech.

### Problem #1: Array addition

We want to add very large numbers that exceed the capacity of the base types,
so we store them as an array of non-negative numbers.

You need to write a function that will take two such arrays as input,
will calculate the sum of the numbers represented by the arrays and return the result as the same array.

#### Example

```
input

arr1 = [1, 2, 3] # number 123
arr2 = [4, 5, 6] # number 456

conclusion

res = [5, 7, 9] # number 579
```

#### Solution
Recall the course of school mathematics.
We will add two numbers, starting with the least significant digits (i.e. from the end),
with the remainder of the addition carried over to the next bit.

#### Launch
```
php array_sum.php
```

----------------------

### Task #2: The most popular array elements

Given an array of integers nums and an integer k.

You need to write a PHP function that takes out the k most frequently occurring elements from an array.

#### Example
```
input
nums = [1,1,1,2,2,3]
k = 2

output (in any order)
[12]
```

#### Solution #1 (not optimal)

We build an array of frequency of occurrence of elements, sort it in descending order (f-th arsort).
We take the first N elements from the sorted array.

(*) This solution is **not optimal** because alg. complexity is O(N*log(n)) due to the sort function:

The arsort function in PHP sorts an array by value in reverse order (largest to smallest).
Algorithmic complexity of the arsort function: O(N log N), where N is the size of the sorted array.

*How to solve the problem in O(N) time? See solution #2.*

Launch:
```
php freq_nums.php
```

#### Solution #2 (optimal)

Here, instead of sorting, we build a hash array of the form:
```
[<frequency> => <elements>]
```
Thus, running through its elements (from the highest element down),
get the elements of the original array with maximum frequencies.

Launch:
```
php freq_nums2.php
```

----------------------

### Task #3 (Platform section): Adding caching
Add caching to the getByIds method in the file (the interface for the cache is specified),
That. so that the IDs are cached and the API is accessed only if the data is not in the cache.

#### Source
see file ``cache_task_src.php``

#### Solution
see file ``cache_task_solution.php``

----------------------

### Task #4 (Platform section): Reading a large log

In the code below, write the body of the numberOfErrors method, i.e.,
so that it counts the number of errors of the specified type in the log file.
The trick is that the file can. large (many GB), and the script should not crash
due to memory limits.

(*) **Add. question:** how to give the result after 100 micro-seconds of startup?
That is, if the server has set a time limit for running the script
in ~ 100 ms, and you cannot exceed it, and you need to give the result (number of counted errors) -
how much did you count during this time.

#### Source
see file ``read_log_src.php``

#### Solution
see file ``read_log_solution.php``