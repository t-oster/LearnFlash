<?php

$um = new Manager\UserManager();
$um->register("Max Mustermann", "max@musterstadt.eu", "test", "test");
$um->login("test", "test");

$cm = new \Manager\CardsManager();
$cm->createCard($um->getLoggedInUser(), "Card A", "Hello", "World", array("tag1","tag2","tagC"));

$cm->createCard($um->getLoggedInUser(), "Card B", "Hello", "World", array("tag2","tagC"));

$cm->createCard($um->getLoggedInUser(), "Card C", "Hello", "World", array("tagC"));


?>
