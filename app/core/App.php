<?php

class App{

    protected $controlador = 'InicioCtrl';

    protected $metodo = 'incio';

    protected $params = [];

    public function __construct(){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $urlParts = $this->convertirUrl();

        require_once '../app/rutas.php';

        if(isset($urlParts[0])){

            $ruta = $urlParts[0];
            
        }

        if(isset($urlParts[1])){

            $ruta = $urlParts[0] . '/' . $urlParts[1];

        }

        if(isset($rutas[$ruta])){

            $this->controlador = $rutas[$ruta]['controlador'];

            $this->metodo = $rutas[$ruta]['metodo'];

            $this->params = array_slice($urlParts, 2);

        }else{

            echo "404 - URL erroneo crack!";
            return;

        }

        require_once '../app/controladores/' . $this->controlador . '.php';

        $this->controlador = new $this->controlador;

        call_user_func_array([$this->controlador, $this->metodo], $this->params);

    }

    private function convertirUrl(){

        if(isset($_GET['url'])){
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

        return [''];

    }

}


?>