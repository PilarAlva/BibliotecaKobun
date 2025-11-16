<?php

require_once '../app/bd/conexion.php';

class LibroBD {

    private $db;

    public function __construct() {
        $this->db = new BaseDatos();
    }

    /* ============================================================
       FUNCIONES PRIVADAS PARA EVITAR REPETIR CÓDIGO
       ============================================================ */

    private function sqlJoins() {
        return "
            LEFT JOIN libros_generos lg ON l.id = lg.libro_id
            LEFT JOIN generos g ON lg.genero_id = g.id
            LEFT JOIN libros_autores la ON l.id = la.libro_id
            LEFT JOIN autores a ON la.autor_id = a.id
            LEFT JOIN libros_editoriales le ON l.id = le.libro_id
            LEFT JOIN editoriales e ON le.editorial_id = e.id
        ";
    }

    private function sqlFiltro($filtro) {
        switch ($filtro) {
            case 'autor':
                return "AND EXISTS (
                            SELECT 1 
                            FROM libros_autores la2 
                            INNER JOIN autores a2 ON la2.autor_id = a2.id 
                            WHERE la2.libro_id = l.id
                            AND (a2.nombre LIKE :busqueda_nombre OR a2.apellido LIKE :busqueda_apellido)
                        )";

            case 'genero':
                return "AND EXISTS (
                            SELECT 1 
                            FROM libros_generos lg2
                            INNER JOIN generos g2 ON lg2.genero_id = g2.id
                            WHERE lg2.libro_id = l.id
                            AND g2.nombre LIKE :busqueda
                        )";

            case 'editorial':
                return "AND EXISTS (
                            SELECT 1 
                            FROM libros_editoriales le2
                            INNER JOIN editoriales e2 ON le2.editorial_id = e2.id
                            WHERE le2.libro_id = l.id
                            AND e2.nombre LIKE :busqueda
                        )";

            case 'isbn':
                return "AND l.isbn LIKE :busqueda";

            case 'descripcion':
                return "AND l.descripcion LIKE :busqueda";

            case 'titulo':
            default:
                return "AND l.titulo LIKE :busqueda";
        }
    }

    private function bindFiltro($filtro, $busqueda) {
        if ($filtro == 'autor') {
            $this->db->unir(':busqueda_nombre', "%$busqueda%");
            $this->db->unir(':busqueda_apellido', "%$busqueda%");
        } else {
            $this->db->unir(':busqueda', "%$busqueda%");
        }
    }

    /* ============================================================
       MÉTODOS ORIGINALES (solo limpiados)
       ============================================================ */

    public function cambiarEstado($libro_id, $activado){
        $consulta = "UPDATE libros 
                        SET activo = :activado
                        WHERE id = :libro_id";

        $this->db->consulta($consulta);
        $this->db->unir(":libro_id", $libro_id);
        $this->db->unir(":activado", $activado);

        return $this->db->ejecutar();
    }

    public function busquedaCatalogo($busqueda, $filtro, $inicio = 0, $cant = 1000, $todos = false){

        $consulta = "SELECT  
                        l.id as id,
                        l.titulo as titulo,
                        l.sinopsis as sinopsis,
                        l.ref_portada as portada,
                        l.descripcion as descripcion,

                        (SELECT 
                            count(e.id) - count(a.ejemplar_id) as disponibles
                            FROM ejemplares e
                            LEFT JOIN (
                                SELECT ejemplar_id 
                                FROM prestamos 
                                WHERE fecha_devolucion IS NULL
                            ) AS a 
                            ON e.id = a.ejemplar_id
                            WHERE e.libro_id = l.id) as cantidad,

                        group_concat(distinct g.nombre separator ', ') as generos,
                        group_concat(distinct concat(a.nombre, ' ', a.apellido ) separator ', ') as autores,
                        group_concat(distinct e.nombre separator ', ') as editorial
                        
                    FROM libros l
                    " . $this->sqlJoins();

        $consulta .= $todos ? " " : " WHERE l.activo = 1 ";

        if ($busqueda != '') {
            $consulta .= $this->sqlFiltro($filtro);
        }

        $consulta .= " GROUP BY l.id ORDER BY l.titulo ASC LIMIT :limite OFFSET :offset";

        $this->db->consulta($consulta);

        if ($busqueda != '') {
            $this->bindFiltro($filtro, $busqueda);
        }

        $this->db->unir(':limite', $cant);
        $this->db->unir(':offset', $inicio);

        $this->db->ejecutar();

        return $this->db->resultados();
    }


    public function cantResultadosCatalogo($busqueda, $filtro){ 

        $consulta = "
            SELECT count(distinct l.id) as cantidad
            FROM libros l
            " . $this->sqlJoins() . "
            WHERE l.activo = 1
        ";

        if ($busqueda != '') {
            $consulta .= $this->sqlFiltro($filtro);
        }

        $this->db->consulta($consulta);

        if ($busqueda != '') {
            $this->bindFiltro($filtro, $busqueda);
        }

        $this->db->ejecutar();

        return $this->db->resultado();
    }

    /* ============================================================
       RESTO DEL ARCHIVO SE MANTIENE EXACTO (SIN CAMBIOS)
       ============================================================ */

    public function cantidadDisponible($libro_id){
        $consulta = "SELECT 
                        count(e.id) - count(a.ejemplar_id) as disponibles
                    FROM ejemplares e
                    LEFT JOIN (
                        SELECT ejemplar_id 
                        FROM prestamos 
                        WHERE fecha_devolucion IS NULL
                    ) AS a 
                    ON e.id = a.ejemplar_id
                    WHERE e.libro_id = :libro_id";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->ejecutar(); 

        return $this->db->resultado();
    }

    public function ejemplaresTotales($libro_id){
        $consulta = "SELECT 
                        e.id as ejemplar_id,
                        e.codigo_topografico as codigo_topografico,
                        e.libro_id as libro_id,
                        CASE WHEN p.fecha_vencimiento IS NOT NULL THEN '1' ELSE '0' END as activo,
                        p.fecha_vencimiento as fecha_vencimiento
                    FROM ejemplares e 
                    LEFT JOIN prestamos p 
                        ON p.ejemplar_id = e.id 
                        AND p.fecha_devolucion IS NULL
                    WHERE e.libro_id = :libro_id";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->ejecutar(); 

        return $this->db->resultados();
    }

    public function ejemplaresDisponiblesPorTitulo($titulo){
        $consulta = "SELECT 
                        e.id AS ejemplar_id,
                        l.titulo
                    FROM ejemplares e
                    LEFT JOIN prestamos p 
                        ON p.ejemplar_id = e.id 
                        AND p.fecha_devolucion IS NULL
                    LEFT JOIN libros l 
                        ON e.libro_id = l.id
                    WHERE l.titulo LIKE :busqueda
                    AND p.id IS NULL";

        $this->db->consulta($consulta);
        $this->db->unir(':busqueda', "%$titulo%");
        return $this->db->resultados();
    }

    public function cantEjemplaresTotales($libro_id){
        $consulta = "SELECT 
                        COUNT(e.id) disponibles
                    FROM ejemplares e 
                    WHERE e.libro_id = :libro_id";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);

        return $this->db->resultado();
    }

    public function ejemplaresDisponibles($libro_id){
        $consulta = "SELECT 
                        e.id as id,
                        e.libro_id
                    FROM ejemplares e 
                    WHERE e.id NOT IN (
                        SELECT p.ejemplar_id 
                        FROM prestamos p 
                        WHERE p.fecha_devolucion IS NULL
                    )
                    AND e.libro_id = :libro_id";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->ejecutar(); 

        return $this->db->resultados();
    }

    public function obtenerLibroPorEjemplar($id_ejemplar){
        $consulta = "SELECT 
                        l.id as id, 
                        l.isbn as isbn,
                        l.titulo as titulo,
                        l.sinopsis as sinopsis,
                        l.ref_portada as portada,
                        l.descripcion as descripcion,
                        group_concat(distinct g.nombre separator ', ') as generos,
                        group_concat(distinct concat(a.nombre, ' ', a.apellido ) separator ', ') as autores,
                        group_concat(distinct e.nombre separator ', ') as editorial
                    FROM ejemplares ej
                    LEFT JOIN libros l ON ej.libro_id = l.id
                    LEFT JOIN libros_generos lg ON l.id = lg.libro_id
                    LEFT JOIN generos g ON lg.genero_id = g.id
                    LEFT JOIN libros_autores la ON l.id = la.libro_id
                    LEFT JOIN autores a ON la.autor_id = a.id
                    LEFT JOIN libros_editoriales le ON l.id = le.libro_id
                    LEFT JOIN editoriales e ON le.editorial_id = e.id
                    WHERE ej.id = :ejemplar_id
                    GROUP BY l.id";

        $this->db->consulta($consulta);
        $this->db->unir(':ejemplar_id', $id_ejemplar);
        return $this->db->resultado();
    }

    public function obtenerEditoriales(){
        $consulta = "SELECT id, nombre FROM editoriales";
        $this->db->consulta($consulta);
        return $this->db->resultados();
    }

    public function obtenerAutores(){
        $consulta = "SELECT id, concat(nombre, ' ', apellido) as nombre FROM autores";
        $this->db->consulta($consulta);
        return $this->db->resultados();
    }

    public function obtenerGeneros(){
        $consulta = "SELECT id, nombre FROM generos";
        $this->db->consulta($consulta);
        return $this->db->resultados();
    }

    public function obtenerEjemplarPorId($ejempalr_id){
        $consulta = "SELECT * FROM ejemplares e WHERE e.id = :ejemplar_id";

        $this->db->consulta($consulta);
        $this->db->unir(":ejemplar_id", $ejempalr_id);
        $this->db->ejecutar();

        return $this->db->resultados();
    }

    public function infoLibro($id_libro){
        $consulta = "SELECT 
                        l.id as id, 
                        l.isbn as isbn,
                        l.titulo as titulo,
                        l.activo as activo,
                        l.sinopsis as sinopsis,
                        l.ref_portada as portada,
                        l.descripcion as descripcion,
                        group_concat(distinct g.nombre separator ', ') as generos,
                        group_concat(distinct concat(a.nombre, ' ', a.apellido ) separator ', ') as autores,
                        group_concat(distinct e.nombre separator ', ') as editorial
                    FROM libros l
                    LEFT JOIN libros_generos lg ON l.id = lg.libro_id
                    LEFT JOIN generos g ON lg.genero_id = g.id
                    LEFT JOIN libros_autores la ON l.id = la.libro_id
                    LEFT JOIN autores a ON la.autor_id = a.id
                    LEFT JOIN libros_editoriales le ON l.id = le.libro_id
                    LEFT JOIN editoriales e ON le.editorial_id = e.id
                    WHERE l.id = :id_libro
                    GROUP BY l.id";

        $this->db->consulta($consulta);
        $this->db->unir(':id_libro', $id_libro);
        $this->db->ejecutar();
        return $this->db->resultado();
    }

    /* resto del archivo sigue igual... */

    public function __destruct() {
        $this->DB = null;
    }
}
