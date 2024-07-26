<?php

namespace App\Http\Controllers\Web;

use stdClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\FnController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\HotelController;
use App\Http\Controllers\Web\OpenPayController;
use App\Http\Controllers\Web\CivitatisController;
use App\Http\Controllers\Web\ExperienciaController;
use App\Http\Controllers\Web\TransportacionController;

class SiteMapController extends Controller
{
    private $siteMap;
    private $hoteles;
    private $experiencias;
    private $civitatis;
    private $token;
    private $fn;
    private $openpay;
    private $blog;
    private $transportacion;
    private $startOfMonth;

    public function __construct()
    {
        $this->siteMap          = new SiteMap();
        $this->hoteles          = new HotelController();
        $this->experiencias     = new ExperienciaController();
        $this->civitatis        = new CivitatisController();
        $this->blog             = new BlogController();
        $this->fn               = new FnController();
        $this->openpay          = new OpenPayController();
        $this->transportacion   = new TransportacionController();
        $this->startOfMonth     = Carbon::now()->startOfMonth()->format('c');
    }    
    
    public function index()
    {
        $this->addUniqueRoutes();
        $this->addBlog();
        $this->addExperiencias();        
        $this->addCivitatisHome();

        //Hoteleria 
        $this->addHotelesHome();
        $this->addHotels();
        
        
        

        return response($this->siteMap->build(), 200)
            ->header('Content-Type', 'text/xml');
    }

    private function addUniqueRoutes()
    {
        $this->siteMap->add(
            Url::create('/')
                ->lastUpdate($this->startOfMonth)
                ->frequency('monthly')
                ->priority('1.00')
        );

        $this->siteMap->add(
            Url::create('/experiencias')
                ->lastUpdate($this->startOfMonth)
                ->frequency('monthly')
                ->priority('0.9')
        ); 
        
        $this->siteMap->add(
            Url::create('/galeria')
                ->lastUpdate($this->startOfMonth)
                ->frequency('monthly')
                ->priority('0.9')
        );   
        
        $this->siteMap->add(
            Url::create('/blog')
                ->lastUpdate($this->startOfMonth)
                ->frequency('monthly')
                ->priority('0.9')
        );   
        
        $this->siteMap->add(
            Url::create('/nosotros')
                ->lastUpdate($this->startOfMonth)
                ->frequency('monthly')
                ->priority('0.9')
        );   
        
        $this->siteMap->add(
            Url::create('/contacto')
                ->lastUpdate($this->startOfMonth)
                ->frequency('monthly')
                ->priority('0.9')
        );                   
        
    }

    private function addBlog()
    {
        $noticias = $this->blog->infoBlog();
        foreach($noticias as $noticia){
            $link = '/blog/articulo/'.$this->fn->stringToUrl($noticia['titulo']).'/'.$noticia["id"];
            $this->siteMap->add(
                Url::create($link)
                    ->lastUpdate($this->startOfMonth)
                    ->frequency('monthly')
                    ->priority('0.8')
            );            
        }
    }

    private function addExperiencias()
    {
        $experiencias    = $this->experiencias->listado();
        $experienciasAll = $experiencias["data"]["tours"];
        foreach($experienciasAll as $experiencia){
            $link = "tours/" . mb_strtolower($experiencia["carpeta_seo"]) . "/" . $this->fn->stringToUrl($experiencia["nombre"]) . "/" . $experiencia["id"];
            $this->siteMap->add(
                Url::create($link)
                    ->lastUpdate($this->startOfMonth)
                    ->frequency('weekly')
                    ->priority('0.9')
            );            
        }        
    }

    private function addHotelesHome()
    {
        $hotelesHome            = $this->hoteles->destinosHotelerosFavoritos();
        $hotelesHomeData        = $hotelesHome['data'];

        foreach($hotelesHomeData as $hotel){
            $link = "hoteles-en/".$this->fn->stringToUrl($hotel['nombre_destino'])."/".$hotel['id_region'];
            $this->siteMap->add(
                Url::create($link)
                    ->lastUpdate($this->startOfMonth)
                    ->frequency('weekly')
                    ->priority('0.9')
            );            
        } 
    }

    private function addCivitatisHome()
    {
        $civitatisHome          = $this->civitatis->civitatisHome();
        foreach ($civitatisHome['result'] as $civitatiHome){
            if($civitatiHome['tipo'] == 'destino'){
                $link = "tours-list?lang=es&nombreDestinoTour=".$this->fn->reemplaza_espacios($civitatiHome['nombre'])."&idDestinoTour=".$civitatiHome['id'];
            }else{
                $link = "actividad/".$this->fn->reemplaza_espacios($civitatiHome['nombre'])."/".$civitatiHome['id'];
            }
            
            $this->siteMap->add(
                Url::create($link)
                    ->lastUpdate($this->startOfMonth)
                    ->frequency('weekly')
                    ->priority('0.9')
            );             
        }
    }

    private function addHotels()
    {
        // $hotelesHome            = $this->hoteles->destinosHotelerosFavoritos();
        // $hotelesHomeData        = $hotelesHome['data'];

        // foreach($hotelesHomeData as $hotel){
        //     $form               = new stdClass();
        //     $monedaSeleccionada = "MXN";
        //     $sandbox            = false;

        //     $checkinDate  = '2024-02-01';
        //     $checkoutDate = '2024-02-02';
        //     $adultos      = 2;
        //     $menores      = 0;
        //     $menoresTxt   = 'cero';
        //     $totalPublico = 0;
        //     $residency    = 'MXN';
        //     $markup       = '';

        //     $form->destinoHotelero = $hotel['id_region'];
        //     $form->adultos         = $adultos;
        //     $form->menores         = $menores;
        //     $form->checkin         = $checkinDate;
        //     $form->checkout        = $checkoutDate;
        //     $lista                 = $this->hoteles->buscaHotelesMotorSEO($form, $monedaSeleccionada, $sandbox);
        //     $markup                = $lista["comision"][0]["comision_hoteleria"];
        //     $hoteles               = $lista["hoteles"]["data"]["hotels"];

        //     if ($hoteles != null) {
        //         foreach ($hoteles as $conteo => $hotel) {
        //             $idhotel   = $hotel['id'];
        //             $hotelName = $idhotel;

        //             $link  = 'hotel/'.$idhotel."/".$this->fn->stringToUrl($hotelName);
        //             $link .= '/' . $checkinDate;
        //             $link .= '/' . $checkoutDate;
        //             $link .= '/' . $adultos;
        //             $link .= '/' . $menoresTxt;
        //             $link .= '/' . $totalPublico;
        //             $link .= '/' . $residency;
        //             $link .= '/' . $markup . '/';

        //             $this->siteMap->add(
        //                 Url::create($link)
        //                     ->lastUpdate($this->startOfMonth)
        //                     ->frequency('daily')
        //                     ->priority('0.7')
        //             );                     
        //         }
        //     }           
        // }        
    }
}

class SiteMap
{
    const START_TAG = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    const END_TAG = '</urlset>';

    // to build the XML content
    private $content;

    public function add(Url $siteMapUrl)
    {
        $this->content .= $siteMapUrl->build();
    }

    public function build()
    {
        return self::START_TAG . $this->content . self::END_TAG;
    }
}

class Url
{
    private $url;
    private $lastUpdate;
    private $frequency;
    private $priority;

    public static function create($url)
    {
        $newNode = new self();
        $newNode->url = url($url);
        return $newNode;
    }

    public function lastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

    public function frequency($frequency)
    {
        $this->frequency = $frequency;
        return $this;
    }

    public function priority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    public function build()
    {
        // $url = 'https://programacionymas.com/';
        // $lastUpdate = '2019-07-31T01:06:39+00:00';
        // $frequency = 'monthly';
        // $priority = '1.00';
        return "<url>" .
            "<loc>".htmlspecialchars($this->url)."</loc>" .
            "<lastmod>".htmlspecialchars($this->lastUpdate)."</lastmod>" .
            "<changefreq>".htmlspecialchars($this->frequency)."</changefreq>" .
            "<priority>".htmlspecialchars($this->priority)."</priority>" .
        "</url>";
    }
}