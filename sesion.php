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

    <?php
        if (isset($_SESSION['msg'])) {
            $codigo_msg = $_SESSION['msg'];
            $mensaje = '';
            $clase_mensaje = 'mensaje-rojo';

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
                    $clase_mensaje = 'mensaje-verde';
                    break;
            }

           

            unset($_SESSION['msg']);
        }
    ?>

    <main class="main-content">
        <div class="formulario">
            <form id="inicio_sesion" class="activo" method="POST" action="controlador/datos_registro_sesion.php">
                <div>
                    <h2>Iniciar Sesión</h2>
                    <input type="email" name="mail" placeholder="Correo" required>
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                    <input type="hidden" name="action" value="login">
                    <p class="pseudo-link" >Olvidé mi contrseña</p>
                </div>
                <div class="boton-submit">
                    <button type="submit">Entrar</button>
                    <?php
                     if (!empty($mensaje)) {
                        echo '
                            <p class= "' . $clase_mensaje . '">' . htmlspecialchars($mensaje) . '</p>';
                    }
                    ?>
                </div>
                <div>
                    <p class="pseudo-link" onclick="toggleForms()">¿No tienes cuenta? Regístrate</p>
                </div>
            </form>

        
            <form id="registro" method="POST" action="controlador/datos_registro_sesion.php">
                <div>
                    <h2>Registrarse</h2>
                    <input type="email" name="mail" placeholder="Correo" required>
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                    <input type="hidden" name="action" value="registro">
                </div>
                <div class="boton-submit">
                    <button type="submit">Registrar</button>
                    <?php
                        if (!empty($mensaje)) {
                            echo '
                                <p class= "' . $clase_mensaje . '">' . htmlspecialchars($mensaje) . '</p>';
                        }
                    ?>
                </div>
                <div>
                    <p class="pseudo-link" onclick="toggleForms()">¿Ya tienes cuenta? Inicia sesión</p>
                </div>
            </form>

            <script>
                // Función para alternar entre formularios
                function toggleForms() {
                    const loginForm = document.getElementById("inicio_sesion");
                    const registerForm = document.getElementById("registro");

                    const mensajes = document.querySelectorAll('.mensaje-rojo, .mensaje-verde');
                    mensajes.forEach(function(mensaje) {
                        mensaje.remove();
                    });

                    // Cambia el título de la página según el formulario mostrado
                    const isLoginActive = loginForm.classList.contains('activo');
                    document.title = isLoginActive ? 'Registrarse - Kobun' : 'Iniciar Sesión - Kobun';

                    loginForm.classList.toggle("activo");
                    registerForm.classList.toggle("activo");
                }
            </script>

            
        </div>

    </main>

    <footer class="footer">
        <?php
            include 'footer.php';
        ?>
    </footer>
</body>
</html>