[Russian version](README.md)
<img src="../../ru.png" alt="rus" width="20"/>

## TASK
It is necessary to write a function that takes an array with a list of words as input
and returns the grouped words.

One group includes words that can be obtained from one another
by random permutation of letters.

## EXAMPLE
For example:
```
     makeGroups( array('rfv', 'vfr', 'abc', 'bac', 'dbatre', 'qwer', 'cba', 'terbda') )
```
Will return:
```
     array(
         array('rfv', 'vfr'),
         array('abc', 'bac', 'cba'),
         array('dbatre', 'terbda'),
         array('qwer'),
     )
```
Here rfv is obtained from vfr by interchanging v and r, and from the words abc,
bac and cba form a common group,
because any of these words turns into a neighboring one by one
or several permutations of letters.


## NOTES
* Test your code.
* (!) This is a statement of the problem, see the solution in the file ``solution.php``