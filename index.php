<?php
include './main.php';
//Parameter in instantiated main object is a page number
$main = new Main(2);
$main->startScript();
$main->showDataProperties();
