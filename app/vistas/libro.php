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
                    <label> <?php echo $ejemplar["ejemplar_id"]?>  </label>  
                      
                    <label> Prestado: <?php echo $ejemplar["activo"]? "no" : "si"?>  </label>   
                    
                    <?php 
                    if (!$ejemplar["activo"]) {
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
            </ul>
        </div>

    </main>

    <footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>