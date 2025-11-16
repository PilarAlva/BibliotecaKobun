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
                s.id AS socio_id,
                date(s.fecha_alta) as fecha_alta,
                s.usuario_id,
                s.activo,
                db.cuota_socio,

                -- Último pago de cuota
                MAX(date(p.fecha)) AS ultimo_pago,

                -- Fecha de referencia: si no hay pago, usamos la fecha de alta
                COALESCE(MAX(p.fecha), s.fecha_alta) AS fecha_referencia,

                -- Fecha de referencia + 1 mes (primer día del siguiente mes)
                DATE_ADD(
                    DATE_FORMAT(COALESCE(MAX(p.fecha), s.fecha_alta), '%Y-%m-01'),
                    INTERVAL 1 MONTH
                ) AS fecha_siguiente_cuota,

                -- Diferencia en meses entre hoy y la fecha de referencia
                CASE 
                    WHEN CURDATE() >= DATE_ADD(
                        DATE_FORMAT(COALESCE(MAX(p.fecha), s.fecha_alta), '%Y-%m-01'),
                        INTERVAL 1 MONTH
                    )
                    THEN TIMESTAMPDIFF(
                        MONTH,
                        DATE_ADD(DATE_FORMAT(COALESCE(MAX(p.fecha), s.fecha_alta), '%Y-%m-01'), INTERVAL 1 MONTH),
                        CURDATE()
                    ) + 1
                    ELSE 0
                END AS meses_adeudados,

                -- Monto total de deuda
                CASE 
                    WHEN CURDATE() >= DATE_ADD(
                        DATE_FORMAT(COALESCE(MAX(p.fecha), s.fecha_alta), '%Y-%m-01'),
                        INTERVAL 1 MONTH
                    )
                    THEN (TIMESTAMPDIFF(
                            MONTH,
                            DATE_ADD(DATE_FORMAT(COALESCE(MAX(p.fecha), s.fecha_alta), '%Y-%m-01'), INTERVAL 1 MONTH),
                            CURDATE()
                        ) + 1
                        ) * db.cuota_socio
                    ELSE 0
                END AS monto_adeudado,

                -- Cuota al día (true/false)
                CASE 
                    WHEN DATE_FORMAT(COALESCE(MAX(p.fecha), s.fecha_alta), '%Y-%m')
                        = DATE_FORMAT(CURDATE(), '%Y-%m')
                    THEN TRUE
                    ELSE FALSE
                END AS cuota_al_dia

            FROM socios s
            LEFT JOIN pagos p ON p.socio_id = s.id
            CROSS JOIN datos_biblioteca db
            WHERE s.id = :socio_id
            GROUP BY s.id
            ";

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