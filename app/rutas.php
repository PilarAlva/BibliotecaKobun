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

    'publicacion' => ['controlador' => 'publicacionCtrl', 'metodo' => 'index'],

    'publicacion/editar' => ['controlador' => 'publicacionCtrl', 'metodo' => 'editar'],

    'libro/prestamo' => ['controlador' => 'prestamoCtrl', 'metodo' => 'prestamo'],
    
    'sesion' => ['controlador' => 'SesionCtrl', 'metodo' => 'index'],

    'sesion/cerrar' => ['controlador' => 'SesionCtrl', 'metodo' => 'cerrar_sesion'],

    'talleres' => ['controlador' => 'tallerCtrl', 'metodo' => 'index'],

    'taller/info' => ['controlador' => 'tallerCtrl', 'metodo' => 'mostrarInfoTaller'],

    'taller/id' => ['controlador' => 'tallerCtrl', 'metodo' => 'taller'],

    'taller/ins' => ['controlador' => 'tallerCtrl', 'metodo' => 'inscripcion'],

    'taller/editar' => ['controlador' => 'tallerCtrl', 'metodo' => 'editar'],

    'ins/eliminar' => ['controlador' => 'tallerCtrl', 'metodo' => 'eliminarAlumno'],

    'ins/rechazar' => ['controlador' => 'tallerCtrl', 'metodo' => 'rechazarAlumno'],

    'ins/aceptar' => ['controlador' => 'tallerCtrl', 'metodo' => 'aceptarAlumno'],

    'contacto' => ['controlador' => 'contactoCtrl', 'metodo' => 'index'],

    'contacto/enviar' => ['controlador' => 'contactoCtrl', 'metodo' => 'enviar'],

    'perfil' => ['controlador' => 'perfilCtrl', 'metodo' => 'index'],

    'perfil/editar' => ['controlador' => 'perfilCtrl', 'metodo' => 'editar'],

    'pago' => ['controlador' => 'pagoCtrl', 'metodo' => 'pago'],

    'pago/procesar' => ['controlador' => 'pagoCtrl', 'metodo' => 'procesarPago'],

    'archivo' => ['controlador' => 'archivoCtrl', 'metodo' => 'inicio'],

    'archivo/id' => ['controlador' => 'archivoCtrl', 'metodo' => 'descargar'],

    'archivo/subir' => ['controlador' => 'archivoCtrl', 'metodo' => 'subir'],

    'archivo/lista' => ['controlador' => 'archivoCtrl', 'metodo' => 'lista'],

    'peticion' => ['controlador' => 'peticionCtrl', 'metodo' => 'peticion'],




    
];


?>