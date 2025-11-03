<?php



class PublicacionBD extends Modelo{
    
    

    public function subirPublicacionAForo($taller_id, $usuario_id, $titulo, $cuerpo){
        $consulta = "INSERT INTO publicaciones 
                    (taller_id, usuario_id, alcance,
                    fecha_publicacion, titulo, cuerpo)
                    VALUES (:taller_id, :usuario_id, 'foro',
                    NOW(), :titulo, :cuerpo)";

        $this->db->consulta($consulta);
        $this->db->unir("taller_id", $taller_id);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->unir("titulo", $titulo);
        $this->db->unir("cuerpo", $cuerpo);

        return $this->db->ejecutar();

    }
    
    public function subirPublicacionALibreta($taller_id, $usuario_id, $titulo, $cuerpo){
        $consulta = "INSERT INTO publicaciones 
                    (taller_id, usuario_id, alcance,
                    fecha_publicacion, titulo, cuerpo)
                    VALUES (:taller_id, :usuario_id, 'libreta',
                    NOW(), :titulo, :cuerpo)";

        $this->db->consulta($consulta);
        $this->db->unir("taller_id", $taller_id);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->unir("titulo", $titulo);
        $this->db->unir("cuerpo", $cuerpo);

        return $this->db->resultado();

    }

    public function ultimo_id(){
        $consulta = "SELECT MAX(id) FROM publicaciones";

        $this->db->consulta($consulta);

        return $this->db->resultado();

    }

    public function registrarPublicacionArchivo($publicacion_id, $archivo_id){  
            $consulta = "INSERT INTO publicaciones_archivo (publicacion_id, archivo_id)  VALUES (:publicacion_id, :archivo_id)";

            $this->db->consulta($consulta);
            $this->db->unir(':publicacion_id', $publicacion_id);
            $this->db->unir(':archivo_id', $archivo_id);

            return $this->db->ejecutar();


    }

    public function subirRecurso($taller_id, $usuario_id, $titulo, $cuerpo){
        $consulta = "INSERT INTO publicaciones 
                    (taller_id, usuario_id, alcance,
                    fecha_publicacion, titulo, cuerpo)
                    VALUES (:taller_id, :usuario_id, 'recurso',
                    NOW(), :titulo, :cuerpo)";

        $this->db->consulta($consulta);
        $this->db->unir("taller_id", $taller_id);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->unir("titulo", $titulo);
        $this->db->unir("cuerpo", $cuerpo);

        return $this->db->ejecutar();

    }

    public function cantPublicacionesPorTaller($taller_id, $alcance = 'foro'){
        
        $consulta = "SELECT count(p.id) as cantidad FROM publicaciones p
                    WHERE p.taller_id = :taller_id
                    AND p.alcance = :alcance";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':alcance', $alcance);

        return $this->db->resultado();
    }

    public function obtenerPublicacionesPorTaller($taller_id, $alcance = 'foro',  $inicio = 0, $cant = 1000){
        $consulta = "SELECT 
                        p.id, p.titulo, p.cuerpo,
                        concat(u.nombre, ' ', u.apellido) as usuario_nombre,
                        u.id as usuario_id,
                        p.fecha_publicacion,
                        group_concat(distinct pa.archivo_id separator ', ') as archivos_id,
                        group_concat(distinct a.titulo separator ', ') as archivos_titulos
                    FROM publicaciones  p
                    LEFT JOIN usuarios u ON p.usuario_id = u.id
                    LEFT JOIN publicaciones_archivo pa ON p.id = pa.publicacion_id
                    LEFT JOIN archivos a ON pa.archivo_id = a.id
                    WHERE p.taller_id = :taller_id
                    AND p.alcance = :alcance
                    GROUP BY p.id
                    ORDER BY p.fecha_publicacion DESC
                    LIMIT :limite OFFSET :offset";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':alcance', $alcance);
        $this->db->unir(':limite', $cant);
        $this->db->unir(':offset', $inicio);

        $this->db->ejecutar();

        return $this->db->resultados();

    }

    public function obtenerPublicacionesLibretaPorTaller($taller_id, $usuario_id,  $inicio = 0, $cant = 1000){
        $consulta = "SELECT 
                        p.id, p.titulo, p.cuerpo,
                        concat(u.nombre, ' ', u.apellido) as usuario_nombre,
                        u.id as usuario_id,
                        p.fecha_publicacion,
                        group_concat(distinct pa.archivo_id separator ', ') as archivos_id 
                    FROM publicaciones  p
                    LEFT JOIN usuarios u ON p.usuario_id = u.id
                    LEFT JOIN publicaciones_archivo pa ON p.id = pa.publicacion_id
                    WHERE p.usuario_id = :usuario_id
                    AND p.taller_id = :taller_id
                    GROUP BY p.id
                    ORDER BY p.fecha_publicacion DESC
                    LIMIT :limite OFFSET :offset";

        $this->db->consulta($consulta);
        $this->db->unir(':taller_id', $taller_id);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':limite', $cant);
        $this->db->unir(':offset', $inicio);

        return $this->db->resultados();

    }

    




    



}