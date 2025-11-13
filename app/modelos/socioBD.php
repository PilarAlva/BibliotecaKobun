<?php

require_once '../app/core/BaseDatos.php';

class socioBD {

    private $db;

    public function __construct() {

        $this->db = new BaseDatos();

    }

    public function registrarSocio($usuario_id, $telefono, $dni, $fecha_nacimiento ){
        
        $consulta = "INSERT INTO socios (usuario_id, telefono, dni, fecha_nacimiento, fecha_alta) 
                    VALUES (:usuario_id, :telefono, :dni, :fecha_nacimiento, NOW() )";


        $this->db->consulta($consulta);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':telefono', $telefono);
        $this->db->unir(':dni', $dni);
        $this->db->unir(':fecha_nacimiento', $fecha_nacimiento);    

        return $this->db->ejecutar();

        }   

    public function obtenerSocioPorId($socio_id) {

        $consulta = "SELECT * FROM socios WHERE id = :socio_id";

        $this->db->consulta($consulta);
        $this->db->unir(':socio_id', $socio_id);
        $this->db->ejecutar();

        return $this->db->resultado();
    }   

    public function obtenerSocioPorIdUsuario($usuario_id) {

        $consulta = "SELECT 
                    s.id,
                    s.usuario_id,
                    s.telefono,
                    s.dni,
                    s.fecha_alta,
                    s.fecha_nacimiento,
                    s.activo
                    FROM socios s
                    LEFT JOIN usuarios u ON s.usuario_id = u.id
                    WHERE u.id = :usuario_id";

        $this->db->consulta($consulta);
        $this->db->unir(':usuario_id', $usuario_id);
        

        return $this->db->resultado();
    }   

    public function obtenerSocioPorMail($mail) {

        $consulta ="SELECT 
                    s.id,
                    s.usuario_id,
                    s.telefono,
                    s.dni,
                    s.fecha_alta,
                    s.fecha_nacimiento,
                    s.activo    
                    FROM socios s
                    LEFT JOIN usuarios u ON s.usuario_id = u.id
                    WHERE u.mail = :mail";

        $this->db->consulta($consulta);
        $this->db->unir(':mail', $mail);

        return $this->db->resultado();
    }           

    public function actualizarSocio($socio_id, $telefono, $dni, $fecha_nacimiento) {
        $consulta = "UPDATE socios 
                    SET telefono = :telefono, dni = :dni, fecha_nacimiento = :fecha_nacimiento 
                    WHERE socio_id = :socio_id";

        $this->db->consulta($consulta);
        
        $this->db->unir(':socio_id', $socio_id);
        $this->db->unir(':telefono', $telefono);
        $this->db->unir(':dni', $dni);
        $this->db->unir(':fecha_nacimiento', $fecha_nacimiento);    

        return $this->db->ejecutar();
    }   

    public function eliminarSocio($socio_id) {
        $consulta = "DELETE FROM socios WHERE socio_id = :socio_id";

        $this->db->consulta($consulta);
        $this->db->unir(':socio_id', $socio_id);

        return $this->db->ejecutar();
    }   

    public function listarSocios() {
        $consulta = "SELECT * FROM socios";

        $this->db->consulta($consulta);
        $this->db->ejecutar();

        return $this->db->resultados();
    }   
    public function esSocioHabilitado($socio_id) {
        $consulta = "SELECT activo FROM socios WHERE id = :socio_id";       
            $this->db->consulta($consulta);
            $this->db->unir(':socio_id', $socio_id);

            return $this->db->resultado();
    }
    public function antiguedadSocio($socio_id) {
        $consulta = "SELECT DATEDIFF(NOW(), fecha_alta) AS dias_antiguedad 
                    FROM socios 
                    WHERE id = :socio_id";

        $this->db->consulta($consulta);
        $this->db->unir(':socio_id', $socio_id);

        $this->db->ejecutar();

        return $this->db->resultado();
    }


    public function obtenerUltimoPagoCuota($socio_id) {
        $consulta = "SELECT MAX(fecha) as ultimo_pago FROM pagos WHERE socio_id = :socio_id";
        $this->db->consulta($consulta);
        
        $this->db->unir(':socio_id', $socio_id);
        $this->db->ejecutar();
        
        return $this->db->resultado();
    }
    
    public function obtenerMultasActivas($socio_id) {
        $consulta = "SELECT * FROM multas 
                    WHERE socio_id = :socio_id 
                    AND fecha_pago IS NULL
                    ORDER BY fecha_alta DESC";
        $this->db->consulta($consulta);
        
        $this->db->unir(':socio_id', $socio_id);
        return $this->db->resultados();
        
    }
    public function obtenerMultasPagadas($socio_id) {
        $consulta = "SELECT * FROM multas 
                    WHERE socio_id = :socio_id 
                    AND fecha_pago != NULL
                    ORDER BY fecha_pago DESC";
        $this->db->consulta($consulta);
        
        $this->db->unir(':socio_id', $socio_id);
        return $this->db->resultados();
        
    }
    public function obtenerMultas($socio_id, $activas = 1) {
       if($activas){
       $consulta = "SELECT * FROM multas 
                    WHERE socio_id = :socio_id 
                    AND fecha_pago IS NULL
                    ORDER BY fecha_alta DESC";
       }else{
        $consulta = "SELECT * FROM multas 
                        WHERE socio_id = :socio_id 
                        AND fecha_pago != NULL
                        ORDER BY fecha_pago DESC";
       }
        
        $this->db->consulta($consulta);
        
        $this->db->unir(':socio_id', $socio_id);
        return $this->db->resultados();

    }
    public function obtenerCantMultasActivas($socio_id) {
        $consulta = "SELECT 
                            COUNT(id) as cantidad,
                            SUM(monto) as monto_total
                        FROM multas 
                        WHERE socio_id = :socio_id 
                        AND fecha_pago IS NULL
                        GROUP BY socio_id";

        $this->db->consulta($consulta);
        $this->db->unir(':socio_id', $socio_id);
        return $this->db->resultado();
    }   
    public function __destruct() {
        $this->con = null;
    }
}   
?>
