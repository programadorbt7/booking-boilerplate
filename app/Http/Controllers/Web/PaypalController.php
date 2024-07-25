<?php

namespace App\Http\Controllers\Web;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaypalController extends Controller
{

    private $client;
        
    public function __construct()
    {
        $this->client = new Client([
            // 'base_uri' => 'https://api-m.paypal.com'
            'base_uri' => 'https://api.sandbox.paypal.com'
        ]);
    }    

    public function getEstatus(Request $request){
        $sitioweb = session('sitioWeb');
        $clave    = array_search('4', array_column($sitioweb[0]["terminales"], "id"));

        $clientId = $sitioweb[0]["terminales"][$clave]["id_afiliacion"];
        $secret   = $sitioweb[0]["terminales"][$clave]["llave_privada"];

        $orderId     = $request->order;
        $accessToken = $this->getAccessToken($clientId, $secret);

        $requestUrl = "/v2/checkout/orders/$orderId/capture";
    
        $response = $this->client->request('POST', $requestUrl, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $accessToken"
            ]
        ]);
    
        return $response;
    }

    private function getAccessToken($clientId, $secret)
    {
        $response = $this->client->request('POST', '/v1/oauth2/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => 'grant_type=client_credentials',
                'auth' => [
                    $clientId, $secret, 'basic'
                ]
            ]
        );
    
        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    } 
}
