<?php


class libroCtrl extends Controlador{
    
    

    public function index($filtro = '', $busqueda = '', $pagina = '1'){

        $cantidad_por_pagina = 20;

        $libroModel = $this->cargarModelo("libroBD");
        
        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;

        $libros = $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, $cantidad_por_pagina );

        $resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);

        $pagina = $this->chequeoPagina($pagina);
        $cantidad_paginas = ceil($resultados / $cantidad_por_pagina);

        $data = [
                "cssEspecifico" => "catalogo.css",
                 "busqueda" => $busqueda,
                 "filtro" => $filtro,
                 "libros" => $libros,
                 "resultados" => $resultados,
                 "offset" => $offset,
                 "url_paginacion" => $this->urlPaginacion($filtro, $busqueda, $pagina),
                 "pagina" => $pagina,
                 "cantidad_paginas" => $cantidad_paginas,
                 "paginas_mostrar" => $this->quePaginasMostrar($pagina, $cantidad_paginas) ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    }


    public function busqueda($filtro = '', $busqueda = '', $pagina = '1'){

        $cantidad_por_pagina = 20;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            /*$busqueda = htmlspecialchars();
            $filtro = htmlspecialchars(,  );*/
            $busqueda = $_POST['q'];
            $filtro = $_POST['filtro'];
            
            
            $busqueda = str_replace(' ', '_', $busqueda);
            $filtro = str_replace(' ', '_', $filtro);

            header('Location: ' . BASE_URL . 'catalogo/b/' . $filtro . '/' . $busqueda );

        }

        $busqueda = str_replace('_', ' ', $busqueda);
        $filtro =  str_replace('_', ' ', $filtro);


        $libroModel = $this->cargarModelo("libroBD");
        
        if($this->esEnteroPositivo($filtro)){
            $pagina = $filtro;
        }else{
            $pagina = 1;
        }

        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;



        $libros = $libroModel->busquedaCatalogo($busqueda, $filtro, $offset, $cantidad_por_pagina );

        $resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);

       
  
        $pagina = $this->chequeoPagina($pagina);
        $cantidad_paginas = ceil($resultados / $cantidad_por_pagina);

        $data = ["cssEspecifico" => "catalogo.css",
                 "busqueda" => $busqueda,
                 "filtro" => $filtro,
                 "libros" => $libros,
                 "resultados" => $resultados,
                 "offset" => $offset,
                 "url_paginacion" => $this->urlPaginacion($filtro, $busqueda, $pagina),
                 "pagina" => $pagina,
                 "cantidad_paginas" => $cantidad_paginas,
                 "paginas_mostrar" => $this->quePaginasMostrar($pagina, $cantidad_paginas) ];

        $this->mostrarVista('catalogo', $data, 'Catalogo');

    }

    public function mostrarLibro($libro_id = '1'){
        
        $libroModel = $this->cargarModelo("libroBD");
        $pagoModel = $this->cargarModelo("pagoDB");

        $libro = $libroModel->infoLibro($libro_id);

        $ejemplares = $libroModel->ejemplaresTotales($libro_id);
        
        if($this->esSocio($this->usuarioRegistrado())){
            $socio = $this->esSocio($this->usuarioRegistrado());
            $estadoCuenta = $pagoModel->estadoCuenta($socio["id"]);   
        }
        

        $data = [
            "es_socio" => $this->esSocio($this->usuarioRegistrado()),
            "estadoCuenta" => isset($estadoCuenta) ? $estadoCuenta : null,
            "libro" => $libro,
            "cantidad" => $libroModel->cantidadDisponible($libro_id),
            "ejemplares" => $ejemplares,
            "cssEspecifico" => ['catalogo.css','libro.css'] // Usamos el mismo CSS que el catálogo
        ];


        $this->mostrarVista('Libro', $data, $libro['titulo']);

    }


    //Funciones utilitarias

    private function esSocio($usuario_id){  
        
        $socioModel = $this->cargarModelo("socioBD");

        return $socioModel->obtenerSocioPorIdUsuario($usuario_id);

    }

    private function quePaginasMostrar($pagina, $cantidad_paginas){

        $numero_paginas = [1];

        $inico = 1;
        $fin = $cantidad_paginas;

		if($cantidad_paginas == 1){
			return $numero_paginas;
		}
		if($pagina == 1){
			$inicio_paginas = $pagina;
	        $fin_paginas = $pagina + 4;
		}else if($pagina == $cantidad_paginas){
			$inicio_paginas = $pagina - 4 ;
	        $fin_paginas = $pagina;
		}else{
	        $inicio_paginas = $pagina - 2;
	        $fin_paginas = $pagina + 2;
			
		}
		

        for($i = $inicio_paginas; $i <= $fin_paginas; $i++){
            if($i > 1 && $i < $cantidad_paginas){
                $numero_paginas[] = $i;
            }
        }
        
		array_push($numero_paginas, $fin);

        return $numero_paginas;
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
