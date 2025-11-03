<?php

require_once '../app/core/BaseDatos.php';

class ArchivoBD {

    private $db;
    private $ultimo_id;

    public function __construct() {

        $this->db = new BaseDatos();
        $this->ultimo_id = -1;

    }

    public function obtenerArchivos(){
        
        $consulta = "SELECT * FROM archivos";

        $this->db->consulta($consulta);
        $this->db->ejecutar();

        return $this->db->resultados();

    }

    public function obtenerArchivoPorId($id){
        
        $consulta = "SELECT * FROM archivos WHERE id = :id LIMIT 1";

        $this->db->consulta($consulta);
        $this->db->unir(':id', $id);
        return $this->db->resultado();

    }

    public function registrarArchivo($referencia, $titulo ){
        
        $consulta = "INSERT INTO archivos (titulo, referencia ) 
                    VALUES (:titulo, :referencia )";  
                    
        $this->db->consulta($consulta);
        $this->db->unir(':titulo', $titulo);    
        $this->db->unir(':referencia', $referencia);
        
        
        $this->ultimo_id = $this->obtenerUltimoId();

        return $this->db->ejecutar();   
        

    }
    private function obtenerUltimoId(){
        $consulta = "SELECT LAST_INSERT_ID() AS ultimo_id";  
                    
        $this->db->consulta($consulta);

        return $this->db->resultado();   

    }
    
    public function ultimoId(){
            return $this->ultimo_id;
    }
    
    public function __destruct() {
        $this->db->cerrarConexion();
    }

}   