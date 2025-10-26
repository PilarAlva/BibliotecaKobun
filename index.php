<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Kobun - Inicio</title>

    <link rel="stylesheet" href="vistas/css/style.css">
    <link rel="stylesheet" href="vistas/css/inicio.css">
</head>
<body>
    <header>
        <?php
            include 'vistas/header.php'; 
        ?>
    </header>

    <div class="hero-banner">
        <img src="vistas/img/banner1.jpg" alt="Banner de bienvenida" class="hero-banner-img">
        <div class="hero-greeting">
            <?php
                // Cargar el nombre de usuario con la sesión activa.
                $username = "Usuario";
                echo "<h1>Hola " . htmlspecialchars($username) . "!</h1>";
            ?>
        </div>
    </div>

    <main class="main-content">

        <section>
            <div class="info-container">
                <div class="info-texto">
                    <h2>Quiénes somos</h2>
                    <p>En Biblioteca Kobun, nos apasiona conectar a los lectores con el conocimiento y la imaginación. Fundada en 2025, nuestra misión es proporcionar un espacio acogedor donde las personas puedan explorar una amplia variedad de libros y recursos de apoyo digitales.</p>
                </div>
                <div class="imagen">
                    <img src="vistas/img/frente-biblioteca.jpg" alt="Imagen de la biblioteca">
                </div>
            </div>
        </section>

        <section>

        </section>
        
        <section>

        </section>
        
    </main>

    <footer>

    </footer>

    
</body>

</html>