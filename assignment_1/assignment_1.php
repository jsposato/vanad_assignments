#!/usr/local/bin/php
<?php
/**
 * Assignment 1:
 *
 * Preferred tools:
 * - N/A
 * Write a PHP function that accepts an integer as a parameter and
 * outputs a numbered and sorted list of all prime numbers that are
 * smaller than the supplied number.
 * Deliverable:
 * - Provide us with a public GitHub repository containing the assignment.
 */

// check argument count
if ($argc != 2) {
    echo "Usage: " . basename(__FILE__) . " INTEGER";
    exit;
}

// check argument is a number
if (!is_numeric($argv[1])) {
    echo "Usage: " . basename(__FILE__) . " INTEGER";
    exit;
}

$number = $argv[1];
showPrimes($number);

/**
 * showPrimes
 *
 * given an integer, output all prime numbers smaller than the given
 * integer sorted smallest to largest
 *
 * @param $integer
 */
function showPrimes($integer)
{
    $count = 0;
    for ($i = 0; $i<$integer; $i++) {
        if (isPrime($i)) {
            $count = $count + 1;
            echo $count . '. ' . $i . PHP_EOL;
        }
    }

}

/**
 * isPrime
 *
 * given an integer, determine if it is prime
 *
 * @param $integer
 * @return bool
 */
function isPrime($integer)
{
    // prime numbers start at 2
    if ($integer == 1) {
        return false;
    }
    // 2 is the only even prime number
    if ($integer == 2) {
        return true;
    }

    // numbers divisible by 2 (except 2) are not prime
    if($integer % 2 == 0) {
        return false;
    }
    /**
     * You have to test every prime integer greater than 2, but less
     * than or equal to the square root. So if a number (greater than 1)
     * is not prime and we test divisibility up to square root of the
     * number, we will find one of the factors.
     */
    for($i = 3; $i <= ceil(sqrt($integer)); $i = $i + 2) {

        if($integer % $i == 0)

            return false;
    }
    return true;

}