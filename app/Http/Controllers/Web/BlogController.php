<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public $token;
    public $api;

    public function __construct()
    {
        $this->api = new ApiController;
        $this->token = $this->api->token();
    }

    public function infoBlog() {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/v2/blog/articulos')->json();
        return $response;
    }

    public function articulosRecientes()
    {
        if(Cache::has("articulosRecientes")){
            return Cache::get('articulosRecientes');
        } else {
            $response = Http::withToken($this->token)
                        ->withHeaders([
                            'realip'  => $_SERVER['REMOTE_ADDR'],
                            'dominio' => $_SERVER['SERVER_NAME']
                        ])
                        ->get('https://app.bookingtrap.com/api/v2/blog/articulosRecientes')->json();
            Cache::put('articulosRecientes', $response);
            return $response;
        }
    }

    public function categoriasBlog() 
    {
        if(Cache::has("categoriasBlog")) {
            return Cache::get('categoriasBlog');
        } else {
            $response = Http::withToken($this->token)
                        ->withHeaders([
                            'realip'  => $_SERVER['REMOTE_ADDR'],
                            'dominio' => $_SERVER['SERVER_NAME']
                        ])
                        ->get('https://app.bookingtrap.com/api/v2/blog/categorias')->json();
            Cache::put('categoriasBlog', $response);
            return $response;
        }
    }

    public function informacionArticulo($idPost) 
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/v2/blog/articulo/?idArticulo=' . $idPost)->json();
        return $response;
    }

    public function articulosPorCategoria($idCategoria) 
    {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME']
                    ])
                    ->get('https://app.bookingtrap.com/api/v2/blog/articulos/categoria/?categoria=' . $idCategoria)->json();
        
        //$response = Http::withToken($this->token)
        //->withBody(json_encode($idCategoria), 'application/json')
        //->get('https://app.bookingtrap.com/api/v2/blog/articulos/categoria');
        return $response;
    }
}
