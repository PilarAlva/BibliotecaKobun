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
        if ($socio) {
            $prestamos = $prestamoModel->prestamosPorSocio($socio['id']);
        }
        
        $talleres = [];
        $talleres = $talleresModel->obtenerTalleresUsuario($_SESSION["usuario_id"]);
        
        $estadoSocio = "";
        if ($socio) {
            if ($socio['activo'] == 1) {
                $estadoSocio = "Activo";
            } else {
                $estadoSocio = "Inactivo";
            }
        }
        
        /* FALTA EL MODELO Y CONTROLADOR DE LOS DATOS DE LA BIBLIOTECAAAA !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
        $socioHabilitado= false;
        $socioInfoDeudas = [];
        $libros_prestados = [];
        if ($socio) {
            $cuotaSocio = $biblioteca["cuota_socio"];
            
            // --- Lógica de Cuotas de Socio ---
            $cuotaMensual = (float)$cuotaSocio;
            $ultimoPago = $pagoModel->obtenerUltimoPagoCuota($socio['id']);

            $fechaAlta = new DateTime($socio['fecha_alta']);
            
            $fechaReferencia = $ultimoPago && $ultimoPago['ultimo_pago'] ? new DateTime($ultimoPago['ultimo_pago']) : $fechaAlta;
            $hoy = new DateTime();
    
            // Se considera el mes siguiente al del último pago/alta como el primer mes de deuda.
            $fechaReferencia->modify('first day of next month');
       
            $mesesAdeudados = 0;
            if ($hoy >= $fechaReferencia) {
                $diferencia = $hoy->diff($fechaReferencia);
                // Se cuentan los meses completos transcurridos más el actual.
                $mesesAdeudados = ($diferencia->y * 12) + $diferencia->m + 1;
            }
    
            $montoCuotaTotal = $mesesAdeudados * $cuotaMensual;
    
            // La cuota está al día si debe solo la del mes actual y no ha pasado el día 15.
            $cuotaAlDia = ($montoCuotaTotal == $cuotaMensual && $hoy->format('d') < 16) || $montoCuotaTotal == 0;
    
            // --- Lógica de Multas por Préstamos de Libros Vencidos ---
            $multaDiaria = (float)$biblioteca["multa"];
            $montoMultasTotal = 0;

            foreach ($prestamos as $prestamo) {

                
                
                $libros_prestados[$prestamo["ejemplar_id"]] = $libroModel->infoLibro($prestamo["libro_id"]);
                

                if (!$prestamo['fecha_devolucion'] && new DateTime() > new DateTime($prestamo['fecha_vencimiento'])) {
                    $fechaVencimiento = new DateTime($prestamo['fecha_vencimiento']);
                    $diasAtraso = $hoy->diff($fechaVencimiento)->days;
                    
                    $montoMultasTotal += $diasAtraso * $multaDiaria;
                }
            }
            


            $socioInfoDeudas = [
                "montoCuota" => $montoCuotaTotal,
                "cuotaAlDia" => $cuotaAlDia,
                "montoMultas" => $montoMultasTotal,
            ];

            // Socio habilitado para pedir libros
            if ($cuotaAlDia && $montoMultasTotal == 0)
                $socioHabilitado = true;
            else if ($estadoSocio = "Inactivo")
                $socioHabilitado = false;
            else
                $socioHabilitado = false;
        } /**/
        
        /* Busqueda de Usuarios*/
        $listaUsuarios = $usuarioModel->obtenerTodosUsuarios();


        $prestamos = [];
        if ($socio) {
            $prestamos = $prestamoModel->prestamosPorSocio($socio['id']);
        }

        $talleres = [];
        $talleres = $talleresModel->obtenerTalleresUsuario($_SESSION["usuario_id"]);

        $estadoSocio = "";
        if ($socio) {
            if ($socio['activo'] == 1) {
                $estadoSocio = "Activo";
            } else {
                $estadoSocio = "Inactivo";
            }
        }
        
        /* FALTA EL MODELO Y CONTROLADOR DE LOS DATOS DE LA BIBLIOTECAAAA !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
        $socioHabilitado= false;
        $socioInfoDeudas = [];
        /* if ($socio) {
            $cuotaSocio = $biblioteca->cuotaSocio;

            // --- Lógica de Cuotas de Socio ---
            $cuotaMensual = (float)$biblioteca->cuota_socio;
            $ultimoPago = $socioModel->obtenerUltimoPagoCuota($socio['id']);
            $fechaAlta = new DateTime($socio['fecha_alta']);
            $fechaReferencia = $ultimoPago && $ultimoPago['ultimo_pago'] ? new DateTime($ultimoPago['ultimo_pago']) : $fechaAlta;
            $hoy = new DateTime();
    
            // Se considera el mes siguiente al del último pago/alta como el primer mes de deuda.
            $fechaReferencia->modify('first day of next month');
       
            $mesesAdeudados = 0;
            if ($hoy >= $fechaReferencia) {
                $diferencia = $hoy->diff($fechaReferencia);
                // Se cuentan los meses completos transcurridos más el actual.
                $mesesAdeudados = ($diferencia->y * 12) + $diferencia->m + 1;
            }
    
            $montoCuotaTotal = $mesesAdeudados * $cuotaMensual;
    
            // La cuota está al día si debe solo la del mes actual y no ha pasado el día 15.
            $cuotaAlDia = ($montoCuotaTotal == $cuotaMensual && $hoy->format('d') < 16) || $montoCuotaTotal == 0;
    
            // --- Lógica de Multas por Préstamos de Libros Vencidos ---
            $multaDiaria = (float)$biblioteca->multa;
            $montoMultasTotal = 0;
            foreach ($prestamos as $prestamo) {
                if (!$prestamo['fecha_devolucion'] && new DateTime() > new DateTime($prestamo['fecha_vencimiento'])) {
                    $fechaVencimiento = new DateTime($prestamo['fecha_vencimiento']);
                    $diasAtraso = $hoy->diff($fechaVencimiento)->days;
                    
                    $montoMultasTotal += $diasAtraso * $multaDiaria;
                }
            }
    
            $socioInfoDeudas = [
                "montoCuota" => $montoCuotaTotal,
                "cuotaAlDia" => $cuotaAlDia,
                "montoMultas" => $montoMultasTotal,
            ];

            // Socio habilitado para pedir libros
            if ($cuotaAlDia && $montoMultasTotal == 0)
                $socioHabilitado = true;
            else if ($estadoSocio = "Inactivo")
                $socioHabilitado = false;
            else
                $socioHabilitado = false;
        } */
        
        /* Busqueda de Usuarios*/
        $listaUsuarios = $usuarioModel->obtenerUsuarios();


        /* Busqueda de Libros */
        /* ... */
        
        /* Listado de Libros */
        /* $listaLibros = $libroModel->obtenerLibros(); */


        
        $data = [
            "usuario" => $usuario,
            "socio" => $socio,
            "prestamos" => $prestamos,
            "libros_prestados" => $libros_prestados,
            "socioInfoDeudas" => $socioInfoDeudas,
            "socioHabilitado" => $socioHabilitado,
            "talleres" => $talleres,
            "estadoSocio" => $estadoSocio,
            "listaUsuarios" => $listaUsuarios,

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

    

