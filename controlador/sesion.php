<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesion</title>
</head>
<body>
    
    <form id="inicio_sesion" class="activo" method="POST" action="datos_registro_sesion.php">    
     <h2>Iniciar Sesión</h2>
      <input type="email" name="mail" placeholder="Correo" required>
      <input type="password" name="contraseña" placeholder="Contraseña" required>
      <input type="hidden" name="action" value="login">
      <button type="submit">Entrar</button>
      <p class="toggle" onclick="toggleForms()">¿No tienes cuenta? Regístrate</p>
    </form>

   
    <form id="registro" method="POST" action="datos_registro_sesion.php">
      <h2>Registrarse</h2>
      <input type="text" name="nombre" placeholder="Nombre" required>
      <input type="text" name="apellido" placeholder="Apellido" required>
      <input type="password" name="contraseña" placeholder="Contraseña" required>
      <input type="email" name="mail" placeholder="Correo" required>
      <input type="hidden" name="action" value="registro">
      <button type="submit">Registrar</button>
      <p class="toggle" onclick="toggleForms()">¿Ya tienes cuenta? Inicia sesión</p>
    </form>




    </form>






</body>
</html>