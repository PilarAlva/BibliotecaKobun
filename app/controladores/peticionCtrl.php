

<?php

    include_once("../app/controladores/sesionCtrl.php");
    include_once("../app/controladores/archivoCtrl.php");

    class peticionCtrl extends Controlador{

       public function peticion(){
        
        $sesionCtrl = new SesionCtrl();
        $archivoCtrl = new ArchivoCtrl();

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
                                'multas' => $socioModel->obtenerMultas($_POST['socio_id']) 
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
                    case 'buscar-ejemplares':
                        $ejemplares = $libroModel->ejemplaresDisponiblesPorTitulo($_POST['q'], 1); 

                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Ejemplares obtenidos correctamente.',
                            'data' => [
                                'ejemplares' => $ejemplares
                            ]];
                    
                        break;
                    case 'buscar-socio':
                        $nombre = htmlentities($_POST['q']);
                        $socios = $socioModel->obtenersociosPorNombre($nombre); 

                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Socios obtenidos con exito.',
                            'data' => [
                                'socios' => $socios
                            ]];
                    
                        break;
                    case 'prestar-libro':
                        $socio = $socioModel->obtenerSocioPorIdUsuario($_POST['usuario_id']);
                        $resultado = false;
                        if($socio){
                            $resultado = $prestamosModel->registrarPrestamo($socio["id"], $_POST['ejemplar_id'], $_POST['fecha_limite']);
                        }
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Prestamo registrado con exito.',
                                'data' => [
                                    'prestamo_id' => $resultado
                                ]
                            ];                            
                        }else{
                            $respuesta_data = [
                                'estado' => 'error',
                                'mensaje' => 'No se pudo registrar el prestamo.'
                            ];

                        }
                        
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
                    case 'agregar-ejemplar':
                        $resultado  = $libroModel->agregarEjemplar($_POST['libro_id']);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Ejemplares agregado correctamente.',
                                'data' => [
                                    'ejemplar_id' => $resultado,
                                    'libro_id' => $_POST['libro_id']
                                ]];
                            
                        }else{
                            $respuesta_data = ['estado' => 'error',
                            'mensaje' => 'No se pudo agregar el ejemplar.'];
                        }
                        break;
                    case 'ejemplares-disponibles':
                        $disponibles = $libroModel->ejemplaresDisponibles($_POST['libro_id']); 

                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Ejemplares obtenidos correctamente.',
                            'data' => [
                                'disponibles' => $disponibles
                            ]];
                    
                        break;
                    case 'estado-libro':
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Cambio de estado libro',
                            'data' =>[
                                "estado" => $libroModel->cambiarEstado($_POST['libro_id'], $_POST['activado']),
                                "activado" =>  $_POST['activado']
                            ]
                        ];
                        break;
                    case 'agregar-autor':
                        $nombre = $_POST['nombre'];
                        $apellido = $_POST['apellido'];
                        $fecha_nacimiento = $_POST['fecha_nacimiento'];
                        $fecha_muerte = $_POST['fecha_muerte'];
                        $resultado  = $libroModel->agregarAutor($nombre, $apellido, $fecha_nacimiento, $fecha_muerte);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Autor agregado correctamente'
                            ];
                        }
                        break;
                    case 'agregar-editorial':
                        $nombre = $_POST['nombre'];
                        $resultado  = $libroModel->agregarEditorial($nombre);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Editorial agregada correctamente'
                            ];
                        }
                        break;
                    case 'agregar-genero':
                        $nombre = $_POST['nombre'];
                        $resultado  = $libroModel->agregarGenero($nombre);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Genero agregado correctamente'
                            ];
                        }
                        break;
                    case 'registrar-libro':

                        $isbn = htmlspecialchars($_POST['isbn']);
                        $titulo = htmlspecialchars($_POST['titulo']);

                        $autores = htmlspecialchars($_POST['autores_ids']);
                        $autores = explode(',', $autores);

                        $editoriales = htmlspecialchars($_POST['editorial_id']);
                        $editoriales = [$editoriales];

                        $generos = htmlspecialchars($_POST['generos_ids']);
                        $generos = explode(',', $generos);

                        $descripcion = htmlspecialchars($_POST['descripcion']);
                        
                        $sinopsis = htmlspecialchars($_POST['sinopsis']);
                        
                        $ref_portada = $archivoCtrl->guardarPortada($titulo, $_FILES['portada']);

                        $libro_id = $libroModel->agregarLibro($isbn, $titulo, $sinopsis, $ref_portada, $descripcion, $autores, $generos, $editoriales, 0);

                        if($libro_id){
                            $respuesta_data = [
                                "estado" => "exito",
                                "mensaje" => "Libro registrado correctamente",
                                "data" => [
                                    "libro_id" => $libro_id
                                ]
                            ];

                        }else{

                            $respuesta_data = [
                                "estado" => "error",
                                "mensaje" => "No se pudo guardar el libro"
                            ];

                        }
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
                        try{
                            $resultado =  $usuarioModel->borrarUsuario($_POST['usuario_id']);
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
                            
                        }catch(Exception $e){
                             $respuesta_data = [
                                'estado' => 'error',
                                'mensaje' => 'El usuario seguro tiene alguna clave.'
                            ];
                        }
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
                     case 'taller':
                                $taller = $talleresModel->obtenerTallerPorId($_POST['taller_id']);
                                $profesores = $talleresModel->obtenerProfesores($_POST['taller_id']);
                                if($taller){
                                    $respuesta_data = [
                                        'estado' => 'exito',
                                        'mensaje'=> "Taller obtenido",
                                        'data' => [
                                            'taller' => $taller,
                                            'profesores' => $profesores
                                        ]
                                    ];
                                }else{
                                    $respuesta_data = [
                                    'estado' => 'error',
                                    'mensaje'=> "no se pudo devolver"
                                ];
                                }
                                break;
                    case 'agregar-taller':

                        $nombre = htmlspecialchars($_POST['nombre']);
                        $descripcion = htmlspecialchars($_POST['descripcion']);
                        $ref_portada = $archivoCtrl->guardarPortada($nombre, $_FILES['portada']);
                        $horario = htmlspecialchars($_POST['horario']);
                        $lugar = htmlspecialchars($_POST['lugar']);

                        $resultado  = $talleresModel->agregarTaller($nombre, $descripcion, $ref_portada, $horario, $lugar, $activo = 0);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Taller agregado correctamente.'
                            ];
                            
                        }else{
                            $respuesta_data = ['estado' => 'error',
                            'mensaje' => 'No se pudo agregar el taller.'];
                        }
                        break;
                    case 'estado-taller':
                        $estado = $_POST["estado"];
                        $taller_id = $_POST["taller_id"];
                        $resultado  = $talleresModel->cambiarEstadoTaller($taller_id, $estado);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Cambiado estado del taller correctamente.'];
                        }else{
                            $respuesta_data = ['estado' => 'error',
                            'mensaje' => 'No se pudo cambiar el taller.'];
                        }
                        break;
                    case 'asignar-profesor':
                        $taller_id = $_POST["taller_id"];
                        $profesores_id = $_POST["profesor_ids"];

                        $profesores_id = explode(",", $profesores_id);
                        foreach($profesores_id as $key => $value){
                            $resultado  = $talleresModel->agregarProfesor($taller_id, $value);
                            if(!$resultado){
                                $respuesta_data = ['estado' => 'error',
                                'mensaje' => 'No se pudo agregar el profesor.'];
                            }
                        }
                        $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Profesor agregado con éxito.'];
                        
                        break;
                    case 'eliminar-profesor':
                        $taller_id = $_POST["taller_id"];
                        $usuario_id = $_POST["usuario_id"];
                        $resultado  = $talleresModel->eliminarProfesor($taller_id, $usuario_id);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => 'Profesor eliminado con éxito.'];
                        }else{
                            $respuesta_data = ['estado' => 'error',
                            'mensaje' => 'No se pudo eliminar el profesor.'];
                        }
                        break;
                    case 'otros-profesores':
                        $taller_id = $_POST["taller_id"];
                        $resultado  = $talleresModel->otrosProfesores($taller_id);
                        
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje'=> "Profesores obtenidos",
                                'data' => [
                                    'profesores' => $resultado
                                ]];
                        
                        break;
                    case 'obtener-socio-id':
                        
                        $resultado  = isset($_SESSION["usuario_id"]) ? $_SESSION["usuario_id"] : false;
                        if($resultado){
                            $resultado = $socioModel->obtenerSocioPorIdUsuario($resultado);
                            if($resultado)
                                $resultado = $resultado["id"];
                        }
                    
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje'=> "Socio obtenido",
                            'data' => [
                                'id' => $resultado
                            ]];
                        
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
                                        'resultados' => $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, 20, true )
                                    ]
                                ];
                                break;
                             case 'usuarios':
                                $respuesta_data = [
                                    'estado' => 'exito',
                                    'mensaje'=> "Usuarios devueltos",
                                    'data' => [
                                        'cantidad' => $usuarioModel->cantResultadosBusqueda($busqueda, $filtro),
                                        'resultados' => $usuarioModel->busquedaUsuarios($busqueda, $filtro, $offset, 20 )
                                    ]
                                ];
                                break;  
                            case 'talleres':
                                $respuesta_data = [
                                    'estado' => 'exito',
                                    'mensaje'=> "Talleres devueltos",
                                    'data' => [
                                        'cantidad' => 100,
                                        'resultados' => $talleresModel->busquedaTaller($busqueda)
                                    ]
                                ];
                                break;
                            case 'multas':
                                $socio_id = htmlspecialchars($_POST['socio_id']);
                                $respuesta_data = [
                                    'estado' => 'exito',
                                    'mensaje'=> "Multas devueltas",
                                    'data' => [
                                        'cantidad' => 100,
                                        'resultados' => $socioModel->obtenerMultas($socio_id, 1)
                                    ]
                                ];
                                break;
                             case 'pagos':
                                $respuesta_data = [
                                    'estado' => 'exito',
                                    'mensaje'=> "Pagos devueltas",
                                    'data' => [
                                        'cantidad' => 100,
                                        'resultados' => $pagoModel->obtenerpagos($filtro)
                                    ]
                                ];
                                break;
                            default:
                                break;
                        }

                        break;
                    case 'registrar-pago':
                        $resultado = $pagoModel->registrarPago($_POST['socio_id'], $_POST['monto'], $_POST['razon'], $_POST['medio_id']);
                        if($resultado){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje'=> "Pago registrado",
                            ];
                        }else{
                            $respuesta_data = [
                                'estado' => 'error',
                                'mensaje'=> "No se pudo registrar el pago", 
                            ];
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


