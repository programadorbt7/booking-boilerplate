<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Web\ApiController;

class ExperienciaController extends Controller
{

    public $api;
    public $token;

    public function __construct()
    {
        $this->api   = new  ApiController();  
        $this->token = $this->api->token();
    }   

    public function listado()
    {
        if(Cache::has("listadoTours")) {
            return Cache::get('listadoTours');
        } else {
            $response = Http::withToken($this->token)
                        ->withHeaders([
                            'realip'  => $_SERVER['REMOTE_ADDR'],
                            'dominio' => $_SERVER['SERVER_NAME']
                        ])
                        ->get('https://app.bookingtrap.com/api/tours')->json();
            
            Cache::put('listadoTours', $response);
            return $response;
        }
    }

    public function infoTour($idtour)
    {
        $endpoint = 'https://app.bookingtrap.com/api/tours/?tour='.$idtour;  
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get($endpoint);
        return $response;        
    }

    public function experienciasSimilares($data)
    {
        $endpoint = 'https://app.bookingtrap.com/api/relatedTours';  
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get($endpoint, [
                        'categorias'  => $data["categorias"],
                        'idexcursion' => $data["idexcursion"]
                    ]);
        return $response;          
    }

    //Funcion para mostrar homeTours
    public function ToursInicio()
    {  
        if(Cache::has("toursInicio")) {
            return Cache::get('toursInicio');
        } else {
            $response = Http::withToken($this->token)
                        ->withHeaders([
                            'realip'  => $_SERVER['REMOTE_ADDR'],
                            'dominio' => $_SERVER['SERVER_NAME']
                        ])
                        ->get('https://app.bookingtrap.com/api/toursHome')->json();
            Cache::put('toursInicio', $response);
            return $response;
        }
    }

    public function obtenerCategoriasExperiencias() 
    {
        $response = http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/categories');
        return $response['data'];
    }

    public function obtenerCategoriaUnica($idCategoria) 
    {
        $response = http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/tours-categories?id='.$idCategoria);

        return $response;
    }

    // SOLO TRAVEL CIT
    public function obtenerTiposExcursion()
    {
        
            $response = Http::withToken($this->token)
                        ->withHeaders([
                            'realip'  => $_SERVER['REMOTE_ADDR'],
                            'dominio' => $_SERVER['SERVER_NAME']
                        ])
                        ->get('https://app.bookingtrap.com/api/experiencias/tipos-excursion');
            return $response;
    }

    // SOLO TRAVEL CIT
    public function obtenerToursTipos($data)
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/tours-tipos?id='. $data);
        return $response;
    }

    //Funcion para obtener otras experiencias
    public function otrasExperiencias()
    {
        if(Cache::has("otrasExperiencias")) {
            return Cache::get('otrasExperiencias');
        } else {
            $response = Http::withToken($this->token)
                        ->withHeaders([
                            'realip'  => $_SERVER['REMOTE_ADDR'],
                            'dominio' => $_SERVER['SERVER_NAME']
                        ])
                        ->get('https://app.bookingtrap.com/api/v2/experiencias/otrasExperiencias')->json();
            Cache::put('otrasExperiencias', $response);
            return $response;
        }
    }

    public function agregarReservacion($reservacion)
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
            ->post('https://app.bookingtrap.com/api/v2/experiencias/agregarReservacion', $reservacion);
        return $response;
    }

    public function actualizarReservacion($data)
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->withBody(json_encode($data), 'application/json')
                    ->post('https://app.bookingtrap.com/api/updateReservation');
        return $response;
    }
}
