<?php

namespace App\Validators;

class Validator {

    public function __construct(?array $request)
    {
        if(is_null($request)) throw new ValidatorException("Pas de body de request.", 400);

        $this->request = $request;
        
    }

    /**
     * Valide les régles.
     */
    public function validate(){
        $errors = [];
        $validated = [];

        foreach ($this->rules() as $key => $config) {
            $rules = explode('|',$config['rules']);
            $is_valid = true;
            $value = array_key_exists($key,$this->request) ? $this->request[$key] : null;
            foreach ($rules as $rule) {
                $is_valid_rule = self::callFunction($value,$rule);
                $is_valid = $is_valid && $is_valid_rule;
        
                $func_infos = self::getRuleInformations($rule);
                $func_name = $func_infos['function_name'];
                if(!$is_valid_rule){
                    $errors[$key][$func_name] = $this->getErrorMessage($key,$rule);
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
                $validated[$config['output_name']] = array_key_exists('transform',$config) ? $config['transform']($value) : $value;
            }
        }

        if(count($errors) > 0){
            $exception = new ValidatorException(null,422);
            $exception->setErrors($errors);
            
            throw $exception;
            
        }

        return $validated;
    }

    /**
     * Retourne les informations d'une Régle
     */
    public static function getRuleInformations(string $rule) :array{
        $rule_explode = explode(':',$rule);
        return [
            'function_name' => $rule_explode[0],
            'params' => array_key_exists(1,$rule_explode) ? explode(',',$rule_explode[1]) : []
        ];
    }

    /**
     * Appel une fonction d'une règle donnée
     */
    public static function callFunction($val,string $rule) : bool{
        $func_infos = self::getRuleInformations($rule);
        $function = $func_infos['function_name'];

        if(!function_exists($function)) throw new ValidatorException("$function n'est pas une fonction.", 500);
        
        $params = count($func_infos['params']) > 0 ? array_merge([$val],$func_infos['params']) : [$val];

        return boolval(call_user_func_array($function,$params));
    }

    /**
     * Retourne les messages d'erreurs
     */
    function getErrorMessage(string $key, string $rule) :string{ 
        return 'Message Non Définie.';
    }

    public function rules() :array{
        return [];
    }
}