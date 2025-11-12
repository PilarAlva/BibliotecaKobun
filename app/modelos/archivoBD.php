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

        $ultimo_id = 1;
        if($this->db->ejecutar()){
            $ultimo_id = $this->db->ultimoId();
        }
        return $ultimo_id;   
        

    }
    public function borrarArchivo($id){
        
        $consulta = "DELETE FROM archivos WHERE id = :id";

        $this->db->consulta($consulta);
        $this->db->unir(':id', $id);

        return $this->db->ejecutar();   
        

    }



}   