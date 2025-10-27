<?php

    
    require_once "./modelo/libroBD.php";
    require_once "./modelo/socioBD.php";


    class PrestamoCtrl {

        $LibroBD;
        $SocioBD;
        $PrestamoBD;

        public function __construct(){

            $this->LibroBD = new LibroBD();
            $this->SocioBD = new socioBD();
            $this->PrestamoBD = new PrestamoBD();

        }

        public function registrarPrestamo($socio_id, $ejemplar_id, $fecha_prestamo) {

            
            $socio = $this->SocioBD->obtenerSocioPorId($socio_id);
            if (!$socio) {
                return ["error" => "El socio no existe."];
            }

            $ejemplar = $this->LibroBD->obtenerEjemplarPorId($ejemplar_id);

            if (!$ejemplar || !$ejemplar['disponible']) {
                return ["error" => "El ejemplar no está disponible para préstamo."];
            }

            $antiguedad_socio = $this->SocioBD->antiguedadSocio($socio_id);
            $cantidad_prestamos = $this->PrestamoBD->cantPrestamosActivosPorSocio($socio_id);

            $fecha_vencimiento = date('Y-m-d', strtotime($fecha_prestamo . ' + 15 days'));

            //Si el socio es nuevo se le dejan reservar únicamente 2 libros a la vez, si es un socio viej se lo dejan registrar 6 libros
            $valido = FALSE;

            if($socio["activo"] == 1){
             $valido = TRUE;   
            }

            switch($antiguedad_socio){
                case 10:

                    if($cantidad_prestamos < 2) 
                        $valido = TRUE;

                    break;
                case 20:
                default:
                    
                    if($cantidad_prestamos < 6) 
                        $valido = TRUE;

                    break;

            }         

            if(!$valido){
                return ["error" => "El socio no cumple con lso requisitos."]
            }
            
            $resultado = $this->PrestamoBD->registrarPrestamo($socio_id, $ejemplar_id, $fecha_prestamo, $fecha_vencimiento);
            if ($resultado) {
                
                return ["success" => "Préstamo registrado exitosamente."];

            } else {

                return ["error" => "Error al registrar el préstamo."];
                
            }
        }



    }