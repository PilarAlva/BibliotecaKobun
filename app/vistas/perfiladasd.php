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

        <!-- Botón para el menú de perfil en móviles -->
        <button id="perfil-nav-toggle" aria-expanded="false">Menú de Perfil</button>

        <div class="cuerpo-perfil">
            <nav class="nav-perfil">
                <ul>
                    <!-- Se añade la clase 'active' al primer elemento y atributos data-target -->
                    <li><a href="#" class="nav-link active" data-target="info-personal">Información Personal</a></li>
                    <li><a href="#" class="nav-link" data-target="prestamos">Préstamos</a></li>
                    <li><a href="#" class="nav-link" data-target="talleres">Talleres</a></li>
                    <li><a href="#" class="nav-link" data-target="accesibilidad">Accesibilidad</a></li>

                    <!-- VISTAS ADICIONALES DE ADMINISTRADOR -->
                    <?php
                    if ($usuario['rol_id'] == 1){ ?>
                        <li><a href="#" class="nav-link" data-target="gestion-usuarios">Gestionar Usuarios</a></li>
                        <li><a href="#" class="nav-link" data-target="gestion-material">Gestionar Material Bibliográfico</a></li>
                    <?php } ?>
                </ul>
            </nav>

            <div class="contenido-perfil">
                <!-- Contenido para "Información Personal" -->
                <div id="info-personal" class="tab-content active">
                    <div class="info-datos-personales">
                        <?php
                            $defaultImg = 'img/perfil-default.png';
                            $perfilImg = isset($_SESSION['img_perfil']) && !empty($_SESSION['img_perfil']) ? $_SESSION['img_perfil'] : $defaultImg;
                        ?>
                        <div class="perfil-img-cont">
                            <label for="upload-photo" class="upload-label">
                                <img src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
                                <div class="overlay">
                                    <img src="img/icono-camara.png" alt="Cambiar foto" class="camera-icon">
                                </div>
                            </label>
                            <!-- FALTA FUNCION PARA GURDAR Y/O ACTUALIZAR LA IMAGEN DEL USUARIO EN LA BD !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <input type="file" id="upload-photo" name="photo" style="display: none;">
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

                            <!-- FORMULARIO NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
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

                    <!-- Vista Adicional de Socios -->
                    <?php
                    if ($socio) {
                        $msjColor = '';
                        if ($estadoSocio == "Activo" ) {
                            $msjColor = 'msj-verde';
                        } else {
                            $msjColor = 'msj-rojo';
                        } ?>
                        <hr class="linea-divisora">
                        <div class="info-socio">
                            <p>Usted es:<span class="<?php echo $msjColor?>"> Socio <?php echo $estadoSocio ?></span> </p>
                            <?php if ($socioInfoDeudas): ?>
                                <p>Estado de Cuota Socio:
                                    <?php if ($socioInfoDeudas['cuotaAlDia']): ?>
                                        <span class="msj-verde"><?php echo htmlspecialchars(number_format($socioInfoDeudas['montoCuota'], 2)); ?>$</span>
                                    <?php else: ?>
                                        <span class="msj-rojo"><?php echo htmlspecialchars(number_format($socioInfoDeudas['montoCuota'], 2)); ?>$</span>
                                    <?php endif; ?>
                                </p>
                                <?php if ($socioInfoDeudas['montoMultas'] > 0): ?>
                                    <p>Multas: <span class="msj-rojo"><?php echo htmlspecialchars(number_format($socioInfoDeudas['montoMultas'], 2)); ?>$</span></p>
                                <?php endif; ?>
                                <?php if ($socioHabilitado) ?>
                                    <p class="msj-gris">ⓘ Habilitado para préstamos</p>
                                <?php else: ?>
                                    <p class="msj-rojo">ⓘ Inhabilitado para préstamos</p>
                                <?php endif; ?>

                                <!-- BOTON NO FUNCIONALL !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                <button class="bt" id="bt-pagar-cuota"><a href="<?php echo BASE_URL; ?>">Pagar Cuota</a></button>
                        </div>

                    <?php
                    } ?>
                    
                    
                    <div class="info-adicional">
                        <div class="boton-derecha">
                            <button class="bt" id="bt-cerrar-sesion"><a href="<?php echo BASE_URL; ?>sesion/cerrar">Cerrar Sesión</a></button>
                        </div>
                    </div>
                    
                    
                </div>

                <!-- Contenido para "Préstamos" -->
                <div id="prestamos" class="tab-content">
                    <h3>Mis Préstamos</h3>

                    <div>
                        <p class="msj-gris"><?php
                        if (!$socio) {
                            echo 'Para pedir préstamos, primero debe asociarse a la biblioteca.';
                        } elseif (empty($prestamos)) {
                            echo 'No tiene préstamos activos.';
                        ?></p>
                        <?php
                        } else {
                            // Iteramos sobre cada préstamo para mostrarlo
                            foreach ($prestamos as $prestamo) { ?>
                                <div class="libro">
                                    <div class="imagen-libro-cont">
                                        <?php
                                            $portadaSrc = !empty($prestamo['portada']) ? 'img/portadas/' . htmlspecialchars($prestamo['portada']) : 'img/no.png';
                                        ?>
                                        <img src="<?php echo $portadaSrc; ?>" alt="Portada del libro <?php echo htmlspecialchars($prestamo['titulo']); ?>">
                                    </div>
                                    <div class="info-libro-contenedor">
                                        <div>
                                            <a href="<?=BASE_URL?>libro/id/<?= $prestamo['libro_id']; ?>">
                                                <h4 class="titulo-libro"><?php echo htmlspecialchars($prestamo['titulo']); ?></h4>
                                                <p class="autor-libro">Por <?php echo htmlspecialchars($prestamo['nombre_completo']); ?></p>
                                            </a>
                                        </div>
                                        <div>
                                            <?php if ($prestamo['fecha_devolucion']): ?>
                                                <p class="devuelto">Devuelto el: <?php echo date("d/m/Y", strtotime($prestamo['fecha_devolucion'])); ?></p>
                                            <?php else: ?>
                                                <?php if ($prestamo['fecha_vencimiento'] < date('Y-m-d')): ?>
                                                    <p class="msj-rojo">Reservado hasta: <?php echo date("d/m/Y", strtotime($prestamo['fecha_vencimiento'])); ?></p>
                                                <?php else: ?>
                                                    <p>Reservado hasta: <?php echo date("d/m/Y", strtotime($prestamo['fecha_vencimiento'])); ?></p>                                                
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                        <?php } // Fin del foreach
                        } // Fin del else ?>
                    </div>
                </div>

                <!-- Contenido para "Talleres" -->
                <div id="talleres" class="tab-content">
                    <h3>Mis Talleres</h3>
                    
                        <?php
                        if (empty($talleres)) { ?>
                            <div class="sin-contenido">
                                <p class="msj-gris">No participa de ningún taller.</p>
                                <div class="boton-derecha">
                                    <button class="bt"><a href="<?php echo BASE_URL; ?>talleres">Ver Talleres</a></button>
                                </div>
                            </div>
                        <?php }
                        else { ?>
                            <div class="talleres-grid">
                                <?php // Iteracion sobre cada taller
                                foreach ($talleres as $taller) { ?>
                                
                                    <div class="taller">
                                        <a href="<?=BASE_URL?>taller/id/<?= $taller['taller_id']; ?>">
                                            <div class="taller-contenedor">  
                                                <div class="imagen-taller-cont">
                                                    <?php
                                                        $portadaSrc = !empty($taller['taller_portada']) ? 'img/portadas/' . htmlspecialchars($taller['taller_portada']) : 'img/talleres-default.webp';
                                                    ?>
                                                    <img src="<?php echo $portadaSrc; ?>" alt="Portada del taller <?php echo htmlspecialchars($taller['taller_nombre']); ?>">
                                                </div>
                                                <div class="info-taller-contenedor">
                                                    <h4 class="titulo-taller"><?php echo htmlspecialchars($taller['taller_nombre']); ?></h4>
                                                    <p>Profesor: <?php echo htmlspecialchars($taller['profesor_nombre'])?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                
                                <?php } ?> <!-- Fin del foreach --> 
                            </div>
                        <?php } ?>
                
                </div>

                <!-- Contenido para "Accesibilidad" -->
                <div id="accesibilidad" class="tab-content">
                    <h3>Opciones de Accesibilidad</h3>

                    <!-- FORMULARIO NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                    <div>
                        <form method="POST" action="">
                            <div class="form-datos">
                                <div class="form-group">
                                    <label for="nombre">Su correo</label>
                                    <input type="email" name="mail" value="<?php echo $usuario["mail"]; ?>" placeholder="Correo">
                                </div>
                                <div class="form-group">
                                    <label for="clave_actual">Contraseña actual</label>
                                    <input type="password" id="clave_actual" name="clave_actual" value="" placeholder="Introduce tu contraseña actual" autocomplete="current-password">
                                </div>
                                <div class="form-group password-container">
                                    <label for="clave_nueva">Cambiar la contrseña</label>
                                    <input type="password" id="clave_nueva" name="clave_nueva" value="" placeholder="Introduce tu nueva contraseña">
                                </div>
                                <div class="form-group password-container">
                                    <label for="confirmar_clave_nueva">Confirmar nueva contraseña</label>
                                    <input type="password" id="confirmar_clave_nueva" name="confirmar_clave_nueva" value="" placeholder="Confirma tu nueva contraseña">
                                </div>
                            </div>

                            <div class="boton-derecha">
                                <button type="submit" class="bt-guardar-cambios" class="destacado">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>




                <!-- VISTAS ADICIONALES DE ADMINISTRADOR -->
                <?php
                if ($usuario['rol_id'] == 1) { ?>
                    <div id="gestion-usuarios" class="tab-content">
                        <h3>Gestionar Usuarios</h3>
                        
                        <!-- BUSQUEDA NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                        <div class="cabecera-gestion">
                            <div class="buscador">
                                <form action="" method="POST">
                                    <select name="filtro" class="selector">
                                        <option value="usuario-gral" <?php /* if($filtro=='usuraio-gral') */ echo 'selected'; ?>>Usuarios Generales</option>
                                        <option value="socios" <?php /* if($filtro=='socios') */ echo 'selected'; ?>>Socios</option>
                                        <option value="profesores" <?php /* if($filtro=='profesores') */ echo 'selected'; ?>>Profesores</option>
                                        <option value="administradores" <?php /* if($filtro=='administradores') */ echo 'selected'; ?>>Administradores</option>
                                    </select>
                                    <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php /* echo htmlspecialchars($busqueda); */ ?>">
                                    <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>

                            <!-- BOTON NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <div>
                                <button class="bt bt-añadir"><a href="<?php /* echo BASE_URL; > */?>...">Añadir Usuario</a></button>
                            </div>
                        </div>
                        

                        <div class="cuerpo-gestion-usuarios">
                            <div class="muestra-usuarios">
                                <?php foreach ($listaUsuarios as $usuarioItem) : ?>
                                    <div class="usuario">
                                        <div class="imagen-usuario-cont">
                                            <?php
                                                $defaultImg = 'img/perfil-default.png';
                                                $perfilImg = (isset($usuarioItem['img_perfil']) && !empty($usuarioItem['img_perfil'])) ? $usuarioItem['img_perfil'] : $defaultImg;
                                            ?>
                                            <img src="<?php echo htmlspecialchars($perfilImg); ?>" alt="Imagen de perfil del usuario">
                                        </div>                                    
                                        <div class="contenedor-info">
                                            <p><?php echo htmlspecialchars($usuarioItem['nombre']) . ' ' . htmlspecialchars($usuarioItem['apellido']);?></p>
                                            <!-- BOTON NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <button class="bt-mas-info">
                                                <img src="<?= BASE_URL ?>/img/icono-mas.png" alt="icono mas informacion">
                                            </button>
                                        </div>
                                    </div>
                                    <hr class="linea-divisora">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>


                    <div id="gestion-material" class="tab-content">
                        <h3>Gestionar Material Bibliográfico</h3>
                        <!-- BUSQUEDA NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                        <div class="cabecera-gestion">
                            <div class="buscador">
                                <form action="<?php BASE_URL?>catalogo/b/" method="POST">
                                    <select name="filtro" class="selector">
                                        <option value="titulo" <?php /* if($filtro=='titulo') */ echo 'selected'; ?>>Título</option>
                                        <option value="autor" <?php /* if($filtro=='autor') */ echo 'selected'; ?>>Autor</option>
                                        <option value="genero" <?php /* if($filtro=='genero') */ echo 'selected'; ?>>Género</option>
                                        <option value="contenido" <?php /* f($filtro=='contenido') */ echo 'selected'; ?>>Contenido</option>
                                    </select>
                                    <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php /* echo htmlspecialchars($busqueda); */ ?>">
                                    <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>
                            
                            <!-- BOTON NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <div>
                                <button class="bt bt-añadir"><a href="<?php /* echo BASE_URL; > */?>...">Añadir Material</a></button>
                            </div>
                        </div>

                        <div class="cuerpo-gestion-material">
                            <div class="muestra-libros">
                                <!-- REEMPLAZAR $prestamos por $listaLibros + HACER LA LOGICA PORQUE NO SE CONECTA BIEN CON LA BD NO SE PORQUÉ :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                <?php foreach ($prestamos as $libroItem) : ?>
                                    <div class="libro">
                                    <div class="imagen-libro-cont">
                                        <?php
                                            $portadaSrc = !empty($libroItem['ref_portada']) ? 'img/portadas/' . htmlspecialchars($libroItem['ref_portada']) : 'img/no.png';
                                        ?>
                                        <img src="<?php echo $portadaSrc; ?>" alt="Portada del libro <?php echo htmlspecialchars($libroItem['titulo']); ?>">
                                    </div>
                                    <div class="contenedor-info">
                                        <div>
                                            <h4 class="titulo-libro"><?php echo htmlspecialchars($libroItem['titulo']); ?></h4>
                                            <p class="autor-libro">Por <?php echo htmlspecialchars($libroItem['nombre_completo']); ?></p>
                                        </div>
                                        <button class="bt-mas-info"><img src="<?= BASE_URL ?>/img/icono-mas.png" alt="icono mas informacion"></button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <hr class="linea-divisora">

                        </div>

                    </div>

                <?php } ?>

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

<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>