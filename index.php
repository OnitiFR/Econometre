<?php

require 'vendor/autoload.php';

use App\Router\Router;
use App\Validators\ValidatorException;

try {
    $router = new Router($_SERVER['REQUEST_URI']);

    $router->post('MoteurEconometre','EconometreController@calcul');

    $router->get('departements',function(){
        echo 'future routes des départements';
    });

    $router->get('cities',function(){
        echo 'future routes des cities';
    });

    $router->post('executions/:type',function($type){
        echo 'future routes des executions de type '.$type;
    });



    $router->run();
} 
catch( ValidatorException $ex){
    displayResponse(422,[
        'error' => $ex->getMessage(),
        'erreurs' => $ex->errors ?? []
    ]);
}
catch (\Throwable $th) {
    $code_http = $th->getCode() >= 100 && $th->getCode() <= 500 ? $th->getCode() : 500; 
    displayResponse($code_http,['erreur' => $th->getMessage()]);
}

