<?php

namespace App\Validators;

use Exception;

class ValidatorException extends Exception{
    public $errors;

    public function setErrors(array $errors){
        $this->errors = $errors;
    }
}