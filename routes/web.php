<?php

use Faker\Core\Number;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SitioWebController;
use App\Http\Controllers\Web\SiteMapController;
use App\Http\Controllers\Web\HotelController;
use App\Http\Controllers\Web\CivitatisController;
use App\Http\Controllers\Web\FormularioController;

Auth::routes();

// Página principal
Route::get('/',                                     [SitioWebController::class, 'index'] )                   ->name('index');

Route::get('/test',                                 [SitioWebController::class, 'tester'] )                   ->name('tester');
Route::get('/preguntas-frecuentes', fn() => view('web.preguntasFrecuentes'))->name('preguntas');

//Paginas generales
Route::get('/nosotros',                             function(){ return view("web.nosotros"); });
Route::get('/contacto',                             [SitioWebController::class, 'contacto'])                 ->name('contacto');
Route::get('/terminos-condiciones',                 [SitioWebController::class, 'terminosYCondiciones'])     ->name('terminos-condiciones');
Route::get('/aviso-privacidad',                     [SitioWebController::class, 'avisoPrivacidad'])          ->name('aviso-privacidad');
Route::get('/gracias-email',                        [SitioWebController::class, 'graciasEmail'])             ->name('gracias-email');
Route::get('/changeCurrency',                       [SitioWebController::class, 'changeCurrency'])           ->name('changeCurrency');
Route::get('/galeria',                              [SitioWebController::class, 'galeria'])                  ->name('galeria');
Route::get('/circuitos/{entidad}/{entidad2}/{id}',  [SitioWebController::class, 'circuitosTuristicos'])      ->name('circuitosTuristicos.entidad.entidad2.id');
Route::post('/paypalEstatus',                       [SitioWebController::class, 'getEstatusPaypal'])         ->name('getEstatusPaypal');

//Exclusivo para envio y recepcion de email Personalizados de una Agencia
Route::get('/formularioAgencia',                    function(){ return view("web.formularioAgencia"); });
Route::post('/graciasAgencia',                      [FormularioController::class, 'formularioAgencia'])      ->name('graciasAgencia');

//Experiencias
Route::get('/experiencias',                         [SitioWebController::class, 'experiencias'] )            ->name('experiencias');
Route::get('/experiencias/{categoria}/{id}',        [SitioWebController::class, 'categoriasExperienciasUnica'])   ->name('categoriasExperiencias.categoria.id');
Route::get('/tours/{seo1}/{seo2}/{idtour}',         [SitioWebController::class, 'experiencia_detalle'] )     ->name('experiencia_detalle');
Route::get('/getPrices',                            [SitioWebController::class, 'getPrices'])                ->name('getPrices');
Route::post('/datos-compra',                        [SitioWebController::class, 'datosCompra'])              ->name('datos-compra');
Route::post('/save-openpay',                        [SitioWebController::class, 'saveOpenPay'])              ->name('save-openpay');
Route::get('/save-openpay',                         [SitioWebController::class, 'saveOpenPay'])              ->name('save-openpay-get');
Route::post('/guardar-openpay',                     [SitioWebController::class, 'guardarOpenPay'])          ->name('guardarOpenpay')->defaults('openpay', '0');
// Route::get('/gracias-openpay',                      [SitioWebController::class, 'graciasOpenPay'])           ->name('gracias-openpay');
Route::get('/gracias-openpay',                      [SitioWebController::class, 'graciasOpenpayExpriencias'])           ->name('gracias-openpay');
Route::get('/gracias',                              [SitioWebController::class, 'graciasOpenpayContacto'])              ->name("graciasOpenpayContacto");

//Hoteles
Route::get('/buscar-hotel',                         [HotelController::class,         'buscaHotel'])               ->name('buscaHotel');
Route::get('/hotels-list',                          [SitioWebController::class,      'listaHoteles'])             ->name('listaHoteles');
Route::get('/hoteles-en/{nombreDestino}/{idregion}',[SitioWebController::class,      'hotelesRegion'] )           ->name('hotelesRegion');
Route::get('/hotel/{hotelName}/{idHotel}/{checkin}/{checkout}/{adultos}/{menores}/{total}/{residency}/{markup}',  [SitioWebController::class, 'habitaciones'])        ->name('habitaciones');
Route::get('/datos-compra-hotel',                   [SitioWebController::class,      'datosCompraHotel'])         ->name('datos-compra-hotel');
Route::post('/save-openpay-hotel',                  [SitioWebController::class,      'saveOpenPayHotel'])         ->name('save-openpay-hotel');
Route::get('/save-openpay-hotel',                   [SitioWebController::class,      'saveOpenPayHotel'])         ->name('save-openpay-hotel-get');
Route::get('/gracias-openpay-hotel',                [SitioWebController::class,      'graciasHoteles'])           ->name('gracias-openpay-hotel');

Route::get('/hotels-list-b',                        [SitioWebController::class,      'listaHotelesV2'])             ->name('listaHotelesB');
Route::get('/hotels-list-ajax',                     [SitioWebController::class,      'ajaxHotelListaV2'])             ->name('ajaxHotelLista');

//Blog
Route::get('/blog',                                  [SitioWebController::class, 'listBlog'] )                     ->name('blog');
Route::get('/blog/articulo/{titulo}/{id}',           [SitioWebController::class, 'detalleArticulo'] )              ->name('detalleArticulo');
Route::get('/blog/categoria/{nombre}/{idCategoria}', [SitioWebController::class, 'listCategoriaArticulo'] )        ->name('categoriaArticulo');

//Resultados de busqueda de tours civitatis en el motor
Route::get('/buscar-tour',                         [CivitatisController::class, 'buscaTour'] )                      ->name('buscaTour');
Route::get('/tours-list',                          [SitioWebController::class, 'tourList'] )                        ->name('toursResult');
Route::get('/actividad/{seo}/{idtour}',            [SitioWebController::class, 'tourDetalle'] )                     ->name('tourDetalle');
Route::post('/datos-compra-civitatis',             [SitioWebController::class, 'datosCompraCivitatis'] )            ->name('datos-compra-civitatis');
Route::post('/save-openpay-civitatis',             [SitioWebController::class, 'saveOpenPayCivitatis'] )            ->name('save-openpay-civitatis');
Route::get('/save-openpay-civitatis',              [SitioWebController::class, 'saveOpenPayCivitatis'] )            ->name('save-openpay-civitatis-get');
Route::get('/gracias-openpay-civitatis',           [SitioWebController::class, 'graciasCivitatis'] )         ->name('gracias-openpay-civitatis');

//Enlace directo a tours de civitatis
Route::get('/tours-en/{nombreDestino}/{idtour}',    function(){ return view("web.index"); });

//Transportaciones MV1
Route::get('/destination-transporte',              [SitioWebController::class, 'destinoTransporte'])                             ->name('destination-transporte');
Route::get('/transportation-list',                 [SitioWebController::class, 'transportationList'])                               ->name('transportation-list');
Route::get('/datos-compra-transportacion/{datosCompraTransporte}',         [SitioWebController::class, 'datosCompraTransportacionM1'])                               ->name('datos-compra-transportacion-m1');
Route::post('/save-openpay-transportacion-m1',             [SitioWebController::class, 'saveOpenPayTransportacionM1'] )            ->name('save-openpay-transportacion-m1');
// Route::get('/gracias-openpay-transportacion-m1',           [SitioWebController::class, 'graciasOpenPayTransportacionesM1'] )         ->name('gracias-openpay-transportacion-m1');
Route::get('/gracias-openpay-transportaciones',           [SitioWebController::class, 'graciasOpenPayTransportacionesM1'] )         ->name('gracias-openpay-transportaciones-m1');

Route::get('/save-openpay-transportaciones',             [SitioWebController::class, 'saveOpenPayTransportaciones'] )            ->name('save-openpay-transportaciones');

//Cupones
Route::post('/validarCupon',                 [SitioWebController::class, 'validarCupon'])                               ->name('validarCupon');

//SiteMap
Route::get('/sitemap.xml',                   [SiteMapController::class, 'index'])                             ->name('sitemap');

//Exclusivo uso para TravelCit
// Route::get('/tiposexperiencias/{categoriaEx}/{idEx}',[SitioWebController::class, 'categoriasExcursionesUnica'])   ->name('tiposexperiencias.categoriaEx.idEx');

// Route::get('/ofertas-megatravel',                             function(){ return view("web.ofertasMegatravel"); });