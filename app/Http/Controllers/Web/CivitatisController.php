<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\ApiController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CivitatisController extends Controller
{

    public $api;
    public $token;

    public function __construct()
    {
        $this->api      = new  ApiController();
        $this->token    = $this->api->token(); 
    }      
    public function buscaTour(Request $request){
        // return $request;
        $form["search"] = $request->search;
        $path = 'https://app.bookingtrap.com/api/civitatis/buscar'; 
        $response  = $this->api->getContentGet($path, $form);  
        $arrayMerge = array_merge_recursive($response['destinos'], $response['tours']);
        
        return $arrayMerge; 
        echo json_encode($response);
    }

    public function buscaToursMotor(Request $request, $moneda, $sandBox)
    {
        $form["lang"]     = $request->lang;
        $form["id"]       = $request->idDestinoTour;
        $form["currency"] = $moneda;
        $form["sandbox"]  = $sandBox;
        
        //comprobar si se envia el currency
        // $path="https://app.bookingtrap.com/api/getActivitiesCivitatis";
        // $response  = $this->api->getContentGet($path, $form); 

        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($form), 'application/json')
            ->get('https://app.bookingtrap.com/api/getActivitiesCivitatis');
        
            return $response;
    }

    public function tourDetalle($idtour, $moneda, $sandbox)
    {
        $form["id"]       = $idtour;
        $form["currency"] = $moneda;
        $form["sandbox"]  = $sandbox;

        // $path = "https://app.bookingtrap.com/api/getCivitatisTour";
        // $response  = $this->api->getContentGet($path, $form);
        
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($form), 'application/json')
            ->get('https://app.bookingtrap.com/api/getCivitatisTour');
        
        return $response;
    }

    public function agregarTourCarito($data) 
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($data), 'application/json')
            ->post('https://app.bookingtrap.com/api/reservation/tour/addCart');
        return $response;
    }

    public function agregarReserva($data) 
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($data), 'application/json')
            ->put('https://app.bookingtrap.com/api/reservation/tour/addBooking');
        return $response;
    }

    public function confirmaPagoReservaCivitatis($data) 
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($data), 'application/json')
            ->post('https://app.bookingtrap.com/api/reservation/tour/finishBooking');
        return $response;
    }

    public function civitatisHome() 
    {
        if (Cache::has("civitatisHome")) {
            $response = Cache::get('civitatisHome');
        } else {
            $response = Http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/v2/civitatis/home')->json();

                Cache::put('civitatisHome', $response);
        }
        return $response;
    }
}
