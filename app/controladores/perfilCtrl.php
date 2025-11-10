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

            "cssEspecifico" => ['perfil.css'],
        ];

        $this->mostrarVista('perfil/perfil', $data, 'Perfil');

    }


}

