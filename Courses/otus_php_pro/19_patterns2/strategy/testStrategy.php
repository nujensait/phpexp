<?php

// создаём коллекцию новостей
$collection = new NewsCollection([]);

if($_POST['sort_by'] == 'date'){
    // сортировка по дате
    $collection->setComparator(new DateComparator());
}
else{
    $collection->setComparator(new CountComparator());
}

$className = $_POST['sort_by'] . "Comparator";
if(class_exists($className) && $className instanceof ComparatorInterface){
    $collection->setComparator(new $className());
}
else{
    throw new Exception();
}

try {
    $elements = $collection->sort();
} catch (Exception $e) {
    /* ... */
}