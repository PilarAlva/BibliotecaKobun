<?php

    class BaseDatos{
        private $host = BD_HOST;
        private $usuario = BD_USUARIO;
        private $clave = BD_CLAVE;
        private $bdNombre = BD_NOMBRE;
        private $puerto = BD_PUERTO;
        
        private $dbh;
        private $stmt;
        private $error;
        
        public function __construct(){

            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->bdNombre . ';port' . $this-> puerto;
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            try{
                $this->dbh = new PDO($dsn, $this->usuario, $this->clave, $options);
            }catch (PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        public function consulta($sql){

            $this->stmt = $this->dbh->prepare($sql);

        }
        public function ejecutar(){

            return $this->stmt->execute();

        }

        // public function emepzarTransaccion(){

        //     return $this->dbh->beginTransaction();

        // }
        // public function aceptarTransaccion(){

        //     return $this->dbh->commit();

        // }
        // public function eliminarTransaccion(){

        //     return $this->dbh->rollback();

        // }


        public function resultados(){

            $this->ejecutar();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        public function resultado(){

                $this->ejecutar();
                $result = $this->stmt->fetch(PDO::FETCH_ASSOC);

                if($result){
                    if(count($result) > 1){
                        return $result;
                    }else{
                        
                        return $result[array_key_first($result)];
                    }
                }
                return null; 

        }
        public function unico(){

            $this->ejecutar();
                return $this->stmt->fetchColumn();

        }
        public function unir($param, $valor){

            switch(gettype($valor)){
                case 'string':
                    $this->stmt->bindValue($param, $valor, PDO::PARAM_STR);
                    break;
                case 'integer':
                    $this->stmt->bindValue($param, $valor, PDO::PARAM_INT);
                    break;
                case 'bool':
                    $this->stmt->bindValue($param, $valor, PDO::PARAM_BOOL);
                    break;  
                default:
                    $this->stmt->bindValue($param, $valor);
                    break;
            }

            

        }
        public function ultimoId(){

            return $this->dbh->lastInsertId();

        }

        public function cerrarConexion(){
    
                $this->dbh = null;
    
        }   

        public function __destruct(){

            $this->cerrarConexion();

        }   
    }

?>