<?php

class Validator {

    public static function validateString($value, $min = 3, $max = INF){
        $value = trim($value);
        return strlen($value) > $min && strlen($value) < $max;
    }

    public static function validateInteger($value, $min = 1, $max = INF){
        $value = trim($value);
        return strlen($value) >= $min && strlen($value) < $max;
    }

    public static function validateDecimal($value, $min = 0.01, $max = INF){
        $value = trim($value);
        return strlen($value) >= $min && strlen($value) < $max;
    }
}