

<?php

    require '../vendor/PHPMailer/src/Exception.php';
    require '../vendor/PHPMailer/src/PHPMailer.php';
    require '../vendor/PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class ContactoCtrl extends Controlador{

       public function index(){
        
        $registrado = $this->usuarioRegistrado();

        $usuarioModel = $this->cargarModelo("usuarioBD");

        $usuario = $usuarioModel->obtenerDatosContacto($_SESSION["usuario_id"]);

        $data = [
            "usuario" => $usuario,
            "registrado" => $registrado
        ];

        $this->mostrarVista('contacto', $data, 'Contacto');        

    }


    public function enviar(){

        $contactoModel = $this->cargarModelo("contactoBD");


        $nombre = $_POST['nombre'];
        $email = $_POST['email'];        // correo ingresado por el usuario
        $tel = $_POST['tel'];
        $comentarios = $_POST['mensaje'];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bibliotecakobun@gmail.com'; // tu Gmail
            $mail->Password   = 'akabutqdcvrpikwo';           // App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Remitente real (Gmail)
            $mail->setFrom('bibliotecakobun@gmail.com', 'Formulario Web');

            // Destinatario
            $mail->addAddress('bibliotecakobun@gmail.com'); 

            // Para que se pueda responder al usuario
            $mail->addReplyTo($email, $nombre);

            // Contenido del correo
            $mail->Subject = 'Nuevo mensaje desde el formulario';
            $mail->Body    = "Nombre: $nombre\nEmail: $email\nTeléfono: $tel\nComentarios:\n$comentarios";

            $mail->send();

            $contactoModel->enviarCorreo($nombre, $email, $tel, $comentarios);


            header('Location: ' . BASE_URL . 'contacto');

        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }

    }

    }


