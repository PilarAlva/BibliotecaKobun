<?php

class PagoCtrl extends Controlador{

    
    public function pago(){
        
        $usuarioModel = $this->cargarModelo("usuarioBD");
        $socioModel = $this->cargarModelo("socioBD");

        if(!isset($_SESSION["usuario_id"])){
            header('Location: ' . BASE_URL . 'sesion');
        }

        $usuario = $usuarioModel->obtenerUsuarioPorId($_SESSION["usuario_id"]);
        
        $socio = $socioModel->obtenerSocioPorIdUsuario($_SESSION["usuario_id"]);


        $data = [
            "usuario" => $usuario,
            "socio" => $socio
        ];

        $this->mostrarVista('perfil', $data, 'Perfil');

    }

}

