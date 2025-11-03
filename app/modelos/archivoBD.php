<?php



class ArchivoBD extends Modelo{

    public function obtenerArchivos(){
        
        $consulta = "SELECT * FROM archivos";

        $this->db->consulta($consulta);

        return $this->db->resultados();

    }

    public function obtenerArchivoPorId($id){
        
        $consulta = "SELECT * FROM archivos WHERE id = :id LIMIT 1";

        $this->db->consulta($consulta);
        $this->db->unir(':id', $id);

        return $this->db->resultado();

    }

    public function registrarArchivo($referencia, $titulo ){
        
        $consulta = "INSERT INTO archivos (titulo, referencia ) 
                    VALUES (:titulo, :referencia )";  
                    
        $this->db->consulta($consulta);
        $this->db->unir(':titulo', $titulo);    
        $this->db->unir(':referencia', $referencia);

        return $this->db->ejecutar();   
        

    }

}   