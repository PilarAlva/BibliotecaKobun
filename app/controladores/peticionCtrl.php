

<?php

    include_once("../app/controladores/sesionCtrl.php");

    class peticionCtrl extends Controlador{

       public function peticion(){
        
        $sesionCtrl = new SesionCtrl();

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $usuarioModel = $this->cargarModelo("usuarioBD");
        $transaccionModel = $this->cargarModelo("transaccionBD");
        $prestamosModel = $this->cargarModelo("prestamoBD");
        $pagoModel = $this->cargarModelo("pagoDB");
        $socioModel = $this->cargarModelo("socioBD");
        $talleresModel = $this->cargarModelo("tallerBD");

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
                        
                        //$cuerpo = $usuarioModel->obtenerTodosUsuarios();
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Usuarios obtenidos correctamente.',
                            'data' => [
                                'usuarios' => $usuarioModel->obtenerTodosUsuarios()                            ]
                        ];

                    break;
                    case 'insertar-usuario':
                        http_response_code(200);
                        $estado = $sesionCtrl->registrarUsuario($_POST['nombre'], $_POST['apellido'], $_POST['mail'], $_POST['clave']);
                        if($estado["estado"] == "exito"){
                            $respuesta_data = [
                                'estado' => 'exito',
                                'mensaje' => $estado["mensaje"],
                            ];
                        }else{
                            $respuesta_data = [
                                'estado' => 'error',
                                'mensaje' => $estado["mensaje"],
                            ];
                        }
                    break;   
                    case 'usuario':
                        
                        //$cuerpo = $usuarioModel->obtenerTodosUsuarios();
                        $usuario = $usuarioModel->obtenerInfoCompletaUsuarioPorId($_POST['usuario_id']);
                        $prestamos = [];
                        $estado_cuenta = []; 
                        $multas = [];
                        $socio_habilitado = false;
                        
                        if(isset($usuario["socio_id"])){
                            $prestamos = $prestamosModel->prestamosPorSocio($usuario["socio_id"]);
                            $estado_cuenta = $pagoModel->estadoCuenta($usuario["socio_id"]);
                            $multas = $prestamosModel->obtenerMultas($usuario["socio_id"]);
                            $socio_habilitado = $socioModel->esSocioHabilitado($usuario["socio_id"]);
                        }

                        $respuesta_data = [
                            'estado' => 'extio',
                            'mensaje' => 'Usuario obtenido correctamente.',
                            'data' => [
                                'usuario' => $usuario,
                                'socio_habilitado' => $socio_habilitado,
                                'prestamos' => $prestamos,
                                'estado_cuenta' => $estado_cuenta,
                                'multas' => $multas
                            ]];

                    break;
                    case 'agregar-socio':
                        $respuesta_data = [
                            'estado' => 'error',
                            'mensaje' => 'No se pudo ingresar el socio'
                        ];
                        break;
                    case 'devolver-prestamo':
                        
                        $respuesta_data = [
                            'estado' => 'exito',
                            'mensaje' => 'Devuelto '
                        ];
                        foreach ($_POST as $key => $value) {
                            if($key == 'prestamo_id') {
                            if($prestamosModel->devolverPrestamo($_POST['prestamo_id'])){
                                $respuesta_data['mensaje'] .=''. $key .''. $value .'';
                            }else{
                                $respuesta_data = [
                                    'estado' => 'error',
                                    'mensaje'=> "no se pudo devolver"
                                ];
                            }
                        }   
                    }

                        
                    break;
                    case 'profesores':
                              
                       

                    break;
                    
                    default:
                    break;
            }



        }

        echo json_encode($respuesta_data);
    
    }
    }


