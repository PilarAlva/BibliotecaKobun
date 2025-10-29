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
  

    // Route for a specific book page, maps to the 'bookId' metodo of 'Bookcontrolador'
    'book/id' => ['controlador' => 'Bookcontrolador', 'metodo' => 'bookById'],

    // Route for adding a new book, maps to the 'addBook' metodo of 'Bookcontrolador'
    'book/add' => ['controlador' => 'Bookcontrolador', 'metodo' => 'addNewBook'],

    // Route for deleting a book, maps to the 'delete' metodo of 'Bookcontrolador'
    'book/delete' => ['controlador' => 'Bookcontrolador', 'metodo' => 'deleteBook'],

    // Route for updating a book, maps to the 'update' metodo of 'Bookcontrolador'
    'book/update' => ['controlador' => 'Bookcontrolador', 'metodo' => 'updateBook']
];


?>