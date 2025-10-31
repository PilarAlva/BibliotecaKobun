<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <main class="main-content">

        <ul>

            <li>
                <h1> <?php echo $libro["titulo"]?>  </h1>    
            </li>
            <li>
                <label> <?php echo $libro["autores"]?>  </label>    
            </li>
            <li>
                <label> <?php echo $libro["generos"]?>  </label>    
            </li>
        
        </ul>

        <div>
            <ul>
            <?php 
            if (!empty($ejemplares)) {
            foreach ($ejemplares as $ejemplar) {
            ?>
                <li>
                    <label> <?php echo $ejemplar["ejemplar_id"]?> -  </label>  
                    <label> <?php echo $ejemplar["codigo_topografico"]?>  </label>  
                      
                    <label> Prestado: <?php echo $ejemplar["activo"] == '0' ? "no" : "si"?>  </label>   
                      
                    <?php 
                    if (!$ejemplar["activo"] == '0') {
                    ?>

                        <label> <?php echo $ejemplar["fecha_vencimiento"]?>  </label>    
            
                    <?php 
                    }
                    ?>  

                </li>
            <?php 
                }
            }
            ?>

            <form method="POST" action="<?php BASE_URL?>libro/prestamo">
                <input type="hidden" name="libro_id" value="<?php echo $libro["id"]?>">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?>">
                <button type="submit" class="destacado">Solicitar Préstamo</button>
            </form>

            </ul>
        </div>

    </main>

    <footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>