<?php
session_start();
include('../BD/conexion.php');

// Solo profesores pueden aprobar
if ($_SESSION['rol_id'] != 3) {
    die("No autorizado.");
}

$taller_id = $_POST['taller_id'] ?? 0;
$usuario_id = $_POST['usuario_id'] ?? 0;

if (!$taller_id || !$usuario_id) {
    die("Datos incompletos.");
}

// Actualiza el estado a activo
$stmt = $conn->prepare("UPDATE talleres_usuarios SET activo = 1 WHERE taller_id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $taller_id, $usuario_id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../alumnos.php?id={$taller_id}");
    exit();
} else {
    echo "Error al aprobar: " . $stmt->error;
}
?>