<?php

require_once '../app/core/BaseDatos.php';


class UsuarioBD {
    
    private $db;

    public function __construct() {
        
        $this->db = new BaseDatos();

    }

    public function obtenerDatosContacto($usuario_id){
        $consulta = "SELECT 
                    concat(u.nombre, ' ', u.apellido) as usuario_nombre,
                    u.mail as usuario_mail,
                    IFNULL(s.telefono, '') as usuario_telefono
                    FROM usuarios u
                    LEFT JOIN socios s ON u.id = s.usuario_id
                    WHERE u.id = :usuario_id";

        $this->db->consulta($consulta);
    
        $this->db->unir(':usuario_id', $usuario_id);
    
        return $this->db->resultado();
    }
    public function editarNombreApellido($usuario_id, $nombre, $apellido){
        $consulta = 'UPDATE usuarios SET nombre = :nombre, apellido = :apellido WHERE id = :usuario_id';

        $this->db->consulta($consulta);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':nombre', $nombre);
        $this->db->unir(':apellido', $apellido);

        return $this->db->ejecutar();

    }

    public function obtenerUsuarioPorMail($mail){

        $consulta = "SELECT * FROM  usuarios WHERE mail = :mail";

        $this->db->consulta($consulta);
        $this->db->unir("mail", $mail);
        $this->db->ejecutar();

        return $this->db->resultado();

    }
    public function obtenerUsuarioPorId($usuario_id){

        $consulta = "SELECT * FROM  usuarios WHERE id = :usuario_id";

        $this->db->consulta($consulta);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }
    public function borrarUsuario($usuario_id){

        $consulta = "DELETE FROM usuarios WHERE id = :usuario_id AND rol_id != 1";
        $this->db->consulta($consulta);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->ejecutar();

    }
    public function obtenerInfoCompletaUsuarioPorId($usuario_id){

         $consulta = "SELECT 
                        u.id as usuario_id,
                        s.id as socio_id,
                        u.rol_id,
                        u.nombre,
                        u.apellido,
                        u.mail,
                        u.clave,
                        u.img_perfil,
                        s.telefono,
                        s.dni,
                        s.fecha_nacimiento,
                        s.fecha_alta
                    FROM  usuarios u 
                    LEFT JOIN socios s ON u.id = s.usuario_id
                    WHERE u.id = :usuario_id";

        $this->db->consulta($consulta);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }
    public function obtenerRolUsuario($usuario_id){

        $consulta = "SELECT rol_id FROM  usuarios WHERE id = :usuario_id";

        $this->db->consulta($consulta);
        $this->db->unir("usuario_id", $usuario_id);
        $this->db->ejecutar();

        return $this->db->resultado();

    }

    public function obtenerTodosUsuarios(){
        
        $consulta = "SELECT * FROM usuarios WHERE rol_id != 0";

        $this->db->consulta($consulta);

        return $this->db->resultados();

    }

    public function obtenerUsuarios(){
        
        $consulta = "SELECT * FROM usuarios WHERE rol_id = 3";

        $this->db->consulta($consulta);
        $this->db->ejecutar();

        return $this->db->resultados();

    }
    public function obtenerProfesores(){

        $consulta = "SELECT * FROM usuarios WHERE rol_id = 2";

        $this->db->consulta($consulta);
        $this->db->ejecutar();

        return $this->db->resultados();

    }   

    public function cantResultadosBusqueda($busqueda, $filtro){

        $consulta = "SELECT
                    COUNT(u.id) as cantidad
                    FROM usuarios u 
                    LEFT JOIN socios s ON u.id = s.usuario_id ";

        if ($busqueda != '') {
            
            switch ($filtro) {
                case 'usuario-gral':
                    $consulta .= "WHERE u.rol_id = 3 ";
                    break;
                case 'socios':
                    $consulta .= "WHERE s.id IS NOT NULL ";
                    break;
                case 'profesores':
                    $consulta .= "WHERE u.rol_id = 2 ";
                    break;
                case 'administrador':
                    $consulta .= "WHERE u.rol_id = 1 ";
                default:
                    $consulta .= " ";
                    break;    
                }
            $consulta .= " AND (u.nombre LIKE :busqueda_nombre OR u.apellido LIKE :busqueda_apellido)";
        
        }


        $this->db->consulta($consulta);

        if ($busqueda != '') {
                $this->db->unir(':busqueda_nombre', "%$busqueda%");
                $this->db->unir(':busqueda_apellido', "%$busqueda%");
            
            }

        $this->db->ejecutar(); 

        return $this->db->resultado();

    }
    public function busquedaUsuarios($busqueda, $filtro, $inicio = 0, $cant = 1000){

        $consulta = "SELECT
                    u.id,
                    u.nombre,
                    u.apellido,
                    u.mail,
                    u.rol_id,
                    u.img_perfil,
                    s.id as socio_id
                    FROM usuarios u 
                    LEFT JOIN socios s ON u.id = s.usuario_id ";

        if ($busqueda != '') {
            
            switch ($filtro) {
                case 'usuario-gral':
                    $consulta .= "WHERE u.rol_id = 3  ";
                    break;
                case 'socios':
                    $consulta .= "WHERE s.id IS NOT NULL  ";
                    break;
                case 'profesores':
                    $consulta .= "WHERE u.rol_id = 2  ";
                    break;
                case 'administrador':
                    $consulta .= "WHERE u.rol_id = 1  ";
                default:
                    $consulta .= " WHERE u.rol_id != 0  ";
                    break;    
                }
            $consulta .= " AND (u.nombre LIKE :busqueda_nombre OR u.apellido LIKE :busqueda_apellido) ";
        
        }

        $consulta .= " GROUP BY u.id ORDER BY u.id ASC LIMIT :limite OFFSET :offset";

        $this->db->consulta($consulta);

        if ($busqueda != '') {
                $this->db->unir(':busqueda_nombre', "%$busqueda%");
                $this->db->unir(':busqueda_apellido', "%$busqueda%");
            
            }

        $this->db->unir(':limite', $cant);
        $this->db->unir(':offset', $inicio);

        $this->db->ejecutar(); 

        return $this->db->resultados();
    
    }
    public function registrarUsuario($nombre, $apellido, $mail, $clave){

        $consulta = "INSERT INTO usuarios (nombre, apellido, mail, clave) VALUES (:nombre, :apellido, :mail, :clave)";

        $this->db->consulta($consulta);

        $this->db->unir("nombre", $nombre);
        $this->db->unir("apellido", $apellido);
        $this->db->unir("mail", $mail);
        $this->db->unir("clave", $clave);

        

        return $this->db->ejecutar();

    }
    public function registrarProfesor($nombre, $apellido, $mail, $clave){

        $consulta = "INSERT INTO usuarios (rold_id, nombre, apellido, mail, clave) 
                    VALUES (2, :nombre, :apellido, :mail, :clave)";

        $this->db->consulta($consulta);

        $this->db->unir("nombre", $nombre);
        $this->db->unir("apellido", $apellido);
        $this->db->unir("mail", $mail);
        $this->db->unir("clave", $clave);

        $this->db->ejecutar();

        return $this->db->resultado();

    }


    /* 
    public function busquedaUsuarios ( ) {
        
    } */



    public function cambiarRolUsuario($usuario_id, $rol_id){

        $consulta = "UPDATE usuarios SET rol_id = :rol_id WHERE id = :usuario_id";
        
        $this->db->consulta($consulta);
        $this->db->unir("usuario_id", $usuario_id); 
        $this->db->unir("rol_id", $rol_id);

       

        return $this->db->ejecutar();

    }

    public function actualizarImagenPerfil($usuario_id, $ruta_imagen){
        $consulta = 'UPDATE usuarios SET img_perfil = :ruta_imagen WHERE id = :usuario_id';

        $this->db->consulta($consulta);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':ruta_imagen', $ruta_imagen);

        return $this->db->ejecutar();
    }

    public function actualizarMail($usuario_id, $mail){
        $consulta = 'UPDATE usuarios SET mail = :mail WHERE id = :usuario_id';

        $this->db->consulta($consulta);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':mail', $mail);

        return $this->db->ejecutar();
    }

    public function actualizarClave($usuario_id, $clave){
        $consulta = 'UPDATE usuarios SET clave = :clave WHERE id = :usuario_id';

        $this->db->consulta($consulta);
        $this->db->unir(':usuario_id', $usuario_id);
        $this->db->unir(':clave', $clave);

        return $this->db->ejecutar();
    }

    public function __destruct() {
        $this->db->cerrarConexion();
    }


}
?>