<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
</header>
    
    <main class="main-content">

        <section class="detalle-libro">

            <div class="portada">
                <img src="img/no.png" alt="Portada del libro">
            </div>

            <div class="info-libro">
                <h1>
                    <?php echo $libro["titulo"]?>
                </h1>         

                <p><strong>Autor:</strong>
                    <?php echo $libro["autores"]?>
                </p>
                <p><strong>ISBN:</strong>
                    <?php echo $libro["isbn"]?>
                </p>
                <p><strong>Género:</strong>
                    <?php echo $libro["generos"]?>
                </p>
                <?php if ($cantidad > 0){?>
                <p><strong>Disponibilidad:</strong> <span class="disponible">
                    
                    Items Disponibles

                </span></p>
                <?php }?>
                <?php 
                //TODO: Arreglar esto
                if (isset($_SESSION['usuario_id']) ) { ?>
                    <?php if($es_socio){
                            if($cantidad > 0){
                            ?>
                            <form method="POST" action="<?php BASE_URL?>libro/prestamo">
                                <input type="hidden" name="libro_id" value="<?php echo $libro["id"]?>">
                                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?>">
                                <button type="submit" class="btn-prestamo">Pedir Préstamo</button>
                            </form>
                        <?php }
                            else{?> 
                                <p class="msj-gris">ⓘ No hay ejemplares disponibles</p>
                        <?php }
                }else{?>
                        <p class="msj-gris">ⓘ Debe ser socio para solcitar prestamos</p>
                    <?php }?>

                <?php } else { ?>
                     <p class="msj-gris">ⓘ Debe ser socio para solcitar prestamos</p>
                <?php } ?>

            

            </div>

        </section>

        <section class="sinopsis">
            <h2>Sinopsis</h2>
            <p>
                 <?php echo $libro["sinopsis"]?>
            </p>
        </section>
        
        <section class="existencias">
            <h2>Existencias <?php echo count($ejemplares) ?></h2>
            
            <table>
                   
                <thead>
                    <tr>
                        <th></th>
                        <th>Código Topográfico</th>
                        <th>Estado</th>
                        <th>Vencimiento</th>
                    </tr>
                </thead>
                    

                <tbody>
                    <?php 
                    if (!empty($ejemplares)) {
                    foreach ($ejemplares as $ejemplar) {
                    ?>

                    <tr>
                        <td>
                            <img src="img/no.png" alt="icono"/>
                        </td>
                        <td>
                            <?php echo $ejemplar["codigo_topografico"]?>
                        </td>

                        <?php if($ejemplar["activo"] == '0'){?>
                        
                            <td class="disponible"> Disponible</td>

                        <?php }else{?>

                            <td class="no-disponible"> Prestado</td>

                        <?php }?>


                        <td>
                            <?php echo $ejemplar["fecha_vencimiento"]?>
                        </td>
                    </tr>

                    <?php 
                        }}
                    ?>
                                    
                    
                </tbody>

                    </table>
            
        </section>

    </main>

<footer>
        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>


