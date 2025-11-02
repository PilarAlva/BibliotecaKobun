<?php
session_start();
include('BD/conexion.php');

// 🔹 Hardcode sesión de prueba si no hay login
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario_id'] = 6; // usuario de prueba
    $_SESSION['rol_id'] = 3;     // profesor
    $_SESSION['nombre'] = "Juan";
    $_SESSION['apellido'] = "Pérez";
}

$taller_id = $_GET['id'] ?? 0;
if (!$taller_id) {
    echo "Taller no válido";
    exit();
}



if ($_SESSION['rol_id'] == 3) {
    $prof_check = $conn->prepare("SELECT 1 FROM Talleres_Profesores WHERE taller_id = ? AND usuario_id = ?");
    $prof_check->bind_param("ii", $taller_id, $_SESSION['usuario_id']);
    $prof_check->execute();
    $prof_check->store_result();
    $is_profesor = $prof_check->num_rows > 0;
    $prof_check->close();
}



// 🔹 Alumnos activos
$stmt = $conn->prepare("SELECT u.id, u.nombre, u.apellido, u.mail
                        FROM Talleres_Usuarios tu
                        JOIN Usuarios u ON tu.usuario_id = u.id
                        WHERE tu.taller_id = ? AND tu.activo = 1");
$stmt->bind_param("i", $taller_id);
$stmt->execute();
$alumnos_activos = $stmt->get_result();
$stmt->close();

// 🔹 Solicitudes pendientes
$stmt = $conn->prepare("SELECT u.id, u.nombre, u.apellido, u.mail
                        FROM Talleres_Usuarios tu
                        JOIN Usuarios u ON tu.usuario_id = u.id
                        WHERE tu.taller_id = ? AND tu.activo = 0");
$stmt->bind_param("i", $taller_id);
$stmt->execute();
$solicitudes = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Alumnos del Taller</title>
<style>
    .alumno { margin-bottom: 10px; }
    .btn { padding: 4px 10px; margin-left: 5px; cursor: pointer; }
</style>
</head>
<body>
<h2>Alumnos Activos</h2>
<div class="alumnos-activos">
    <?php
    if ($alumnos_activos->num_rows > 0) {
        while ($row = $alumnos_activos->fetch_assoc()) {
            echo "<div class='alumno'>";
            echo htmlspecialchars($row['nombre']." ".$row['apellido']." (".$row['mail'].")");
            echo "<form method='post' action='BD/eliminaralumno.php' style='display:inline;'>
                    <input type='hidden' name='taller_id' value='$taller_id'>
                    <input type='hidden' name='usuario_id' value='".$row['id']."'>
                    <button type='submit' class='btn'>Eliminar</button>
                  </form>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay alumnos activos.</p>";
    }
    ?>
</div>

<h2>Solicitudes Pendientes</h2>
<div class="solicitudes">
    <?php
    if ($solicitudes->num_rows > 0) {
        while ($row = $solicitudes->fetch_assoc()) {
            echo "<div class='alumno'>";
            echo htmlspecialchars($row['nombre']." ".$row['apellido']." (".$row['mail'].")");
            echo "<form method='post' action='BD/aprobaralumno.php' style='display:inline;'>
                    <input type='hidden' name='taller_id' value='$taller_id'>
                    <input type='hidden' name='usuario_id' value='".$row['id']."'>
                    <button type='submit' class='btn'>Aceptar</button>
                  </form>";
            echo "<form method='post' action='BD/eliminaralumno.php' style='display:inline;'>
                    <input type='hidden' name='taller_id' value='$taller_id'>
                    <input type='hidden' name='usuario_id' value='".$row['id']."'>
                    <button type='submit' class='btn'>Rechazar</button>
                  </form>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay solicitudes pendientes.</p>";
    }
    ?>
</div>

<a href="taller.php?id=<?php echo $taller_id; ?>">Volver al Taller</a>
</body>
</html>