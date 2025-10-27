<?php

// Call model
require_once "./modelo/libroBD.php";

$libroModel = new LibroBD();

// Example of fetching books. You can make $busqueda and $filtro dynamic,
// for example, by getting them from $_GET parameters.
$busqueda = 'garcia'; // Empty search will get all books
$filtro = 'autor';

$libros = $libroModel->busquedaCatalogo($busqueda, $filtro);

// Call the view
require_once "vistas/catalogo.php";