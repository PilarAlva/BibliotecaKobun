

<?php

    include_once("../app/controladores/sesionCtrl.php");

    class peticionCtrl extends Controlador{

       public function peticion(){
        
        $sesionCtrl = new SesionCtrl();

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $usuarioModel = $this->cargarModelo("usuarioBD");
        $socioModel = $this->cargarModelo("socioBD");
        $transaccionModel = $this->cargarModelo("transaccionBD");
        $prestamosModel = $this->cargarModelo("prestamoBD");
        $pagoModel = $this->cargarModelo("pagoDB");
        $socioModel = $this->cargarModelo("socioBD");
        $talleresModel = $this->cargarModelo("tallerBD");
        $libroModel = $this->cargarModelo("libroBD");

        $respuesta_data = [
                        'estado' => 'error',
                        'mensaje' => 'Error en la peticion'
                    ];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {
                $peticion = $_POST['accion'];

            switch ($peticion) {

                    // case 'emepezar-transaccion':
                    //     if($transaccionModel->empezar()){
                    //         $respuesta_data =[
                    //             'estado' => 'exito',
                    //             'mensaje' => 'Transaccion iniciada.'
                    //         ];
                    //     }else{
                    //         $respuesta_data =[
                    //             'estado' => 'error',
                    //             'mensaje' => 'No se pudo comenzar la transaccion.'
                    //         ];
                    //     }
                    //     break;
                    // case 'commit-transaccion':
                    //     if($transaccionModel->aceptar()){
                    //         $respuesta_data =[
                    //             'estado' => 'exito',
                    //             'mensaje' => 'Cambios realizados.'
                    //         ];
                    //     }else{
                    //         $respuesta_data =[
                    //             'estado' => 'error',
                    //             'mensaje' => 'No se pudieron guardar los cambios.'
                    //         ];
                    //     }
                    //     break;
                    // case 'cerrar-transaccion':
                    //     if($transaccionModel->cerrar()){
                    //         $respuesta_data =[
                    //             'estado' => 'exito',
                    //             'mensaje' => 'Cambios realizados.'
                    //         ];
                    //     }else{
                    //         $respuesta_data =[
                    //             'estado' => 'error',
                    //             'mensaje' => 'Error al cerrar la transaccion'
                    //         ];
                    //     }
                    //     break;
                    case 'usuarios':
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Usuarios obtenidos correctamente.',
                            'data' => [
                                'usuarios' => $usuarioModel->obtenerTodosUsuarios() ]
                        ];

                    break;
                    case 'prestamos':
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Prestamos obtenidos correctamente.',
                            'data' => [
                                'prestamos' => $prestamosModel->prestamosPorSocio($_POST['socio_id']) 
                                ]
                        ];
                    break;
                    case 'multas':
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Multas obtenidos correctamente.',
                            'data' => [
                                'multas' => $prestamosModel->obtenerMultas($_POST['socio_id']) 
                                ]
                        ];

                    break;
                    case 'estado-cuenta':
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Estado obtenido correctamente.',
                            'data' => [
                                'estado_cuenta' => $pagoModel->estadoCuenta($_POST['socio_id']) 
                                ]
                            ];
                            
                            break;
                    case 'usuario':
                        $usuario = $usuarioModel->obtenerInfoCompletaUsuarioPorId($_POST['usuario_id']);
                        $socio_habilitado = false;
                        
                        if(isset($usuario["socio_id"])){
                            $socio_habilitado = $socioModel->esSocioHabilitado($usuario["socio_id"]);
                        }

                        $respuesta_data = [
                            'estado' => 'extio',
                            'mensaje' => 'Usuario obtenido correctamente.',
                            'data' => [
                                'usuario' => $usuario,
                                'socio_habilitado' => $socio_habilitado
                            ]];

                        break;
                    case 'libro':
                        $libro = $libroModel->infoLibro($_POST['libro_id']); 

                        $respuesta_data = [
                            'estado' => 'extio',
                            'mensaje' => 'Libro obtenido correctamente.',
                            'data' => [
                                'libro' => $libro
                            ]];
                    
                        break;
                    case 'ejemplares':
                        $ejemplares = $libroModel->ejemplaresTotales($_POST['libro_id']); 

                        $respuesta_data = [
                            'estado' => 'extio',
                            'mensaje' => 'Ejemplares obtenidos correctamente.',
                            'data' => [
                                'ejemplares' => $ejemplares
                            ]];
                    
                        break;
                    case 'ejemplares-disponibles':
                        $disponibles = $libroModel->ejemplaresDisponibles($_POST['libro_id']); 

                        $respuesta_data = [
                            'estado' => 'extio',
                            'mensaje' => 'Ejemplares obtenidos correctamente.',
                            'data' => [
                                'disponibles' => $disponibles
                            ]];
                    
                        break;
                    case 'estado-libro':
                        $respuesta_data = [
                            'estado' => 'extio',
                            'mensaje' => 'Cambio de estado libro',
                            'data' =>[
                                "estado" => $libroModel->cambiarEstado($_POST['libro_id'], $_POST['activado'])
                            ]
                        ];
                        break;
                    case 'registrar-usuario':
                        http_response_code(200);
                        $nombre = htmlspecialchars($_POST['nombre']);
                        $apellido = htmlspecialchars($_POST['apellido']);
                        $mail = htmlspecialchars($_POST['mail']);
                        $clave = htmlspecialchars($_POST['nombre'] . "1234");

                        $estado = $sesionCtrl->registrarUsuario($nombre, $apellido, $mail, $clave);
                        if($estado["estado"] == "exito"){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => $estado["mensaje"],
                                'data' => [
                                    'usuario_id' => $usuarioModel->obtenerUsuarioPorMail($mail)["id"]
                                    ]
                            ];
                        }else{
                            $respuesta_data = [
                                'estado' => 'error',
                                'mensaje' => $estado["mensaje"],
                            ];
                        }
                    break;   
                    case 'agregar-socio':
                        $resultado = $socioModel->registrarSocio($_POST['usuario_id'], $_POST['telefono'], $_POST['dni'], $_POST['fecha_nacimiento']);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Registrado como socio',
                            ];

                        }else{
                        $respuesta_data = [
                            'estado' => 'error',
                            'mensaje' => 'No se pudo ingresar el socio'
                        ];}
                        break;
                    case 'agregar-profesor':
                        $resultado = $usuarioModel->cambiarRolUsuario($_POST['usuario_id'], 2);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Registrado como profesor',
                            ];

                        }else{
                        $respuesta_data = [
                            'estado' => 'error',
                            'mensaje' => 'No se pudo hacer profesor'
                        ];}
                        break;
                    case 'quitar-profesor':
                        $resultado = $usuarioModel->cambiarRolUsuario($_POST['usuario_id'], 3);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Quitado rol de profesor',
                            ];

                        }else{
                        $respuesta_data = [
                            'estado' => 'error',
                            'mensaje' => 'Ya no quiero poner más errores'
                        ];}
                        break;
                    case 'borrar-usuario':
                        $resultado =  false; // $usuarioModel->borrarUsuario($_POST['usuario_id']);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Quitado rol de profesor',
                            ];

                        }else{
                        $respuesta_data = [
                            'estado' => 'error',
                            'mensaje' => 'Está implementado, pero da miedito'
                        ];}
                        break;
                    case 'devolver-prestamo':
                        
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Devuelto '
                        ];
                        foreach ($_POST as $index => $valor) {
                            if($index == 'prestamo_id') {
                            if($prestamosModel->devolverPrestamo($_POST['prestamo_id'])){
                                $respuesta_data['mensaje'] .='-'. $index .'-'. $valor .'';
                            }else{
                                $respuesta_data = [
                                    'estado' => 'error',
                                    'mensaje'=> "no se pudo devolver"
                                ];
                                }
                            }   
                        }   
                        break;
                    case 'busqueda-dinamica':
                        $tabla = htmlspecialchars($_POST['tabla']);
                        $busqueda = htmlspecialchars($_POST['q']);
                        $filtro = htmlspecialchars($_POST['filtro']);   
                        $offset = htmlspecialchars($_POST['pagina']);
                        $offset = ($offset - 1) * 20;

                        switch ($tabla) {
                            case 'libros':
                                $respuesta_data = [
                                    'estado' => 'exito',
                                    'mensaje'=> "Libros devueltos",
                                    'data' => [
                                        'cantidad' => $libroModel->cantResultadosCatalogo($busqueda, $filtro),
                                        'resultados' => $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, 20 )
                                    ]
                                ];
                                break;
                             case 'usuarios':
                                $respuesta_data = [
                                    'estado' => 'exito',
                                    'mensaje'=> "Uusarios devueltos",
                                    'data' => [
                                        'cantidad' => $usuarioModel->cantResultadosBusqueda($busqueda, $filtro),
                                        'resultados' => $usuarioModel->busquedaUsuarios($busqueda, $filtro, $offset, 20 )
                                    ]
                                ];
                                break;
                            default:
                                break;
                        }

                        break;
                    case 'opciones':

                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje'=> "Opciones devueltas",
                        ];

                        $resultado = "";
                        switch($_POST["nombre"]){
                            case "autores":
                                $resultado = $libroModel->obtenerAutores();
                                break;
                            case "editoriales":
                                $resultado = $libroModel->obtenerEditoriales();
                                break;    
                            case "generos":
                                $resultado = $libroModel->obtenerGeneros();
                                break;
                        }
                        $respuesta_data["data"]=$resultado;

                        
                        break;
                    
                    default:
                        break;
            }



        }

        echo json_encode($respuesta_data);
    
    }
    }


