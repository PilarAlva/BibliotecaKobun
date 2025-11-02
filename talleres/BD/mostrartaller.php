<!-- este se encarga de realizar la consulta a la BD para sacar los datos del taller y de su profesor, para luego ponerlos de manera dinamica en un div que muestra todos los datos. -->

<?php
include('conexion.php');

$sql = "SELECT t.id, t.nombre AS taller_nombre, t.descripcion, t.lugar, t.horario, t.activo, 
               u.nombre AS profesor_nombre, u.apellido AS profesor_apellido
        FROM talleres t
        JOIN talleres_profesores tp ON t.id = tp.taller_id
        JOIN usuarios u ON tp.usuario_id = u.id
        ORDER BY t.id ASC";

$result = $conn->query($sql);

if($result->num_rows > 0) {
    echo '<div class="talleres-container">';
    while($row = $result->fetch_assoc()) {
        echo '<div class="taller">';
        echo '<h3>'.htmlspecialchars($row['taller_nombre']).'</h3>';
        echo '<p><strong>Profesor:</strong> '.htmlspecialchars($row['profesor_nombre'].' '.$row['profesor_apellido']).'</p>';
        echo '<p><strong>Lugar:</strong> '.htmlspecialchars($row['lugar']).'</p>';
        echo '<p><strong>Horario:</strong> '.htmlspecialchars($row['horario']).'</p>';
        echo '<p>'.htmlspecialchars($row['descripcion']).'</p>';
        echo '<h3><a href="taller.php?id='.$row['id'].'">'.htmlspecialchars($row['taller_nombre']).'</a></h3>';

        $estado = $row['activo'] ? 'Activo' : 'Inactivo';
        echo '<p><strong>Estado:</strong> '.$estado.'</p>';

        
        echo '<form method="post" action="BD/cambiarestado.php">';
        echo '<input type="hidden" name="taller_id" value="'.$row['id'].'">';
        echo '<input type="hidden" name="nuevo_estado" value="'.($row['activo'] ? 0 : 1).'">';
        echo '<button type="submit">'.($row['activo'] ? 'Desactivar' : 'Activar').'</button>';
        echo '</form>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p>No hay talleres disponibles.</p>';
}

$conn->close();
?>