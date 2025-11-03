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

}

