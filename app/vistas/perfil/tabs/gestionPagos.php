
    <div id="gestion-pagos" class="tab-content">
        <h3>Gestionar Material Bibliográfico</h3>
        <!-- BUSQUEDA NOOOO FUNCIONAL :) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
        
        <div class="cabecera-gestion">
            <div class="buscador">
                <form id="buscador-pagos" action="/" method="POST">
                    <select name="filtro" class="selector">
                        <option value="transferencia" <?php /* if($filtro=='titulo') */ echo 'selected'; ?>>Transferencia</option>
                        <option value="efectivo" <?php /* if($filtro=='autor') */ echo 'selected'; ?>>Efectivo</option>  
                        <option value="todos" <?php /* if($filtro=='autor') */ echo 'selected'; ?>>Todos</option>  
                    </select>
                    <input type="hidden" name="q" class="search-input" placeholder="Buscar..." value="<?php /* echo htmlspecialchars($busqueda); */ ?>">
                    <button type="submit" class="boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            
            
            <div>
                <button id="bt-agregar-pago" class="bt bt-añadir">Registrar Pago</button>
            </div>
        </div>


        <div class="cuerpo-gestion-material">

            <div class="muestra_meterial" id="cuerpo-pagos" >

                No hay pagos registrados.

            </div>
            
        </div>
</div>