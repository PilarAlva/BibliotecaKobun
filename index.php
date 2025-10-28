<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Kobun - Inicio</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/inicio.css">
</head>
<body>
    <header class="header">
        <?php
            include 'header.php'; 
        ?>
    </header>

    <div class="banner">
        <img src="img/banner.jpg" alt="Banner de bienvenida" class="banner-img">
        <div class="saludo">
            <?php
                // Cargar el nombre de usuario con la sesión activa.
                if (isset($_SESSION['usuario_id'])) {
                    $username = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
                } else {
                    $username = "Usuario";
                }
                echo "<h1>Hola " . htmlspecialchars($username) . "</h1>";
            ?>
        </div>
    </div>
    
    <main class="main-content">

        <section class="info-container">
            <div class="info-texto">
                <h2>Quiénes somos</h2>
                <p>En Biblioteca Kobun, nos apasiona conectar a los lectores con el conocimiento y la imaginación. Fundada en 2025, nuestra misión es proporcionar un espacio acogedor donde las personas puedan explorar una amplia variedad de libros y recursos de apoyo digitales.</p>
            </div>
            <div class="imagen">
                <img id="frente-biblio" src="img/frente-biblioteca.jpg" alt="Frente de la Biblioteca Kobun">
            </div>
        </section>

        <hr class="linea-divisora">

        <section>
            <h2>Los Espacios de la Biblioteca</h2>
            <div class="info-container">
                <div class="imagen">
                    <img src="img/sala-lectura-general.jpg" alt="Sala de Lectura general">
                </div>
                <div class="info-texto">
                    <h3>Sala de Lectura</h3>
                    <p> Nuestra sala de lectura general es un remanso de tranquilidad y conocimiento, diseñada para inspirar la concentración y el aprendizaje. Con sus altos techos, grandes ventanales que permiten la entrada de luz natural y amplias mesas de estudio, ofrece un entorno ideal para la lectura, la investigación y el trabajo colaborativo. Equipada con cómodas sillas, acceso a enchufes y puntos de conexión Wi-Fi. </p>
                </div>                
            </div>
            <div class="info-container">
                <div class="info-texto">
                    <h3>Salas para Talleres</h3>
                    <p> La biblioteca cuenta con una variedad de espacios especializados más allá de la sala general. Disponemos de salas dedicadas a talleres, como la "Sala Azul", y otras como la "Sala Roja" y la "Sala Violeta", diseñadas para inspirar y acoger diversas actividades y reuniones. </p>
                </div>
                <div class="imagen">
                    <img src="img/sala-azul.jpg" alt="Sala Azul, destinada a Talleres">
                </div>
            </div>
            <div class="info-container">
                <div class="imagen">
                    <img src="img/patio-biblio.jpg" alt="Espacio verde">
                </div>
                <div class="info-texto">
                    <h3>Espacio al Aire Libre</h3>
                    <p>Nuestro patio interior es un oasis de calma en medio de la arquitectura clásica de la biblioteca. Con sus zonas de pasto, plantas y bancas para el descanso, ofrece un espacio tranquilo y perfecto para tomar un respiro o leer al aire libre, sin salir del edificio.</p>
                </div>                
            </div>
        </section>
        
        <hr class="linea-divisora">

        <section>
            <h2>Nuestros Servicios</h2>
            <div class="info-container">
                <!-- Lista de servicios con íconos personalizados -->
                <ul class="servicios-lista">
                    <li class="servicio-item-prestamo">Préstamos en sala y a domicilio</li>
                    <li class="servicio-item-salas">Salas de lectura</li>
                    <li class="servicio-item-talleres">Talleres</li>
                    <li class="servicio-item-wifi">Acceso a Internet y Wifi</li>
                    <li class="servicio-item-pc">Acceso a PC's en sala</li>
                    <li class="servicio-item-cargador">Banco de Cargadores</li>
                    <li class="servicio-item-verde">Espacio verde</li>
                </ul>
                <!-- Puedes mantener una imagen general de la sección si lo deseas -->
                 <div class="imagen">
                    <img src="img/recepcion.jpg" alt="Recepción de la Biblioteca Kobun">
                </div>
            </div>
        </section>

        <hr class="linea-divisora">

        <section>
            <h2>Información Útil</h2>
            <div id="info-util">
                <div>
                    <p><span class="destacado">Horario de Atención:</span> 08:00 a 20:00 hs.</p>
                    <p><span class="destacado">Jefe/a de Biblioteca:</span> Fernanda Trías. </p>
                    <p><span class="destacado">Bibliotecarios/as Profesionales:</span> Juana Inés de Asbaje, Laura Esquivel. </p>
                    <p><span class="destacado">Circulación y Préstamos:</span> Samanta Schweblin, Valeria Luiselli. </p>
                </div>
                <!-- <div class="redes-sociales">
                    <a href="https://www.facebook.com/?locale=es_LA" aria-label="Facebook" target="_blank" rel="noopener noreferrer"><img src="img/facebook.png" alt="Icono de Facebook" width="30"></a>
                    <a href="https://x.com/?lang=es" aria-label="Twitter" target="_blank" rel="noopener noreferrer"><img src="img/twitter.png" alt="Icono de Twitter" width="30"></a>
                    <a href="https://www.instagram.com/" aria-label="Instagram" target="_blank" rel="noopener noreferrer"><img src="img/instagram.png" alt="Icono de Instagram" width="30"></a>    
                </div> -->
            </div>
        </section>
        
    </main>

    <footer>
        <?php
            include 'footer.php';
        ?>
    </footer>
    
</body>

</html>