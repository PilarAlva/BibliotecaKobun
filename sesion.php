<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesion</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <header class="header">
        <?php
            include 'header.php';
        ?>
    </header>

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
            document.getElementById('inicio_sesion').classList.toggle('activo');
            document.getElementById('registro').classList.toggle('activo');
        }
    </script>
</body>
</html>