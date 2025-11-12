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

}