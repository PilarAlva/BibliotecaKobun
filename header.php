<div>
    <a href="index.php"> <img src="img/logo.svg" alt="logo" width="150"> </a>      
</div>

<button class="hamburger-menu" aria-label="Abrir menú" aria-expanded="false">
    <span class="hamburger-box">
        <span class="hamburger-inner"></span>
    </span>
</button>

<nav class="main-nav">
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="#">Catálogo</a></li>
        <li><a href="#">Talleres</a></li>
        <li><a href="#">Contacto</a></li>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <?php
                // Define la imagen de perfil: usa la de la sesión si existe, si no, una genérica.
                $defaultPic = 'img/perfil-generico.png';
                $profilePic = isset($_SESSION['img_perfil']) && !empty($_SESSION['img_perfil']) ? $_SESSION['img_perfil'] : $defaultPic;
            ?>
            <li class="no-underline">
                <a href="perfil.php" class="btn-perfil" aria-label="Ver perfil">
                    <img src="<?php echo htmlspecialchars($perfilPic); ?>" alt="Imagen de perfil del usuario" class="img-perfil">
                </a>
            </li>

        <?php else: ?>
            <!-- Si el usuario NO está logueado, muestra el botón de acceso -->
            <li class="no-underline"><a href="sesion.php" class="btn-acceso">Acceso</a></li>

        <?php endif; ?>
    </ul>
</nav>

<!-- Archivos .js -->
<script src="js/main.js"></script>
