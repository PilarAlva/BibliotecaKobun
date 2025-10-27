<?php

require_once './bd/conexion.php';

class socioBD {
        
    private $con;

    public function __construct() {
        
        $db = new Database();
        $this->con = $db->conectar();

    }

    public function registrarSocio($usuario_id, $telefono, $dni, $fecha_nacimiento ){
        
        $consulta = "INSERT INTO socios (usuario_id, telefono, dni, fecha_nacimiento, fecha_alta) 
                    VALUES (:usuario_id, :telefono, :dni, :fecha_nacimiento, NOW() )";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $sql->bindValue(':telefono', $telefono, PDO::PARAM_STR);
        $sql->bindValue(':dni', $dni, PDO::PARAM_STR);
        $sql->bindValue(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);    
        return $sql->execute();

        }   

    public function obtenerSocioPorId($socio_id) {
        $consulta = "SELECT * FROM socios WHERE socio_id = :socio_id";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }       

    public function actualizarSocio($socio_id, $telefono, $dni, $fecha_nacimiento) {
        $consulta = "UPDATE socios 
                    SET telefono = :telefono, dni = :dni, fecha_nacimiento = :fecha_nacimiento 
                    WHERE socio_id = :socio_id";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);
        $sql->bindValue(':telefono', $telefono, PDO::PARAM_STR);
        $sql->bindValue(':dni', $dni, PDO::PARAM_STR);
        $sql->bindValue(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);    

        return $sql->execute();
    }   

    public function eliminarSocio($socio_id) {
        $consulta = "DELETE FROM socios WHERE socio_id = :socio_id";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);

        return $sql->execute();
    }   

    public function listarSocios() {
        $consulta = "SELECT * FROM socios";

        $sql = $this->con->prepare($consulta);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function antiguedadSocio($socio_id) {
        $consulta = "SELECT DATEDIFF(NOW(), fecha_alta) AS dias_antiguedad 
                    FROM socios 
                    WHERE socio_id = :socio_id";

        $sql = $this->con->prepare($consulta);
        
        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);
        
        return $sql->execute();
    }



    public function __destruct() {
        $this->con = null;
    }

}   