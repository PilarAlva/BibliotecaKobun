<?php

class InicioCtrl extends Controlador{

    
    public function inicio(){
        
        $this->mostrarVista('inicio', ['cssEspecifico' => 'inicio.css'], 'Inicio');

    }

}


?>