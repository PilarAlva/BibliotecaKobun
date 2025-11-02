<?php
session_start();
include('BD/conexion.php');

$taller_id = $_GET['id'] ?? 0;
$usuario_id = 6; // $_SESSION['usuario_id'];



// Los escritos según usuario y taller
$sql = "SELECT id, titulo, cuerpo, fecha_publicacion
        FROM publicaciones
        WHERE taller_id = ? AND usuario_id = ? AND public = 0
        ORDER BY fecha_publicacion DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $taller_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Mi libreta personal</h2>";

echo '<div class="libreta">';
while($row = $result->fetch_assoc()) {
    echo "<div class='nota'>";
    if (!empty($row['titulo'])) echo "<h4>".htmlspecialchars($row['titulo'])."</h4>";
    echo "<p>".nl2br(htmlspecialchars($row['cuerpo']))."</p>";
    echo "<p><small>Guardado el ".$row['fecha_publicacion']."</small></p>";

    // Para subir al foro
    echo "<form method='post' action='../BD/enviaraforo.php'>
            <input type='hidden' name='publicacion_id' value='".$row['id']."'> 
            <input type='hidden' name='taller_id' value='".$taller_id."'>
            <button type='submit'>Publicar en foro</button>
          </form>";
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
    <input type="hidden" name="public" value="0">
    <input type="text" name="titulo" placeholder="Título (opcional)" maxlength="100"><br>
    <textarea name="cuerpo" placeholder="Escribe tu nota interna..." required></textarea><br>
    <button type="submit">Guardar nota</button>
</form>

</body>
</html>