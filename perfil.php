<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - <?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?></title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <header class="header">
        <?php
            include 'header.php'; 
        ?>
    </header>

    <main class="main-content">
        <button onclick="location.href='controlador/cerrar_sesion.php'"> cerrar sesión </button>
    </main>

    <footer class="footer">
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>