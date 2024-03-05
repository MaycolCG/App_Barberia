<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $apellido;
    public $token;
    
    public function __construct($email, $nombre, $apellido, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->token = $token;

    }

    public function enviarConfirmacion() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('cuentas@KalimanBarber.com');
         $mail->addAddress('cuentas@KalimanBarber.com', 'KalimanBarber.com');
         $mail->Subject = 'Confirma tu Cuenta';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '<html>';
         $contenido .= "<p>Hola<strong> " . $this->nombre . " " . $this->apellido .  "</strong> Has Creado tu cuenta en KalimanBarber, solo debes confirmarla presionando el siguiente enlace</p>";
         $contenido .= "<p>Presiona aquí: <a href='" .  $_ENV['APP_URL']   . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";        
         $contenido .= "<p>Si tú no solicitaste este cambio, puedes ignorar el mensaje</p>";
         $contenido .= '</html>';
         $mail->Body = $contenido;

         //Enviar el mail
         $mail->send();

    }

    public function enviarInstrucciones() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('cuentas@KalimanBarber.com');
        $mail->addAddress('cuentas@KalimanBarber.com', 'KalimanBarber.com');
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p>Hola<strong> " . $this->nombre . " " . $this->apellido .  "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" .  $_ENV['APP_URL']   . "/recuperar?token=" . $this->token . "'>Reestablecer Password</a>";        
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;

            //Enviar el mail
        $mail->send();
    }
}