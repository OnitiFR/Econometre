<?php 

namespace App\Controllers;

class Controller{
    
    public function __construct(){
        // Parse le contenu d'un post en tableau PHP associatif
        $inputJSON = file_get_contents('php://input');
        $post = json_decode($inputJSON, true);
        $post = $post ?? [];
        $this->request = array_merge($post,$_GET);
    }
}