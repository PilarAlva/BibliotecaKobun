<?php


class ArchivoCtrl extends Controlador{

    
    
    public function inicio(){
        
        $this->mostrarVista('archivo', [], 'Archivo');

    }
    public function lista(){

        $archivoDB = $this->cargarModelo('archivoBD');

        $archivos = $archivoDB->obtenerArchivos();

        $this->mostrarVista('listaArchivos', ['archivos' => $archivos, 'resultados' => count($archivos)], 'Lista de Archivos');

    }


    public function subir(){

        //TODO: Se debería hacer la comprobación de si en la sesion hay un usuario registrado.
        //En este momento cualquiera que haga un post a este enlace puede guardar un archivo.

        //Esto es para el error de cross origin
        header("Access-Control-Allow-Origin: * ");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $archivoDB = $this->cargarModelo('archivoBD');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){


            $carpetaDestino = '../almacenamiento/subidos/';
            $archivoDestino = $carpetaDestino . date('YmdHis') . '_' . $_POST['titulo'];

            $tipoImagen = strtolower(pathinfo($_FILES['image_uploads']["name"], PATHINFO_EXTENSION));
            
            if(move_uploaded_file($_FILES['image_uploads']["tmp_name"], $archivoDestino . '.' . $tipoImagen)){                

                $resultado = $archivoDB->registrarArchivo($archivoDestino . '.' . $tipoImagen, $_POST['titulo']);

                if($resultado){    

                        http_response_code(201);
                        $respuesta_data = [
                                'status' => 'success',
                                'message' => 'Archivo guardado exitosamente.',
                                'data' => [
                                    'id' => $archivoDB->ultimo_id(),
                                    'estatus' => $resultado
                                ]
                            ];

                }else{
                        http_response_code(500);
                        unlink($archivoDestino);

                        $respuesta_data = [
                                'status' => 'error',
                                'message' => 'No se pudo registrar el archivo.'
                            ];

                }

    

            }else{
                http_response_code(500);
                 $respuesta_data = [
                                'status' => 'error',
                                'message' => 'No se pudo guardar el archivo.'
                            ];
                
            }

        }

        echo json_encode($respuesta_data);
        

    }

    public function guardarPortada($nombre, $portada){

        $archivoDB = $this->cargarModelo('archivoBD');

        $nombre = strtolower(htmlspecialchars($nombre));

        $carpetaDestino = '../almacenamiento/portadas/';
        $archivoDestino = $carpetaDestino . date('YmdHis') . '_' . $nombre;

        $tipoImagen = strtolower(pathinfo($portada["name"], PATHINFO_EXTENSION));
        
        if(move_uploaded_file($portada["tmp_name"], $archivoDestino . '.' . $tipoImagen)){                

            $resultado = $archivoDB->registrarArchivo($archivoDestino . '.' . $tipoImagen, $nombre);

            if($resultado){
                return $resultado;
            }
            
            unlink($archivoDestino);

        }
        return null;

    }
  

    public function descargar($id){
    
        $archivoDB = $this->cargarModelo('archivoBD');

        $archivo = $archivoDB->obtenerArchivoPorId($id);

        if($archivo){

            if (file_exists($archivo['referencia'])) {
                
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($archivo['referencia']).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($archivo['referencia']));


                
                    readfile($archivo['referencia']);
                
            }
            


        }else{
            readfile('../almacenamiento/no.png');
        }


    }

}


?>