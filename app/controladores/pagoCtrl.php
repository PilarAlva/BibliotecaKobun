<?php
    require_once '../vendor/autoload.php';

    use MercadoPago\Client\Common\RequestOptions;
    use MercadoPago\Client\Payment\PaymentClient;
    use MercadoPago\Client\Preference\PreferenceClient;
    use MercadoPago\Exceptions\MPApiException;
    use MercadoPago\MercadoPagoConfig;


class PagoCtrl extends Controlador{

        public function pago(){
    
            $data = [
                "public_key" => "TEST-ac92ff51-624f-4ceb-abf8-c891401b570e"
            ];
    
            $this->mostrarVista('pago', $data, 'Pago');
        }
    

    public function procesarPago(){

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);

        MercadoPagoConfig::setAccessToken('TEST-871194051580877-103109-9d2d1d43fb5f959797e60086efae79c8-285602852');
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::SERVER);

        $client = new PaymentClient();

        try {
            $request = [
                "transaction_amount" => $data['transaction_amount'],
                "description"        => $data['description'],
                "payment_method_id"  => $data['payment_method_id'],
                "token"              => $data['token'],
                "installments"       => $data['installments'],
                "payer" => [
                    "email"      => $data['payer']['email'],
                    "identification" => [
                        "number" => $data['payer']['identification']['number'],
                        "type"   => $data['payer']['identification']['type']
                    ]
                ]
            ];

            $request_options = new RequestOptions();
            $request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);

            $payment = $client->create($request, $request_options);
            
            echo json_encode([
                'id' => $payment->id,
                'status' => $payment->status,
                'detail' => $payment->status_detail
            ]);

        } catch (MPApiException $e) {
            echo json_encode([
                'error' => 'MPApiException',
                'status' => $e->getApiResponse()->getStatusCode(),
                'content' => $e->getApiResponse()->getContent()
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'error' => 'Exception',
                'message' => $e->getMessage()
            ]);
        }
    }

}

