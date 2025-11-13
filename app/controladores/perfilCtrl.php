<?php


class PerfilCtrl extends Controlador{

    
    public function index(){
        
        $usuarioModel = $this->cargarModelo("usuarioBD");
        $socioModel = $this->cargarModelo("socioBD");
        $prestamoModel = $this->cargarModelo("prestamoBD");
        $talleresModel = $this->cargarModelo("tallerBD");
        $bibliotecaModel = $this->cargarModelo("bibliotecaBD");
        $libroModel = $this->cargarModelo("libroBD");
        $pagoModel = $this->cargarModelo("pagoDB");
        
        if(!isset($_SESSION["usuario_id"])){
            header('Location: ' . BASE_URL . 'sesion');
        }
        
        $usuario = $usuarioModel->obtenerUsuarioPorId($_SESSION["usuario_id"]);
        $socio = $socioModel->obtenerSocioPorIdUsuario($_SESSION["usuario_id"]);
        $biblioteca = $bibliotecaModel->obtenerDatos();

        $prestamos = [];
        $estadoSocio = "";

        if ($socio) {
            
        }
        
        $talleres = [];
        $talleres = $talleresModel->obtenerTalleresUsuario($_SESSION["usuario_id"]);
        $mesesAdeudados = 0;
        $cuotaAlDia = false;
        $multas["cantidad"] = 0;

        if ($socio) {

            $prestamos = $prestamoModel->prestamosPorSocio($socio['id']);
            if ($socio['activo'] == 1) {
                $estadoSocio = "Activo";
            } else {
                $estadoSocio = "Inactivo";
            }
            $multas = $socioModel->obtenerCantMultasActivas($socio['id']);

            $cuotaSocio = $biblioteca["cuota_socio"];
            
            // --- Lógica de Cuotas de Socio ---
            // --- Lógica de Cuotas de Socio ---
            $cuotaMensual = (float)$cuotaSocio;
            $ultimoPago = $pagoModel->obtenerUltimoPagoCuota($socio['id']);

            $fechaAlta = new DateTime($socio['fecha_alta']);
            $hoy = new DateTime();

            if (!empty($ultimoPago) && !empty($ultimoPago['ultimo_pago'])) {
                $fechaReferencia = new DateTime($ultimoPago['ultimo_pago']);
            } else {
                $fechaReferencia = $fechaAlta;
            }

            // Avanzamos la fecha de referencia al primer día del mes siguiente
            $fechaReferencia->modify('first day of next month');

            $mesesAdeudados = 0;
            $montoCuotaTotal = 0;

            // Si hoy ya pasó la fecha de referencia, hay cuotas adeudadas
            if ($hoy >= $fechaReferencia) {
                $diferencia = $fechaReferencia->diff($hoy);

                // Meses completos transcurridos + el actual
                $mesesAdeudados = ($diferencia->y * 12) + $diferencia->m + 1;

                $montoCuotaTotal = $mesesAdeudados * $cuotaMensual;
            }

            // Cuota al día si:
            // - Debe solo la del mes actual y todavía no pasó el día 15, o
            // - No debe nada.
            $cuotaAlDia = ($montoCuotaTotal == $cuotaMensual && (int)$hoy->format('d') < 16) || $montoCuotaTotal == 0;
    
       
           
        } 
        
       
        
        $data = [
            "usuario" => $usuario,
            "socio" => $socio,
            "prestamos" => $prestamos,
            
            "estadoSocio" => $estadoSocio,
            "multas" => $multas,
            "cuotaAlDia" => $cuotaAlDia,
            "mesesAdeudados" => $mesesAdeudados,

            "talleres" => $talleres,

            "cssEspecifico" => ['perfil.css', 'formulario.css'],
        ];

        $this->mostrarVista('perfil/perfil', $data, 'Perfil');

    }

    public function editar(){

        if($_SERVER['REQUEST_METHOD'] != "POST"){
            header('Location: ' . BASE_URL .'');
        }
        if(isset( $_SESSION['usuario_id'] ) && $_SESSION['usuario_id'] == $_POST["usuario_id"]){

            $usuarioModel = $this->cargarModelo("usuarioBD");
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];

            $usuario = $usuarioModel->obtenerUsuarioPorId($_POST["usuario_id"]);
            if($usuario){

                if($usuarioModel->editarNombreApellido($_POST["usuario_id"], $nombre, $apellido)){
                    header('Location: ' . BASE_URL . 'perfil');
                }
            }

        }
        header('Location: ' . BASE_URL);
    }
    public function acc(){

        if($_SERVER['REQUEST_METHOD'] != "POST"){
            header('Location: ' . BASE_URL .'perfil');
            exit;
        }

        if(!isset($_SESSION["usuario_id"]) || $_SESSION['usuario_id'] != $_POST["usuario_id"]){
            header('Location: ' . BASE_URL .'perfil');
            exit;
        }

        $usuarioModel = $this->cargarModelo('usuarioBD');
        $usuario_id = $_POST['usuario_id'];
        $mail = $_POST['mail'];
        $clave_actual = $_POST['clave_actual'];
        $clave_nueva = $_POST['clave_nueva'];
        $confirmar_clave_nueva = $_POST['confirmar_clave_nueva'];

        $usuario = $usuarioModel->obtenerUsuarioPorId($usuario_id);

        $mensaje = "No paso nada?";

        if(!$usuario){
            header('Location: ' . BASE_URL . 'perfil');
            exit;
        }

        // Cambiar mail
        if($usuario["mail"] != $mail){
            if(!$usuarioModel->obtenerUsuarioPorMail($mail)){
                $usuarioModel->actualizarMail($usuario_id, $mail);
                $_SESSION['user_mail'] = $mail; // Actualizar mail en sesión
                $mensaje = "Exito.";
            } else {
                // Opcional: manejar el error de mail ya registrado
                $mensaje = "El mail ya está registrado.";
            }
        }

        // Cambiar contraseña
        if(!empty($clave_nueva) && !empty($clave_actual)) {
            if (password_verify($clave_actual, $usuario["clave"])) {
                if ($clave_nueva == $confirmar_clave_nueva) {
                    $hashed_password = password_hash($clave_nueva, PASSWORD_DEFAULT);
                    $usuarioModel->actualizarClave($usuario_id, $hashed_password);
                    $mensaje = "Exito.";
                } else {
                    // Opcional: manejar el error de que las contraseñas no coinciden
                    $mensaje = "Las contraseñas no coinciden.";
                }
            } else {
                // Opcional: manejar el error de que la contraseña actual es incorrecta
                $mensaje = "La constraseña actual es incorrecta.";
            }
        }
        
        $_SESSION["msj_acc"] = $mensaje;
        header('Location: ' . BASE_URL . 'perfil');
        
    }

    public function subir_imagen() {
        header('Content-Type: application/json');

        if (!isset($_SESSION["usuario_id"])) {
            echo json_encode(['success' => false, 'error' => 'Usuario no autenticado.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['photo'])) {
            echo json_encode(['success' => false, 'error' => 'Solicitud no válida.']);
            return;
        }

        $file = $_FILES['photo'];

        if ($file['error']) {
            echo json_encode(['success' => false, 'error' => 'Error en la subida del archivo.']);
            return;
        }

        $uploadDir = 'almacenamiento/perfiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '-' . basename($file['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $usuarioModel = $this->cargarModelo("usuarioBD");
            if ($usuarioModel->actualizarImagenPerfil($_SESSION["usuario_id"], $uploadFile)) {
                $_SESSION['img_perfil'] = $uploadFile;
                echo json_encode(['success' => true, 'filePath' => $uploadFile]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar la base de datos.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo mover el archivo subido.']);
        }
    }

}

    

