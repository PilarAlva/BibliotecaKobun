<?php



class ContactoBD extends Modelo{

    public function enviarCorreo($nombre, $email, $tel, $mensaje){
        
        $consulta = "INSERT INTO correos (nombre, email, telefono, consulta) VALUES (:nombre, :email, :tel, :mensaje)";

        $this->db->consulta($consulta);
        $this->db->unir(':nombre', $nombre);
        $this->db->unir(':email', $email);
        $this->db->unir(':tel', $tel);
        $this->db->unir(':mensaje', $mensaje);

        return $this->db->ejecutar();

    
    }



}   