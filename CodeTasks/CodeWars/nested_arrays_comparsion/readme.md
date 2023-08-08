## Task title
Nesting Structure Comparison

## Task source
https://www.codewars.com/kata/520446778469526ec0000001

## Task
Complete the function/method (depending on the language) to return true/True 
when its argument is an array that has the same nesting structures and 
same corresponding length of nested arrays as the first array.

For example:
```
same_structure_as([1, 1, 1], [2, 2, 2]);        // => true
same_structure_as([1, [1, 1]], [2, [2, 2]]);    // => true
same_structure_as([1, [1, 1]], [[2, 2], 2]);    // => false
same_structure_as([1, [1, 1]], [[2], 2]);       // => false
same_structure_as([[[], []]], [[[], []]]);      // => true
same_structure_as([[[], []]], [[1, 1]]);        // => false
```

You may assume that all arrays passed in will be non-associative.

# Run
```
php run.php
phpunit SameStructureAsTest.php
```