<?php

enum USUARIO
{
    case NO_REGISTRADO;
    case ALUMNO;
    case PROFESOR;
    case ADMINISTRADOR;

}


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

    /*
           if($this->usuarioRegistrado() ){

                if($this->estaUsuario()){

                    $mostrarTaller = true;

                }
    */

    protected function usuarioRegistrado(){

        //Me gustaría que acá haga más comprobaciones
        if(isset($_SESSION['usuario_id'])){
            
            return $_SESSION['usuario_id'];
        }else{
            return 0;
        }


    }
    protected function estadoUsuario(){
        if(isset($_SESSION['usuario_id']))
        {
            switch($_SESSION['rol_id']){
                case 1:
                    return USUARIO::ADMINISTRADOR; // Rol de Administrador
                case 2:
                    return USUARIO::PROFESOR; // Rol de Profesor
                default:
                    // Cualquier otro rol logueado se considera Alumno
                    return USUARIO::ALUMNO;
            }

        }
        return USUARIO::NO_REGISTRADO;

    }

    



}

?>