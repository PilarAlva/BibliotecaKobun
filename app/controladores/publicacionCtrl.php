

<?php

    class publicacionCtrl extends Controlador{

        public function index(){

            //TODO: Se debería hacer la comprobación de si en la sesion hay un usuario registrado.

            //Esto es para el error de cross origin
            header("Access-Control-Allow-Origin: http://" . SERVER_IP . "");
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");

            $metodo = $_SERVER['REQUEST_METHOD'];

            $respuesta_data = [""];

            switch($metodo){
                case 'POST':
                    $respuesta_data = $this->registrar();
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


                    break;
                case 'libreta':
                    http_response_code(500);
                    $publicacionDB->subirPublicacionALibreta($taller_id, $usuario_id, $titulo, $cuerpo);
                    break;
                case 'recurso':
                    http_response_code(500);
                    $publicacionDB->subirRecurso($taller_id, $usuario_id, $titulo, $cuerpo);
                    break;
                default:
                    http_response_code(501);
                    return $respuesta_data = [
                        'status' => 'error',
                        'message' => 'Fuera de alcance'
                        ];
                    break;
                    }


        
        }

    

}


