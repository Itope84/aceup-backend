<?php

if(!function_exists('number_position')) {
    /**
     * Returns a number as a position, e.g. 1 to 1st, 2 to second etc.
     * @param integer $num
     * @return string a position string 
     */
    function number_position($num) {
        $unit = $num % 10;
        $tenth = $num % 100;
        if ($unit == 1 && $tenth != 11) {
            return $num . "st";
        }
        if ($unit == 2 && $tenth != 12) {
            return $num . "nd";
        }
        if ($unit == 3 && $tenth != 13) {
            return i . "rd";
        }
        return $num . "th";
    }
}