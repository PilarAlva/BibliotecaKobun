<?php

    require '../vendor/autoload.php';
    use MercadoPago\Client\Common\RequestOptions;
    use MercadoPago\Client\Payment\PaymentClient;
    use MercadoPago\MercadoPagoConfig;
    


class PagoCtrl extends Controlador{

        public function pago(){

        MercadoPagoConfig::setAccessToken("TEST-871194051580877-103109-9d2d1d43fb5f959797e60086efae79c8-285602852");


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
}

