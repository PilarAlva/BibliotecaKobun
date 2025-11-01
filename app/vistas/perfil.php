

<script src="https://sdk.mercadopago.com/js/v2">
</script>

    <header class="header">
        <?php
            include '../app/vistas/componentes/header.php'; 
        ?>
    </header>
    
    <main class="main-content">

        <h1> Perfil </h1>
        <p> Acá tiene que ir el perfil </p>

        <p> ID Socio: <?php echo $usuario["id"]; ?> </p>
        <p> Nombre: <?php echo $usuario["nombre"]; ?> </p>
        <p> Apellido: <?php echo $usuario["apellido"]; ?> </p>
        <p> Email: <?php echo $usuario["mail"]; ?> </p>
        

        <?php if ($socio): ?>

        <h2> Socio: </h2>
        <p> Teléfono: <?php echo $socio["telefono"]; ?> </p>
        <p> DNI: <?php echo $socio["dni"]; ?> </p>
    
                
        <div id="paymentBrick_container">
            </div>
            <script>
            const mp = new MercadoPago('TEST-ac92ff51-624f-4ceb-abf8-c891401b570e', {
                locale: 'es-AR'
            });
            const bricksBuilder = mp.bricks();
                const renderPaymentBrick = async (bricksBuilder) => {
                const settings = {
                initialization: {
                    /*
                    "amount" es el monto total a pagar por todos los medios de pago con excepción de la Cuenta de Mercado Pago y Cuotas sin tarjeta de crédito, las cuales tienen su valor de procesamiento determinado en el backend a través del "preferenceId"
                    }
                    */
                    amount: 10000,
                    preferenceId: "<PREFERENCE_ID>",
                    payer: {
                        firstName: "",
                        lastName: "",
                        email: "",
                    },
                    },
                    customization: {
                    visual: {
                        style: {
                        theme: "default",
                    },
                    },
                    paymentMethods: {
                        bankTransfer: "all",
                                            wallet_purchase: "all",
                                            debitCard: "all",
                                            creditCard: "all",
                        maxInstallments: 1
                    },
                    },
                    callbacks: {
                    onReady: () => {
                        /*
                        Callback llamado cuando el Brick está listo.
                        Aquí puede ocultar cargamentos de su sitio, por ejemplo.
                        */
                    },
                    onSubmit: ({ selectedPaymentMethod, formData }) => {
                        // callback llamado al hacer clic en el botón de envío de datos
                        return new Promise((resolve, reject) => {
                        fetch("/BibliotecaKobun/public/pago", {
                            method: "POST",
                            headers: {
                            "Content-Type": "application/json",
                            },
                            body: JSON.stringify(formData),
                        })
                            .then((response) => response.json())
                            .then((response) => {
                            // recibir el resultado del pago
                            resolve();
                            })
                            .catch((error) => {
                            // manejar la respuesta de error al intentar crear el pago
                            reject();
                            });
                        });
                    },
                    onError: (error) => {
                        // callback llamado para todos los casos de error de Brick
                        console.error(error);
                    },
                    },
                };
                window.paymentBrickController = await bricksBuilder.create(
                    "payment",
                    "paymentBrick_container",
                    settings
                );
                };
                renderPaymentBrick(bricksBuilder);
            </script>

   
        <?php endif; ?>

</main>

    <footer>

        <?php
            include '../app/vistas/componentes/footer.php';
        ?>

</footer>