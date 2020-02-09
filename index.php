<?php

/* Tina O
 * 01-15-2020
 * /328/food/index.php
 */

//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require("vendor/autoload.php");

//Define variables
$meals = array('breakfast', 'lunch', 'dinner');
$condiments = array('mayonnaise', 'mustard', 'ketchup');

//Instantiate F3
$f3 = Base::instance();

//instantiate the controller
$controller = new FoodController($f3);

//define our routes
$f3->route('GET /', function() {

    $GLOBALS['controller']->home();
});

//Define an order route for initial order page
$f3->route('GET|POST /order', function($f3) {

    $GLOBALS['controller']->order1();
});

//Define a route for order2:  Meal selection
$f3->route('GET|POST /order2', function($f3) {

    $GLOBALS['controller']->order2();
});

//Define a route for order3:  Condiments
$f3->route('GET|POST /order3', function($f3) {

    $GLOBALS['controller']->order3();
});


//Define a route for summary page
$f3->route('GET /summary', function() {

    $GLOBALS['controller']->summary();
});

//Run F3
$f3->run();