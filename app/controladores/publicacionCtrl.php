

<?php

    class publicacionCtrl extends Controlador{

        public function index(){

            //TODO: Se debería hacer la comprobación de si en la sesion hay un usuario registrado.

            //Esto es para el error de cross origin
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");

            $metodo = $_SERVER['REQUEST_METHOD'];

            $respuesta_data = [""];

            //ESTO ESTÁ BASTANTE FEO
            switch($metodo){
                case 'POST':

                    $accion = $_POST['accion'];
                    switch($accion){
                        case 'editar':
                            $respuesta_data = $this->editar();
                            break;
                        case 'borrar':
                            $respuesta_data = $this->borrar();
                            break;
                        case 'subir':
                            $respuesta_data = $this->registrar();
                            break;
                        case 'subir_edicion':
                            $respuesta_data = $this->subirEdicion();
                            break;
                        default:
                            break;
                        }
                    break;
                    case 'GET':
                    http_response_code(200);
                    $respuesta_data = [
                        'status' => 'success',
                        'message' => 'Invalido get'
                    ];
                    break;
                    case 'DELETE':
                        http_response_code(200);
                        $respuesta_data = [
                        'status' => 'success',
                        'message' => 'Invalido delete'
                    ];
                    break;
                    case 'UPDATE':
                        $publicacionModelo = $this->cargarModelo('publicacionBD');
                        $resultado = $publicacionModelo->actualizarPublicacion();
                        http_response_code(200);
                    break;
                default:
                http_response_code(501);
                    $respuesta_data = [
                        'status' => 'error',
                        'message' => 'Error en el metodo'
                    ];
                    break;
                }
                
            echo json_encode($respuesta_data);
            

        }

        public function registrar(){

            $publicacionDB = $this->cargarModelo('publicacionBD');

            $taller_id = $_POST['taller_id'];
            $usuario_id = $_POST['usuario_id'];
            $titulo = $_POST['titulo'];
            $cuerpo = $_POST['cuerpo'];
            $archivos_id = $_POST['archivos_id'];

            $resultado = FALSE;

            switch($_POST['alcance']){
                case 'foro':

                    $resultado = $publicacionDB->subirPublicacionAForo($taller_id, $usuario_id, $titulo, $cuerpo);

                    $ultimo_indice = $publicacionDB->ultimo_id();

                    $test_dummy = 0;
                    if($archivos_id != '' && $resultado){

                        $array_id = explode(',', $archivos_id);

                       
                        foreach($array_id as $archivo_id){
                            $test_dummy = $test_dummy + 1;
                            if($publicacionDB->registrarPublicacionArchivo($ultimo_indice, $archivo_id)){
                                $resultado = TRUE;
                            }else{
                                $resultado = FALSE;
                                break;
                            }
                            
                        }
                        
                    }
            
                    
                    if($resultado){

                        http_response_code(201);
                        $respuesta_data = [
                            'status' => 'success',
                            'message' => 'Archivo guardado exitosamente.',
                            'data' => [
                                'id' => $ultimo_indice,
                                'archivos_id' => $archivos_id,
                                'ids' => $test_dummy
                            ]
                        ];
                        return $respuesta_data;
                    }else{
                        http_response_code(500);
                        return $respuesta_data = [
                        'status' => 'error',
                        'message' => 'Fuera de alcance',
                        'archivos_id' => $archivos_id,
                        'resultado' => $resultado, 
                        'alcance' => $_POST['alcance']
                        ];
                        
                    }
                    
                case 'libreta':
                    http_response_code(500);
                    $publicacionDB->subirPublicacionALibreta($taller_id, $usuario_id, $titulo, $cuerpo);
                    break;

                case 'recurso':

                    //FALTA EL CHEQUEO DE SI ES UN PROFESOR O NO
                    $resultado = $publicacionDB->subirRecurso($taller_id, $usuario_id, $titulo, $cuerpo);

                    $ultimo_indice = $publicacionDB->ultimo_id();

                    if($archivos_id != '' && $resultado){

                        $array_id = explode(',', $archivos_id);

                        foreach($array_id as $archivo_id){
                            if($publicacionDB->registrarPublicacionArchivo($ultimo_indice, $archivo_id)){
                                $resultado = TRUE;
                            }else{
                                $resultado = FALSE;
                            }
                            
                            break;
                        }
                        
                    }
            
                    
                    if($resultado){

                        http_response_code(201);

                        return $respuesta_data = [
                            'status' => 'success',
                            'message' => 'Archivo guardado exitosamente.',
                            'data' => [
                                'id' => $ultimo_indice,
                                'archivos_id' => $archivos_id
                            ]
                        ];
                    }else{
                        http_response_code(500);
                        return $respuesta_data = [
                        'status' => 'error',
                        'message' => 'Fuera de alcance',
                        'archivos_id' => $archivos_id,
                        'resultado' => $resultado, 
                        'alcance' => $_POST['alcance']
                        ];
                        
                    }
                    
                    if($resultado){

                        http_response_code(201);

                        return $respuesta_data = [
                            'status' => 'success',
                            'message' => 'Recurso guardado exitosamente.',
                            'data' => [
                                'id' => $ultimo_indice,
                                'archivo_id' => $archivo_id
                            ]
                        ];
                    }else{
                        http_response_code(500);
                        return $respuesta_data = [
                        'status' => 'error',
                        'message' => 'Fuera de alcance',
                        'archivos_id' => $archivos_id,
                        'resultado' => $resultado, 
                        'alcance' => $_POST['alcance']
                        ];
                        
                    }
                default:
                    http_response_code(501);
                    return $respuesta_data = [
                        'status' => 'error',
                        'message' => 'Fuera de alcance'
                        ];
                    
                    }


        
        }

        public function borrar(){

            $publicacionDB = $this->cargarModelo('publicacionBD');
            $tallerModelo = $this->cargarModelo('tallerBD');

            http_response_code(200);

            $publicacion = $publicacionDB->obtenerPublicacionPorId($_POST['id']);

            if($_SESSION['rol_id'] == 3){
                 if($_POST['usuario_id']  == $publicacion['usuario_id']) {
                    if($publicacionDB->borrarPublicacion($_POST['id'], TRUE)){
                        return [
                            'estado' => 'exito',
                            'mensaje' => 'Publicacion borrada exitosamente.'
                        ];
                    }else{
                        return [
                            'estado' => 'error',
                            'mensaje' => 'No pudo borrarse.'
                        ];
                    }
                 }else{
                        return [
                            'estado' => 'error',
                            'mensaje' => 'Prohibido.'
                        ];
                    }
            }else if($_SESSION['rol_id'] == 2){
                
                if( $tallerModelo->esProfesorDelTaller( $publicacion['taller_id'], $_SESSION['usuario_id'] )){
                    if($publicacionDB->borrarPublicacion($_POST['id'], TRUE)){
                        return [
                            'estado' => 'exito',
                            'mensaje' => 'Publicacion borrada exitosamente.'
                        ];
                    }else{
                        return [
                            'estado' => 'error',
                            'mensaje' => 'No pudo borrarse.'
                        ];
                    }
                }
                
            }else{
                if($publicacionDB->borrarPublicacion($_POST['id'], TRUE)){
                        return [
                            'estado' => 'exito',
                            'mensaje' => 'Publicacion borrada exitosamente.'
                        ];
                    }else{
                        return [
                            'estado' => 'error',
                            'mensaje' => 'No pudo borrarse.'
                        ];
                    }
            }


           

            
                
                return $respuesta_data = [
                    'status' => 'error',
                    'message' => 'No se pudo borrar la publicacion.'
                ];

            


        }

        public function editar(){

            $publicacionDB = $this->cargarModelo('publicacionBD');

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $publicacion = $publicacionDB->obtenerPublicacionPorId($_POST['id']);

                $data = [

                    'publicacion' => $publicacion
    
                ];

            }
           

            $this->mostrarVista('publicaciones/editar', $data, 'Editar Publicacion');


        }
        public function subirEdicion(){

            $publicacionDB = $this->cargarModelo('publicacionBD');

            $taller_id = $_POST['taller_id'];
            $publicacion_id = $_POST['publicacion_id'];
            $usuario_id = $_POST['usuario_id'];
            $titulo = $_POST['titulo'];
            $cuerpo = $_POST['cuerpo'];
            $archivos_id = $_POST['archivos_id'];

            $resutlado = $publicacionDB->actualizarPublicacion($publicacion_id, $titulo, $cuerpo, $archivos_id);

            if($resutlado){
                http_response_code(200);
            }

        }
    

}
