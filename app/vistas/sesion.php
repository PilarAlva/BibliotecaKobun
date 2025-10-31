<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>

    <main class="main-content">
        <div class="formulario">

            <form id="inicio_sesion" class="activo" method="POST" action="<?php BASE_URL?>sesion">
                <div>
                    <h2>Iniciar Sesión</h2>
                    <input type="email" name="mail" placeholder="Correo" required>
                    <input type="password" name="clave" placeholder="Contraseña" required>
                    <input type="hidden" name="action" value="login">
                    <p class="pseudo-link" >Olvidé mi contrseña</p>
                </div>
                <div class="boton-submit">
                    <button type="submit" class="destacado">Entrar</button>
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

        
            <form id="registro" method="POST" action="<?php BASE_URL?>sesion">
                <div>
                    <h2>Registrarse</h2>
                    <input type="email" name="mail" placeholder="Correo" required>
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                    <input type="password" name="clave" placeholder="Contraseña" required>
                    <input type="hidden" name="action" value="registro">
                </div>
                <div class="boton-submit">
                    <button type="submit" class="destacado">Registrarse</button>
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

    <footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>
    </footer>