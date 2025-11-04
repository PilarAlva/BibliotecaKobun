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

        public function resultados(){

            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        public function resultado(){

                $this->ejecutar();
                return $this->stmt->fetch(PDO::FETCH_ASSOC);

        }
        public function unir($param, $valor){

            $this->stmt->bindValue($param, $valor);

        }

    }

?>