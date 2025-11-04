<?php

class PerfilCtrl extends Controlador{

    
    public function index(){
        
        $usuarioModel = $this->cargarModelo("usuarioBD");
        $socioModel = $this->cargarModelo("socioBD");

        if(!isset($_SESSION["usuario_id"])){
            header('Location: ' . BASE_URL . 'sesion');
        }

        $usuario = $usuarioModel->obtenerUsuarioPorId($_SESSION["usuario_id"]);
        
        $socio = $socioModel->obtenerSocioPorIdUsuario($_SESSION["usuario_id"]);


        $data = [
            "usuario" => $usuario,
            "socio" => $socio,
            "cssEspecifico" => 'perfil.css'
        ];

        $this->mostrarVista('perfil', $data, 'Perfil');

    }

    public function MostrarPrestamos() {
        
        if (!$socio) {
            return ["error" => "Usted no es Socio."];
        }

        $prestamoModel = $this->cargarModelo("prestamoBD");
        $prestamos = $prestamoModel->prestamosPorSocio($socio['id']);

        return $prestamos;
    }
    
    /* private function MostrarTalleres () {
        

        $talleres[] = 
        return $talleres;
    }
 */
    /* private function datosSocio () {

    } */

    




}

