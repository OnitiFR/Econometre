<?php

namespace App\Router;

class Route
{
    public function __construct(string $path, $function){
        // supprimes les / et capture les parametres commençant par :
        $this->path = preg_replace('#:([\w]+)#','([^/]+)',trim($path,'/'));
        $this->function = $function;
    }

    /**
     * Appel la fonction associée a l'url
     */
    public function call(){

        if(is_callable($this->function)){
            return call_user_func_array($this->function,$this->params);
        }
        else if(is_string($this->function) && strpos($this->function,'@') !== -1){
            $function_parts = explode('@',$this->function);
            $namespace = "App\Controllers\\".$function_parts[0];
            $function_parts[0] = new $namespace;
            
            return call_user_func_array($function_parts,$this->params);
        }
        
        throw new RouterException("Fonction déclarée invalide, elle doit être soit un callable soit un string namespace@method", 500);
        
    }

    /**
     * Vérifie si la route correspond a l'url courrante.
     */
    public function match(string $url) :bool{
        
        $urls_parts = explode('?',$url);
        $url = trim($urls_parts[0],'/');
        
        $regex = '#^'.$this->path.'$#i';

        if(!preg_match($regex,$url,$matches)){
            return false;
        }

        array_shift($matches); // supprime le premier résultat qui contient l'url complete.

        $this->params = $matches;

        return true;

    }
}
