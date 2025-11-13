<?php

require_once '../app/core/BaseDatos.php';

class PagoDB {

    private $db;

    public function __construct() {

        $this->db = new BaseDatos();

    }


    public function deudasPagos($socio_id) {
        $consulta = "SELECT 
                    DATEDIFF(CURRENT_DATE,
                    (SELECT MAX(fecha) FROM PAGOS
		            WHERE socio_id = :socio_id)) as dias_atraso";

        $this->db->consulta($consulta);
        $this->db->unir(':socio_id', $socio_id);

        return $this->db->resultado();
    }
    public function obtenerUltimoPagoCuota($socio_id){
        $consulta = "SELECT MAX(fecha) as ultimo_pago 
        FROM pagos WHERE socio_id = :socio_id";

        $this->db->consulta($consulta);
        $this->db->unir(':socio_id', $socio_id);
        return $this->db->resultado();

    }
    public function obtenerpagos($filtro){

        switch($filtro){
            case 'todos':
                $consulta = 'SELECT 
                                pagos.id as pago_id,
                                socio_id,
                                monto,
                                razon,
                                medio,
                                fecha,
                                concat(u.nombre, " ", u.apellido) as usuario_nombre
                            FROM pagos
                            LEFT JOIN socios ON pagos.socio_id = socios.id
                            LEFT JOIN usuarios u ON socios.usuario_id = u.id
                            ORDER BY pagos.fecha DESC';
                 break;
             case 'efectivo':
                $consulta = 'SELECT 
                                pagos.id as pago_id,
                                socio_id,
                                monto,
                                razon,
                                medio,
                                fecha,
                                concat(u.nombre, " ", u.apellido) as usuario_nombre
                            FROM pagos
                            LEFT JOIN socios ON pagos.socio_id = socios.id
                            LEFT JOIN usuarios u ON socios.usuario_id = u.id
                            WHERE medio = "efectivo"
                            ORDER BY pagos.fecha DESC';
                 break;
             case 'transferencia':
                $consulta = 'SELECT 
                                pagos.id as pago_id,
                                socio_id,
                                monto,
                                razon,
                                medio,
                                fecha,
                                concat(u.nombre, " ", u.apellido) as usuario_nombre
                            FROM pagos
                            LEFT JOIN socios ON pagos.socio_id = socios.id
                            LEFT JOIN usuarios u ON socios.usuario_id = u.id
                            WHERE medio = "transferencia"
                            ORDER BY pagos.fecha DESC';
                 break;
                
            default:
                break;
        }
        $this->db->consulta($consulta);
        return $this->db->resultados();

    }
    public function estadoCuenta($socio_id){
        $consulta = "SELECT 
                        s.id as socio_id,
                        u.id as usuario_id,
                        DATE(MAX(p.fecha)) as ultimo_pago,
                        TIMESTAMPDIFF(MONTH, MAX(p.fecha), CURDATE()) AS meses_vencido,
                        ((TIMESTAMPDIFF(MONTH, MAX(p.fecha), CURDATE()) + 1) * db.cuota_socio) AS total_deuda,
                        DATEDIFF(
                            CASE 
                            WHEN DAY(CURDATE()) <= 15 
                                THEN DATE_FORMAT(CURDATE(), '%Y-%m-15')
                            ELSE DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-15')
                            END,
                            CURDATE()
                        ) as proxima_cuota
                        FROM pagos p
                        JOIN datos_biblioteca db
                        LEFT JOIN socios s on s.id = p.socio_id
                        LEFT JOIN usuarios u on s.usuario_id = u.id
                        WHERE s.id = :socio_id
                        GROUP BY s.id";

        $this->db->consulta($consulta); 
        $this->db->unir(":socio_id", $socio_id);

        return $this->db->resultado();
    }

    public function registrarPago($socio_id, $monto, $razon, $medio){
        $consulta = "INSERT INTO pagos (socio_id, monto, razon, medio, fecha) 
                    VALUES (:socio_id, :monto, :razon, :medio, NOW())";

        $this->db->consulta($consulta);
        $this->db->unir(":socio_id", $socio_id);
        $this->db->unir(":monto", $monto);
        $this->db->unir(":razon", $razon);
        $this->db->unir(":medio", $medio);

        return $this->db->ejecutar();

    }

}