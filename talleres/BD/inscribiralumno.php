<?php
session_start();
include('conexion.php');

$taller_id = $_POST['taller_id'];
$usuario_id = 7; // $_SESSION['usuario_id'];


// Verificar si ya está inscripto
$check = $conn->prepare("SELECT COUNT(*) FROM talleres_usuarios WHERE taller_id = ? AND usuario_id = ?");
$check->bind_param("ii", $taller_id, $usuario_id);
$check->execute();
$check->bind_result($yaExiste);
$check->fetch();
$check->close();

if ($yaExiste > 0) {
    header("Location: ../taller.php?id={$taller_id}");
    echo"Ya estás inscripto";
    exit();
}

var_dump($_POST);


// Insertar con activo = 0 (pendiente)
$stmt = $conn->prepare("INSERT INTO talleres_usuarios (taller_id, usuario_id, activo) VALUES (?, ?, 0)");
$stmt->bind_param("ii", $taller_id, $usuario_id);

if ($stmt->execute()) {
    header("Location: ../taller.php?id={$taller_id}");
    exit();
} else {
    echo "Error al inscribirse: " . $stmt->error;
}
?>