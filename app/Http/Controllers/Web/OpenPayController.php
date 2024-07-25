<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenPayController extends Controller
{
    public $api;
    public $token;

    public function __construct(){
        $this->api      = new  ApiController();  
        $this->token    = $this->api->token();
    }

    public function obtenerLinkOpenPay($data) {
        //return $data['nombre'];
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->withBody(json_encode($data), 'application/json')
                    ->get('https://app.bookingtrap.com/api/linkPayGenerator');
        return json_decode($response);
    }

    public function obtenerStatusPay($data) {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->withBody(json_encode($data), 'application/json')
                    ->get('https://app.bookingtrap.com/api/getStatusPay');
        return json_decode($response);
    }
}
