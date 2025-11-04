<?php

    class ContactoCtrl extends Controlador{

       public function index(){

        $datos = [
            'cssEspecifico' => 'contacto.css'
        ];
        $this->mostrarVista('contacto', $datos, 'Contacto');
            

    }


    }
