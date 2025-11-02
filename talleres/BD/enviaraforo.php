<?php
session_start();
include('conexion.php');

$publicacion_id = $_POST['publicacion_id'];
$taller_id = $_POST['taller_id'];

$stmt = $conn->prepare("UPDATE publicaciones SET publico = 1 WHERE id = ?");
$stmt->bind_param("i", $publicacion_id);
$stmt->execute();

header("Location: ../foro_publico.php?taller_id=$taller_id");
exit();
?>