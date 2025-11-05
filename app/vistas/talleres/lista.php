<script src="js/talleres.js"></script>

<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">

    
    <div class="talleres__encabezado">
        
        <?php if (isset($_SESSION['usuario_id'])): ?>
            
            <ul class="te_menu">
                
                <li class="te_menu__btn" id = "btn_mis_talleres" >Mis talleres</li>
                <li class="te_menu__btn selected" id = "btn_talleres_busqueda">Busqueda</li>
                
                
            </ul>
            
            
            <?php endif; ?>
        </div>
        
        <div class="buscador">
            <form action="<?php BASE_URL?>talleres/b/" method="POST">
                <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php echo htmlspecialchars(''); ?>">
                <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

    <div id="talleres_section_talleres_busqueda" >
        <?php include '../app/vistas/talleres/busqueda.php'; ?>
    </div>
    
    <?php if (isset($_SESSION['usuario_id'])): ?>
            
        <div id="talleres_section_mis_talleres" hidden>
            <?php include '../app/vistas/talleres/mis_talleres.php'; ?>
        </div>            

    <?php endif; ?>
    



    
</main>

<footer>
    <?php
        include '../app/vistas/componentes/footer.php';
    ?>
</footer>


<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>