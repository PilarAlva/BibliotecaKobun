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
            switch($_SESSION['usuario_rol']){
                case 0:
                    return USUARIO::ADMINISTRADOR;
                    break;
                case 1:
                    return USUARIO::ALUMNO;
                    break;
                case 2:
                    return USUARIO::PROFESOR;
                    break;
                default:
                    return USUARIO::NO_REGISTRADO;
                    break;
            }   

        }
        return USUARIO::NO_REGISTRADO;

    }

    



}

?>