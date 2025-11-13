<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <style>
        .msg { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .ok { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h2>Restablecer contraseña</h2>

    <?php if ($mensaje): ?>
        <div class="msg <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($usuario): ?>
        <form method="POST">
            <label>Nueva contraseña:</label>
            <input type="password" name="password1" required>
            <label>Repetir contraseña:</label>
            <input type="password" name="password2" required>
            <button type="submit">Actualizar contraseña</button>
        </form>
    <?php endif; ?>
</body>
</html>