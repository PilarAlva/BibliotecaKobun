<div>
    <a href=<?php BASE_URL?>>
        <img src="img/logo.svg" alt="logo" width="150">
    </a>      
</div>

<button class="hamburger-menu" aria-label="Abrir menú" aria-expanded="false">
    <span class="hamburger-box">
        <span class="hamburger-inner"></span>
    </span>
</button>

<nav class="main-nav">
    <ul>
        <li><a href= "<?php BASE_URL?>inicio" >Inicio</a></li>
        <li><a href= "<?php BASE_URL?>catalogo" >Catálogo</a></li>
        <li><a href= "<?php BASE_URL?>talleres">Talleres</a></li>
        <li><a href= "<?php BASE_URL?>contacto">Contacto</a></li>

        <?php if (isset($_SESSION['usuario_id'])):
                // Define la imagen de perfil: usa la de la sesión si existe, si no, una genérica.
                $defaultImg = 'img/perfil-generico.png';
                $perfilImg = isset($_SESSION['img_perfil']) && !empty($_SESSION['img_perfil']) ? $_SESSION['img_perfil'] : $defaultImg;
            ?>
            <!-- Elemento de perfil para VISTA ESCRITORIO -->
            <li class="no-underline perfil-desktop">
                <a href="<?php BASE_URL?>perfil" class="btn-perfil" aria-label="Ver perfil">
                    <img src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario" class="img-perfil">
                </a>
            </li>
            <!-- Elemento de perfil para VISTA MÓVIL (menú hamburguesa) -->
            <li class="perfil-mobile">
                <a href="<?php BASE_URL?>perfil">Perfil</a>
            </li>

        <?php else: ?>
            <!-- Si el usuario NO está logueado, muestra el botón de acceso -->
            <li class="no-underline"><a href="<?php BASE_URL?>sesion" class="btn-acceso">Acceso</a></li>

        <?php endif; ?>
    </ul>
</nav>

