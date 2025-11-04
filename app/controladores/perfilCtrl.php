<?php

class PerfilCtrl extends Controlador{

    
    public function index(){
        
        $usuarioModel = $this->cargarModelo("usuarioBD");
        $socioModel = $this->cargarModelo("socioBD");
        $prestamoModel = $this->cargarModelo("prestamoBD");
        $talleresModel = $this->cargarModelo("talleresBD");

        if(!isset($_SESSION["usuario_id"])){
            header('Location: ' . BASE_URL . 'sesion');
        }

        $usuario = $usuarioModel->obtenerUsuarioPorId($_SESSION["usuario_id"]);
        $socio = $socioModel->obtenerSocioPorIdUsuario($_SESSION["usuario_id"]);


        $prestamos = [];
        if ($socio) {
            // El usuario es socio, buscamos sus préstamos.
            $prestamos = $prestamoModel->prestamosPorSocio($socio['id']);
        }

        $talleres = [];
        if (  ) {
            // Se buscan sus talleres.

        }
        /* OJO ACTUALIZAR LA TABLA DE TALLERES POR USUARIO PARA EL CAMPO: estado (pendiente, admitido) */


        $data = [
            "usuario" => $usuario,
            "socio" => $socio,
            "prestamos" => $prestamos,
            "cssEspecifico" => 'perfil.css',
        ];

        $this->mostrarVista('perfil', $data, 'Perfil');

    }

    

    
    




}
