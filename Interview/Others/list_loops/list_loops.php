<?php

// Напиши функцию на php, которая сможет обнаружить наличие петли (т.е. зацикливание) в односвязном списке ,
// либо отсутствие петель.

// Write a php function that can detect the presence of a loop (i.e. loop)
// in a singly linked list, or the absence of loops.

/**
 * @param $head
 * @return bool
 */
function hasLoop(Node $head): bool
{
    $slow = $head;
    $fast = $head;
    while ($fast !== null && $fast->next !== null) {
        $slow = $slow->next;
        $fast = $fast->next->next;
        if ($slow === $fast) {
            return true;
        }
    }
    return false;
}
// example usage
class Node {
    public int $data;
    public Node $next;

    /**
     * @param $data
     */
    public function __construct(int $data) {
        $this->data = $data;
        $this->next = null;
    }
}
$a = new Node(1);
$b = new Node(2);
$c = new Node(3);
$d = new Node(4);

$a->next = $b;
$b->next = $c;
$c->next = $d;
var_dump(hasLoop($a)); // false

$d->next = $b;
var_dump(hasLoop($a)); // true