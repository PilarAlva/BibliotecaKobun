<?php

class Controlador{

    
    protected function cargarModelo($modelo){
        
        require_once '../app/modelos/' . $modelo . '.php';

        return new $modelo;

    }

    protected function mostrarVista($direccionVista, $datos = [], $titulo = 'Kobun'){

        //Este método del aberno desarma un array y hace que los elementos sean como variables de entorno, loquísimo
        extract($datos);
        require_once '../app/vistas/layout.php';

    }

}

?>