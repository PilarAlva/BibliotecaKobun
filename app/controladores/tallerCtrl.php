<?php

    class TallerCtrl extends Controlador{

       public function index($pagina = '1'){
        
        $cantidad_por_pagina = 20;

        $tallerModel = $this->cargarModelo("tallerBD");
        
        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;

        $talleres = $tallerModel->obtenerTalleres(0, 10);
        $resultados = $tallerModel->cantTalleres();

        $estado = 'no_inscripto';
        
        $mis_talleres = [];


        switch($this->estadoUsuario()){
            case USUARIO::ALUMNO:
                case USUARIO::PROFESOR:
                case USUARIO::ADMINISTRADOR:
                
                //TODO: Habria que agregar el offset y límite para esto tmb, pero qué paja 
                $mis_talleres = $tallerModel->obtenerTalleresUsuario($_SESSION['usuario_id']);
                
                break;
                default:
                $estado = 'no_inscripto';
                break;
                
            }
            
            
            
            $data = [
                    "cssEspecifico" => ["catalogo.css", "talleres.css", "publicaciones.css", "libreta.css"],
                    "talleres" => $talleres,
                     "mis_talleres" => $mis_talleres  ,
                     "resultados" => $resultados,
                     "offset" => $offset,
                     "url_paginacion" => $this->urlPaginacion('', '', $pagina),
                     "pagina" => $this->chequeoPagina($pagina),
                     "cantidad_paginas" => ceil(10 / $cantidad_por_pagina) ];


        $this->mostrarVista('talleres/lista', $data, 'Talleres');
            

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
                    $estado = 'profesor';
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

                if($this->estaElUsuarioInscripto($taller_id)){
    
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

                    //TODO: estas peticiones se deberían hacer cuando el usuario cambia de pestaña en el taller, pero bueno :/
                    $data = [
                        "cssEspecifico" => ["talleres.css", "publicaciones.css", "libreta.css"],
                        "publicaciones" => $publicacionModel->obtenerPublicacionesPorTaller($taller_id),
                        "recursos" => $publicacionModel->obtenerPublicacionesPorTaller($taller_id, 'recursos'),
                        "libreta" => $publicacionModel->obtenerPublicacionesLibretaPorTaller($taller_id, $_SESSION["usuario_id"] ),
                        "taller_id" => $taller_id,
                        "usuario_id" => $_SESSION["usuario_id"]
                    ];
                    
                    $publicacionModel->obtenerPublicacionesLibretaPorTaller($taller_id, $_SESSION["usuario_id"] );

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

                if($this->estaElUsuarioInscripto($taller_id)){
                    
                    if($this->usuarioRegistrado()){

                        $activo = $tallerModel->estaElUsuarioInscripto($taller_id, $_SESSION['usuario_id']);

                        if(!isset($activo)) $accion = 'inscribir';
                        else if ($activo == 1) $accion = 'inscripto';
                        else $accion = 'espera';

                    }
    
                }else{

                    $accion = 'info' ; 
                }

            }

            switch($accion){
                case 'inscribir':              
                    if($tallerModel->inscribirAlumno($taller_id, $_SESSION['usuario_id'])){
                        header('Location: ' . BASE_URL . 'taller/info' . $taller_id );
                    }else{
                        header('Location: ' . BASE_URL . 'taller/info');
                    }
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

        private function estaElUsuarioInscripto($taller_id){

            if($this->usuarioRegistrado()){

                $usuario_id = $_SESSION['usuario_id'];

                $tallerModel = $this->cargarModelo("tallerBD");

                $existe = $tallerModel->estaElUsuarioInscripto($taller_id, $usuario_id);

                return true;

                

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


