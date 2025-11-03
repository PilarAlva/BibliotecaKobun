

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
                    $this->registrar();
                    break;
                default:
                    http_response_code(501);
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

            

            switch($_POST['alcance']){
                case 'foro':
                    $publicacionDB->subirPublicacionAForo($taller_id, $usuario_id, $titulo, $cuerpo);
                    if(isset($archivos_id)){
                        $ultimo_indice = $publicacionDB->ultimoId();

                        foreach($archivos_id as $indice => $archivo_id){
                            $publicacionDB->registrarPublicacionArchivo($ultimo_indice, $archivo_id);
                        }
                        
                    }
                    break;
                case 'libreta':
                    $publicacionDB->subirPublicacionALibreta($taller_id, $usuario_id, $titulo, $cuerpo);
                    break;
                case 'recurso':
                    $publicacionDB->subirRecurso($taller_id, $usuario_id, $titulo, $cuerpo);
                    break;
                default:
                    break;
            }
            
                    
            
                http_response_code(500);
                $respuesta_data = [
                                'status' => 'error',
                                'message' => 'No se pudo guardar el archivo.'
                            ];
                http_response_code(201);
                        


                http_response_code(500);
                $respuesta_data = [
                        'status' => 'success',
                        'message' => 'Archivo guardado exitosamente.',
                        'data' => [
                            'id' => $archivoDB->ultimoId(),
                        ]
                    ];

                $respuesta_data = [
                        'status' => 'error',
                        'message' => 'No se pudo registrar el archivo.'
                    ];
                
                        


        
        }

    

}


