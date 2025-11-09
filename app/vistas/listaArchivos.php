<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">

    
    <div class="encabezado">
        <h3>Resultados de búsqueda</h3>
        <p>Cantidad de Resultados <?php echo $resultados ?></p>
    </div>

    <div>
        <table class="tabla-libro">
            <tbody>
                <?php foreach ($archivos as $indice => $archivo) { ?>
                <tr>
                    <td id="numero"><?php echo $indice + 1;?>.</td>
                    <td class="imagen-libro">
                        <img src="img/no.png" alt="...">
                    </td>
                    <td>
                        <div class="info-libro-contenedor">
                            <div class="info-libro">
                                <h3 class="titulo-libro"><?php echo htmlspecialchars($archivo['titulo']); ?></h3>

                                <a href="<?=BASE_URL?>archivo/id/<?= $archivo['id']; ?>" class="info-libro-link">
                                    Descargar
                                </a>
                            </div>
    
                            
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>            

        

    </div>
</main>

<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>

<footer>
    <?php
        include '../app/vistas/componentes/footer.php';
    ?>
</footer>
