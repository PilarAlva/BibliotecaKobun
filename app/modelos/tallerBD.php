<?php

require_once '../app/core/BaseDatos.php';

class TallerBD {
    
    private $db;

    public function __construct() {
        
        $this->db = new BaseDatos();

    }

    public function agregarTaller($nombre, $descripcion, $ref_portada, $horario, $lugar, $activo = 1, $cupo = 0){   
        $consulta = "INSERT INTO talleres
                    (nombre, ref_portada, lugar,
                     horario, descripcion, activo) 
                    VALUES 
                    (:nombre, :descripcion, :ref_portada, :horario,:lugar, :activo, :cupo";

        $this->db->consulta($consulta);
        $this->db->unir(':nombre', $nombre);
        $this->db->unir(':descripcion', $descripcion);
        $this->db->unir(':ref_portada', $ref_portada);
        $this->db->unir(':horario', $horario);
        $this->db->unir(':lugar', $lugar);
        $this->db->unir(':activo', $activo);
        $this->db->unir(':cupo', $cupo);                

        return $this->db->ejecutar();     

    }   
    public function agregarProfesor($taller_id, $usuario_id){

        $consulta = "INSERT INTO talleres_profesores (taller_id, usuario_id) 
                    VALUES (:taller_id, :usuario_id)";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);

        return $this->db->ejecutar(); 
        
    }

    public function obtenerTalleres($inicio = 0, $cant = 1000){

        $consulta = "SELECT 
                        t.id as taller_id,
                        t.nombre as taller_nombre,
                        t.ref_portada as taller_portada,
                        t.lugar as lugar,
                        t.horario as horario,
                        t.descripcion as descripcion,
                        t.activo as activo,
                        t.fecha_alta as fecha_alta,
                        u.id as profesor_id,
                        concat(u.nombre, ' ', u.apellido) as profesor_nombre,
                        u.mail as profesor_mail
                        FROM talleres t 
                        LEFT JOIN talleres_profesores tp ON t.id = tp.taller_id
                    LEFT JOIN usuarios u ON tp.usuario_id = u.id    
                    GROUP BY t.id
                    ORDER BY t.fecha_alta DESC
                    LIMIT :limite OFFSET 0
                    ";
 
                    
        $this->db->consulta($consulta);
        $this->db->unir(':limite', $cant);
        //$this->db->unir(':offset', $inicio);
        $this->db->ejecutar();

        return $this->db->resultados();

    }
    public function cantTalleres(){
        
        $consulta = "SELECT count(id) as cantidad FROM talleres";

        $this->db->consulta($consulta);
        $this->db->ejecutar();

        return $this->db->resultado();
    }
        

    public function obtenerTallerPorId($taller_id, $inicio = 0, $cant = 1000){

        $consulta = "SELECT 	t.id as taller_id,
		t.nombre as taller_nombre,
        t.ref_portada as taller_portada,
        t.lugar as lugar,
        t.horario as horario,
        t.descripcion as descripcion,
        t.activo as activo,
        t.fecha_alta as fecha_alta,
        u.id as profesor_id,
        concat(u.nombre, ' ' , u.apellido) as profesor_nombre,
        u.mail as profesor_mail
        FROM talleres t 
        LEFT JOIN talleres_profesores tp ON t.id = tp.taller_id
                    LEFT JOIN usuarios u ON tp.usuario_id = u.id    
                    WHERE t.id = :taler_id";
 
        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }

    public function inscribirAlumno ($taller_id, $usuario_id, $activo = 0){ 
        $consulta = "INSERT INTO talleres_usuarios (taller_id, usuario_id, activo) 
                    VALUES (:taller_id, :usuario_id, :activo)";
                    
        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':activo', $activo);
        $this->db->ejecutar();

        return $this->db->resultado();
    }
    public function cambiarEstadoAlumno($taller_id, $usuario_id, $activo){

        $consulta = "UPDATE talleres_usuarios SET activo = :activo WHERE taller_id = :taller_id AND usuario_id = :usuario_id";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);  
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':activo', $activo);
        $this->db->ejecutar();

        return $this->db->resultado();

    }
    public function alumnosInscriptios ($taller_id){
        
        $consulta = "SELECT u.id as alumno_id,
                    concat(u.nombre, ' ', u.apellido) as alumno_nombre,
                    FROM talleres_usuarios tu
                    LEFT JOIN usuarios u ON tu.usuario_id = u.id;
                    WHERE tu.taller_id = :taller_id AND tu.activo = 1";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->ejecutar();

        return $this->db->resultado();
    }  
    public function alumnosPendientes($taller_id){

        $consulta = "SELECT u.id as alumno_id,
                    concat(u.nombre, ' ', u.apellido) as alumno_nombre,
                    FROM talleres_usuarios tu
                    LEFT JOIN usuarios u ON tu.usuario_id = u.id;
                    WHERE tu.taller_id = :taller_id AND tu.activo = 0";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    } 
    public function estaElAlumno ($taller_id, $usuario_id){
        
        $consulta = "SELECT count(usuario_id) as existe FROM talleres_usuarios  
                     WHERE taller_id = :taller_id 
                     AND usuario_id = :usuario_id
                     AND activo = 1";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }   


}
?>