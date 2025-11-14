

<?php

    class SesionCtrl extends Controlador{

        
        public function index(){

            $msj =  ["estado" => "",
                        "mensaje"=> ""];

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
                
                
                switch($_POST['action']){
                    case 'login':

                        $mail = isset($_POST['mail']) ? trim($_POST['mail'] ) : '';
                        $clave = isset($_POST['clave']) ? trim($_POST['clave'] ) : '';
                        
                        $msj = $this->loginUsuario($mail, $clave);
                        
                        $_POST['mensaje'] = $msj;

                        if($msj["estado"] == "exito"){
                            header("location: " . BASE_URL );
                        }

                        break;
                    case 'registro':
                            
                        $nombre = trim($_POST['nombre']);
                        $apellido =trim($_POST['apellido']);
                        $mail =trim($_POST['mail']);
                        $clave = isset($_POST['clave']) ? trim($_POST['clave'] ) : '';
                    
                        
                        $msj = $this->registrarUsuario($nombre, $apellido, $mail, $clave);    

                        break;
                    default:
                        break;
                    
            };
        }
            
        $data = ["msj" => $msj,
                "cssEspecifico"=> "sesion.css"];

        $this->mostrarVista('sesion', $data, 'Sesion');
            

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

        

        $usuarioModel = $this->cargarModelo("usuarioBD");

        if (empty($mail) || empty($clave)) {
            return ["estado" => "error",
                        "mensaje" => "Todos los campos son obligatorios."];
        } else {

            $usuario = $usuarioModel->obtenerUsuarioPorMail($mail);

            if ($usuario) {
                if (password_verify($clave, $usuario['clave'])) {
                    $_SESSION['usuario_mail'] = $mail;
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_apellido'] = $usuario['apellido'];
                    $_SESSION['img_perfil'] = $usuario['img_perfil'];
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['rol_id'] = $usuario['rol_id'];
                    return ["estado" => "exito",
                    "mensaje" => "Exito!"];
     
                } else {
                    return ["estado" => "error",
                        "mensaje" => "Datos erroneos"];

                } 
            } else {
                return ["estado" => "error",
                        "mensaje" => "No se encontró el usuario. Regístrese."];

            }
        }

    

    }
}

