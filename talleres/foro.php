<?php
session_start();
include('BD/conexion.php');

$taller_id = $_GET['id'] ?? 0;


$sql = "SELECT p.id, p.titulo, p.cuerpo, p.fecha_publicacion,
               u.nombre, u.apellido
        FROM publicaciones p
        JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.taller_id = ? AND p.public = 1
        ORDER BY p.fecha_publicacion DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $taller_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Foro público</h2>";

echo '<div class="foro-publico">';

while($row = $result->fetch_assoc()) {
    echo "<div class='publicacion'>";
    echo "<p><strong>".htmlspecialchars($row['nombre']." ".$row['apellido'])."</strong> — ".$row['fecha_publicacion']."</p>";
    if (!empty($row['titulo'])) echo "<h4>".htmlspecialchars($row['titulo'])."</h4>";
    echo "<p>".nl2br(htmlspecialchars($row['cuerpo']))."</p>";

    
    if ($_SESSION['rol'] === 'profesor') {
        echo "<form method='post' action='../BD/borrar_publicacion.php'>
                <input type='hidden' name='publicacion_id' value='".$row['id']."'>
                <input type='hidden' name='taller_id' value='".$taller_id."'>
                <button type='submit' class='borrar'> Borrar</button>
              </form>";
    }

    echo "</div><hr>";
}
echo '</div>';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

    <form action="BD/subirpublicacion.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="taller_id" value="<?php echo $taller_id; ?>">
    <input type="hidden" name="public" value="1">
    <input type="text" name="titulo" placeholder="Título (opcional)" maxlength="100"><br>
    <textarea name="cuerpo" placeholder="Escribe tu mensaje..." required></textarea><br>
    <input type="file" name="archivo" accept=".jpg,.png,.pdf,.docx,.txt"><br>
    <button type="submit">Publicar</button>
</form>



</body>
</html>