<?php
session_start();
include('BD/conexion.php');

// 🔧 Datos de sesión de prueba si aún no está vinculado al login
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario_id'] = 7; // usuario de ejemplo
    $_SESSION['rol_id'] = 2;     // usuario común
    $_SESSION['nombre'] = "Marta";
    $_SESSION['apellido'] = "Gómez";
}

$taller_id = $_GET['id'] ?? 0;
if (!$taller_id) {
    echo "Taller no válido";
    exit();
}

// 🧠 Consultar datos del taller y su profesor
$sql = "SELECT t.id, t.nombre AS taller_nombre, t.descripcion, t.lugar, t.horario, t.activo,
               u.nombre AS profesor_nombre, u.apellido AS profesor_apellido
        FROM talleres t
        JOIN talleres_profesores tp ON t.id = tp.taller_id
        JOIN usuarios u ON tp.usuario_id = u.id
        WHERE t.id = ?
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $taller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Taller no encontrado";
    exit();
}

$row = $result->fetch_assoc();

// 🧾 Verificar si el usuario ya está inscripto en este taller
$check = $conn->prepare("SELECT activo FROM Talleres_Usuarios WHERE taller_id = ? AND usuario_id = ?");
$check->bind_param("ii", $taller_id, $_SESSION['usuario_id']);
$check->execute();
$check->bind_result($activo);
$check->fetch();
$check->close();

// Si está inscripto, $activo tendrá 0 (pendiente) o 1 (aceptado)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($row['taller_nombre']); ?></title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn[disabled] {
            background-color: #999;
            cursor: not-allowed;
        }
        .container {
            max-width: 600px;
            margin: auto;
            font-family: sans-serif;
        }
        a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?php echo htmlspecialchars($row['taller_nombre']); ?></h1>
    <p><strong>Profesor:</strong> <?php echo htmlspecialchars($row['profesor_nombre'].' '.$row['profesor_apellido']); ?></p>
    <p><strong>Lugar:</strong> <?php echo htmlspecialchars($row['lugar']); ?></p>
    <p><strong>Horario:</strong> <?php echo htmlspecialchars($row['horario']); ?></p>
    <p><strong>Estado:</strong> <?php echo $row['activo'] ? 'Activo' : 'Inactivo'; ?></p>
    <p><?php echo htmlspecialchars($row['descripcion']); ?></p>

    <div style="margin: 20px 0;">
        <?php if (!isset($activo)) { ?>
            <!-- ✅ Usuario no inscripto -->
            <form method="post" action="BD/inscribiralumno.php">
                <input type="hidden" name="taller_id" value="<?php echo $taller_id; ?>">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                <button type="submit" class="btn">Inscribirse al taller</button>
            </form>
        <?php } elseif ($activo == 0) { ?>
            <!-- 🕓 Inscripto pero pendiente -->
            <button class="btn" disabled>Esperando aprobación</button>
        <?php } else { ?>
            <!-- ✅ Ya aceptado -->
            <a href="foro.php?id=<?php echo $row['id']; ?>" class="btn">Entrar al foro</a>
        <?php } ?>
    </div>

    <a href="talleres.php">Volver a la lista</a>
    <a href="libreta.php?id=<?php echo $row['id']; ?>">Libreta personal</a>
    <a href="alumnos.php?id=<?php echo $row['id']; ?>">Alumnos</a>
    <a href="recursos.php?id=<?php echo $row['id']; ?>">Recursos</a>
    
</div>
</body>
</html>