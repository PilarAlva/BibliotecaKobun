<?php

include('BD/subirrecurso.php'); // carga conexión y listado de recursos

$taller_id = $_GET['id'] ?? 0;



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recursos del Taller</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .btn { padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .container { max-width: 700px; margin: auto; font-family: sans-serif; }
        .recurso { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Recursos del Taller</h2>

    <?php if ($is_profesor): ?>
    <!-- Formulario para agregar recurso -->
    <form method="post" action="BD/subirrecurso.php">
        <input type="hidden" name="taller_id" value="<?php echo htmlspecialchars($taller_id); ?>">
        <input type="text" name="titulo" placeholder="Título del recurso" required><br><br>
        <textarea name="cuerpo" placeholder="Contenido del recurso..." required></textarea><br><br>
        <button type="submit" class="btn">Agregar Recurso</button>
    </form>
    <hr>
    <?php endif; ?>

    <!-- Listado de recursos -->
    <?php
if ($recursos->num_rows > 0) {
    while ($row = $recursos->fetch_assoc()) {
        echo "<div class='recurso'>";
        echo "<h4>" . htmlspecialchars($row['titulo']) . "</h4>";
        echo "<p>" . nl2br(htmlspecialchars($row['cuerpo'])) . "</p>";
        echo "<small>Subido por " . htmlspecialchars($row['nombre'] . " " . $row['apellido']) . " el " . $row['fecha_publicacion'] . "</small>";
        echo "</div>";
    }
} else {
    echo "<p>No hay recursos disponibles.</p>";
}

$stmt->close();
$conn->close();
?>
</body>
</html>