<?php 
namespace Convoiturage\Convoiturage\Core;

use Convoiturage\Convoiturage\Controllers\ErrorController;
use Convoiturage\Convoiturage\Controllers\MainController;


class Router
{
    private ErrorController $error;

    public function  __construct(){
        $this->error = new ErrorController();

    }

    
    public function start()
    {
        session_start();
        
        //recperer l'url
        $uri = $_SERVER['REQUEST_URI'];

        //on verifie si l'url ecrite se termine par un slash et si oui on l'enleve
        if(!empty($uri) && $uri != '/' && $uri[-1] ==="/")
        {
            $uri = substr($uri, 0, -1);
            
            //on envoie un code de redirection permanent
            http_response_code(301);

            //on redirige vers le lien demandé
            header('Location: '.$uri);            
        }

        //Recuper le $_GET['p] pour ensuite le scinder puis la 1ers elmt sera le controller, 2em methode, le reste les paramatre
        $params = explode('/', $_GET['p']);        

        if($params[0] !== ''){

            $controller = '\\Convoiturage\\Convoiturage\\Controllers\\'.ucfirst(array_shift($params)).'Controller';

            if(class_exists($controller)){
                $controller = new $controller();

                $methode = (isset($params[0])) ? array_shift($params) : 'index';

                if(method_exists($controller, $methode))
                {
                    (isset($params[0])) ? call_user_func_array([$controller, $methode], $params) : $controller->$methode();
                }else{
                    $this->error->pageNotFound();
                }
                
            }else{
                $this->error->pageNotFound();
            }

            

            

        }else{
            $controller = new MainController();
            $controller->index();
        }
        
       

    }
}