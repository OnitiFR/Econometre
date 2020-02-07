<?php
require_once('./functions.php');

$params_rules = require('./params_rules.php');

$inputJSON = file_get_contents('php://input');
$request = json_decode($inputJSON, true);

$errors = [];
$lua_params = [];
if(!$request){
    displayResponse(500,['erreur' => 'Aucune requete trouvée']);
    die();
}
foreach ($params_rules as $key => $config) {
    $rules = explode('|',$config['rules']);
    $is_valid = true;
    $value = array_key_exists($key,$request) ? $request[$key] : null;
    foreach ($rules as $rule) {
        $is_valid_rule = callFunction($value,$rule);
        $is_valid = $is_valid && $is_valid_rule;

        $func_infos = getRuleInformations($rule);
        $func_name = $func_infos['function_name'];
        if(!$is_valid_rule){
            $errors[$key][$func_name] = getErrorMessage($key,$rule);
        }
    }
    if(!$is_valid){
        if(!in_array('required',$rules) && !required($value)){
            unset($errors[$key]);
            $is_valid = true;
        }
    }
    // Si tout est OK on allimante le tableau de paramètres
    if($is_valid){
        $lua_params[$config['output_name']] = array_key_exists('transform',$config) ? $config['transform']($value) : $value;
    }
}

if(count($errors) > 0 ){
    displayResponse(400,$errors);
}else{
    // Execécuter le LUA
    // paramètres attendus : 
    // {Occupation, Departement, Ville, Surface, Annee_const, Vitrage, Travaux, Nb_occupants, T_cons, Syst_actuel, Age_syst,Emetteurs, Syst_ECS_actuel, Chgmt_ECS}

    $lua_params_string = [];

    foreach (['Occupation', 'Departement', 'Ville', 'Surface', 'Annee_const', 'Vitrage', 'Travaux', 'Nb_occupants', 'T_cons', 'Syst_actuel', 'Age_syst','Emetteurs', 'Syst_ECS_actuel', 'Chgmt_ECS'] as $key) {

        $value = $lua_params[$key];
        if(is_array($value)){
            $value = arrayToLuaParams($value,false);
        }
        $lua_params_string[$key] = $value;
    }
    $ECO_IN = arrayToLuaParams($lua_params_string,true);

    exec('lua call.lua',$output);
    var_dump($output);
}