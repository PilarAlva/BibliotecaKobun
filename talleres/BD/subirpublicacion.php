<?php
session_start();
include('conexion.php');

// Verificar que el usuario esté logueado
// if (!isset($_SESSION['usuario_id'])) {
//     echo "Debes iniciar sesión para publicar.";
//     exit();
// }

// Solo procesar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = 6; // $_SESSION['usuario_id'];
    $taller_id = $_POST['taller_id'] ?? 0;
    $titulo = trim($_POST['titulo'] ?? '');
    $cuerpo = trim($_POST['cuerpo'] ?? '');
    $fecha_publicacion = date('Y-m-d H:i:s');

    
    $publico = isset($_POST['public']) ? intval($_POST['public']) : 0;

    
    $archivo_nombre = null;

    // Validación básica
    if ($taller_id == 0 || empty($cuerpo)) {
        echo "Error: faltan datos requeridos.";
        exit();
    }

    // Inserción segura con prepared statement
    $sql = "INSERT INTO publicaciones (taller_id, usuario_id, `public`, fecha_publicacion, titulo, cuerpo)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisss", $taller_id, $usuario_id, $publico, $fecha_publicacion, $titulo, $cuerpo);

    if ($stmt->execute()) {
        echo "Publicación agregada correctamente.";
    } else {
        echo "Error al guardar la publicación: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>