<?php

require_once '../app/core/BaseDatos.php';
require_once '../app/modelos/PublicacionBD.php';

class TallerBD {
    
    private $db;

    public function __construct() {
        
        $this->db = new BaseDatos();

    }

    public function agregarTaller($nombre, $descripcion, $ref_portada, $horario, $lugar, $activo = 1, $cupo = null){   
        $consulta = "INSERT INTO talleres
                    (nombre, ref_portada, lugar, horario, descripcion, activo, cupo) 
                    VALUES 
                    (:nombre, :ref_portada, :lugar, :horario, :descripcion, :activo, :cupo)";

        $this->db->consulta($consulta);
        $this->db->unir(':nombre', $nombre);
        $this->db->unir(':descripcion', $descripcion);
        $this->db->unir(':ref_portada', $ref_portada);
        $this->db->unir(':horario', $horario);
        $this->db->unir(':lugar', $lugar);
        $this->db->unir(':activo', $activo);
        $this->db->unir(':cupo', $cupo);                
        $this->db->ejecutar();  
        $id = $this->db->ultimoId();
        return  $id;

    }   
    public function agregarProfesor($taller_id, $usuario_id){

        $consulta = "INSERT INTO talleres_profesores (taller_id, usuario_id) 
                    VALUES (:taller_id, :usuario_id)";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);

        return $this->db->ejecutar(); 
        
    }

    public function eliminarTaller($taller_id){
        
        $publicacionModel = new PublicacionBD();
        $publicaciones = $publicacionModel->obtenerPublicacionesPorTaller($taller_id, 'foro', 0, 9999);
        $recursos = $publicacionModel->obtenerPublicacionesPorTaller($taller_id, 'recurso', 0, 9999);
        $libretas = $publicacionModel->obtenerPublicacionesPorTaller($taller_id, 'libreta', 0, 9999);
        
        $todasLasPublicaciones = array_merge($publicaciones, $recursos, $libretas);

        foreach($todasLasPublicaciones as $publicacion){
            $publicacionModel->borrarPublicacion($publicacion['id'], true);
        }

        
        $this->db->consulta("DELETE FROM talleres_profesores WHERE taller_id = :taller_id");
        $this->db->unir(':taller_id', $taller_id);
        $this->db->ejecutar();

        $this->db->consulta("DELETE FROM talleres_usuarios WHERE taller_id = :taller_id");
        $this->db->unir(':taller_id', $taller_id);
        $this->db->ejecutar();

        
        $this->db->consulta("DELETE FROM talleres WHERE id = :taller_id");
        $this->db->unir(':taller_id', $taller_id);
        
        return $this->db->ejecutar();
    }
    public function eliminarProfesor($taller_id, $usuario_id){

        $consulta = "DELETE  tp  FROM talleres_profesores tp 
                     WHERE tp.usuario_id = :usuario_id 
                     AND tp.taller_id = :taller_id";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);

        return $this->db->ejecutar(); 
        
    }

    public function busquedaTaller($titulo){

        $consulta = 'SELECT * FROM talleres WHERE nombre LIKE :titulo';

        $this->db->consulta($consulta);
        $this->db->unir(':titulo', "%$titulo%");

        return $this->db->resultados();


    }
    public function obtenerTalleres($inicio = 0, $cant = 1000){

        $consulta = "SELECT 
                        t.id as taller_id,
                        t.nombre as nombre,
                        t.ref_portada as portada,
                        t.lugar as lugar,
                        t.horario as horario,
                        t.descripcion as descripcion,
                        t.activo as activo,
                        t.fecha_alta as fecha_alta,
                        group_concat(distinct u.id separator ', ') as profesores_id,
                        group_concat(distinct concat(u.nombre, ' ', u.apellido ) separator ', ') as profesores_nombre,
                        group_concat(distinct u.mail separator ', ') as profesores_mail
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
        
        $consulta = "SELECT count(id) as cantidad FROM talleres WHERE activo = 1";

        $this->db->consulta($consulta);
        $this->db->ejecutar();

        return $this->db->resultado();
    }

    public function obtenerTalleresActivos($inicio = 0, $cant = 1000){

        $consulta = "SELECT 
                        t.id as taller_id,
                        t.nombre as nombre,
                        t.ref_portada as portada,
                        t.lugar as lugar,
                        t.horario as horario,
                        t.descripcion as descripcion,
                        t.activo as activo,
                        t.fecha_alta as fecha_alta,
                        group_concat(distinct u.id separator ', ') as profesores_id,
                        group_concat(distinct concat(u.nombre, ' ', u.apellido ) separator ', ') as profesores_nombre,
                        group_concat(distinct u.mail separator ', ') as profesores_mail
                        FROM talleres t 
                    LEFT JOIN talleres_profesores tp ON t.id = tp.taller_id
                    LEFT JOIN usuarios u ON tp.usuario_id = u.id WHERE t.activo = 1
                    GROUP BY t.id
                    ORDER BY t.fecha_alta DESC
                    LIMIT :limite OFFSET :offset
                    ";
 
        $this->db->consulta($consulta);
        $this->db->unir(':limite', $cant);
        $this->db->unir(':offset', $inicio);
        return $this->db->resultados();
    }
    public function obtenerTalleresInactivos($inicio = 0, $cant = 1000){

        $consulta = "SELECT 
                        t.id as taller_id,
                        t.nombre as nombre,
                        t.ref_portada as portada,
                        t.lugar as lugar,
                        t.horario as horario,
                        t.descripcion as descripcion,
                        t.activo as activo,
                        t.fecha_alta as fecha_alta,
                        group_concat(distinct u.id separator ', ') as profesores_id,
                        group_concat(distinct concat(u.nombre, ' ', u.apellido ) separator ', ') as profesores_nombre,
                        group_concat(distinct u.mail separator ', ') as profesores_mail
                        FROM talleres t 
                    LEFT JOIN talleres_profesores tp ON t.id = tp.taller_id
                    LEFT JOIN usuarios u ON tp.usuario_id = u.id WHERE t.activo = 0
                    GROUP BY t.id
                    ORDER BY t.fecha_alta DESC
                    LIMIT :limite OFFSET :offset
                    ";
 
        $this->db->consulta($consulta);
        $this->db->unir(':limite', $cant);
        $this->db->unir(':offset', $inicio);
        return $this->db->resultados();
    }

   public function actualizarPortada($taller_id, $archivo_id){
        

        $consulta = "UPDATE talleres 
                        SET ref_portada = :ref_portada
                        WHERE id = :taller_id ";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':ref_portada', $archivo_id);

        return $this->db->ejecutar();        

    }

    public function obtenerTallerPorId($taller_id){

        $consulta = "SELECT 
                        t.id as taller_id,
                        t.nombre as nombre,
                        t.ref_portada as portada,
                        t.lugar as lugar,
                        t.horario as horario,
                        t.descripcion as descripcion,
                        t.activo as activo,
                        t.fecha_alta as fecha_alta,
                        group_concat(distinct u.id separator ', ') as profesores_id,
                        group_concat(distinct concat(u.nombre, ' ', u.apellido ) separator ', ') as profesores_nombre,
                        group_concat(distinct u.mail separator ', ') as profesores_mail
                    FROM talleres t 
                    LEFT JOIN talleres_profesores tp ON t.id = tp.taller_id
                    LEFT JOIN usuarios u ON tp.usuario_id = u.id    
                    WHERE t.id = :taller_id";
 
        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }
    
    public function obtenerTalleresUsuario($usuario_id){
         $consulta = "SELECT 
                        t.id as taller_id,
                        t.nombre as nombre,
                        t.ref_portada as portada,
                        t.lugar as lugar,
                        t.horario as horario,
                        t.descripcion as descripcion,
                        t.activo as taller_activo,
                        tu.activo as usuario_activo,
                        t.fecha_alta as fecha_alta,
                        group_concat(distinct u.id separator ', ') as profesores_id,
                        group_concat(distinct concat(u.nombre, ' ', u.apellido ) separator ', ') as profesores_nombre,
                        group_concat(distinct u.mail separator ', ') as profesores_mail
                    FROM talleres t 
                    LEFT JOIN talleres_usuarios tu ON t.id = tu.taller_id
                    LEFT JOIN talleres_profesores tp ON t.id = tp.taller_id
                    LEFT JOIN usuarios u ON tp.usuario_id = u.id    
                    WHERE tu.usuario_id = :usuario_id
                    AND t.activo = 1
                    GROUP BY t.id
                    ORDER BY t.fecha_alta DESC";
 
        $this->db->consulta($consulta);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->ejecutar();

        return $this->db->resultados();
    }

    public function inscribirAlumno ($taller_id, $usuario_id, $activo = 0){ 
        $consulta = "INSERT IGNORE INTO talleres_usuarios (taller_id, usuario_id, activo) 
                    VALUES (:taller_id, :usuario_id, :activo)
                    
                    ";
                    
        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':activo', $activo);
        $this->db->ejecutar();

        return $this->db->resultado();
    }
    public function eliminarAlumno($taller_id, $usuario_id){

        $consulta = "DELETE FROM talleres_usuarios WHERE taller_id = :taller_id AND usuario_id = :usuario_id";

        $this->db->consulta($consulta);
        $this->db->unir(":taller_id", $taller_id);
        $this->db->unir(":usuario_id", $usuario_id);

        return $this->db->ejecutar();

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
    public function otrosProfesores($taller_id){

        $consulta = 'SELECT
                        u.id,
                        concat(u.nombre, " ", u.apellido) as nombre
                        FROM usuarios u
                        WHERE u.rol_id = 2 AND 
                        u.id NOT IN
                        (SELECT tp.usuario_id FROM talleres_profesores tp WHERE tp.taller_id = :taller_id)';

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        return $this->db->resultados();

    }
    public function alumnosInscriptios ($taller_id){
        
        $consulta = "SELECT u.id as usuario_id,
                    u.img_perfil,
                    concat(u.nombre, ' ', u.apellido) as usuario_nombre
                    FROM talleres_usuarios tu
                    LEFT JOIN usuarios u ON tu.usuario_id = u.id
                    WHERE tu.taller_id = :taller_id AND tu.activo = 1";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->ejecutar();

        return $this->db->resultados();
    }  
    public function editarTaller($taller_id, $nombre, $descripcion, $horario, $lugar, $activo){

        $consulta =  "UPDATE talleres SET 
                        nombre = :nombre,
                        descripcion = :descripcion,
                        horario = :horario,
                        lugar = :lugar,
                        activo = :activo
                    WHERE id = :taller_id";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);  
        $this->db->unir(':nombre', $nombre);
        $this->db->unir(':descripcion', $descripcion);
        $this->db->unir(':horario', $horario);
        $this->db->unir(':lugar', $lugar);
        $this->db->unir(':activo', $activo);
        
        return $this->db->ejecutar();

    }
    public function alumnosPendientes($taller_id){

        $consulta = "SELECT u.id as usuario_id,
                    concat(u.nombre, ' ', u.apellido) as usuario_nombre, 
                    u.img_perfil
                    FROM talleres_usuarios tu
                    LEFT JOIN usuarios u ON tu.usuario_id = u.id
                    WHERE tu.taller_id = :taller_id AND tu.activo = 0";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);

        return $this->db->resultados();

    } 
    public function obtenerProfesores($taller_id){
        $consulta = "SELECT 
                        u.id as usuario_id,
                        u.mail as mail,
                        u.img_perfil,
                        concat(u.nombre, ' ', u.apellido) as nombre

                    FROM talleres_profesores tp
                    LEFT JOIN usuarios u ON tp.usuario_id = u.id
                    WHERE tp.taller_id = :taller_id";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);

        return $this->db->resultados();
    }

    public function esProfesorDelTaller($taller_id, $usuario_id){
        $consulta = "SELECT usuario_id FROM talleres_profesores 
                    WHERE taller_id = :taller_id 
                    AND usuario_id = :usuario_id ";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);

        return $this->db->resultado();

    }
    public function estaElUsuarioInscripto ($taller_id, $usuario_id){
        
        $consulta = "SELECT activo as existe FROM talleres_usuarios  
                     WHERE taller_id = :taller_id 
                     AND usuario_id = :usuario_id
                     ";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }   

    public function cambiarEstadoTaller($taller_id, $activo){

        $consulta = "UPDATE talleres
                     SET activo = :activo 
                     WHERE id = :taller_id";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);  
        $this->db->unir(':activo', $activo);
        

        return $this->db->ejecutar();

    }
    public function ultimo_id(){
        return $this->db->ultimoId();

    }
    public function cambiarEstadoConfirmacao($taller_id, $usuario_id){
    }  
 }
?>