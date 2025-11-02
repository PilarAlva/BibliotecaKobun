<?php
session_start();
include('conexion.php');

if ($_SESSION['rol_id'] != 3) {
    die("No autorizado.");
}

$taller_id = $_POST['taller_id'];
$usuario_id = $_POST['usuario_id'];

$stmt = $conn->prepare("DELETE FROM Talleres_Usuarios WHERE taller_id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $taller_id, $usuario_id);

if ($stmt->execute()) {
    header("Location:../alumnos.php?taller_id={$taller_id}");
} else {
    echo "Error al eliminar: " . $stmt->error;
}
?>