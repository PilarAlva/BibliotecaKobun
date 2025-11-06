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


}