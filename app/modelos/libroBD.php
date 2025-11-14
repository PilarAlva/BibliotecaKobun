<?php

require_once '../app/bd/conexion.php';

class LibroBD {
    
    private $db;

    public function __construct() {
        
        $this->db = new BaseDatos();

    }
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
                                SELECT 
                                    ejemplar_id 
                                FROM prestamos WHERE fecha_devolucion IS NULL
                                )AS a 
                            ON e.id = a.ejemplar_id
                            WHERE e.libro_id = l.id) as cantidad,

                        group_concat(distinct g.nombre separator ', ') as generos,
                        group_concat(distinct concat(a.nombre, ' ', a.apellido ) separator ', ') as autores,
                        group_concat(distinct e.nombre separator ', ') as editorial
                        
                    FROM libros l

                        LEFT JOIN libros_generos lg ON l.id = lg.libro_id
                        LEFT JOIN generos g ON lg.genero_id = g.id
                        LEFT JOIN libros_autores la ON l.id = la.libro_id
                        LEFT JOIN autores a ON la.autor_id = a.id
                        LEFT JOIN libros_editoriales le ON l.id = le.libro_id
                        LEFT JOIN editoriales e ON le.editorial_id = e.id";
                        
                        $consulta .= !$todos ? " WHERE l.activo = 1 " : " ";
                        


        if ($busqueda != '') {
        
        switch ($filtro) {
            case 'autor':
                $consulta .= "AND EXISTS (
                                SELECT 1 
                                FROM libros_autores la2 
                                INNER JOIN autores a2 ON la2.autor_id = a2.id 
                                WHERE la2.libro_id = l.id
                                    AND (a2.nombre LIKE :busqueda_nombre OR a2.apellido LIKE :busqueda_apellido) )";
                break;
            case 'genero':
                $consulta .= " AND EXISTS (
                                SELECT 1 
                                FROM libros_generos lg2 
                                INNER JOIN generos g2 ON lg2.libro_id = g2.id 
                                WHERE lg2.libro_id = l.id 
                                    AND g2.nombre LIKE :busqueda )";
                break;
            case 'editorial':
                $consulta .= " AND EXISTS (
                                SELECT 1 
                                FROM libros_editoriales le2 
                                INNER JOIN editoriales e2 ON le2.libro_id = e2.id 
                                WHERE le2.libro_id = l.id 
                                    AND e2.nombre LIKE :busqueda )";
                break;
            case 'isbn':
                $consulta .= " AND l.isbn LIKE :busqueda";
                break;    
            case 'descripcion':
                $consulta .= " AND l.descripcion LIKE :busqueda";
                break;    
            case 'titulo':
            default:
                $consulta .= " AND l.titulo LIKE :busqueda";
                break;
            }

        
        
        }

        $consulta .= " GROUP BY l.id ORDER BY l.titulo ASC LIMIT :limite OFFSET :offset";

        $this->db->consulta($consulta);

        if ($busqueda != '') {
            if ($filtro == 'autor') {
                $this->db->unir(':busqueda_nombre', "%$busqueda%");
                $this->db->unir(':busqueda_apellido', "%$busqueda%");
            } else {
                $this->db->unir(':busqueda', "%$busqueda%");
            }
        }

        $this->db->unir(':limite', $cant);
        $this->db->unir(':offset', $inicio);

        $this->db->ejecutar(); 

        return $this->db->resultados();

    
    }

    public function cantResultadosCatalogo($busqueda, $filtro){ 

        $consulta = "SELECT  
                        count( distinct l.id ) as cantidad
                    FROM libros l

                        LEFT JOIN libros_generos lg ON l.id = lg.libro_id
                        LEFT JOIN generos g ON lg.genero_id = g.id
                        LEFT JOIN libros_autores la ON l.id = la.libro_id
                        LEFT JOIN autores a ON la.autor_id = a.id
                        LEFT JOIN libros_editoriales le ON l.id = le.libro_id
                        LEFT JOIN editoriales e ON le.editorial_id = e.id 
                        WHERE l.activo = 1 ";

        if ($busqueda != '') {
        
        switch ($filtro) {
            case 'autor':
                $consulta .= "AND EXISTS (
                                SELECT 1 
                                FROM libros_autores la2 
                                INNER JOIN autores a2 ON la2.autor_id = a2.id 
                                WHERE la2.libro_id = l.id
                                    AND (a2.nombre LIKE :busqueda_nombre OR a2.apellido LIKE :busqueda_apellido) )";
                break;
            case 'genero':
                $consulta .= " AND EXISTS (
                                SELECT 1 
                                FROM libros_generos lg2 
                                INNER JOIN generos g2 ON lg2.libro_id = g2.id 
                                WHERE lg2.libro_id = l.id 
                                    AND g2.nombre LIKE :busqueda )";
                break;
            case 'editorial':
                $consulta .= " AND EXISTS (
                                SELECT 1 
                                FROM libros_editoriales le2 
                                INNER JOIN editoriales e2 ON le2.libro_id = e2.id 
                                WHERE le2.libro_id = l.id 
                                    AND e2.nombre LIKE :busqueda )";
                break;
            case 'isbn':
                $consulta .= " AND l.isbn LIKE :busqueda";
                break;    
            case 'descripcion':
                $consulta .= " AND l.descripcion LIKE :busqueda";
                break;    
            case 'titulo':
            default:
                $consulta .= " AND l.titulo LIKE :busqueda";
                break;
            }

        
        }


        $this->db->consulta($consulta);

        if ($busqueda != '') {
            if ($filtro == 'autor') {
                $this->db->unir(':busqueda_nombre', "%$busqueda%");
                $this->db->unir(':busqueda_apellido', "%$busqueda%");
            } else {
                $this->db->unir(':busqueda', "%$busqueda%");
            }
        }
        $this->db->ejecutar(); 

        return $this->db->resultado();

    }

    public function cantidadDisponible($libro_id){
        $consulta = "SELECT 
                        count(e.id) - count(a.ejemplar_id) as disponibles
                    FROM ejemplares e
                    LEFT JOIN (
                        SELECT 
                            ejemplar_id 
                        FROM prestamos WHERE fecha_devolucion IS NULL
                        )AS a 
                    ON e.id = a.ejemplar_id
                    WHERE e.libro_id = :libro_id";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->ejecutar(); 

        return $this->db->resultado();
    }

    public function ejemplaresTotales($libro_id){
        
        $consulta = "SELECT 
                        e.id as ejemplar_id ,
                        e.codigo_topografico as codigo_topografico,
                        e.libro_id as libro_id,
                        CASE WHEN p.fecha_vencimiento IS NOT NULL THEN '1' ELSE '0' END as activo,
                        p.fecha_vencimiento as fecha_vencimiento
                    FROM ejemplares e 
                    LEFT JOIN prestamos p ON p.ejemplar_id = e.id AND p.fecha_devolucion IS NULL
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
                        AND p.fecha_devolucion IS NULL   -- préstamo ACTIVO
                        LEFT JOIN libros l 
                        ON e.libro_id = l.id
                        WHERE 
                    l.titulo LIKE :busqueda
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
                    WHERE e.id
                    NOT IN (
                        SELECT 
                            p.ejemplar_id 
                        FROM prestamos p WHERE p.fecha_devolucion IS NULL
                    ) AND e.libro_id = :libro_id";

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
        $this->db->unir(':id_ejemplar', $id_ejemplar);
        return $this->db->resultado();
        
    }
    public function obtenerEditoriales(){
        $consulta = "SELECT 
                        id,
                        nombre
                    FROM editoriales";
        $this->db->consulta($consulta);

        return $this->db->resultados();
    }

    public function obtenerAutores(){
        $consulta = "SELECT id,
                        concat(nombre, ' ', apellido) as nombre
                    FROM autores";
        $this->db->consulta($consulta);

        return $this->db->resultados();
    }

    public function obtenerGeneros(){
        $consulta = "SELECT 
                        id,
                        nombre
                    FROM generos";
        $this->db->consulta($consulta);

        return $this->db->resultados();
    }

    public function obtenerEjemplarPorId($ejempalr_id){

        $consulta = "SELECT 
                        *   
                    FROM ejemplares e 
                    WHERE e.id = :ejemplar_id ";

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

    public function agregarLibro($isbn, $titulo, $sinopsis, $ref_portada, $descripcion, $autores, $generos, $editoriales, $activo = 1){
        

       $consulta = "INSERT INTO libros (isbn, titulo, sinopsis, ref_portada, descripcion, activo) 
                                VALUES (:isbn, :titulo, :sinopsis, :ref_portada, :descripcion, :activo)";
       
        $this->db->consulta($consulta);
        $this->db->unir(':isbn', $isbn);
        $this->db->unir(':titulo', $titulo);
        $this->db->unir(':sinopsis', $sinopsis);
        $this->db->unir(':ref_portada', $ref_portada);
        $this->db->unir(':descripcion', $descripcion);
        $this->db->unir(':activo', $activo);
        
        $libro_id = 0;
        if($this->db->ejecutar()){
            $libro_id = $this->db->ultimoId();
            $this->agregarLibroAutores($libro_id, $autores);
            $this->agregarLibroGeneros($libro_id, $generos);      
            $this->agregarLibroEditoriales($libro_id, $editoriales);
        };


       return $libro_id;
    }

    private function agregarLibroAutores($libro_id, $autores_id){

        foreach ($autores_id as $autor_id) {
            $this->agregarLibroAutor($libro_id, $autor_id);
        }
    }

    private function agregarLibroAutor($libro_id, $autor_id){
        $consulta = "INSERT INTO libros_autores (libro_id, autor_id) 
                     VALUES (:libro_id, :autor_id)";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->unir(':autor_id', $autor_id);

        return $this->db->ejecutar();
    }

    private function agregarLibroEditoriales($libro_id, $editoriales_id){

        foreach ($editoriales_id as $editorial_id) {
            $this->agregarLibroEditorial($libro_id, $editorial_id);
        }
    }   

    private function agregarLibroEditorial($libro_id, $editorial_id){
        $consulta = "INSERT INTO libros_editoriales (libro_id, editorial_id) 
                     VALUES (:libro_id, :editorial_id)";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->unir(':editorial_id', $editorial_id);

        return $this->db->ejecutar();
    }

    private function agregarLibroGeneros($libro_id, $generos_id){

        foreach ($generos_id as $genero_id) {
            $this->agregarLibroGenero($libro_id, $genero_id);
        }
    }   
    private function agregarLibroGenero($libro_id, $genero_id){
        $consulta = "INSERT INTO libros_generos (libro_id, genero_id) 
                     VALUES (:libro_id, :genero_id)";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->unir(':genero_id', $genero_id);

        return $this->db->ejecutar();
    }   

    public function editarLibro($isbn, $titulo, $sinopsis, $ref_portada, $descripcion){
        

        $consulta = "UPDATE libros 
                        SET isbn = :isbn, titulo = :titulo,
                            sinopsis = :sinopsis, ref_portada = :ref_portada,
                            descripcion = :descripcion 
                            WHERE id = :id ";

        $this->db->consulta($consulta);
        $this->db->unir(':isbn', $isbn);
        $this->db->unir(':titulo', $titulo);
        $this->db->unir(':sinopsis', $sinopsis);
        $this->db->unir(':ref_portada', $ref_portada);
        $this->db->unir(':descripcion', $descripcion);

        return $this->db->ejecutar();        

    }

    public function actualizarPortada($libro_id, $archivo_id){
        

        $consulta = "UPDATE libros 
                        SET ref_portada = :ref_portada
                        WHERE id = :libro_id ";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->unir(':ref_portada', $archivo_id);

        return $this->db->ejecutar();        

    }
    public function estadoLibro($libro_id, $activo){
        
        $consulta = "UPDATE libros 
                        SET activo = :activo
                        WHERE id = :libro_id ";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->unir(':activo', $activo);

        return $this->db->ejecutar();        

    }

    public function agregarEjemplar($libro_id){
        
        $consulta = "INSERT INTO ejemplares (libro_id, codigo_topografico) 
                     VALUES (:libro_id, '-') ";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);

        return $this->db->ejecutar();        

    }

    public function agregarGenero($nombre) {

        $consulta = "INSERT INTO generos (nombre) 
                     VALUES (:nombre) ";

        $this->db->consulta($consulta);
        $this->db->unir(':nombre', $nombre);

        return $this->db->ejecutar();

    }

    public function agregarEditorial($nombre) {

        $consulta = "INSERT INTO editoriales (nombre) 
                     VALUES (:nombre) ";

        $this->db->consulta($consulta);
        $this->db->unir(':nombre', $nombre);

        return $this->db->ejecutar();

    }   

    public function agregarAutor($nombre, $apellido, $fecha_nacimiento, $fecha_muerte = NULL) {

        $consulta = "INSERT INTO autores (nombre, apellido, fecha_nacimiento, fecha_muerte) 
                     VALUES (:nombre, :apellido, :fecha_nacimiento, :fecha_muerte) ";

        $this->db->consulta($consulta);
        $this->db->unir(':nombre', $nombre);
        $this->db->unir(':apellido', $apellido);
        $this->db->unir(':fecha_nacimiento', $fecha_nacimiento);
        $this->db->unir(':fecha_muerte', $fecha_muerte);

        return $this->db->ejecutar();

    }   
    public function antiguedadLibro($libro_id) {

        $consulta = "SELECT 
                        DATEDIFF(NOW(), l.fecha_alta ) AS dias_antiguedad 
                    FROM libros l
                    WHERE l.libro_id = :libro_id";

        $this->db->consulta($consulta);
        $this->db->unir(':libro_id', $libro_id);
        $this->db->ejecutar();

        return $this->db->resultado();
    }   



    /* ---------- */
    /* public function obtenerLibros () {
        $consulta = "SELECT l.id, l.titulo, l.ref_portada, CONCAT(a.nombre, ' ', a.apellido) AS nombre_completo 
                        FROM libros l
                        JOIN libros_autores la ON l.id = la.libro_id
                        JOIN autores a ON la.autor_id = a.id;";

        $sql = $this->con->prepare($consulta);
        $sql->execute();

        return $sql->fectchAll(PDO::FETCH_ASOC);
    }

    public function obtenerLibroPorId($libro_id){
        $consulta = "SELECT *   
                    FROM libros l 
                    WHERE l.id = :libro_id ";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(":libro_id", $libro_id, PDO::PARAM_INT);    
        $sql->execute();

        return $sql->fectchAll(PDO::FETCH_ASOC);
    } */


    public function __destruct() {
        $this->DB = null;
    }
 
}