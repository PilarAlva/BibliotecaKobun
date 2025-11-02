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
    echo "<div>".$row['cuerpo']."</div>";

    
    if ($_SESSION['rol_id'] == '2') {
        echo "<form method='post' action='../talleres/BD/borrarpublicacion.php' 'id='borrar'>
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="../talleres/Estilos/foro.css" />
    <title>Document</title>
</head>
<body>

    <form action="BD/subirpublicacion.php" method="post" enctype="multipart/form-data" id="publicacion">
    <input type="hidden" name="taller_id" value="<?php echo $taller_id; ?>">
    <input type="hidden" name="public" value="1">
    <label for="titulo">Título</label><br>
    <input type="text" name="titulo" placeholder="Título (opcional)" maxlength="100"><br>

    <label>Texto</label>
    <div id="editor"></div>
    <input type="hidden" name="cuerpo" id="cuerpo">

    <input type="file" name="archivo" accept=".jpg,.png,.pdf,.docx,.txt"><br>
    <button type="submit" id="publicar" >Publicar</button>

    </form>

    <script src="../talleres/JS/foro.js"></script>

</body>
</html>