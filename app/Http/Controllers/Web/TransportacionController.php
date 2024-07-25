<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransportacionController extends Controller
{
    public $api;
    public $token;

    public function __construct() {
        $this->api = new ApiController;
        $this->token = $this->api->token();
    }

    //TRANSPORTACIÓN M1 CONSUMO DE DESTINOS PARA MOTOR - Transportacion M1 Migración
    public function transportacionDestinations($data)
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->withBody(json_encode($data), 'application/json')
                    ->get('https://app.bookingtrap.com/api/transportacion/destinos');
        return $response;
    }

    public function transportacionServicesList($data)
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->withBody(json_encode($data), 'application/json')
                    ->get('https://app.bookingtrap.com/api/transportacion/listaprecios');
        return $response;
    }

    public function productosTransportacion() {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/transportacion/tiendita');
        return $response;
    }

    public function guardarReserva($data) {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->withBody(json_encode($data), 'application/json')
                    ->get('https://app.bookingtrap.com/api/transportacion/guardarReserva');
        return $response;
    }

    public function actualizarReservacionTransportacion($data) {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->withBody(json_encode($data), 'application/json')
                    ->get('https://app.bookingtrap.com/api/transportacion/actualizaReserva');
        return $response;
    }

    //TRANSPORTACIÓN M2 CONSUMO DE DESTINOS PARA MOTOR
    public function transportacionDestinationsM2()
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/v2/colectivo/rutasOrigen');
        return $response;

    }

    public function transportacionLlegada($idSalida)
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/v2/colectivo/rutasDestino', [ 'origen' => $idSalida]);
        return $response;
    }
}
