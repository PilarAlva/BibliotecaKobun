
<div id="gestion-talleres" class="tab-content">
    <h3>Gestionar Talleres</h3>
    <!-- BUSQUEDA NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
    <div class="cabecera-gestion">
        <div class="buscador">
            <form id="buscador-taller" action="/" method="POST">
                <select name="filtro" class="selector">
                    <option value="titulo" <?php /* if($filtro=='titulo') */ echo 'selected'; ?>>Título</option>
                </select>
                <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php /* echo htmlspecialchars($busqueda); */ ?>">
                <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        
        <!-- BOTON NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
        <div>
            <button id="bt-agregar-taller" class="bt bt-añadir">Añadir Taller</button>
        </div>
    </div>

    <div class="cuerpo-gestion-material">

        <div class="muestra_meterial" id="cuerpo-material" >
            No hay talleres todavía 
        </div>

    </div>

</div>