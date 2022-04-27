<?php
$burger = (new BurgerBuilder(14))
    ->addCheese()
    ->addPepperoni()
    ->build();

$burger->consume();