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



    public function cambiarRolUsuario($usuario_id, $rol_id){

        $consulta = "UPDATE usuarios SET rol_id = :rol_id WHERE id = :usuario_id";
        
        $this->db->consulta($consulta);
        $this->db->unir("usuario_id", $usuario_id); 
        $this->db->unir("rol_id", $rol_id);

        $this->db->ejecutar();

        return $this->db->resultado();

    }

    public function __destruct() {
        $this->db->cerrarConexion();
    }


}
?>