<?php

/**
 * @param int $n
 * @return bool
 */
function is_prime(int $n): bool  
{ 
    if($n <= 1) { 
        return false; 
    }
     
    for($i = 2; $i < sqrt($n); $i++) { 
        if($n % $i == 0) { 
            return false; 
        } 
    } 
 
    return true; 
}