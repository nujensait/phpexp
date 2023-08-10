<?php

$hunter = new Hunter();

$wildDog = new WildDog();
$adaptedDog = new WildDogAdapter($wildDog);

$hunter->hunt($adaptedDog);