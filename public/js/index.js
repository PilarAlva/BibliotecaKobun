
const mp = new MercadoPago('TEST-ac92ff51-624f-4ceb-abf8-c891401b570e');
const bricksBuilder = mp.bricks();

const renderCardPaymentBrick = async (bricksBuilder) => {
    const settings = {
        initialization: {
            amount: 1000,
            payer: {
                email: "test@test.com",
            },
        },
        customization: {
            visual: {
                paymentMethods: {
                    maxInstallments: 1
                }
            }
        },
        callbacks: {
            onReady: () => {
                /*
                  Callback called when Brick is ready.
                  Here you can hide loadings from your site, for example.
                */
            },
            onSubmit: (cardFormData) => {
                return new Promise((resolve, reject) => {
                    fetch("http://localhost/BibliotecaKobun/public/pago/procesar", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(cardFormData)
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        // handle payment result
                        console.log(data);
                        resolve();
                    })
                    .catch((error) => {
                        // handle error
                        console.error(error);
                        reject();
                    });
                });
            },
            onError: (error) => {
                console.error(error);
            },
        },
    };
    window.cardPaymentBrickController = await bricksBuilder.create('cardPayment', 'form-checkout', settings);
};

renderCardPaymentBrick(bricksBuilder);