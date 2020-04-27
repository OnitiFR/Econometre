<?php

namespace App\Router;

class Router
{
    private $routes = [];
    
    public function __construct(string $url){
        $this->url = $url;
    }

    public function run(){
        $method = $_SERVER['REQUEST_METHOD'];

        if(!array_key_exists($method,$this->routes)) throw new RouterException("Méthode non supportée",404);

        foreach($this->routes[$method] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }

        throw new RouterException("Route Inconnue",404);
        
    }


    /**
     * Décalare une route GET
     */
    public function get(string $path, $function) :void{
        $this->storeRoute($path,$function,'GET');
    }

    /**
     * Décalare une route POST
     */
    public function post(string $path, $function) :void{
        $this->storeRoute($path,$function,'POST');
    }

    /**
     * Décalare une route PUT
     */
    public function put(string $path, $function) :void{
        $this->storeRoute($path,$function,'PUT');
    }

    /**
     * Décalare une route DELETE
     */
    public function delete(string $path, $function) :void{
        $this->storeRoute($path,$function,'DELETE');
    }

    /**
     * Centralise les déclarations de route
     */
    private function storeRoute(string $path, $function, string $method) : void{
        $route = new Route($path,$function);
        $this->routes[$method][] = $route;
    }
}
