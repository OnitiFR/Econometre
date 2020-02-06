<?php

function is_int_between(string $key,$val,int $min, int $max) :bool{
    $int_val = intval($val);
    $is_valid = is_int($int_val) && $int_val >= $min && $int_val <= $max;
    if(!$is_valid){
        declareError($key,'is_int_between','Le champ '.$key.' doit être compris entre '.$min.' et '.$max);
    }
    return $is_valid;
}

function required(string $key,$val) :bool{
    $is_valid = !is_null($val) && $val !== '';
    if(!$is_valid){
        declareError($key,'required','Le champ '.$key.' est obligatoire');
    }
    return $is_valid ;
}

function declareError(string $key,string $func_name,string $message) :void{
    global $errors;
    if(!array_key_exists($key,$errors)) $errors[$key] = [];
    $errors[$key][$func_name] = $message;
}


function is_array_walk(string $key,$val,string $rule){
    if(!is_array($val)) return false;
    else {
        $rule = str_replace('@',',',str_replace('!',':',$rule));
        $is_valid = true;
        foreach ($val as $value) {
            $is_valid = $is_valid && callFunction($key,$value,$rule);
        }
        if(!$is_valid){
            declareError($key,'is_array_walk','Le champ '.$key.' ne remplis pas les conditions de validation');
        }
        return $is_valid;
    }
}

function callFunction(string $key,$val,string $rule){
    $rule_explode = explode(':',$rule);
    $function = $rule_explode[0];
    $params = array_key_exists(1,$rule_explode) ? array_merge([$key,$val],explode(',',$rule_explode[1])) : [$key,$val];

    return call_user_func_array($function,$params);
}