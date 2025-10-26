<?php

require_once './bd/conexion.php';

class Libro {
    
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
                                    AND a2.nombre LIKE :busqueda OR
                                    a2.apellido   LIKE :busqueda )";
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
            $sql->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
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
                                    AND a2.nombre LIKE :busqueda OR
                                    a2.apellido   LIKE :busqueda )";
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
            $sql->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
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


 
}