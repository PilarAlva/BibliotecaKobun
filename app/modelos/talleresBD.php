<?php

require_once '../app/bd/conexion.php';


class talleresBD {
        
    private $con;

    public function __construct() {
        
        $db = new Database();
        $this->con = $db->conectar();

    }

    /* Agregar las Consultas que faltaannn */

    /* public function registrarPrestamo($socio_id, $ejemplar_id, $fecha_prestamo, $fecha_vencimiento) {
        $consulta = "INSERT INTO prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) 
                    VALUES (:socio_id, :ejemplar_id, :fecha_prestamo, :fecha_vencimiento )";

        $sql = $this->con->prepare($consulta);

        $sql->bindValue(':socio_id', $socio_id, PDO::PARAM_INT);
        $sql->bindValue(':ejemplar_id', $ejemplar_id, PDO::PARAM_INT);
        $sql->bindValue(':fecha_prestamo', $fecha_prestamo, PDO::PARAM_STR);
        $sql->bindValue(':fecha_vencimiento', $fecha_vencimiento, PDO::PARAM_STR);

        return $sql->execute();
    } */

    /* Seguirr por acaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa */
    public function talleresPorUsuario($usuario_id) {
        $consulta = "SELECT p.id, l.id as libro_id, p.ejemplar_id, p.fecha_prestamo, p.fecha_vencimiento, p.fecha_devolucion, l.titulo, CONCAT(a.nombre, ' ', a.apellido) AS nombre_completo, l.ref_portada AS portada
                        FROM prestamos p 
                            JOIN ejemplares e ON p.ejemplar_id = e.id
                            JOIN libros l ON e.libro_id = l.id
                            JOIN libros_autores la ON la.libro_id = l.id
                            JOIN autores a ON la.autor_id = a.id
                                WHERE p.socio_id = :socio_id
                                ORDER BY p.fecha_prestamo DESC;";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(': ... ', $usuario_id, PDO::PARAM_INT);
        
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


}

?>