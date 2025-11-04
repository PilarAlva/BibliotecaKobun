<?php

    class TallerCtrl extends Controlador{

       public function index(){

        
        
        $datos = [
            'cssEspecifico' => 'taller.css'
        ];

        $this->mostrarVista('taller', $datos, 'Taller');
            
            
        }  
    }


?>
