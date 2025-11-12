<?php

require_once '../app/core/BaseDatos.php';

class TransaccionBD {

    private $db;

    public function __construct() {

        $this->db = new BaseDatos();

    }

    // public function empezar(){

    //     return $this->db->emepzarTransaccion();

    // }
    
    // public function aceptar(){
    //     return $this->db->aceptarTransaccion();
    // }
    // public function cerrar(){
    //     return $this->db->eliminarTransaccion();
    // }

    // public function __destruct(){
    //     $this->db->eliminarTransaccion();
    //     $this->db->cerrarConexion();
    // }


}