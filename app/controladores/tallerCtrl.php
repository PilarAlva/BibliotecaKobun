<?php

    class TallerCtrl extends Controlador{

       public function index($pagina = '1'){
        
        $cantidad_por_pagina = 20;

        $tallerModel = $this->cargarModelo("tallerBD");
        
        $offset = ( ((int)$pagina) - 1) * $cantidad_por_pagina;
        $limite = $offset + $cantidad_por_pagina;

        $talleres = $tallerModel->obtenerTalleres(0, 10);
        $resultados = $tallerModel->cantTalleres();


        $data = ["talleres" => $talleres,
                 "resultados" => $resultados,
                 "offset" => $offset,
                 "url_paginacion" => $this->urlPaginacion('', '', $pagina),
                 "pagina" => $this->chequeoPagina($pagina),
                 "cantidad_paginas" => ceil(10 / $cantidad_por_pagina) ];


        $this->mostrarVista('talleres', $data, 'Talleres');
            

    }
    private function chequeoPagina($pagina){
        if (!$this->esEnteroPositivo($pagina) || (int)$pagina < 1) {
            return 1;
        }
        return (int)$pagina;
    }

    private function urlPaginacion($filtro = '', $busqueda = '', $pagina) {

        if($filtro == '' || $busqueda == '') {
            return BASE_URL . 'talleres/b/';
        }

        return BASE_URL . 'talleres/b/' . $filtro . '/' . urlencode($busqueda) . '/';
    }

    private function esEnteroPositivo($string) {
        return preg_match('/^\d+$/', $string);
    }


    }


