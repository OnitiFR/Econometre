<?php

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
            $is_valid = $is_valid && callFunction($value,$rule);
        }
        return $is_valid;
    }
}

/**
 * Appel une fonction d'une règle donnée
 */
function callFunction($val,string $rule) : bool{
    $func_infos = getRuleInformations($rule);
    $function = $func_infos['function_name'];

    if(!function_exists($function)) throw new Exception("$function n'est pas une fonction.", 500);
    
    $params = count($func_infos['params']) > 0 ? array_merge([$val],$func_infos['params']) : [$val];

    return boolval(call_user_func_array($function,$params));
}


/**
 * Retourne les informations d'une Régle
 */
function getRuleInformations(string $rule) :array{
    $rule_explode = explode(':',$rule);
    return [
        'function_name' => $rule_explode[0],
        'params' => array_key_exists(1,$rule_explode) ? explode(',',$rule_explode[1]) : []
    ];
}

/**
 * Retourne message d'erreur d'une régle
 */
function getErrorMessage(string $key, string $rule) :string{
    $message = '';
    $func_infos = getRuleInformations($rule);

    switch ($func_infos['function_name']) {
        case 'is_int_between':
            $message = "Le champ $key doit être un entier et compris entre ".$func_infos['params'][0]." et ".$func_infos['params'][1];
            break;
        case 'is_array_walk':
            $message = "Le champ $key ne répond pas a la validation";
            break;
        case 'required':
            $message = "Le champ $key est obligatoire";
            break;
        case 'is_string':
            $message = "Le champ $key doit être une chaîne de caractères.";
            break;
        case 'is_int':
            $message = "Le champ $key doit être un entier.";
            break;
            
        default:
            $message = "Erreur ".$func_infos['function_name']." inconnue.";
            break;
    }

    return $message;
}

/**
 * Renvoie la réponse à la fin du script
 */
function displayResponse(int $http_code,$data){
    http_response_code($http_code);
    header('Content-Type: application/json');
    echo json_encode($data);
}