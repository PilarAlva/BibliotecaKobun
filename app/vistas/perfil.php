<header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <main class="main-content">

        <h1> Perfil </h1>
        <p> Acá tiene que ir el perfil </p>

        <p> ID Usuario: <?php echo $usuario["id"]; ?> </p>
        <p> Nombre: <?php echo $usuario["nombre"]; ?> </p>
        <p> Apellido: <?php echo $usuario["apellido"]; ?> </p>
        <p> Email: <?php echo $usuario["mail"]; ?> </p>
        
        <?php if ($socio): ?>

        <h2> Socio: </h2>
        <p> Teléfono: <?php echo $socio["telefono"]; ?> </p>
        <p> DNI: <?php echo $socio["dni"]; ?> </p>
        <form method="POST" action="<?php BASE_URL?>pago">
                <input type="hidden" name="libro_id" value="<?php echo $libro["id"]?>">
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id'] ?>">
        </form>
        <?php endif; ?>
        
        <?php if (!$socio): ?>

            <a href="https://www.mercadopago.com.ar/subscriptions/checkout?preapproval_plan_id=af0c15e5b94d41bbb305b0eaa08fafff" name="MP-payButton" class='blue-button'>Suscribirme</a>
            <style>
            .blue-button {
            background-color: #3483FA;
            color: white;
            padding: 10px 24px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-size: 16px;
            transition: background-color 0.3s;
            font-family: Arial, sans-serif;
            }
            .blue-button:hover {
            background-color: #2a68c8;
            }
            </style>
            <script type="text/javascript">
            (function() {
                function $MPC_load() {
                    window.$MPC_loaded !== true && (function() {
                    var s = document.createElement("script");
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = document.location.protocol + "//secure.mlstatic.com/mptools/render.js";
                    var x = document.getElementsByTagName('script')[0];
                    x.parentNode.insertBefore(s, x);
                    window.$MPC_loaded = true;
                })();
            }
            window.$MPC_loaded !== true ? (window.attachEvent ? window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;
            })();
            /*
                    // to receive event with message when closing modal from congrants back to site
                    function $MPC_message(event) {
                    // onclose modal ->CALLBACK FUNCTION
                    // !!!!!!!!FUNCTION_CALLBACK HERE Received message: {event.data} preapproval_id !!!!!!!!
                    }
                    window.$MPC_loaded !== true ? (window.addEventListener("message", $MPC_message)) : null; 
                    */
            </script>
        <?php endif; ?>
        


</main>

    <footer>

        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>