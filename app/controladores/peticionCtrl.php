

<?php

    class peticionCtrl extends Controlador{

       public function peticion(){
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");



        $msj = 1; //ERROR POR DEFECTO

        $usuarioModel = $this->cargarModelo("usuarioBD");
        $respuesta_data = [
                        'status' => 'error',
                        'message' => 'Error la peticion'
                    ];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {
                $peticion = $_POST['accion'];

            switch ($peticion) {
                    case 'usuarios':
                        
                        //$cuerpo = $usuarioModel->obtenerTodosUsuarios();
                        $respuesta_data = [
                            'status' => 'success',
                            'message' => 'Usuarios obtenidos correctamente.',
                            'data' => [
                                'usuarios' => $usuarioModel->obtenerTodosUsuarios()                            ]
                        ];

                    break;
                    case 'insertar_usuario':
                        if($usuarioModel->registrarUsuario($_POST['nombre'], $_POST['apellido'], $_POST['mail'], $_POST['clave'])){
                            $respuesta_data = [
                            'status' => 'success',
                            'message' => 'Usuario insertado correctamente.',
                        ];
                        }else{
                            $respuesta_data = [
                                'status' => 'error',
                                'message' => 'Error al insertar el usuario.',
                            ];
                        }
                    break;   
                    case 'usuario':
                        
                        //$cuerpo = $usuarioModel->obtenerTodosUsuarios();
                        $respuesta_data = [
                            'status' => 'success',
                            'message' => 'Usuario obtenido correctamente.',
                            'data' => [
                                'usuario' => $usuarioModel->obtenerUsuarioPorId($_POST['usuario_id'])                            ]
                        ];

                    break;
                    
                    default:
                    break;
            }



        }

        echo json_encode($respuesta_data);
    
    }
    }


