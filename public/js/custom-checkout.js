window.Mercadopago.setPublishableKey('TEST-ac92ff51-624f-4ceb-abf8-c891401b570e');

document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    window.Mercadopago.createToken(this, function(status, response) {
        if (status != 200 && status != 201) {
            alert("Verifica los datos de tu tarjeta");
        } else {
            var form = document.getElementById('payment-form');
            var cardToken = document.createElement('input');
            cardToken.setAttribute('name', 'token');
            cardToken.setAttribute('type', 'hidden');
            cardToken.setAttribute('value', response.id);
            form.appendChild(cardToken);
            
            var data = {
                token: response.id,
                payment_method_id: response.payment_method_id,
                installments: document.getElementById('installments').value,
                transaction_amount: 1000, // You should get this value from your backend
                description: "Product title",
                payer: {
                    email: document.getElementById('cardholderEmail').value,
                    identification: {
                        type: document.getElementById('identificationType').value,
                        number: document.getElementById('identificationNumber').value
                    }
                }
            };

            fetch("http://localhost/BibliotecaKobun/public/pago/procesar", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert("Pago realizado con éxito!");
            })
            .catch(error => {
                console.error(error);
                alert("Ocurrió un error al procesar el pago");
            });
        }
    });
});
