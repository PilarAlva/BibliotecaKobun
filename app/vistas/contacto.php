<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
     <main id="contacto-main">

        <!-- Sección título e introducción -->
        <section id="intro-contacto">
            <h3>CONTACTO</h3>
            <p><em>Dejanos tu consulta y te responderemos lo antes posible. Estamos para ayudarte a que tu experiencia en Kobun sea única.</em></p>
        </section>
            
        <div class="contenedor-contacto">
            <!-- Sección formulario -->
            <section id="formulario-contacto">
                <form action="<?php echo BASE_URL . 'contacto/enviar'?>" method="post">

                    <h5>FORMULARIO</h5>

                    <label for="nombre">Nombre</label>
                    <input id="nombre" type="text" placeholder="Nombre" name="nombre" required
                    <?php if ($registrado) echo "value = '" . $usuario['usuario_nombre'] . "' readonly"; ?> 
                    />
                    
                    <label for="email">Email</label>
                    <input id="email" type="email" placeholder="Mail@gmail.com" name="email" required
                    <?php if ($registrado) echo "value = '" . $usuario['usuario_mail'] . "' readonly"; ?>
                    />
                    
                    <label for="tel">Teléfono</label>
                    <input id="tel" type="tel" placeholder="+54 9 11 XXXX-XXX" name="tel"
                    <?php if ($registrado) echo "value = '" . $usuario['usuario_telefono'] . "' "; ?>
                    />
                    
                    <div class="espacio-form">
                        <div>
                            <label for="mensaje">Consulta</label>
                            <textarea id="mensaje" name="mensaje" required rows="5"></textarea>
                        </div>
                        
                        <div id="botones-form">
                            <button type="reset" id="btn-reset">Borrar</button>
                            <button type="submit" id="btn-submit">Enviar</button>
                        </div>
                    </div>
                </form>
            </section>

            <!-- Sección información adicional -->
            <section id="info-contacto">
                <h5>HORARIOS DE ATENCIÓN</h5>
                <p>Jueves a Sábados 18:00 - 06:00<br>Domingos: 13:00 - 00:00</p>

                <h5>UBICACIÓN</h5>
                <iframe 
                    id="mapa" 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3282.305944655606!2d-58.58883198814903!3d-34.64697567282581!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcc790303dc6ed%3A0x2ae3ab988b23c6f1!2sBiblioteca%20P%C3%BAblica%20Haedo%20Rosario%20Vera%20Pe%C3%B1aloza!5e0!3m2!1ses-419!2sar!4v1762903641605!5m2!1ses-419!2sar" 
                    height="300" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                
                <address id="datos-contacto">
                    <div id="nombre"><span class="destacado">Kobun</span></div>
                    <div><span class="destacado">Dirección:</span> Av. Asamblea 1221. Parque Chacabuco (1406)</div>
                    <div><span class="destacado">Correo:</span> <a href="mailto:kobun@gmail.com">kobun@gmail.com</a></div>
                    <div><span class="destacado">Celular:</span> <a href="tel:+5491131599936">+54 9 113159-9936</a></div>
                </address>

                <div id="redes">
                    <p>Seguinos en nuestras redes:</p>
                    <div>
                        <a href="https://www.instagram.com" target="_blank">
                            <img src="img/instagram.png" alt="Instagram" width="30">
                        </a>
                        <a href="https://www.facebook.com" target="_blank">
                            <img src="img/facebook.png" alt="Facebook" width="30">
                        </a>
                        <a href="https://twitter.com" target="_blank">
                            <img src="img/twitter.png" alt="Twitter" width="30">
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer>

        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>