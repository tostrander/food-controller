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
require("model/validate.php");

//Define variables
$meals = array('breakfast', 'lunch', 'dinner');
$condiments = array('mayonnaise', 'mustard', 'ketchup');

//Instantiate F3
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {

    //Clear the session variable
    $_SESSION = array();

    //Display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define an order route for initial order page
$f3->route('GET|POST /order', function($f3) {

    $_SESSION = array();
    
    //Check to see if form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Validate data
        if(isset($_POST['food']) && validFood($_POST['food'])) {

            //Get the data and redirect to next page
            $_SESSION['food'] = $_POST['food'];
            $f3->reroute('/order2');
        } else {

            //Set an error variable
            $f3->set("errors['food']", "Enter a food");
        }
    }

    $f3->set('food', isset($_POST['food']) ? $_POST['food'] : "");
    $view = new Template();
    echo $view->render('views/form1.html');
});

//Define a route for order2:  Meal selection
$f3->route('GET|POST /order2', function($f3) {

    //Check to see if form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Validate the meal
        if (isset($_POST['meal']) && validMeal($_POST['meal'])) {

            //Get the data and redirect to next page
            $_SESSION['meal'] = $_POST['meal'];
            $f3->reroute('/order3');
        } else {

            //Set an error variable
            $f3->set("errors['meal']", "Please select a valid meal");
        }
    }

    //Add the $meals array to the fat-free hive
    //so we can access it in the view
    global $meals;
    $f3->set('meals', $meals);
    $f3->set('selectedMeal', isset($_POST['meal']) ? $_POST['meal'] : "");

    //Render the view
    $view = new Template();
    echo $view->render('views/form2.html');
});

//Define a route for order3:  Condiments
$f3->route('GET|POST /order3', function($f3) {

    //Check to see if form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //If no condiments are selected
        if (empty($_POST['conds'])) {

            //Redirect to the next page
            $f3->reroute('/summary');

        }
        //If condiments are valid
        else if (validCondiments($_POST['conds'])) {

            //Get data and redirect
            $_SESSION['conds'] = $_POST['conds'];
            $f3->reroute('/summary');

        }
        //Condiments are selected, but are not valid
        else {

            //Set an error variable
            $f3->set("errors['conds']", "Condiment selection is invalid");
        }
    }

    //Add the $condiments array to the fat-free hive
    //so we can access it in the view
    global $condiments;
    $f3->set('condiments', $condiments);
    $f3->set('selectedCondiments', isset($_POST['conds']) ? $_POST['conds'] : array());

    //Render the view
    $view = new Template();
    echo $view->render('views/form3.html');
});


//Define a route for summary page
$f3->route('GET /summary', function() {

    $view = new Template();
    echo $view->render('views/results.html');
});

//Run F3
$f3->run();