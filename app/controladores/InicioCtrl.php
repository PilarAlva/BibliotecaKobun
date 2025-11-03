<?php

class InicioCtrl extends Controlador{

    
    public function inicio(){
        
        $datos = [
            'cssEspecifico' => 'inicio.css'
        ];

        $this->mostrarVista('inicio', $datos, 'Inicio');
    }

}


?>