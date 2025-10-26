<?php

require_once "../bd/conexion.php";

class Libro {
    
    private $con;

    public function __construct() {
        
        $db = new Database();
        $this->con = $db->conectar();

    }

    

    public busquedaCatalogo($busqueda, $filtro, $inicio = 0, $cant = 1000){

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

        if ($buscar != '') {
        
        switch ($filtro) {
            case 'autor':
                $consulta .= "AND EXISTS (
                                SELECT 1 
                                FROM libros_autores la2 
                                INNER JOIN autores a2 ON la2.autor_id = a2.id 
                                WHERE la2.libro_id = l.id 
                                    AND a2.nombre LIKE :buscar OR
                                    a2.apellido   LIKE :buscar )";
                break;
            case 'genero':
                $consulta .= " AND EXISTS (
                                SELECT 1 
                                FROM libros_generos lg2 
                                INNER JOIN generos g2 ON lg2.libro_id = g2.id 
                                WHERE lg2.libro_id = l.id 
                                    AND g2.nombre LIKE :buscar )";
                break;
            case 'editorial':
                $consulta .= " AND EXISTS (
                                SELECT 1 
                                FROM libros_editoriales le2 
                                INNER JOIN editoriales e2 ON le2.libro_id = e2.id 
                                WHERE le2.libro_id = l.id 
                                    AND e2.nombre LIKE :buscar )";
                break;
            case 'isbn':
                $consulta .= " AND l.isbn LIKE :buscar";
                break;    
            case 'descripcion':
                $consulta .= " AND l.descripcion LIKE :buscar";
                break;    
            case 'titulo':
            default:
                $consulta .= " AND l.titulo LIKE :buscar";
                break;
            }

        
        }

        $consulta .= " GROUP BY l.id ORDER BY l.titulo ASC LIMIT :limite OFFSET :offset";

        $sql = $con->prepare($consulta);

        if ($buscar != '') {
            $sql->bindValue(':buscar', "%$buscar%", PDO::PARAM_STR);
        }

        $sql->bindValue(':limite', $cant,   PDO::PARAM_INT);
        $sql->bindValue(':offset', $inicio, PDO::PARAM_INT);

        $sql->execute(); 

        return $sql->fetchAll(PDO::FETCH_ASSOC);

    
    }

    public static function getAllProducts() {
        $db = DBConexion::connection();
        $data = $db->query("SELECT cod, short_name, nombre, pvp FROM products");
        $products = array();

        while ( $row = $data->fetch_assoc() ) {
            $product = new Product($row);
            $products[] = $product;
        }

        return $products;
    }

    public function getProductName() {
        return $this->name;
    }

    public function getProductCode() {
        return $this->cod;
    }

    public function getProductShortName() {
        return $this->short_name;
    }

    public function getProductPvp() {
        return $this->pvp;
    }
}