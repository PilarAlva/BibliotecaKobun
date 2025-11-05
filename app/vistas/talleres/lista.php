<script src="js/taller.js"></script>

<header class="header">
    <?php
        include '../app/vistas/componentes/header.php';
    ?>
</header>

<main class="main-content">
 
    <nav class="taller_paginas">
           <?php if (isset($_SESSION['usuario_id'])): ?>
               
               <ul class="taller_menu">
               
               <button id="btn_t_mt" tab ="talleres_section_mis_talleres" class="taller_menu_btn ">Mis talleres</button>
               <button id="btn_t_b" tab = "talleres_section_talleres_busqueda" class="taller_menu_btn selected">Busqueda</button>
                   
               </ul>
               
               <?php endif; ?>
    </nav>

    <div class="talleres__encabezado">

        <div class="buscador">
            <form action="<?php BASE_URL?>talleres/b/" method="POST">
                <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php echo htmlspecialchars(''); ?>">
                <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        
    </div>
        

   <div class="taller_cuerpo">

       <div id="talleres_section_talleres_busqueda" >
           <?php include '../app/vistas/talleres/busqueda.php'; ?>
       </div>
       
       <?php if (isset($_SESSION['usuario_id'])): ?>
               
           <div id="talleres_section_mis_talleres" hidden>
               <?php include '../app/vistas/talleres/mis_talleres.php'; ?>
           </div>            
   
       <?php endif; ?>

   </div>
    



    
</main>

<footer>
    <?php
        include '../app/vistas/componentes/footer.php';
    ?>
</footer>


<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>