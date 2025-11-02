<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <main class="main-content">

        <ul>

            <li>
                <h1> <?php echo $taller["taller_nombre"]?>  </h1>    
            </li>
            <li>
                <label> <?php echo $taller["profesor_nombre"]?>  </label>    
            </li>
            <li>
                <label> <?php echo $taller["horario"]?>  </label>    
            </li>
        
        </ul>

        <div>
            <?php if (isset($_SESSION['usuario_id'])) { ?>

            <?php echo $estado; ?>
            <form method="POST" action="<?php BASE_URL?>taller/ins">
                <input type="hidden" name="taller_id" value="<?php echo $taller["taller_id"]?>">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?>">
                <?php if ($estado == 'inscripto'):?> 
                    <button type="submit" class="destacado">Ir al taller</button>
                <?php endif;?>
                <?php if ($estado == 'no_inscripto'):?> 
                    <button type="submit" class="destacado">Inscribirse</button>
                <?php endif;?>
                <?php if ($estado == 'en_espera'):?> 
                    <button type="submit" class="destacado">En cola!</button>
                <?php endif;?>
            </form>

            <?php } else { ?>
                <p>Para incribirse a un taller debe estar registrado - <a href="<?php BASE_URL?>sesion">iniciar sesión</a></p>
            <?php } ?>
        </div>

    </main>

    <footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>