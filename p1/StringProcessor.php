<?php

class StringProcessor
{

    # Properties
    private $inputString;

    # Methods
    public function __construct($inputString)
    {
        $this->inputString = $inputString;
    }
    
    public function isPalindrome()
    {
        if ($this->inputString==null) {
            return 'No';
        } elseif (strrev($this->inputString)==$this->inputString) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function isBigWord()
    {
        // if (strlen($inputString) >7) {
        //     return 'Yes';
        // } else {
        //     return 'No';
        // }
        
        # ternary operator

        return(strlen($this->inputString) > 7) ? 'Yes' : 'No';
    }


    public function countVowel()
    {
        // array to store vowels
        $vowelArray = array('A','E','I','O','U','a','e','i','o','u');

        $count = 0;
        for ($i = 0; $i < strlen($this->inputString); $i++) {
            if (in_array($this->inputString[$i], $vowelArray) == true) {
                $count++;
            }
        }
    
        return $count;
    }
}
