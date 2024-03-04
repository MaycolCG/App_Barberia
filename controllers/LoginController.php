<?php 

namespace Controllers;

use MVC\Router;

class LoginController {

    public static function login(Router $router){
        
        $router->render('auth/login');
    }

    public static function logout(){
        echo "Desde logout";
    }

    public static function olvide(){
        echo "Desde olvide";
    }

    public static function recuperar(){
        echo "Desde Recuperar";
    }

    public static function crear(){
        echo "Desde crear";
    }

    public static function confirmar(){
        echo "Desde confirmar";
    }

    public static function mensaje(){
        echo "Desde mensaje";
    }
}