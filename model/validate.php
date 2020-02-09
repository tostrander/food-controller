<?php
/**
 * Created by PhpStorm.
 * User: laptop
 * Date: 1/29/2020
 * Time: 11:31 AM
 */

    /* Return a value indicating if the param is a valid food
       Valid foods are not empty and do not contain numbers
       @param String $food
       @return boolean
    */
    function validFood($food)
    {
        /*
        if (empty($food))
            return false;
        else
            return true;
        */

        return !empty(trim($food)) && ctype_alpha($food);
    }

    /* Return a value indicating if the param is a valid meal
       Valid meals are in the meals array
       @param String $meal
       @return boolean
    */
    function validMeal($meal)
    {
        global $meals; //This is defined in the controller
        return in_array($meal, $meals);
    }

    /* Return a value indicating if every value in
       the $selectedCondiments array is in the list of
       valid condiments.
       @param String[] $selectedCondiments
       @return boolean
    */
    function validCondiments($selectedCondiments)
    {
        global $condiments; //This is defined in the controller
        //print_r($selectedCondiments);
        //print_r($condiments);

        //We need to check each condiment in our array
        foreach ($selectedCondiments as $selected) {
            if (!in_array($selected, $condiments)) {
                return false;
            }
        }
        return true;
    }