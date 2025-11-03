<header class="header">
    <?php
        include '../app/vistas/componentes/header.php'; 
    ?>
</header>
    
<main class="main-content">
    
    <div class="perfil-contenedor">
        <div class="encabezado">
            <h1> Mi Perfil </h1>
        </div>

        <div class="cuerpo-perfil">
            <div class="nav-perfil">
                <ul>
                    <!-- Se añade la clase 'active' al primer elemento y atributos data-target -->
                    <li><a href="#" class="nav-link active" data-target="info-personal">Información Personal</a></li>
                    <li><a href="#" class="nav-link" data-target="prestamos">Préstamos</a></li>
                    <li><a href="#" class="nav-link" data-target="talleres">Talleres</a></li>
                    <li><a href="#" class="nav-link" data-target="accesibilidad">Accesibilidad</a></li>
                </ul>
            </div>

            <div class="contenido-perfil">
                <!-- Contenido para "Información Personal" -->
                <div id="info-personal" class="tab-content active">
                    <div class="info-datos-personales">
                        <?php
                            // Define la imagen de perfil: usa la de la sesión si existe, si no, una genérica.
                            $defaultImg = 'img/perfil-default.png';
                            $perfilImg = isset($_SESSION['img_perfil']) && !empty($_SESSION['img_perfil']) ? $_SESSION['img_perfil'] : $defaultImg;
                        ?>
                        <div class="perfil-img-cont">
                            <img src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
                        </div>

                        <div class="form-datos-personales">
                            <?php
                                if (isset($usuario['rol_id'])) {
                                    $rol_texto = '';
                                    $rol_clase = ''; 
                                    switch ((int)$usuario['rol_id']) {
                                        case 1:
                                            $rol_texto = 'Administrador';
                                            $rol_clase = 'rol-admin'; 
                                            break;
                                        case 2:
                                            $rol_texto = 'Profesor';
                                            $rol_clase = 'rol-profesor';
                                            break;
                                    }
                                    if (!empty($rol_texto)) {
                                        echo '<p class="info-rol ' . $rol_clase . '">' . htmlspecialchars($rol_texto) . '</p>';
                                    }
                                }
                            ?>

                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="nombre">NOMBRE</label>
                                    <input type="text" name="nombre" value="<?php echo $usuario["nombre"]; ?>" placeholder="Nombre">
                                    <label for="apellido">APELLIDO</label>
                                    <input type="text" name="apellido" value="<?php echo $usuario["apellido"]; ?>" placeholder="Apellido">
                                </div>

                                <div class="boton-derecha">
                                    <button type="submit" class="bt-guardar-cambios" class="destacado">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>                        
                    </div>
                    
                    <div class="info-adicional">
                        <div class="boton-derecha">
                            <button id="bt-cerrar-sesion" class="destacado"><a href="<?php echo BASE_URL; ?>sesion/cerrar">Cerrar Sesión</a></button>
                        </div>
                    </div>
                    
                    
                </div>

                <!-- Contenido para "Préstamos" -->
                <div id="prestamos" class="tab-content">
                    <h3>Mis Préstamos</h3>
                    <p>Aquí se mostrará el historial y estado de tus préstamos.</p>
                </div>

                <!-- Contenido para "Talleres" -->
                <div id="talleres" class="tab-content">
                    <h3>Mis Talleres</h3>
                    <p>Aquí se mostrarán los talleres en los que estás inscrito.</p>
                </div>

                <!-- Contenido para "Accesibilidad" -->
                <div id="accesibilidad" class="tab-content">
                    <h3>Opciones de Accesibilidad</h3>
                    <p>Aquí podrás configurar las opciones de accesibilidad del sitio.</p>
                </div>
            </div>

        </div>
    </div>

    

</main>

<footer>

    <?php
        include '../app/vistas/componentes/footer.php';
    ?>

</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-perfil .nav-link');
    const tabContents = document.querySelectorAll('.contenido-perfil .tab-content');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Quitar clase 'active' de todos los links y contenidos
            navLinks.forEach(nav => nav.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Añadir clase 'active' al link clickeado
            this.classList.add('active');

            // Mostrar el contenido correspondiente
            const targetId = this.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
});
</script>