<?php 

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController {

    public static function login(Router $router){
        
        $router->render('auth/login');
    }


    public static function logout(){
        echo "Desde logout";
    }


    public static function olvide(Router $router){        
        
        $router->render('auth/olvide-password');
    }


    public static function recuperar(){
        echo "Desde Recuperar";
    }


    public static function crear(Router $router){
        
        $usuario = new Usuario;

        // Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alerta este vacio
            if(empty($alertas)) {
                // Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el Password
                    $usuario->hashPassword();

                    // Generar un Token único
                    $usuario->crearToken();

                    // Enviar el Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();                    

                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    // debuguear($usuario);
                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function confirmar(Router $router){
        
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){

            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        } else {

           // Modificar a usuario confirmado
           $usuario->confirmado = "1";
           $usuario->token = null;
           $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');

        }


        
        // Obtener alertas
        $alertas = Usuario::getAlertas();
        // Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
    

    public static function mensaje(Router $router){

        $router->render('auth/mensaje');
    }
}