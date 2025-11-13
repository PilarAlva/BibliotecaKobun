<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <style>
        .msg {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .msg.ok { background-color: #d4edda; color: #155724; }
        .msg.error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <main>
        <div>
            <?php if (isset($_GET['msg'])): ?>
                <?php
                $msg = $_GET['msg'];
                switch ($msg) {
                    case 'ok':
                        echo "<div class='msg ok'>✅ Correo enviado correctamente. Revisá tu bandeja de entrada.</div>";
                        break;
                    case 'noexiste':
                        echo "<div class='msg error'>❌ No existe ninguna cuenta registrada con ese correo.</div>";
                        break;
                    case 'error_envio':
                        echo "<div class='msg error'>⚠️ Error al enviar el correo. Intentalo más tarde.</div>";
                        break;
                    case 'sinemail':
                        echo "<div class='msg error'>⚠️ Por favor ingresá un correo válido.</div>";
                        break;
                }
                ?>
            <?php endif; ?>

            <form action="<?php BASE_URL?>sesion/recuperarcontraseña" method="POST">
                <label for="email">Correo:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Recuperar Contraseña</button>
            </form>
        </div>
    </main>
</body>
</html>