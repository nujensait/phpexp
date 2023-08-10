<?php
$devManager = new DevelopmentManager();
$devManager->takeInterview();

$ceManager = new CommunityExecutive();
$ceManager->takeInterview();

$managers = [$ceManager, $devManager];

foreach($managers as $manager){
    $manager->takeInterview();
}