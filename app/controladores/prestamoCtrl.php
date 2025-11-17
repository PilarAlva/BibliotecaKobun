<?php



    class PrestamoCtrl extends Controlador{



        public function prestamo(){

            
            if (!($_SERVER['REQUEST_METHOD'] == "POST")) {
            
                header('Location: ' . BASE_URL );
            
            }
            
            if(!isset($_SESSION['usuario_id'])){
            
                header('Location: ' . BASE_URL . '/libro/id' . $_POST['libro_id']);
            
            }

            $estado = $this->registrarPrestamoPorIdUsuario($_POST['usuario_id'], $_POST['libro_id'], date('Y-m-d'));

            
            header('Location: ' . BASE_URL . 'libro/id/' . $_POST['libro_id'] . '?estado=' . urlencode($estado["mensaje"]) );


        }

        public function registrarPrestamoPorIdUsuario($usuario_id, $libro_id, $fecha_prestamo) {

            $libroModel = $this->cargarModelo("libroBD");            
            $socioModel = $this->cargarModelo("socioBD");            
            $prestamoModel = $this->cargarModelo("prestamoBD");            

            $socio = $socioModel->obtenerSocioPorIdUsuario($usuario_id);

            if (!$socio) {
            return ["estado" => "error", "mensaje" => "El socio no existe."];
            }

            $antiguedad_socio = $socioModel->antiguedadSocio($socio['id']);

            $cantidad_prestamos = $prestamoModel->cantPrestamosActivosPorSocio($socio['id']);

            $fecha_vencimiento = date('Y-m-d', strtotime($fecha_prestamo . ' + 15 days'));

            //Si el socio es nuevo se le dejan reservar únicamente 2 libros a la vez, si es un socio viej se lo dejan registrar 6 libros
            $valido = FALSE;

            if($socio["activo"] == 1){
                $valido = TRUE;   
            }

            if($antiguedad_socio < 180){
                if($cantidad_prestamos < 2) 
                        $valido = TRUE;
                    else {
                         return ["estado" => "error", "mensaje" => "Se llego al tope de préstamos."];
                    }
            }else if($antiguedad_socio > 181){
                if($cantidad_prestamos < 6) 
                        $valido = TRUE;
                    else{
                        return ["estado" => "error", "mensaje" => "Se llego al tope de préstamos."];
                    }
            }

            if(!$valido){
                return ["estado" => "error", "mensaje" => "El socio no cumple con los requisitos."];
            }
            
            $ejemplares = $libroModel->ejemplaresDisponibles($libro_id);

            if ($ejemplares) {
                
                $resultado = $prestamoModel->registrarPrestamo($socio['id'], $ejemplares[0]['id'], $fecha_vencimiento);
                
            }else{

                return ["estado" => "error", "mensaje" => "No hay ejemplares disponibles."];
            }
            

            if ($resultado) {
                
                return ["estado" => "exito", "mensaje" => "Préstamo registrado exitosamente."];

            } else {

                return ["estado" => "error", "mensaje" => $socio['id'] ."-Error al registrar el préstamo."];
                
            }
        }


    }