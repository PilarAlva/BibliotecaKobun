<?php


class libroCtrl extends Controlador{
    

    

    public function index(){

    
        $libroModel = $this->cargarModelo("libroBD");
        
        $busqueda = isset($_POST['busqueda']) ? trim($_POST['busqueda']) : '';
        $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'titulo';

        $libros = $libroModel->busquedaCatalogo($busqueda, $filtro, 0, 5);
        $resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);

        $data = ["libros" => $libros,
                 "resultados" => $resultados ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    
    }

    public function busqueda($filtro = '', $busqueda = '', $pagina = '1'){

        $cantidad_por_pagina = 20;

        $libroModel = $this->cargarModelo("libroBD");
        
        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;

        $libros = $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, $limite );
        $resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);

        $data = ["libros" => $libros,
                 "resultados" => $resultados,
                 "cantidad_paginas" => ceil($resultados / $cantidad_por_pagina) ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    }


    



}

