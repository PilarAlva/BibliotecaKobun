<?php
session_start();

include('conexion.php'); // tu conexión a la base de datos



// BLOQUE DE SESIÓN DE PRUEBA
    // Usar un ID que exista en Usuarios
    $_SESSION['usuario_id'] = 7; // Cambialo según tu BD
    $_SESSION['rol_id'] = 2;     // 2 = profesor
    $_SESSION['nombre'] = "Marta";
    $_SESSION['apellido'] = "Gómez";




$is_profesor = ($_SESSION['rol_id'] == 2);

// Procesar formulario de recurso (solo profesor)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $is_profesor) {
    $taller_id = $_POST['taller_id'];
    $titulo = trim($_POST['titulo']);
    $cuerpo = trim($_POST['cuerpo']);
    $usuario_id = $_SESSION['usuario_id'];
    $fecha_publicacion = date('Y-m-d H:i:s');
    $public = 3; // valor 3 indica recurso

    $stmt = $conn->prepare("INSERT INTO publicaciones (taller_id, usuario_id, public, fecha_publicacion, titulo, cuerpo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $taller_id, $usuario_id, $public, $fecha_publicacion, $titulo, $cuerpo);

    if ($stmt->execute()) {
        // Redirigir al mismo recursos.php después de guardar
        header("Location: ../recursos.php?id=" . $taller_id);
        exit();
    } else {
        echo "Error al guardar el recurso: " . $stmt->error;
    }
    $stmt->close();

}

// Listar recursos del taller
$taller_id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT p.id, p.titulo, p.cuerpo, p.fecha_publicacion, u.nombre, u.apellido
                        FROM publicaciones p
                        JOIN usuarios u ON p.usuario_id = u.id
                        WHERE p.taller_id = ? AND p.public = 3
                        ORDER BY p.fecha_publicacion DESC");
$stmt->bind_param("i", $taller_id);
$stmt->execute();
$recursos = $stmt->get_result();
?>
