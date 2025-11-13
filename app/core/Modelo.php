<?php 

require_once '../app/core/BaseDatos.php';

class Modelo{

    protected $db;

    public function __construct() {
        
        $this->db = new BaseDatos();

    }    
    

    public function obtenerUltimoId(){
        $consulta = "SELECT LAST_INSERT_ID() AS ultimo_id";  
        
        $this->db->consulta($consulta);
        
        return $this->db->resultado();   
        
    }

    public function ultimo_id(){
            return $this->obtenerUltimoId();
    }
    
    public function __destruct() {
        $this->db->cerrarConexion();
    }

}






?>