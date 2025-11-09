<?php

require_once '../app/core/BaseDatos.php';


class prestamoBD {
        
    private $db;

    public function __construct() {
        
        $this->db = new BaseDatos();

    }

    public function registrarPrestamo($socio_id, $ejemplar_id, $fecha_prestamo, $fecha_vencimiento) {
        
        $consulta = "INSERT INTO prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) 
                    VALUES (:socio_id, :ejemplar_id, :fecha_prestamo, :fecha_vencimiento )";

       $this->db->consulta($consulta);

        $this->db->unir(':socio_id', $socio_id);
        $this->db->unir(':ejemplar_id', $ejemplar_id);
        $this->db->unir(':fecha_prestamo', $fecha_prestamo);
        $this->db->unir(':fecha_vencimiento', $fecha_vencimiento);

        return $this->db->ejecutar();

    }
    
    public function devolverPrestamo($prestamo_id) {
        $consulta = "UPDATE prestamos 
                    SET fecha_devolucion = NOW() 
                    WHERE id = :prestamo_id AND fecha_devolucion IS NULL";

        $this->db->consulta($consulta);

        $this->db->unir(":prestamo_id", $prestamo_id);
        return $this->db->ejecutar();
        
    }

    public function cantPrestamosActivosPorSocio($socio_id) {
        $consulta = "SELECT COUNT(*) AS total FROM prestamos 
                    WHERE socio_id = :socio_id AND fecha_devolucion IS NULL";

        $this->db->consulta($consulta);

        $this->db->unir(":socio_id", $socio_id);
        return $this->db->resultado();
    }

    public function prestamosPorSocio($socio_id) {
        $consulta = "SELECT p.id,
                            l.titulo,
                            group_concat(distinct ar.nombre separator ', ') as autores,
                            p.ejemplar_id, 
                            DATE(p.fecha_prestamo) as fecha_prestamo,
                            DATE(p.fecha_vencimiento) as fecha_vencimiento,
                            p.fecha_devolucion,
                            CASE
                                WHEN p.fecha_devolucion
                                IS NULL THEN 1 ELSE 0
                            END as activo,
                            p.ejemplar_id as ejemplar_id,
                            e.libro_id as libro_id
                    FROM prestamos p
                    LEFT JOIN ejemplares e ON p.ejemplar_id = e.id
                    LEFT JOIN libros l ON l.id = e.libro_id
                    LEFT JOIN libros_autores la ON la.libro_id = l.id
                    LEFT JOIN autores ar ON la.autor_id = ar.id
                    WHERE p.socio_id = :socio_id
                    GROUP BY p.id
                    ORDER BY p.fecha_prestamo DESC
                    ";

        $this->db->consulta($consulta);

        $this->db->unir(":socio_id", $socio_id);
        return $this->db->resultados();
    }
    public function librosAtrasados($socio_id) {
        $consulta = "SELECT 
                        p.ejemplar_id,
                        CASE WHEN p.fecha_devolucion IS NOT NULL THEN '1' ELSE '0' END as activo,
                        FROM prestamos p
                        WHERE p.socio_id = :socio_id
                        AND p.fecha_vencimiento < NOW()";
        $this->db->consulta($consulta);

        $this->db->unir(":socio_id", $socio_id);
        return $this->db->resultados();
        
    }   
    public function obtenerMultas($socio_id){
         $consulta = "SELECT 
                        p.ejemplar_id,
                        l.titulo,
                        TIMESTAMPDIFF(DAY, p.fecha_vencimiento, NOW()) * db.multa AS total_multa
                        FROM prestamos p
                        JOIN datos_biblioteca db
                        LEFT JOIN ejemplares e ON p.ejemplar_id = e.id
                        LEFT JOIN libros l ON l.id = e.libro_id
                        WHERE p.socio_id = :socio_id
                        AND p.fecha_devolucion IS NOT NULL
                        AND p.fecha_vencimiento < NOW()";

        $this->db->consulta($consulta);

        $this->db->unir(":socio_id", $socio_id);
        return $this->db->resultados();
    }
    
    public function __destruct() {
        $this->con = null;
    }

}