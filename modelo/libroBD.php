<?php

require_once './bd/conexion.php';

class LibroBD {
    
    private $con;

    public function __construct() {
        
        $db = new Database();
        $this->con = $db->conectar();

    }

    public function busquedaCatalogo($busqueda, $filtro, $inicio = 0, $cant = 1000){

        $consulta = "SELECT  
                        l.titulo as titulo,
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

        $consulta .= " GROUP BY l.id ORDER BY l.titulo ASC LIMIT :limite OFFSET :offset";

        $sql = $this->con->prepare($consulta);

        if ($busqueda != '') {
            if ($filtro == 'autor') {
                $sql->bindValue(':busqueda_nombre', "%$busqueda%", PDO::PARAM_STR);
                $sql->bindValue(':busqueda_apellido', "%$busqueda%", PDO::PARAM_STR);
            } else {
                $sql->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
            }
        }

        $sql->bindValue(':limite', $cant,   PDO::PARAM_INT);
        $sql->bindValue(':offset', $inicio, PDO::PARAM_INT);

        $sql->execute(); 

        return $sql->fetchAll(PDO::FETCH_ASSOC);

    
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


        $sql = $this->con->prepare($consulta);

        if ($busqueda != '') {
            if ($filtro == 'autor') {
                $sql->bindValue(':busqueda_nombre', "%$busqueda%", PDO::PARAM_STR);
                $sql->bindValue(':busqueda_apellido', "%$busqueda%", PDO::PARAM_STR);
            } else {
                $sql->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
            }
        }
        $sql->execute(); 

        return $sql->fetchColumn();

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

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->execute(); 

        return $sql->fetchColumn();
    }

    public function ejemplaresDisponibles($libro_id){
        
        $consulta = "SELECT 
                        e.id,
                        e.libro_id
                    FROM ejemplares e 
                    WHERE e.id
                    NOT IN (
                        SELECT 
                            p.ejemplar_id 
                        FROM prestamos p WHERE p.fecha_devolucion IS NULL
                    ) AND e.libro_id = :libro_id";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->execute(); 

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEjemplarPorId($ejempalr_id){

        $consulta = "SELECT 
                        *   
                    FROM ejemplares e 
                    WHERE e.id = :ejemplar_id "

        $sql = $this.con->prepare($consulta);
        $sql->bindValue(":ejemplar_id", $ejempalr_id, PDO::PARAM_INT)        
        $sql->execute();

        return $sql->fectchAll(PDO::FETCH_ASOC);
    }

    public function infoLibro($id_libro){

        $consulta = "SELECT  
                        l.titulo as titulo,
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

        $sql = $this->con->prepare($consulta);

        $sql->bindValue(':id_libro', $id_libro, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function agregarLibro($isbn, $titulo, $sinopsis, $ref_portada, $descripcion, $autores, $generos, $editoriales){
        

        $consulta = "INSERT INTO libros (isbn,titulo, sinopsis, ref_portada, descripcion, activo) 
                     VALUES (:isbn,:titulo, :sinopsis, :ref_portada, :descripcion, 1)";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':isbn', $isbn, PDO::PARAM_STR);
        $sql->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $sql->bindValue(':sinopsis', $sinopsis, PDO::PARAM_STR);
        $sql->bindValue(':ref_portada', $ref_portada, PDO::PARAM_STR);
        $sql->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);

        $sql->execute();

        $libro_id = $this->con->lastInsertId();
        $this->agregarLibroAutores($libro_id, $autores);
        $this->agregarLibroGeneros($libro_id, $generos);      
        $this->agregarLibroEditoriales($libro_id, $editoriales);

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

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->bindValue(':autor_id', $autor_id, PDO::PARAM_INT);

        return $sql->execute();
    }

    private function agregarLibroEditoriales($libro_id, $editoriales_id){

        foreach ($editoriales_id as $editorial_id) {
            $this->agregarLibroEditorial($libro_id, $editorial_id);
        }
    }   

    private function agregarLibroEditorial($libro_id, $editorial_id){
        $consulta = "INSERT INTO libros_editoriales (libro_id, editorial_id) 
                     VALUES (:libro_id, :editorial_id)";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->bindValue(':editorial_id', $editorial_id, PDO::PARAM_INT);

        return $sql->execute();
    }

    private function agregarLibroGeneros($libro_id, $generos_id){

        foreach ($generos_id as $genero_id) {
            $this->agregarLibroGenero($libro_id, $genero_id);
        }
    }   
    private function agregarLibroGenero($libro_id, $genero_id){
        $consulta = "INSERT INTO libros_generos (libro_id, genero_id) 
                     VALUES (:libro_id, :genero_id)";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->bindValue(':genero_id', $genero_id, PDO::PARAM_INT);

        return $sql->execute();
    }   

    public function editarLibro($isbn, $titulo, $sinopsis, $ref_portada, $descripcion){
        

        $consulta = "UPDATE libros 
                        SET isbn = :isbn, titulo = :titulo,
                            sinopsis = :sinopsis, ref_portada = :ref_portada,
                            descripcion = :descripcion 
                            WHERE id = :id ";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':isbn', $isbn, PDO::PARAM_STR);
        $sql->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $sql->bindValue(':sinopsis', $sinopsis, PDO::PARAM_STR);
        $sql->bindValue(':ref_portada', $ref_portada, PDO::PARAM_STR);
        $sql->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);

        return $sql->execute();        

    }

    public function estadoLibro($libro_id, $activo){
        
        $consulta = "UPDATE libros 
                        SET activo = :activo
                        WHERE id = :libro_id ";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->bindValue(':activo', $activo, PDO::PARAM_INT);

        return $sql->execute();        

    }

    public function agregarEjemplar($libro_id, $codigo_topografico ){
        
        $consulta = "INSERT INTO ejemplares (libro_id, codigo_topografico) 
                     VALUES (:libro_id, :codigo_topografico) ";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->bindValue(':codigo_topografico', $codigo_topografico, PDO::PARAM_STR);

        return $sql->execute();        

    }

    public function agregarGenero($nombre) {

        $consulta = "INSERT INTO generos (nombre) 
                     VALUES (:nombre) ";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':nombre', $nombre, PDO::PARAM_STR);

        return $sql->execute();

    }

    public function agregarEditorial($nombre) {

        $consulta = "INSERT INTO editoriales (nombre) 
                     VALUES (:nombre) ";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':nombre', $nombre, PDO::PARAM_STR);

        return $sql->execute();

    }   

    public function agregarAutor($nombre, $apellido) {

        $consulta = "INSERT INTO autores (nombre, apellido) 
                     VALUES (:nombre, :apellido) ";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $sql->bindValue(':apellido', $apellido, PDO::PARAM_STR);

        return $sql->execute();

    }   
    public function antiguedadLibro($libro_id) {

        $consulta = "SELECT 
                        DATEDIFF(NOW(), l.fecha_alta ) AS dias_antiguedad 
                    FROM libros l
                    WHERE l.libro_id = :libro_id";

        $sql = $this->con->prepare($consulta);
        $sql->bindValue(':libro_id', $libro_id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchColumn();
    }   

    public function __destruct() {
        $this->con = null;
    }


 
}