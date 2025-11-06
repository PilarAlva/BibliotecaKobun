<?php

require_once '../app/core/BaseDatos.php';

class BibliotecaBD {

    private $db;

    public function __construct() {

        $this->db = new BaseDatos();

    }
    public function obtenerDatos(){
        $consulta = "SELECT * FROM datos_biblioteca";
        $this->db->consulta($consulta);

        return $this->db->resultado();
    }
    public function __destruct() {
        $this->db->cerrarConexion();
    }  

}
