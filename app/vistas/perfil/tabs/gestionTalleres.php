
<div id="gestion-talleres" class="tab-content">
    <h3>Gestionar Talleres</h3>

    <div class="cabecera-gestion">
        <div class="buscador">
            <form id="buscador-talleres" action="/" method="POST">
                <input type="text" name="q" class="search-input" placeholder="Buscar..." value="<?php /* echo htmlspecialchars($busqueda); */ ?>">
                <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        
        <div>
            <button id="bt-agregar-taller" class="bt bt-añadir">Añadir Taller</button>
        </div>
    </div>

    <div class="cuerpo-gestion-material">

        <div class="muestra_meterial" id="cuerpo-talleres" >
            No hay talleres todavía 
        </div>

    </div>

</div>