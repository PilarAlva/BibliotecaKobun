<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vistas/css/style.css">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <?php require 'vistas/header.php';?>

    <main class="">

        <div class="">
            <div class="">
                <h3>CONTACTO</h3>
            <p><em>Dejanos tu consulta y te responderemos lo antes posible. Estamos para ayudarte a que tu experiencia en Kobun sea única.</em></p>
            </div>
            

            <div class="">
                <form action="enviarmail.php" method="post">

                    <h5>FORMULARIO</h5>

                    <label>Nombre</label>
                    <input class="" type="text" placeholder="Gabriel" name="nombre" required>
                    
                    
                    <label for="email">Email</label>
                    <input class="" type="email" placeholder="Mail@gmail.com" name="email" required id="email">
                    

                    <label>Teléfono</label>
                    <input class="" type="tel" placeholder="+54 9 11 XXXX-XXX" name="tel">
                    
                    <label>Consulta</label>
                    <textarea class="" name="mensaje" required rows="5"></textarea>
                            
                    <div class="">
                        <button type="reset" class="">Borrar</button>
                        <button type="submit" class="">Enviar</button>
                    </div>
                
                    
                    
                </form>
            </div>

            <div class="">
                <h5>HORARIOS DE ATENCIÓN</h5>
                        <p>Jueves a Sábados 18:00 - 06:00<br>Domingos: 13:00 - 00:00</p>
                        <h5>UBICACIÓN</h5>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3282.7582198646764!2d-58.4448133898727!3d-34.63554977283005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccbcac53e97b9%3A0xb6e749a09c317752!2sInstituto%20de%20Formaci%C3%B3n%20T%C3%A9cnica%20Superior%20N%C2%BA%2027!5e0!3m2!1ses!2sar!4v1756511829973!5m2!1ses!2sar" height="200" style="" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <address id="datos"><strong>Kobun</strong><br>
                        Dirección: Av. Asamblea 1221. Parque Chacabuco (1406)<br>
                        <strong>Correo: </strong><a href="mailto:kobun@info.com">kobun@info.com</a><br>
                        <strong>Celular: </strong><a href="tel:+5491131599936">+54 9 113159-9936</a>
                        </address>
                        <div id="redes">
                            <p>Seguinos en nuestras redes:</p>
                            <a href="https://www.instagram.com" target="_blank">
                                <img src="vistas/img/insta.png" alt="Instagram" width="30">
                            </a>

                            <a href="https://www.facebook.com" target="_blank">
                                <img src="vistas/img/face.png" alt="Facebook" width="30">
                            </a>

                            <a href="https://twitter.com" target="_blank">
                                <img src="vistas/img/x.png" alt="Twitter" width="30">
                            </a>
                        </div>
            </div>
        </div>
    
        
                  


                 
    </main>

    <?php require 'vistas/footer.php';?>

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous">
    </script>
</body>
</html>