<?php

namespace App\Providers;

use Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\SitioWebController;
use App\Http\Controllers\Web\ExperienciaController;

class AppServiceProvider extends ServiceProvider
{
    protected $request;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){
            $sw       = new SitioWebController();
            $exp      = new ExperienciaController();
            $blog     = new BlogController();
            
            $cacheResponse = $sw->resetCacheStatus();
            $statusSandbox = $sw->sandBox();

            if($cacheResponse == 1) {
                session()->forget('sitioWeb');
                Artisan::call('cache:clear');
            }

            $url                    = Request::root();
            $sitioweb               = json_decode($sw->InfoWebEmpresa());
            $nameEnterprise         = 'Travezo';
            $countMegaTravel        = $sitioweb[0]->circuitos;
            $megaTravel             = $sw->circuitosMegaTravel();
            $hasImage               = $sw->circuitoMegaHasImage();
            $categoriasExperiencias = $exp->obtenerCategoriasExperiencias();
            $countArticulosRecientes= count($blog->infoBlog());

            $monedas            = $sw->Monedas();
            $monedaDefault      = $sw->MonedaDefault();           
            $monedaSeleccionada = session()->has('monedaSeleccionada') ? session('monedaSeleccionada') : $monedaDefault;
 
            $view->with('url', $url)
            ->with('sitioweb', $sitioweb)
            ->with('monedas', $monedas)
            ->with('monedaDefault', $monedaDefault)
            ->with('monedaSeleccionada', $monedaSeleccionada)
            ->with('countMegaTravel', $countMegaTravel)
            ->with('hasImage', $hasImage)
            ->with('megaTravel', $megaTravel)
            ->with('categoriasExperiencias', $categoriasExperiencias)
            ->with('nameEnterprise', $nameEnterprise)
            ->with('countArticulosRecientes', $countArticulosRecientes)
            ->with('statusSandbox', $statusSandbox);
        });        
        
    }
}
