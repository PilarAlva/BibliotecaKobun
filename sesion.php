<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Kobun</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sesion.css">
</head>
<body>
    <header class="header">
        <?php
            include 'header.php';
        ?>
    </header>

    <main>

        <form id="inicio_sesion" class="activo" method="POST" action="controlador/datos_registro_sesion.php">    
        <h2>Iniciar Sesión</h2>
        <input type="email" name="mail" placeholder="Correo" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <input type="hidden" name="action" value="login">
        <button type="submit">Entrar</button>
        <p class="toggle" onclick="toggleForms()">¿No tienes cuenta? Regístrate</p>
        </form>

    
        <form id="registro" method="POST" action="controlador/datos_registro_sesion.php">
        <h2>Registrarse</h2>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <input type="email" name="mail" placeholder="Correo" required>
        <input type="hidden" name="action" value="registro">
        <button type="submit">Registrar</button>
        <p class="toggle" onclick="toggleForms()">¿Ya tienes cuenta? Inicia sesión</p>
        </form>

        <script>
            function toggleForms() {
                const loginForm = document.getElementById("inicio_sesion");
                const registerForm = document.getElementById("registro");

                // Cambia el título de la página según el formulario que se va a mostrar
                const isLoginActive = loginForm.classList.contains('activo');
                document.title = isLoginActive ? 'Registrarse - Kobun' : 'Iniciar Sesión - Kobun';

                loginForm.classList.toggle("activo");
                registerForm.classList.toggle("activo");
            }
        </script>

        <div class="contenedor-mensaje">
            <?php
                if (isset($_SESSION['msg'])) {
                    $codigo_msg = $_SESSION['msg'];
                    $mensaje = '';
                    $clase_mensaje = 'mensaje-rojo'; // Clase por defecto para errores

                    switch ($codigo_msg) {
                        case 1:
                            $mensaje = 'Ha ocurrido un error.';
                            break;
                        case 2:
                            $mensaje = 'Todos los campos son obligatorios.';
                            break;
                        case 3:
                            $mensaje = 'El usuario no existe. Por favor regístrese.';
                            break;
                        case 4:
                            $mensaje = 'El usuario ya existe. Por favor inicie sesión.';
                            break;
                        case 5:
                            $mensaje = 'Registro exitoso. Ahora puede iniciar sesión.';
                            $clase_mensaje = 'mensaje-verde'; // Cambiamos a la clase de éxito
                            break;
                    }

                    // Imprimimos el mensaje una sola vez, de forma segura.
                    if (!empty($mensaje)) {
                        echo '<p class="' . $clase_mensaje . '">' . htmlspecialchars($mensaje) . '</p>';
                    }

                    unset($_SESSION['msg']);
                }
            ?>
        </div>

    </main>

</body>
</html>