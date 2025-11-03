<?php

require_once '../app/bd/conexion.php';


class prestamoBD {
        
    private $con;

    public function __construct() {
        
        $db = new Database();
        $this->con = $db->conectar();

    }

    public function registrarPrestamo($socio_id, $ejemplar_id, $fecha_prestamo, $fecha_vencimiento) {
        
        $consulta = "INSERT INTO prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) 
                    VALUES (:socio_id, :ejemplar_id, :fecha_prestamo, :fecha_vencimiento )";

        $sql = $this->con->prepare($consulta);

        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);
        $sql->bindValue(':ejemplar_id', $ejemplar_id, PDO::PARAM_INT);
        $sql->bindValue(':fecha_prestamo', $fecha_prestamo, PDO::PARAM_STR);
        $sql->bindValue(':fecha_vencimiento', $fecha_vencimiento, PDO::PARAM_STR);

        return $sql->execute();

    }
    
    public function devolverPrestamo($prestamo_id) {
        $consulta = "UPDATE prestamos 
                    SET fecha_devolucion = NOW() 
                    WHERE id = :prestamo_id AND fecha_devolucion IS NULL";

        $sql = $this->con->prepare($consulta);

        $sql->bindValue(':prestamo_id', $prestamo_id, PDO::PARAM_INT);

        return $sql->execute();
    }

    public function cantPrestamosActivosPorSocio($socio_id) {
        $consulta = "SELECT COUNT(*) AS total FROM prestamos 
                    WHERE socio_id = :socio_id AND fecha_devolucion IS NULL";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);
        
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);;
    }

    public function prestamosPorSocio($socio_id) {
        $consulta = "SELECT p.id, p.ejemplar_id, 
                            p.fecha_prestamo, p.fecha_vencimiento,
                            p.fecha_devolucion, e.titulo, e.autores
                    FROM prestamos p
                    JOIN ejemplares e ON p.ejemplar_id = e.id
                    WHERE p.socio_id = :socio_id
                    ORDER BY p.fecha_prestamo DESC";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);
        
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function __destruct() {
        $this->con = null;
    }

}