<?php

require_once('./functions.php');

$params_rules = require('./params_rules.php');

$inputJSON = file_get_contents('php://input');
$request = json_decode($inputJSON, true);

$errors = [];

foreach ($params_rules as $key => $config) {
    $rules = explode('|',$config['rules']);
    $is_valid = true;
    $value = array_key_exists($key,$request) ? $request[$key] : null;
    foreach ($rules as $rule) {
        $is_valid = $is_valid && callFunction($key,$value,$rule);
    }

    var_dump($errors);
}