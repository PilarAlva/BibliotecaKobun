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
                 "pagina" => $pagina,
                 "cantidad_paginas" => ceil($resultados / $cantidad_por_pagina) ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    }

    public function busqueda($filtro = '', $busqueda = '', $pagina = '1'){



        $cantidad_por_pagina = 20;

        $libroModel = $this->cargarModelo("libroBD");
        
        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;

        $libros = $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, $limite );
        $resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Update the book with the given ID using data from the POST request
            //$bookModel->update($id, $_POST['title'], $_POST['author'], $_POST['isbn']);
            // Redirect to the books list page
            header('Location: ' . BASE_URL . 'catalogo/b/' . $_POST['filtro'] . '/' . $_POST['q']);
        }

        $data = ["busqueda" => $busqueda,
                 "filtro" => $filtro,
                 "libros" => $libros,
                 "resultados" => $resultados,
                 "offset" => $offset,
                 "pagina" => $pagina,
                 "cantidad_paginas" => ceil($resultados / $cantidad_por_pagina) ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    }

}

