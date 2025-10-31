<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <main class="main-content">

        <h1> Perfil </h1>
        <p> Acá tiene que ir el perfil </p>

        <p> ID Socio: <?php echo $socio["id"]; ?> </p>
        <p> Nombre: <?php echo $usuario["nombre"]; ?> </p>
        <p> Apellido: <?php echo $usuario["apellido"]; ?> </p>
        <p> Email: <?php echo $usuario["mail"]; ?> </p>
        

        <?php if ($socio): ?>

        <h2> Socio: </h2>
        <p> Teléfono: <?php echo $socio["telefono"]; ?> </p>
        <p> DNI: <?php echo $socio["dni"]; ?> </p>
        <form method="POST" action="<?php BASE_URL?>pago">
                <input type="hidden" name="libro_id" value="<?php echo $libro["id"]?>">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?>">
                <button type="submit" class="destacado">Pago Socio</button>
        </form>
        <?php endif; ?>
            


</main>

    <footer>

        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>