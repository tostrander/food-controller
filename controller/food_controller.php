<?php
    class FoodController
    {
        private $_f3; //router
        private $_val; //validation object
        
        public function __construct($f3)
        {
            $this->_f3 = $f3;
            $this->_val = new Validate();
        }

        public function home()
        {
            $_SESSION = array();
            $view = new Template();
            echo $view->render('views/home.html');
        }

        public function order1()
        {
            //Check to see if form has been submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //Validate data
                if(isset($_POST['food']) && $this->_val->validFood($_POST['food'])) {

                    //Get the data and redirect to next page
                    $_SESSION['food'] = $_POST['food'];
                    $this->_f3->reroute('/order2');
                } else {

                    //Set an error variable
                    $this->_f3->set("errors['food']", "Enter a food");
                }
            }

            $this->_f3->set('food', isset($_POST['food']) ? $_POST['food'] : "");
            $view = new Template();
            echo $view->render('views/form1.html');
        }

        public function order2()
        {
            //Check to see if form has been submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //Validate the meal
                if (isset($_POST['meal']) && $this->_val->validMeal($_POST['meal'])) {

                    //Get the data and redirect to next page
                    $_SESSION['meal'] = $_POST['meal'];
                    $this->_f3->reroute('/order3');
                } else {

                    //Set an error variable
                    $this->_f3->set("errors['meal']", "Please select a valid meal");
                }
            }

            //Add the $meals array to the fat-free hive
            //so we can access it in the view
            global $meals;
            $this->_f3->set('meals', $meals);
            $this->_f3->set('selectedMeal', isset($_POST['meal']) ? $_POST['meal'] : "");

            //Render the view
            $view = new Template();
            echo $view->render('views/form2.html');
        }
        
        public function order3()
        {
            //Check to see if form has been submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //If no condiments are selected
                if (empty($_POST['conds'])) {

                    //Redirect to the next page
                    $this->_f3->reroute('/summary');

                }
                //If condiments are valid
                else if ($this->_val->validCondiments($_POST['conds'])) {

                    //Get data and redirect
                    $_SESSION['conds'] = $_POST['conds'];
                    $this->_f3->reroute('/summary');

                }
                //Condiments are selected, but are not valid
                else {

                    //Set an error variable
                    $this->_f3->set("errors['conds']", "Condiment selection is invalid");
                }
            }

            //Add the $condiments array to the fat-free hive
            //so we can access it in the view
            global $condiments;
            $this->_f3->set('condiments', $condiments);
            $this->_f3->set('selectedCondiments', isset($_POST['conds']) ? $_POST['conds'] : array());

            //Render the view
            $view = new Template();
            echo $view->render('views/form3.html');
        }

        public function summary()
        {
            $view = new Template();
            echo $view->render('views/results.html');
        }
    }









