<?php

//Acá van todas las rutas, con el nombre del controlador
//que necesita cada página y al método que llaman de ese controaldor

$rutas = [
    // Route for the home page, maps to the 'index' metodo of 'Bookcontrolador'
    '' => ['controlador' => 'InicioCtrl', 'metodo' => 'inicio'],
    
    'inicio' => ['controlador' => 'InicioCtrl', 'metodo' => 'inicio'],

    'inicio/inicio' => ['controlador' => 'InicioCtrl', 'metodo' => 'inicio'],

    'catalogo' => ['controlador' => 'libroCtrl', 'metodo' => 'index'],

    'catalogo/b' => ['controlador' => 'libroCtrl', 'metodo' => 'busqueda'],

    'libro/id' => ['controlador' => 'libroCtrl', 'metodo' => 'mostrarLibro'],

    'libro/prestamo' => ['controlador' => 'prestamoCtrl', 'metodo' => 'prestamo'],
    
    'sesion' => ['controlador' => 'SesionCtrl', 'metodo' => 'index'],

    'talleres' => ['controlador' => 'tallerCtrl', 'metodo' => 'index'],
    
    'contacto' => ['controlador' => 'contactoCtrl', 'metodo' => 'index'],

    'perfil' => ['controlador' => 'perfilCtrl', 'metodo' => 'index'],

    'pago' => ['controlador' => 'pagoCtrl', 'metodo' => 'pago'],

    'pago/procesar' => ['controlador' => 'pagoCtrl', 'metodo' => 'procesarPago'],




    
];


?>