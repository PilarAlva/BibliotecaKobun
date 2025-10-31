

<?php

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
                    $clave = password_hash(trim($_POST['contraseña']), PASSWORD_DEFAULT);

                    $msj = $this->registrarUsuario($nombre, $apellido, $mail, $contraseña);

                    break;
                default:
                    break;

            };
         
        
            

        }

        $mensaje = '';
        $clase_mensaje = '';

        $this->mensaje($mensaje, $clase_mensaje, $msj);


        $data = ["mensaje" => $mensaje,
                "clase_mensaje" => $clase_mensaje];

        if($msj == 0)
        {
            header('location: ' . BASE_URL);
        }
        else{
            $this->mostrarVista('sesion', $data, 'Sesion');
        }
            

    }


    private function registrarUsuario($nombre, $apellido, $mail, $clave){

        $msj = 1;

        $usuarioModel = $this->cargarModelo("usuarioBD");

        $chequeo_mail = $usuarioModel->obtenerUsuarioPorMail($mail);


        if (!empty($chequeo_mail)) {
            $msj = 4; //El usuario ya existe. Por favor inicie sesión
        } else {
            
            if ($usuarioModel->registrarUsuario($nombre, $apellido, $mail, $clave)) {
                $msg = 5; //Registro exitoso. Ahora puede iniciar sesión
            } else {
                $msg = 1; //Ha ocurrido un error (3).
            }
        }
        return $msj;

    }

    private function loginUsuario($mail, $clave){

        $msj = 1;

        $usuarioModel = $this->cargarModelo("usuarioBD");

        if (empty($mail) || empty($clave)) {
            $msj = 2; //Todos los campos son obligatorios
        } else {

            $usuario = $usuarioModel->obtenerUsuarioPorMail($mail);

            if ($usuario) {
                if (password_verify($clave, $usuario['password'])) {
                    $_SESSION['usuario_mail'] = $mail;
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_apellido'] = $usuario['apellido'];
                    //$_SESSION['img_perfil'] = $usuario['img_perfil'];
                    $_SESSION['usuario_id'] = $usuario['id'];
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
    }


