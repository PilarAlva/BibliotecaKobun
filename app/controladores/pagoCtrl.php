<?php

    require '../vendor/autoload.php';
    use MercadoPago\Client\Common\RequestOptions;
    use MercadoPago\Client\Payment\PaymentClient;
    use MercadoPago\MercadoPagoConfig;
    


class PagoCtrl extends Controlador{
    
        public function __construct() {
        // Configura tu Access Token de Mercado Pago
        // Es una MUY BUENA práctica guardar esto en una variable de entorno y no directamente en el código.
        MercadoPagoConfig::setAccessToken("TEST-871194051580877-103109-9d2d1d43fb5f959797e60086efae79c8-285602852");
        }   
        public function pago(){

       

        $client = new PaymentClient();
        $request_options = new RequestOptions();
        $idempotencyKey = uniqid('payment_', true);
        $request_options->setCustomHeaders(["X-Idempotency-Key: $idempotencyKey"]);
        
        // This is not the correct place for this code. It should be in the procesarPago() method.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $payload = file_get_contents('php://input');
            $data = json_decode($payload, true);

            // Now you can access the data from the $data array.
            // For example: $token = $data['token'];
            echo var_dump($data);
            
            try{

                $payment = $client->create([
                "payment_method_id" => $data['payment_method_id'],
                "transaction_amount" => (float) $data['transaction_amount'],
                "payer" => [
                    "email" => $data['payer']['email'],
                ]
                ], $request_options);
                
                echo implode($payment);

            } catch (MPApiException $e) {

                echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
                echo "Content: ";           
                var_dump($e->getApiResponse()->getContent());
                echo "\n";
                
            } catch (\Exception $e) {
                echo $e->getMessage();
            }




           
            //$this->mostrarVista('pago', $data, 'Pago');
        }

    }
    public function generarLinkPago() {
        // Este método sería llamado por una nueva ruta, por ejemplo /pago/generar
        try {
            // Crea un cliente de preferencia
            $client = new PreferenceClient();

            // Crea un item para la preferencia
            // Aquí puedes obtener los datos de tu base deatos, como la cuota del socio, una multa, etc.
            $item = [
                "title" => "Cuota Socio Biblioteca Kobun",
                "quantity" => 1,
                "unit_price" => 2500, // Ejemplo: Monto de la cuota
                "currency_id" => "ARS" // Moneda
            ];

            // Crea la preferencia
            $preference = $client->create([
                "items" => [$item],
                "back_urls" => [ // URLs a las que se redirigirá al usuario después del pago
                    "success" => BASE_URL . "/pago?status=success",
                    "failure" => BASE_URL . "/pago?status=failure",
                    "pending" => BASE_URL . "/pago?status=pending"
                ],
                "auto_return" => "approved" // Redirige automáticamente en caso de pago aprobado
            ]);

            // Devuelve el link de pago (init_point) en formato JSON
            header('Content-Type: application/json');
            echo json_encode(['link' => $preference->init_point]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

