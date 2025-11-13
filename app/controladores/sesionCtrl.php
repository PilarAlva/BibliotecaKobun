

<?php

    require '../vendor/PHPMailer/src/Exception.php';
    require '../vendor/PHPMailer/src/PHPMailer.php';
    require '../vendor/PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class SesionCtrl extends Controlador{


        
        public function index(){
            
            $msj = 1; //ERROR POR DEFECTO
            
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
                
                switch($_POST['action']){
                    case 'login':

                        $mail = isset($_POST['mail']) ? trim($_POST['mail'] ) : '';
                    $clave = isset($_POST['clave']) ? trim($_POST['clave'] ) : '';
                    
                    $msj = $this->loginUsuario($mail, $clave);
                    
                    break;
                    case 'registro':
                        
                        $nombre = trim($_POST['nombre']);
                        $apellido =trim($_POST['apellido']);
                        $mail =trim($_POST['mail']);
                        $clave = password_hash(trim($_POST['clave']), PASSWORD_DEFAULT);
                        
                        $msj = $this->registrarUsuario($nombre, $apellido, $mail, $clave);
                        
                    break;
                    default:
                    break;
                    
            };
            
            
            

        }
        
        $mensaje = '';
        $clase_mensaje = '';

        $this->mensaje($mensaje, $clase_mensaje, $msj);


        $data = ["mensaje" => $mensaje,
        "clase_mensaje" => $clase_mensaje,
        "cssEspecifico" => 'sesion.css',
    ];

    if($msj == 0)
        {
            header('location: ' . BASE_URL);
        }
        else{
            $this->mostrarVista('sesion', $data, 'Sesion');
        }
            

    }
    
    public function cerrar_sesion(){

        session_destroy();
        header('location: ' . BASE_URL);
        
        
    } 
    
    public function registrarUsuario($nombre, $apellido, $mail, $clave){

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        
        $usuarioModel = $this->cargarModelo("usuarioBD");
        
        $chequeo_mail = $usuarioModel->obtenerUsuarioPorMail($mail);

        $clave = password_hash($clave, PASSWORD_DEFAULT);

        if (!empty($chequeo_mail)) {
            return ["estado" => "error",
                    "mensaje"=> "El usuario ya existe. Inicie sesión."];
        } else {
            
            if ($usuarioModel->registrarUsuario($nombre, $apellido, $mail, $clave)) {
                return ["estado" =>"exito",
                        "mensaje" => "Registro exitoso."];
            }
        }
        return ["estado" => "error",
                "mensaje" => "Ha ocurrido un error."];

    }

    private function loginUsuario($mail, $clave){

        $msj = 1;

        $usuarioModel = $this->cargarModelo("usuarioBD");

        if (empty($mail) || empty($clave)) {
            $msj = 2; //Todos los campos son obligatorios
        } else {

            $usuario = $usuarioModel->obtenerUsuarioPorMail($mail);

            if ($usuario) {
                if (password_verify($clave, $usuario['clave'])) {
                    $_SESSION['usuario_mail'] = $mail;
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_apellido'] = $usuario['apellido'];
                    //$_SESSION['img_perfil'] = $usuario['img_perfil'];
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['rol_id'] = $usuario['rol_id'];
                    $msj = 0;
                    $error = false;
                    
                } else {
                    $msj = 1; //Ha ocurrido un error (2)
                } 
            } else {
                $msj = 3; //El usuario no existe. Por favor regístrate
            }
        }

        return $msj;

    }

    private function mensaje(&$mensaje, &$clase_mensaje, $msj){
            
            $mensaje = '';
            $clase_mensaje = 'mensaje-rojo';

            switch ($msj) {
                case 1:
                    $mensaje = 'Ha ocurrido un error.';
                    break;
                case 2:
                    $mensaje = 'Todos los campos son obligatorios.';
                    break;
                case 3:
                    $mensaje = 'El usuario no existe. Por favor regístrese.';
                    break;
                case 4:
                    $mensaje = 'El usuario ya existe. Por favor inicie sesión.';
                    break;
                case 5:
                    $mensaje = 'Registro exitoso. Ahora puede iniciar sesión.';
                    $clase_mensaje = 'mensaje-verde';
                    break;
                default:
                    break;
            }


        }

        public function enviarCorreoClave(){
            

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mail'])) {
            $mail =  trim($_POST['mail'] );
            

            $usuarioModel = $this->cargarModelo("usuarioBD");

            $usuario = $usuarioModel->obtenerUsuarioPorMail($mail);

            //generar token
            $token = bin2hex(random_bytes(32));
            $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

            //Eliminar cualquier token anterior
            $usuarioModel->eliminarToken($usuario['id']);
            //Subir nuevo token
            $usuarioModel->guardarToken($usuario['id'], $token, $expiracion);


            $link = "http://localhost/BibliotecaKobun/vistas/perfil/recuperar_clave.php?token=" . $token;

            $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bibliotecakobun@gmail.com';
            $mail->Password   = 'akabutqdcvrpikwo';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('bibliotecakobun@gmail.com', 'Biblioteca Kobun');
            $mail->addAddress($mail);

            $mail->Subject = 'Recuperación de cuenta';
            $mail->Body = "Hola {$usuario['nombre']} {$usuario['apellido']},\n\n".
                          "Hemos recibido una solicitud para restablecer tu contraseña.\n\n".
                          "Para continuar, hacé clic en el siguiente enlace:\n$link\n\n".
                          "Este enlace expirará en 1 hora. Si no solicitaste este cambio, podés ignorar este mensaje.";

            $mail->send();
            header("Location: BibliotecaKobun/vistas/perfil/recuperar_clave.php?msg=ok");
            exit;
        } catch (Exception $e) {
            header("Location: BibliotecaKobun/vistas/perfil/recuperar_clave.php?msg=error_envio");
            exit;
        }

        
        }
    }

}