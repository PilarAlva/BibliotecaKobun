<?php

// Call model
require_once "./modelo/libroBD.php";

$libroModel = new LibroBD();

$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'titulo';

$libros = $libroModel->busquedaCatalogo($busqueda, $filtro, 0, 5);
$resultados = $libroModel->cantResultadosCatalogo($busqueda, $filtro);


// Call the view
require_once "vistas/catalogo.php";