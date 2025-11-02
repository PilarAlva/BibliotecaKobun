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


    public function archivo(){

        $archivoDB = $this->cargarModelo('archivoBD');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $carpetaDestino = '../almacenamiento/subidos/';
            $archivoDestino = $carpetaDestino . date('YmdHis') . '_' . $_POST['titulo'];

            $tipoImagen = strtolower(pathinfo($_FILES['image_uploads']["name"], PATHINFO_EXTENSION));
            
            if(move_uploaded_file($_FILES['image_uploads']["tmp_name"], $archivoDestino . '.' . $tipoImagen)){                

                if($archivoDB->registrarArchivo($archivoDestino . '.' . $tipoImagen, $_POST['titulo'])){    

                        http_response_code(201);
                        echo "Archivo " . htmlspecialchars( basename( $_POST['titulo'])) . " guardado.";

                }else{
                        http_response_code(500);
                        echo "Error al guardar en la base de datos.";
                        unlink($archivoDestino);
                }

    

            }else{
                http_response_code(500);
                echo "No se pudo guardar";
            }

        }

        //header('Location: ' . BASE_URL . 'archivo');
       // exit();

        //$this->mostrarVista('archivo', [], 'Archivo');

    }


    public function idArchivo($id){
    
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
                exit;
            }
            


        }


    }

}


?>