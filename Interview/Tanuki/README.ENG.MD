[Russian version](README.md)
<img src="../../ru.png" alt="rus" width="20"/>

## Test task

### Condition

There is a large system that brings significant income to the company and, therefore,
high demands are placed on the quality of its code.

This system, among other things, uses exchange rates.

The logic for getting exchange rates is as follows:

- Client side can get them from cache,
  from the database and from an external source via http.

- If the exchange rate is not in the cache, you need to check the database,
  and if there is, put it in the cache.

- If not in the database - check the external source and put both in the database and in the cache.

We need to implement this logic. It is supposed to be used in a bunch of different places.
Probably, there are inaccuracies in the condition, some behavior is not specified, and so on.

You need to decide on your own what to do in each such case and clearly mark it -
either in a comment or in a file like readme.

In the same file, write what you would do differently if you had more time;
what were your thoughts on how this code should look like in general, what were you striving for

### Wishes for implementation

Language - ``php 7.2``

Functionality for sending requests,
storage of data in the database and in the cache is not necessary to implement,
instead of them, it is enough to make stubs.

In general, your main goal is to show a design approach,
not write production-ready code.

No need to implement time-consuming technical details.

Instead, it is more important how you decomposed the subject area,
what your classes look like, where you put the logic.

### Solution
See file ``index.php``