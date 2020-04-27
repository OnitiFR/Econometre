<?php

use App\Validators\Validator;

/**
 * Vérfie si c'est un entier entre les bornes données
 */
function is_int_between($val,int $min, int $max) :bool{
    $int_val = intval($val);
    return is_int($int_val) && $int_val >= $min && $int_val <= $max;
}

/**
 * Vérfifie si la valeur n'est pas null ou vide
 */
function required($val) :bool{
    return !is_null($val) && ((!is_array($val) && trim($val) !== '') || (is_array($val) && count($val) > 0));
}

/**
 * Vérifie que la valeur est un tableau et que la fonction est valide sur tous les élements
 */
function is_array_walk($val,string $rule){
    if(!is_array($val)) return false;
    else {
        $rule = str_replace('@',',',str_replace('!',':',$rule));
        $is_valid = true;
        foreach ($val as $value) {
            $is_valid = $is_valid && Validator::callFunction($value,$rule);
        }
        return $is_valid;
    }
}

/**
 * Ajouter des quotes
 */
function addquotes($value) :string{
    return '"'.$value.'"';
}


/**
 * Renvoie la réponse à la fin du script
 */
function displayResponse(int $http_code,$data){
    http_response_code($http_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    die();
}

/**
 * Retourne une clef de configuration
 */
function getConfiguration(string $key, $defaut = null){
    $configuration = require(realpath(__DIR__.'/../Config/config.php'));
    
    return array_key_exists($key,$configuration) ? $configuration[$key] : $defaut;
}

