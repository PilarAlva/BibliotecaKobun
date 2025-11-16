<?php

    class TallerCtrl extends Controlador{

       public function index($pagina = '1'){
        
        $cantidad_por_pagina = 20;

        $tallerModel = $this->cargarModelo("tallerBD");
        
        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;

        $talleres = $tallerModel->obtenerTalleresActivos(0, 100);
        $resultados = $tallerModel->cantTalleres();

        $estado = '';
        
        $mis_talleres = [];
        $talleresInactivos = [];


        switch($this->estadoUsuario()){
            case USUARIO::ALUMNO:
            case USUARIO::PROFESOR:
                $estado = 'inscripto';
                //TODO: Habria que agregar el offset y límite para esto tmb, pero qué paja 
                $mis_talleres = $tallerModel->obtenerTalleresUsuario($_SESSION['usuario_id']);
                break;
            case USUARIO::ADMINISTRADOR:
                $estado = 'admin';
                $mis_talleres = $tallerModel->obtenerTalleresUsuario($_SESSION['usuario_id']);
                $talleresInactivos = $tallerModel->obtenerTalleresInactivos();
                break;
                default:
                $estado = 'no_logueado';
                break;
                
            }
            
            
            
            $data = [
                    "cssEspecifico" => ["catalogo.css", "talleres.css", "publicaciones.css", "libreta.css"],
                    "talleres" => $talleres,
                    "estado" => $estado,
                    "mis_talleres" => $mis_talleres  ,
                    "talleresInactivos" => $talleresInactivos,
                    "resultados" => $resultados,
                    "offset" => $offset,
                    "url_paginacion" => $this->urlPaginacion('', '', $pagina),
                    "pagina" => $this->chequeoPagina($pagina),
                    "cantidad_paginas" => ceil(10 / $cantidad_por_pagina) ];


        /* $this->mostrarVista('talleres/lista', $data, 'Talleres'); */
        $this->mostrarVista('talleres/talleres', $data, 'Talleres');
            

    }

        public function mostrarInfoTaller($taller_id = '1'){
            
            $tallerModel = $this->cargarModelo("tallerBD");

            $taller = $tallerModel->obtenerTallerPorId($taller_id);

            $estado = 'no_inscripto';

            switch($this->estadoUsuario()){
                case USUARIO::ALUMNO:
                case USUARIO::PROFESOR:

                    $activo = $tallerModel->estaElUsuarioInscripto($taller_id, $_SESSION['usuario_id']);

                    if(!isset($activo)) 
                        $estado = 'no_inscripto';
                    else if ($activo == 1) 
                        $estado = 'inscripto';
                    else 
                        $estado = 'en_espera';

                    break;
                    
                case USUARIO::ADMINISTRADOR:
                    $estado = 'admin';
                    break;
                default:
                    $estado = 'no_inscripto';
                    break;

            }

            $data = [
                "cssEspecifico" => "talleres.css",
                "taller" => $taller,
                "estado" => $estado
            ];

            $this->mostrarVista('talleres/taller/info', $data, 'Taller');


        }

        public function taller($taller_id = '1'){
            
            $tallerModel = $this->cargarModelo("tallerBD");
            $accion = 'error';

            if($this->existeTaller($taller_id)){

                
                if($this->esProfesorDelTaller($taller_id)){
                    $accion = 'mostrar'; 
                }
                else if($this->estaElUsuarioInscripto($taller_id)){
    
                    $accion = 'mostrar';
    
                }else{

                    $accion = 'info' ; 
                }

            }

            
            $data = [
                "taller_id" => $taller_id
            ];
            
            switch($accion){
                case 'mostrar':
                    
                    if($_SERVER['REQUEST_METHOD'] == "POST"){
                       $this->procesarPeticion($_POST["accion"], $data);
                    }

                    $publicacionModel = $this->cargarModelo("publicacionBD");
                    
                    $taller = $tallerModel->obtenerTallerPorId($taller_id);

                    //TODO: estas peticiones se deberían hacer cuando el usuario cambia de pestaña en el taller, pero bueno :/
                    $data = [
                        "cssEspecifico" => ["talleres.css", "publicaciones.css", "libreta.css"],
                        "publicaciones" => $publicacionModel->obtenerPublicacionesPorTaller($taller_id),
                        "recursos" => $publicacionModel->obtenerPublicacionesPorTaller($taller_id, "recurso"),
                        "taller" => $taller,
                        "libreta" => $publicacionModel->obtenerPublicacionesLibretaPorTaller($taller_id, $_SESSION["usuario_id"] ),
                        "participantes" => $tallerModel->alumnosInscriptios($taller_id),
                        "pendientes" => $tallerModel->alumnosPendientes($taller_id),
                        "profesores" => $tallerModel->obtenerProfesores($taller_id),
                        "taller_id" => $taller_id,
                        "usuario_id" => $_SESSION["usuario_id"]
                    ];
                    
                    //$publicacionModel->obtenerPublicacionesLibretaPorTaller($taller_id, $_SESSION["usuario_id"] );


                    $this->mostrarVista('talleres/taller/taller', $data, 'Taller');

                    break;
                case 'info':
                    header('Location: ' . BASE_URL . 'taller/info/' . $taller_id );
                    break;
                case 'error':
                default:
                    header('Location: ' . BASE_URL . 'talleres/');
                    break;



                }


        }

        public function inscripcion($taller_id = 0){
        
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                header('Location: ' . BASE_URL . 'taller/ins/' . $_POST['taller_id']);
                return;
            }

            //CHEQUEA SI QUE EL TALLER SEA VALIDO
            if($taller_id == 0){

                header('Location: ' . BASE_URL );
                return;

            }

            $tallerModel = $this->cargarModelo("tallerBD");

            $accion = 'error';

            if($this->existeTaller($taller_id)){

                if($this->usuarioRegistrado()){

                    $activo = $tallerModel->estaElUsuarioInscripto($taller_id, $_SESSION['usuario_id']);

                    if(!isset($activo)) $accion = 'inscribir';
                    else if ($activo == 1) $accion = 'inscripto';
                    else $accion = 'espera';

    
                }else{

                    $accion = 'info' ; 
                }

            }

            switch($accion){
                case 'inscribir':              
                    $tallerModel->inscribirAlumno($taller_id, $_SESSION['usuario_id']);
                    header('Location: ' . BASE_URL . 'taller/info/' . $taller_id);

                    break;
                case 'inscripto':
                    header('Location: ' . BASE_URL . 'taller/id/' . $taller_id);
                    break;
                case 'espera':
                    header('Location: ' . BASE_URL . 'taller/info/' . $taller_id);
                    break;
                case 'info':
                    header('Location: ' . BASE_URL . 'taller/info/' . $taller_id );
                    break;
                case 'error':
                default:
                    header('Location: ' . BASE_URL );
                    break;



                }

        }


        public function eliminarAlumno(){

            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                header('Location: ' . BASE_URL . 'taller/id' . $_POST['taller_id']);
                return;
            }

            //CHEQUEA SI QUE EL TALLER SEA VALIDO
            if($_POST["taller_id"] == 0){

                header('Location: ' . BASE_URL );
                return;

            }

            $tallerModel = $this->cargarModelo("tallerBD");

            $taller_id = $_POST["taller_id"];
            $usuario_id = $_POST["usuario_id"];

            $accion = 'error';

            if($this->existeTaller($taller_id)){
                
                if($this->esProfesorDelTaller($taller_id)){

                    if($tallerModel->estaElUsuarioInscripto($taller_id, $usuario_id)){
                    
                        $accion = 'eliminar';
                    
                    }

                }else if($this->estaElUsuarioInscripto($taller_id)){
                    
                        $accion = 'eliminar';

                }

            }

            switch($accion){
                case 'eliminar':              
                    if($tallerModel->eliminarAlumno($taller_id, $usuario_id)){
                        header('Location: ' . BASE_URL . 'taller/id/' . $taller_id );
                    }else{
                        header('Location: ' . BASE_URL . 'talleres/');
                    }
                    break;
                case 'error':
                default:
                    header('Location: ' . BASE_URL );
                    break;



                }
            

        }

        //ESTADO DE ALUMNOS - SOLO UN PROFESOR HACE ESTO DE MOMENTO

        public function rechazarAlumno(){
            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                header('Location: ' . BASE_URL . 'taller/id' . $_POST['taller_id']);
                return;
            }

            //CHEQUEA SI QUE EL TALLER SEA VALIDO
            if($_POST["taller_id"] == 0){

                header('Location: ' . BASE_URL );
                return;

            }

            $tallerModel = $this->cargarModelo("tallerBD");

            $taller_id = $_POST["taller_id"];
            $usuario_id = $_POST["usuario_id"];

            $accion = 'error';

            if($this->existeTaller($taller_id)){
                
                if($this->esProfesorDelTaller($taller_id)){

                    $accion = 'rechazar';

                }

            }

            switch($accion){

                case 'rechazar':

                    //AHORA SE ELIMINAR Y A LA MIERDA, tendría que mandarse una notificacion o algo así
                    if($tallerModel->eliminarAlumno($taller_id, $usuario_id)){
                        header('Location: ' . BASE_URL . 'taller/id/' . $taller_id );
                    }else{
                        echo 'la puta madre esta cosa no funciona';
                    }
                    break;

                case 'error':
                default:
                    header('Location: ' . BASE_URL );
                    break;



                }

        }

        public function aceptarAlumno(){

            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                header('Location: ' . BASE_URL . 'taller/id' . $_POST['taller_id']);
                return;
            }

            //CHEQUEA SI QUE EL TALLER SEA VALIDO
            if($_POST["taller_id"] == 0){

                header('Location: ' . BASE_URL );
                return;

            }

            $tallerModel = $this->cargarModelo("tallerBD");

            $taller_id = $_POST["taller_id"];
            $usuario_id = $_POST["usuario_id"];

            $accion = 'error';

            if($this->existeTaller($taller_id)){
                
                if($this->esProfesorDelTaller($taller_id)){

                
                    
                    $accion = 'aceptar';
                    
                
                    
                }

            }

            switch($accion){

                case 'aceptar':
                    
                    if(!$tallerModel->cambiarEstadoAlumno($taller_id, $usuario_id, 1 )){
                        header('Location: ' . BASE_URL . 'taller/id/' . $taller_id );
                    }else{
                        header('Location: ' . BASE_URL . 'talleres');
                    }              
                    break;

                case 'error':
                default:
                    header('Location: ' . BASE_URL . 'taller/id/' . $taller_id );
                    break;



                }

        }

        public function editar($taller_id){

            if($_SERVER['REQUEST_METHOD'] != "POST"){
                header('Location: ' . BASE_URL .'');
            }
            if(isset( $_SESSION['rol_id'] ) && $_SESSION['rol_id'] == 1){
                $tallerModel = $this->cargarModelo("tallerBD");
                
                $horario = $_POST["horario"];
                $nombre = $_POST["nombre"];
                $lugar = $_POST["lugar"];
                $descripcion = $_POST["descripcion"];
                $activo = $_POST["activo"];
                
                $taller = $tallerModel->obtenerTallerPorId($taller_id);
                if($taller){
                    $resultado = $tallerModel->editarTaller($taller_id, $nombre, $descripcion, $horario, $lugar, $activo);

                    if(!empty($resultado)){
                        header('Location: ' . BASE_URL . 'taller/id/' . $taller_id);
                        exit;

                    }
                }

            }
            header('Location: ' . BASE_URL);

            
        }

        public function eliminar($taller_id){
            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                header('Location: ' . BASE_URL . 'talleres');
                exit;
            }

            if ($this->estadoUsuario() == USUARIO::ADMINISTRADOR) {
                $tallerModel = $this->cargarModelo("tallerBD");
                if ($tallerModel->eliminarTaller($taller_id)) {
                    
                    header('Location: ' . BASE_URL . 'talleres');
                    exit;
                }
            }
            header('Location: ' . BASE_URL . 'taller/info/' . $taller_id);
        }
        //FUNCIONALES

        function procesarPeticion($accion, &$data){

            $tallerModel = $this->cargarModelo("tallerBD");

            switch($accion){
                case 'editar': 
                    $publicacionModel = $this->cargarModelo("publicacionBD");
                    if($publicacionModel->obtenerPublicacionPorId($_POST['id'])){

                        $data["publicacion_editar"] = $publicacionModel->obtenerPublicacionPorId($_POST['id']);
                        return;
                    };
                break;
                default:
                    break;
              
            }
        }       

        private function existeTaller($taller_id){

                $tallerModel = $this->cargarModelo("tallerBD");

                $existe = $tallerModel->obtenerTallerPorId($taller_id);

                if($existe){
                    return true;
                }else{
                    return false;
                }

        }
        private function esProfesorDelTaller($taller_id){
            
            if($this->usuarioRegistrado()){

                $usuario_id = $_SESSION['usuario_id'];

                $tallerModel = $this->cargarModelo("tallerBD");

                return $tallerModel->esProfesorDelTaller($taller_id, $usuario_id);

            }
            else return false;

        }

        private function estaElUsuarioInscripto($taller_id){

            if($this->usuarioRegistrado()){

                $usuario_id = $_SESSION['usuario_id'];

                $tallerModel = $this->cargarModelo("tallerBD");

                $existe = $tallerModel->estaElUsuarioInscripto($taller_id, $usuario_id);

                return $existe;

                

            }
            else return false;



        }

        private function chequeoPagina($pagina){
            if (!$this->esEnteroPositivo($pagina) || (int)$pagina < 1) {
                return 1;
            }
            return (int)$pagina;
        }

        private function urlPaginacion($filtro = '', $busqueda = '', $pagina) {

            if($filtro == '' || $busqueda == '') {
                return BASE_URL . 'talleres/b/';
            }

            return BASE_URL . 'talleres/b/' . $filtro . '/' . urlencode($busqueda) . '/';
        }



        private function esEnteroPositivo($string) {
            return preg_match('/^\d+$/', $string);
        }


    }