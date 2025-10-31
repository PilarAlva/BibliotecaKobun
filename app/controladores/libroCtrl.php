<?php


class libroCtrl extends Controlador{
    
    

    public function index($filtro = '', $busqueda = '', $pagina = '1'){

        $cantidad_por_pagina = 20;

        $libroModel = $this->cargarModelo("libroBD");
        
        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;

        $libros = $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, $limite );

        $resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);

        $data = ["busqueda" => $busqueda,
                 "filtro" => $filtro,
                 "libros" => $libros,
                 "resultados" => $resultados,
                 "offset" => $offset,
                 "url_paginacion" => $this->urlPaginacion($filtro, $busqueda, $pagina),
                 "pagina" => $this->chequeoPagina($pagina),
                 "cantidad_paginas" => ceil($resultados / $cantidad_por_pagina) ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    }


    public function busqueda($filtro = '', $busqueda = '', $pagina = '1'){

        $cantidad_por_pagina = 20;

        $libroModel = $this->cargarModelo("libroBD");
        
        if($this->esEnteroPositivo($filtro)){
            $pagina = $filtro;
        }

        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;


        $libros = $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, $limite );

        $resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            header('Location: ' . BASE_URL . 'catalogo/b/' . $_POST['filtro'] . '/' . $_POST['q']);

        }

        
        

        $data = ["busqueda" => $busqueda,
                 "filtro" => $filtro,
                 "libros" => $libros,
                 "resultados" => $resultados,
                 "offset" => $offset,
                 "url_paginacion" => $this->urlPaginacion($filtro, $busqueda, $pagina),
                 "pagina" => $this->chequeoPagina($pagina),
                 "cantidad_paginas" => ceil($resultados / $cantidad_por_pagina) ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    }

       public function mostrarLibro($libro_id = '1'){
        
        $libroModel = $this->cargarModelo("libroBD");

        $libro = $libroModel->infoLibro($libro_id);

        $ejemplares = $libroModel->ejemplaresTotales($libro_id);

        $data = [
            "libro" => $libro,
            "ejemplares" => $ejemplares
            
        ];

        $this->mostrarVista('Libro', $data, $libro['titulo']);

    }

    private function chequeoPagina($pagina){
        if (!$this->esEnteroPositivo($pagina) || (int)$pagina < 1) {
            return 1;
        }
        return (int)$pagina;
    }

    private function urlPaginacion($filtro, $busqueda, $pagina) {

        if($filtro == '' || $busqueda == '') {
            return BASE_URL . 'catalogo/b/';
        }

        return BASE_URL . 'catalogo/b/' . $filtro . '/' . urlencode($busqueda) . '/';
    }

    private function esEnteroPositivo($string) {
        return preg_match('/^\d+$/', $string);
    }

}

