<?php

require_once '../app/core/BaseDatos.php';

class UsuarioBD {
    
    private $db;

    public function __construct() {
        
        $this->db = new BaseDatos();

    }

    public function obtenerUsuarioPorMail($mail){

        $consulta = "SELECT * FROM  usuarios WHERE mail = :mail";

        $this->db->consulta($consulta);
        $this->db->unir("mail", $mail);
        $this->db->ejecutar();

        return $this->db->resultado();

    }
    public function obtenerUsuarioPorId($usuario_id){

        $consulta = "SELECT * FROM  usuarios WHERE id = :usuario_id";

        $this->db->consulta($consulta);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }

    public function registrarUsuario($nombre, $apellido, $mail, $clave){

        $consulta = "INSERT INTO usuarios (nombre, apellido, mail, password) VALUES (:nombre, :apellido, :mail, :clave)";

        $this->db->consulta($consulta);

        $this->db->unir("nombre", $nombre);
        $this->db->unir("apellido", $apellido);
        $this->db->unir("mail", $mail);
        $this->db->unir("clave", $clave);

        $this->db->ejecutar();

        return $this->db->resultado();

    }

}
?>