<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Web\FnController;
use App\Http\Controllers\Web\ApiController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\HotelController;
use App\Http\Controllers\Web\OpenPayController;
use App\Http\Controllers\Web\CivitatisController;
use App\Http\Controllers\Web\ExperienciaController;
use App\Http\Controllers\Web\TransportacionController;
use App\Http\Controllers\Web\PaypalController;

class SitioWebController extends Controller
{

    public $api;
    public $hoteles;
    public $experiencias;
    public $civitatis;
    public $token;
    public $fn;
    public $openpay;
    public $blog;
    public $transportacion;
    public $paypal;

    public function __construct()
    {
        $this->api              = new ApiController();
        $this->hoteles          = new HotelController();
        $this->experiencias     = new ExperienciaController();
        $this->civitatis        = new CivitatisController();
        $this->blog             = new BlogController();
        $this->token            = $this->api->token();
        $this->fn               = new FnController();
        $this->openpay          = new OpenPayController();
        $this->transportacion   = new TransportacionController();
        $this->paypal           = new PaypalController();
        $this->monedaSession();
    }

    public function InfoWebEmpresa()
    {
        if (session()->has('sitioWeb')) {
            //Si el sitio web ya esta en sesion, devolvemos la sesion
            $response = json_encode(session('sitioWeb'));
        } else {
            $response = Http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/mywebsite');

            $sesion = json_decode($response->getBody(), true);
            session(['sitioWeb' => $sesion]);
        }
        return $response;
    }

    public function Monedas()
    {
        //Nos trae todas las monedas de la agencia
        if (session()->has('monedasAgencia')) {
            //Si las monedas de la agencia ya existen en la sesion, la devolvemos de sesion
            $response = json_encode(session('monedasAgencia'));
        } else {
            //Si las monedas de la agencia aun no existen en sesion, consumimos la API
            $response = Http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/monedas');

            $sesion = json_decode($response->getBody(), true);
            session(['monedasAgencia' => $sesion]);
        }

        return $response;
    }

    public function MonedaDefault()
    {
        //Determina cual es la moneda que la agencia ha seleccionado como moneda default
        $monedas       = json_decode($this->Monedas());
        $monedaDefault = $monedas->data[0]->iso;
        return $monedaDefault;
    }

    public function tipoDeCambio()
    {
        $monedas        = json_decode($this->Monedas());
        $tipoDecambio   = $monedas->data[0]->tipo_cambio;
        return $tipoDecambio;
    }

    private function sessionAfiliado($request)
    {
        if (!session()->has('idAfiliado')) {
            //Si no existe la session se evalua el request y se asigna el valor
            $idAfiliado = $request->has('affiliate') ? $request->affiliate : 0;
            //se crea la session
            session(['idAfiliado' => $idAfiliado]);
        }
    }

    public function monedaSession()
    {
        if (!session()->has('monedaSeleccionada')) {
            //Si la monedaSeleccionada no esta en sesion, se consume la API
            $moneda = $this->MonedaDefault();
            session(['monedaSeleccionada' => $moneda]);
        }
    }

    public function sandBox()
    {
        $sandBox = false;
        return $sandBox;
    }

    public function slider()
    {
        if (Cache::has("slider")) {
            return Cache::get('slider');
        } else {
            $response = Http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/apiSlider')->json();
            Cache::put('slider', $response);

            return $response;
        }
    }

    public function resetCacheStatus()
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])->get('https://app.bookingtrap.com/api/v2/cache');
        return $response['cache'];
    }

    public function index(Request $request)
    {

        $this->sessionAfiliado($request);
        // return $request->session()->all();

        $sitioWeb               = json_decode($this->InfoWebEmpresa());
        $idLugar                = property_exists($sitioWeb[0], 'idLugar') ?  $sitioWeb[0]->idLugar : '';
        $nombreLugar            = property_exists($sitioWeb[0], 'nombreLugar') ? $sitioWeb[0]->nombreLugar : '';
        $id_zona                = property_exists($sitioWeb[0], 'id_zona') ? $sitioWeb[0]->id_zona : '';
        $slider                 = $this->slider();
        $distintivos            = $this->distintivos();
        $promocionesExpress     = $this->promocionesExpress();
        $civitatisHome          = $this->civitatis->civitatisHome();
        $hotelesHome            = $this->hoteles->destinosHotelerosFavoritos();
        $homeToursQry           = $this->experiencias->ToursInicio();
        $otrasExperienciasQry   = $this->experiencias->otrasExperiencias();
        $hotelesHomeData        = $hotelesHome['data'];
        $countHomeTours         = count($homeToursQry["data"]["tours"]);
        $countOtrasExperiencias = $otrasExperienciasQry['data']['tours'];
        $categoriasBlog         = $this->blog->categoriasBlog();
        $articulosRecientes     = $this->blog->articulosRecientes();
        // $countCivitatis = count($civitatisHome['total']);

        // Usabiliddad en SOLO TRAVEL CIT
        // $tiposExcursion        = $this->experiencias->obtenerTiposExcursion();
        // $listTiposExcursion    = $tiposExcursion["data"];

        // Usabilidad en ViajaSinTantaLana
        //$imagenesGaleria       = $this->galeria(false);


        if ($otrasExperienciasQry['data']['tours'] != null) {
            foreach ($otrasExperienciasQry['data']['tours'] as $i => $experiencia) {
                $precio = 0;

                if ($experiencia['adulto_sencilla'] > 0) {
                    $precio = $experiencia['adulto_sencilla'];
                }

                if ($experiencia['adulto_doble'] > 0) {
                    $precio = $experiencia['adulto_doble'];
                }

                if ($experiencia['adulto_triple'] > 0) {
                    $precio = $experiencia['adulto_triple'];
                }

                if ($experiencia['adulto_cuadruple'] > 0) {
                    $precio = $experiencia['adulto_cuadruple'];
                }

                $otrasExperiencias[$i]["precioReal"]    = $this->fn->precio($precio, $experiencia['iso'], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
                $otrasExperiencias[$i]["link"]          = 'tours/' . mb_strtolower($experiencia['carpeta_seo']) . '/' . $this->fn->stringToUrl($experiencia['nombre']) . '/' . $experiencia['id'];
                $otrasExperiencias[$i]["imagen"]        = $experiencia['imagen'];
                $otrasExperiencias[$i]["nombre"]        = $experiencia['nombre'];
                $otrasExperiencias[$i]["cantidad_dias"] = $experiencia['cantidad_dias'];
                $otrasExperiencias[$i]["estado_comercial"] = $experiencia['estado_comercial'];
                $otrasExperiencias[$i]["ciudad_comercial"] = $experiencia['ciudad_comercial'];
                $otrasExperiencias[$i]["descripcion"]   = $this->fn->recortar_cadena($experiencia['descripcion']);
                $otrasExperiencias[$i]["precioformato"] = $otrasExperiencias[$i]["precioReal"]["precioformato"];
                $otrasExperiencias[$i]["iso"]           = $otrasExperiencias[$i]["precioReal"]["iso"];
                $otrasExperiencias[$i]["tipoDuracion"]  = $experiencia['tipo_duracion'];
            }
        } else {
            $otrasExperiencias = [];
        }

        $contador = 0;
        // return $homeToursQry['data']['tours'];
        if ($homeToursQry['data']['tours'] != null) {
            foreach ($homeToursQry['data']['tours'] as $x => $homeTour) {
                $ids['ids'][$contador] = $homeTour['id'];
                $precio = 0;

                if ($homeTour['adulto_sencilla'] > 0) {
                    $precio = $homeTour['adulto_sencilla'];
                }
                if ($homeTour['adulto_doble'] > 0) {
                    $precio = $homeTour['adulto_doble'];
                }

                if ($homeTour['adulto_triple'] > 0) {
                    $precio = $homeTour['adulto_triple'];
                }

                if ($homeTour['adulto_cuadruple'] > 0) {
                    $precio = $homeTour['adulto_cuadruple'];
                }

                $favoritosTours[$x]["precioReal"]       = $this->fn->precio($precio, $homeTour['iso'], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
                $favoritosTours[$x]["link"]             = 'tours/' . mb_strtolower($homeTour['carpeta_seo']) . '/' . $this->fn->stringToUrl($homeTour['nombre']) . '/' . $homeTour['id'];
                $favoritosTours[$x]["imagen"]           = $homeTour['imagen'];
                $favoritosTours[$x]["nombre"]           = $homeTour['nombre'];
                $favoritosTours[$x]["promocion"]        = $homeTour['promocion'];
                $favoritosTours[$x]["descripcion"]      = $this->fn->recortar_cadena($homeTour['descripcion'], 200);
                $favoritosTours[$x]["estado_comercial"] = $homeTour['estado_comercial'];
                $favoritosTours[$x]["ciudad_comercial"] = $homeTour['ciudad_comercial'];
                $favoritosTours[$x]["cantidad_dias"]    = $homeTour['cantidad_dias'];
                $favoritosTours[$x]["precioformato"]    = $favoritosTours[$x]["precioReal"]["precioformato"];
                $favoritosTours[$x]["iso"]              = $favoritosTours[$x]["precioReal"]["iso"];
                $favoritosTours[$x]["tipoDuracion"]     = $homeTour['tipo_duracion'];
            }
        } else {
            $favoritosTours = [];
        }

        return view("web.index", compact(
            'hotelesHome',
            'hotelesHomeData',
            'favoritosTours',
            'otrasExperiencias',
            'promocionesExpress',
            'countHomeTours',
            'countOtrasExperiencias',
            'slider',
            'distintivos',
            'civitatisHome',
            'categoriasBlog',
            'articulosRecientes',
            'idLugar',
            'nombreLugar',
            'id_zona',
        ));
    }
    // 'listTiposExcursion'

    //contacto funcion
    public function contacto(Request $request)
    {
        $this->sessionAfiliado($request);

        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->get('https://app.bookingtrap.com/api/v2/website/contacto');

        return view('web.contacto', compact('response'));
    }

    public function terminosYCondiciones()
    {
        $sitioWeb = json_decode($this->InfoWebEmpresa());
        $terminosCondiciones = $sitioWeb[0]->politicas;
        return view('web.terminosCondiciones', compact('terminosCondiciones'));
    }

    public function avisoPrivacidad()
    {
        $sitioWeb = json_decode($this->InfoWebEmpresa());
        $avisoPrivacidad = $sitioWeb[0]->aviso_privacidad;
        return view('web.avisoPrivacidad', compact('avisoPrivacidad'));
    }

    public function graciasEmail(Request $request)
    {
        $responseReCaptcha = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', ['secret' => env('RECAPTCHA_SECRET_KEY'), 'response' => $request->input('g-recaptcha-response')])->object();

        if ($responseReCaptcha->success == true) {
            $statusReCaptcha = true;
            $response = Http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/v2/website/enviarEmail', [
                    'name_contact'       => $request->name_contact,
                    'lastname_contact'   => $request->lastname_contact,
                    'phone_contact'      => $request->phone_contact,
                    'email_contact'      => $request->email_contact,
                    'message_contact'    => $request->message_contact,
                    'humano'             => $request->humano,
                    'afiliado'           => $request->idAfiliado,
                    'statusReCaptcha'    => $statusReCaptcha,
                    'isoNumber'          => $request->isoNumber,
                    'codigoNumber'       => $request->codigoNumber,
                ]);
            return view('web.gracias-email');
        } else {
            return redirect()->back();
        }
    }

    public function galeria($galeria = true)
    {
        if (Cache::has("galeria")) {
            Cache::get('galeria');

            $response       = Cache::get('galeria');
            $imagenes       = $response;
            $countImagenes  = count($imagenes);
        } else {
            $response = http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/apiGallery')->json();

            $imagenes       = $response;
            $countImagenes  = count($imagenes);

            Cache::put('galeria', $response);
        }

        if ($galeria) {
            return view('web.galeria', compact('imagenes', 'countImagenes'));
        } else {
            return $response;
        }
    }

    public function reviews()
    {
        $response = $this->InfoWebEmpresa();
        $reviews = $response[0]['snippet_reviews'];
        return $reviews;
    }

    public function promocionesExpress()
    {
        if (Cache::has("promocionesExpress")) {
            return Cache::get('promocionesExpress');
        } else {
            $response = Http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/v2/promociones')->json();
            Cache::put('promocionesExpress', $response);

            return $response;
        }
    }

    public function  circuitosMegaTravel()
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->get('https://app.bookingtrap.com/api/megatravel')->json();
        return $response;
    }

    public function circuitosMegaTravelCount()
    {
        $sitioWeb = $this->InfoWebEmpresa();
        $circuitosWeb = $sitioWeb[0]['circuitos'];
        return $circuitosWeb;
    }

    public function circuitoMegaHasImage()
    {
        $circuitosMegaAll = $this->circuitosMegaTravel();
        $hasImage = false;

        foreach ($circuitosMegaAll as $circuito) {
            if ($circuito['imagen'] != null) {
                $hasImage = true;
                break;
            }
        }

        return $hasImage;
    }

    public function circuitosTuristicos(Request $request, $entidad, $nombreDestino, $id)
    {
        $sitioWeb = $this->InfoWebEmpresa();
        $destino = $id;
        $nombre = $nombreDestino;
        $imagen = 'https://www.megatravel.com.mx/tools/vi.php?Dest=' . $destino;

        return view('web.circuitosMega', compact('imagen', 'nombre'));
    }

    public function distintivos()
    {
        if (Cache::has("distintivos")) {
            return Cache::get('distintivos');
        } else {
            $response = Http::withToken(($this->token))
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/v2/website/distintivos')->json();

            Cache::put('distintivos', $response);
            return $response;
        }
    }

    // EXPERIENCIAS
    //Listado de experiencias
    public function experiencias(Request $request)
    {
        $this->sessionAfiliado($request);
        $experiencias = $this->experiencias->listado();

        $count              = count($experiencias["data"]["tours"]);
        $incluyes           = $experiencias["data"]["incluye"];
        $compara            = [];

        foreach ($incluyes as $incluye) {
            $compara[] = $incluye["id_excursion"];
        }

        $experienciasAll = $experiencias["data"]["tours"];
        $experienciasTodasLasCategorias = $experiencias["data"]['filtros'];

        //Funcionalidad de Filtros
        $paisesExperiencias         = $experienciasTodasLasCategorias['paises'];
        $estadosExperiencias        = $experienciasTodasLasCategorias['estados'];
        $tiposExperiencias          = $experienciasTodasLasCategorias['tipos'];
        $categoriasExperiencias3    = $experienciasTodasLasCategorias['categorias'];
        //conteo de tours por categoria
        $conteoPaisExperiencia       = $this->fn->conteo_experiencias(count($paisesExperiencias), $paisesExperiencias, $experienciasAll, "nombrepais");
        $conteoEstadoExperiencia     = $this->fn->conteo_experiencias(count($estadosExperiencias), $estadosExperiencias, $experienciasAll, "estado_comercial");
        $conteoTipoExperiencia       = $this->fn->conteo_experiencias(count($tiposExperiencias), $tiposExperiencias, $experienciasAll, "tipoexcursion");
        $conteoCategoriaExperiencia  = $this->fn->conteo_experiencias(count($categoriasExperiencias3), $categoriasExperiencias3, $experienciasAll, "categorias");
        //Fin del conteo de filtros

        if ($experienciasAll != null) {
            foreach ($experienciasAll as $i => $experiencia) {
                $precio = 0;

                if (!array_key_exists('categorias', $experiencia)) {
                    $experiencia["categorias"] = 'sin categoria';
                }

                if ($experiencia["adulto_sencilla"] > 0) {
                    $precio = $experiencia["adulto_sencilla"];
                }

                if ($experiencia["adulto_doble"] > 0) {
                    $precio = $experiencia["adulto_doble"];
                }

                if ($experiencia["adulto_triple"] > 0) {
                    $precio = $experiencia["adulto_triple"];
                }

                if ($experiencia["adulto_cuadruple"] > 0) {
                    $precio = $experiencia["adulto_cuadruple"];
                }

                $experienciasList[$i]["precioReal"]       = $this->fn->precio($precio, $experiencia["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
                $experienciasList[$i]["link"]             = "tours/" . mb_strtolower($experiencia["carpeta_seo"]) . "/" . $this->fn->stringToUrl($experiencia["nombre"]) . "/" . $experiencia["id"];
                $experienciasList[$i]["imagen"]           = $experiencia["imagen"];
                $experienciasList[$i]["nombre"]           = $experiencia["nombre"];
                $experienciasList[$i]["descripcion"]      = $this->fn->recortar_cadena($experiencia["descripcion"], 200);
                $experienciasList[$i]["cantidad_dias"]    = $experiencia["cantidad_dias"];
                $experienciasList[$i]["estado_comercial"] = $experiencia["estado_comercial"];
                $experienciasList[$i]["ciudad_comercial"] = $experiencia["ciudad_comercial"];
                $experienciasList[$i]["precioformato"]    = $experienciasList[$i]["precioReal"]["precioformato"];
                $experienciasList[$i]["iso"]              = $experienciasList[$i]["precioReal"]["iso"];
                $experienciasList[$i]["tipoexcursion"]    = $experiencia["tipoexcursion"];
                $experienciasList[$i]["nombrepais"]       = $experiencia["nombrepais"];
                $experienciasList[$i]["categorias"]       =  $experiencia["categorias"];
                $experienciasList[$i]["tipoDuracion"]     =  $experiencia["tipo_duracion"];
                $experienciasList[$i]["idpromocion"]      =  $experiencia["idpromocion"];
            }
        } else {
            $experienciasList = [];
        }

        return view("web.experiencias.index", compact(
            'count',
            'experienciasList',
            'paisesExperiencias',
            'estadosExperiencias',
            'tiposExperiencias',
            'categoriasExperiencias3',
            'conteoEstadoExperiencia',
            'conteoPaisExperiencia',
            'conteoTipoExperiencia',
            'conteoCategoriaExperiencia'
        ));
    }

    //Detalle de una experiencia
    public function experiencia_detalle(Request $request, $seo1, $seo2, $idtour)
    {


        $this->sessionAfiliado($request);
        $monedas             = $this->Monedas();

        $monedaDefault       = $this->MonedaDefault();
        $monedaSeleccionada  = session('monedaSeleccionada');
        $tour                = $this->experiencias->infoTour($idtour);

        // return $tour['fechas'];
        $itinerario_es       = $tour['paquete'][0]['itinerario_es'];
        $tipo_reserva        = $tour['paquete'][0]['tipo_reserva_hotelera'];
        $youtube             = $tour['paquete'][0]['youtube'];
        $isotour             = $tour['paquete'][0]['iso'];
        $clases              = $tour['clases'];
        $calendario          = $tour['paquete'][0]['calendario'];
        $tipo_costo          = $tour['paquete'][0]['tipo_costo'];
        $tipoDuracion        = $tour['paquete'][0]['tipo_duracion'];
        $cant_pax_min        = $tour['paquete'][0]['cant_pax_min'];
        $cant_pax_max        = $tour['paquete'][0]['cant_pax_max'];
        $imagenUnica         = $tour['imagenes'][0]['imagen'];
        $recomendacionesTour = $tour['recomendaciones'];
        $acepta_extras       = $tour['paquete'][0]['acepta_extra'];
        $tipo_ind_comb       = $tour['paquete'][0]['tipo_ind_comb'];
        $pax_max_extra       = $tour['paquete'][0]['pax_max_extra'];
        $tipoCambio          = $tour['paquete'][0]['tipo_cambio'];
        $cambioMoneda        = $tour['paquete'][0]['cambio_moneda'];
        $anticipo            = $tour['paquete'][0]['anticipo'];
        $procesoPago         = $tour['paquete'][0]['proceso_pago'];
        $tipo_valor          = $tour['paquete'][0]['tipo_valor'];
        $release             = $tour['paquete'][0]['release'];

        if ($tour['promociones'] != null) {
            $nombre_promo        = $tour['promociones'][0]['nombre'];
        } else {
            $nombre_promo = '';
        }


        if ($tour['fechas'] != null) {
            $adulto_extra        =  $tour['fechas'][0]['adulto_extra'];
        } else {
            $adulto_extra        = "";
        }



        // return gettype($tour["paquete"][0]["dias_operacion"]);
        if ($tour["paquete"][0]["dias_operacion"] != null || $tour["paquete"][0]["dias_operacion"] != "") {
            $dias_operacion = json_encode(explode(",", $tour["paquete"][0]["dias_operacion"]));
        } else {
            $dias_operacion = "";
        }

        // Asignacion de precio minimo
        if ($tour["paquete"][0]["calendario"] == 0) {
            if ($tour["precios"] != null) {
                $precioMinimoB       = $this->fn->precioMinimo($tour["precios"]);
            } else {
                $precioMinimoB = 0;
            }
            $precioMinimo        = $this->fn->precio($precioMinimoB, $tour["paquete"][0]["iso"], $monedaSeleccionada, $monedaDefault, $monedas);
        } else {
            if ($tour["fechas"] != null) {
                $precioMinimoB       = $this->fn->precioMinimo($tour["fechas"]);
            } else {
                $precioMinimoB = 0;
            }
            $precioMinimo        = $this->fn->precio($precioMinimoB, $tour["paquete"][0]["iso"], $monedaSeleccionada, $monedaDefault, $monedas);
        }

        //Buscamos los paquetes similares
        $categorias = $tour['categorias'];
        $categoriasArray = array_column($categorias, 'id_categoria');
        $categorias_txt  = implode(',', $categoriasArray);

        $formCategorias['categorias']  = $categorias_txt;
        $formCategorias['idexcursion'] = $idtour;
        //return $formCategorias;
        $toursRelacionados             = $this->experiencias->experienciasSimilares($formCategorias);

        $rangoMenores = $tour['paquete'][0]['edad_menor_min'] . ' - ' . $tour['paquete'][0]['edad_menor_max'] . ' años';
        $edadAdulta   = $tour['paquete'][0]['edad_menor_max'] + 1;
        $rangoAdultos = 'A partir de ' . $edadAdulta . ' años';

        if ($tour['paquete'][0]['tipo_min_infantes'] == 0 && $tour['paquete'][0]['tipo_max_infantes'] == 0) {
            //Ambos rangos son Años
            $rangoInfantes = $tour['paquete'][0]['edad_infante_min'] . ' - ' . $tour['paquete'][0]['edad_infante_max'];
            $rangoInfantes .= $tour['paquete'][0]['edad_infante_max'] == 1 ? ' año' : ' años';
        } else {
            if ($tour['paquete'][0]['tipo_min_infantes'] == 1 && $tour['paquete'][0]['tipo_max_infantes'] == 1) {
                //Ambos rangos son meses
                $rangoInfantes = $tour['paquete'][0]['edad_infante_min'] . ' - ' . $tour['paquete'][0]['edad_infante_max'];
                $rangoInfantes .= $tour['paquete'][0]['edad_infante_max'] == 1 ? ' mes' : ' meses';
            } else {
                //De meses a años
                $rangoInfantes = $tour['paquete'][0]['edad_infante_min'];
                $rangoInfantes .= $tour['paquete'][0]['edad_infante_min'] == 1 ? ' mes' : ' meses';

                $rangoInfantes .= ' - ' . $tour['paquete'][0]['edad_infante_max'];
                $rangoInfantes .= $tour['paquete'][0]['tipo_max_infantes'] == 1 ? ($tour['paquete'][0]['edad_infante_max'] == 1 ? ' mes' : ' meses') : ($tour['paquete'][0]['edad_infante_max'] == 0 ? ' año' : ' años');
            }
        }

        //Tours Relacionados
        $incluyes = $toursRelacionados["data"]["incluye"];
        $compara = [];
        foreach ($incluyes as $incluye) {
            $compara[] = $incluye["id_excursion"];
        }

        $countToursRelacionados = count($toursRelacionados["data"]["tours"]);

        if ($countToursRelacionados > 0) {
            foreach ($toursRelacionados["data"]["tours"] as $i => $tourRelacionadoUnico) {
                $precio = 0;

                if ($tourRelacionadoUnico["adulto_sencilla"] > 0) {
                    $precio = $tourRelacionadoUnico["adulto_sencilla"];
                }

                if ($tourRelacionadoUnico["adulto_doble"] > 0) {
                    $precio = $tourRelacionadoUnico["adulto_doble"];
                }

                if ($tourRelacionadoUnico["adulto_triple"] > 0) {
                    $precio = $tourRelacionadoUnico["adulto_triple"];
                }

                if ($tourRelacionadoUnico["adulto_cuadruple"] > 0) {
                    $precio = $tourRelacionadoUnico["adulto_cuadruple"];
                }

                $enlistadoRelacionados[$i]['id']                = $tourRelacionadoUnico['id'];
                $enlistadoRelacionados[$i]['nombre']            = $tourRelacionadoUnico['nombre'];
                $enlistadoRelacionados[$i]['imagen']            = $tourRelacionadoUnico['imagen'];
                $enlistadoRelacionados[$i]['cantidad_dias']     = $tourRelacionadoUnico['cantidad_dias'];
                $enlistadoRelacionados[$i]['carpeta_seo']       = $tourRelacionadoUnico['carpeta_seo'];
                $enlistadoRelacionados[$i]['ciudad_comercial']  = $tourRelacionadoUnico['ciudad_comercial'];
                $enlistadoRelacionados[$i]['estado_comercial']  = $tourRelacionadoUnico['estado_comercial'];
                $enlistadoRelacionados[$i]['precioReal']        = $this->fn->precio($precio, $tourRelacionadoUnico["iso"],  $monedaSeleccionada, $this->MonedaDefault(), $monedas);
                $enlistadoRelacionados[$i]['precioformato']     = $enlistadoRelacionados[$i]['precioReal']['precioformato'];
                $enlistadoRelacionados[$i]['iso']               = $enlistadoRelacionados[$i]['precioReal']['iso'];
                $enlistadoRelacionados[$i]['link']              = "tours/" . mb_strtolower($tourRelacionadoUnico["carpeta_seo"]) . "/" . $this->fn->stringToUrl($tourRelacionadoUnico["nombre"]) . "/" . $tourRelacionadoUnico["id"];
                $enlistadoRelacionados[$i]["tipoDuracion"]      = $tourRelacionadoUnico['tipo_duracion'];
            }
        } else {
            $countToursRelacionados = 0;
            $enlistadoRelacionados  = [];
        }

        return view('web.experiencias.detalle', compact(
            'tour',
            'isotour',
            'clases',
            'precioMinimo',
            'toursRelacionados',
            'rangoMenores',
            'edadAdulta',
            'rangoAdultos',
            'rangoInfantes',
            'itinerario_es',
            'youtube',
            'countToursRelacionados',
            'enlistadoRelacionados',
            'imagenUnica',
            'recomendacionesTour',
            'dias_operacion',
            'tipo_reserva',
            'cant_pax_max',
            'cant_pax_min',
            'tipo_costo',
            'tipoDuracion',
            'acepta_extras',
            'tipo_ind_comb',
            'pax_max_extra',
            'adulto_extra',
            'nombre_promo',
            'anticipo', 
            'procesoPago', 
            'tipoCambio', 
            'cambioMoneda', 
            'tipo_valor',
            'release'
        ));
    }

    // Tipos Experiencia - usabilidad SOLO TRAVEL CIT
    public function categoriasExcursionesUnica(Request $request, $categoriaEx, $idEx)
    {
        $tiposExcursiones   = $this->experiencias->obtenerToursTipos($idEx);
        $countTipos         = count($tiposExcursiones['data']['tours']);

        $monedas            = $this->Monedas();
        $incluyes           = $tiposExcursiones["data"]["incluye"];
        $compara            = [];
        foreach ($incluyes as $incluye) {
            $compara[] = $incluye["id_excursion"];
        }

        if ($countTipos > 0) {
            foreach ($tiposExcursiones["data"]["tours"] as $x => $data) {

                $arrayPrecios["adulto_sencilla"]  = $data["adulto_sencilla"];
                $arrayPrecios["adulto_doble"]     = $data["adulto_doble"];
                $arrayPrecios["adulto_triple"]    = $data["adulto_triple"];
                $arrayPrecios["adulto_cuadruple"] = $data["adulto_cuadruple"];

                $precioMinimo   = $this->fn->precioMinimoLista($arrayPrecios);
                $precioReal     = $this->fn->precio($precioMinimo, $data["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $monedas);


                $tiposExperienciasUnicasTour[$x]['nombre']          = $data['nombre'];
                $tiposExperienciasUnicasTour[$x]['imagen']          = $data['imagen'];
                $tiposExperienciasUnicasTour[$x]['link']            = 'tours/' . mb_strtolower($data['carpeta_seo']) . '/' . $this->fn->stringToUrl($data['nombre']) . '/' . $data['id'];;
                $tiposExperienciasUnicasTour[$x]['descripcion']     =  $this->fn->recortar_cadena($data['descripcion'], 200);
                $tiposExperienciasUnicasTour[$x]['cantidad_dias']   =  $data['cantidad_dias'];
                $tiposExperienciasUnicasTour[$x]['precioformato']   =  $precioReal['precioformato'];
                $tiposExperienciasUnicasTour[$x]['tipoDuracion']    =  $precioReal['tipo_duracion'];

                $tiposExperienciasUnicasTour[$x]['iso']             =  $precioReal['iso'];
            }
        } else {
            $countTipos = 0;
            $tiposExperienciasUnicasTour = [];
        }
        return view('web.experiencias.experienciasTipo', compact('countTipos', 'tiposExperienciasUnicasTour'));
    }

    //Formulario de compra de experiencia
    public function datosCompra(Request $request)
    {

        // $sitioWeb = json_decode($this->InfoWebEmpresa());

        $tipo_costo = $request->tipo_costo;
        $paiscomercial  = $request->pais_comercial;
        $idtour         = $request->idtour;
        $imagen         = $request->imagen;
        $cadultos       = $request->cadultos;
        $cmenores       = $request->cmenores;
        $cinfantes      = $request->cinfantes;
        $padulto        = $request->padulto;
        $pmenor         = $request->pmenor;
        $pinfante       = $request->pinfante;
        $nombretour     = $request->nombretour;
        $fechaPorDia    = $request->fechaSeleccionadaPorDia;
        if ($request->fechaSeleccionadaPorDia != "" or $request->fechaSeleccionadaPorDia != null) {
            $fechaviaje = $request->fechaSeleccionadaPorDia;
        } else {
            $fechaviaje     = $request->fechaviaje;
        }
        $gtotal         = $request->gtotal;
        $tipohabitacion = $request->tipohabitacion;
        $hoteleria      = $request->hoteleria;
        $idPuntoPartida = $request->id_punto_partida;
        $horario        = $request->horario;

        //Aplica solo para circuitos:
        $id_temporada       = $request->id_temporada;
        $nombre_temporada   = $request->nombre_temporada;
        $id_clase_servicio  = $request->id_clase_servicio;
        $nombre_servicio    = $request->nombre_servicio;
        $fecha_inicio       = $request->fecha_inicio;
        $fecha_fin          = $request->fecha_fin;
        $id_paquete_fecha   = $request->id_paquete_fecha;
        $id_temporada_costo = $request->id_temporada_costo;

        //Recibimos informacion de promocion para tours de 1 dia
        $tipo_descuento_frm     = $request->tipo_descuento_frm;
        $valor_promocion_frm    = $request->valor_promocion_frm;
        $descuento_frm          = $request->descuento_frm;
        $idpromo_frm            = $request->idpromo_frm;
        $idexpromo_frm          = $request->idexpromo_frm;
        $aplicapromo            = $request->aplicapromo;
        $gtotalPromo = $request->gtotalPromo;

        // if ($aplicapromo == 1 && $tipo_descuento_frm == 1) {
        //     $gtotalPromo = $gtotal - ($gtotal * ($valor_promocion_frm / 100));
        // } else {
        //     $gtotalPromo = 0;
        // }

        $nombre             = $request->nombre;
        $apellido           = $request->apellido;
        $telefono           = $request->telefono;
        $sexoTitular        = $request->sexoTitular;
        $dianacTitular      = $request->dianacTitular;
        $mesnacTitular      = $request->mesnacTitular;
        $yearTitular        = $request->yearTitular;
        $pasaporteTitular   = $request->pasaporteTitular;

        $indiceAdulto   = 2; //?????
        $indiceMenor    = 1; //?????

        // Agregamos las nuevas variables
        $tipoCambio     = $request->tipoCambio;
        $cambioMoneda   = $request->cambioMoneda;
        $procesoPago    = $request->procesoPago;
        $anticipo       = $request->anticipo;
        $tipoValor      = $request->tipoValor;

        return view('web.experiencias.datosCompra', compact(
            'paiscomercial',
            'idtour',
            'imagen',
            'cadultos',
            'cmenores',
            'cinfantes',
            'padulto',
            'pmenor',
            'pinfante',
            'nombretour',
            'fechaviaje',
            'gtotal',
            'tipohabitacion',
            'hoteleria',

            'id_temporada',
            'nombre_temporada',
            'id_clase_servicio',
            'nombre_servicio',
            'fecha_inicio',
            'fecha_fin',
            'id_paquete_fecha',
            'id_temporada_costo',

            'tipo_descuento_frm',
            'valor_promocion_frm',
            'descuento_frm',
            'idpromo_frm',
            'idexpromo_frm',
            'aplicapromo',
            'gtotalPromo',

            'indiceAdulto',
            'indiceMenor',
            'idPuntoPartida',
            'horario',
            'fechaPorDia',

            'tipo_costo',
            'tipoCambio',
            'cambioMoneda',
            'procesoPago',
            'anticipo',
            'tipoValor',
        ));
    }

    public function validarCupon(Request $request)
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($request->data), 'application/json')
            ->post('https://app.bookingtrap.com/api/v2/cupones/validar');
        return $response;
    }

    //Obtiene link openpay, guarda la reservacion y redirecciona al formulario de pago de openpay
    public function saveOpenPay(Request $request)
    {
        if ($request->ajax()) {
            $response = $this->guardarPaypal($request);
            return $response;

        } else {
            $openpayID   = $request->openpayID;

            if($request->exists('gtotalPromo') && ($request->gtotalPromo != null)){
                $promo       = $request->aplicapromo;
            }else{
                $promo = 0;
            }

            $openpayLINK = $request->openpayLINK;

            $id_paquete  = $request->idtour;
            $id_producto = 1;

            $nombre      = $request->nombre;
            $apellido    = $request->apellido;
            $telefono    = $request->telefono;
            $descripcion = "Experiencia de viaje: " . $request->nombretour;
            $email       = $request->email;
            $domain      = $request->getSchemeAndHttpHost();
            $gracias     = "gracias-openpay";

            if ((int)$promo === 1) {
                if($request->exists('cantidadAnticipo')) {
                    $total = $request->cantidadAnticipo;
                } else {
                    $total = $request->gtotalPromo;
                }
            } else {
                if($request->exists('cantidadAnticipo')) {
                    $total = $request->cantidadAnticipo;
                } else {
                    $total = $request->gtotal;
                }
            }

            $request->request->add(['aplicapromo' => $promo]);
            
            $response = $this->openpay->obtenerLinkOpenPay([
                'nombre'        => $nombre,
                'apellido'      => $apellido,
                'telefono'      => $telefono,
                'descripcion'   => $descripcion,
                'total'         => $total,
                'email'         => $email,
                'domain'        => $domain,
                'gracias'       => $gracias,
                'currency'      => session('monedaSeleccionada'),
                'id_paquete'    => $id_paquete,
                'id_producto'   => $id_producto,
            ]);

            $reserva = $this->guardarOpenPay($request, $response);
            return $reserva;
        }
    }

    public function guardarOpenPay(Request $request, $openPay)
    {

        $sitioWeb = json_decode($this->InfoWebEmpresa());
        $afiliado = session('idAfiliado');

        //Variables del sitio web
        $cc_email_reservas_uno = $sitioWeb[0]->cc_email_reservas_uno;
        $cc_email_reservas_dos = $sitioWeb[0]->cc_email_reservas_dos;

        //Información del titular
        $nombre         = $request->nombre;
        $apellido       = $request->apellido;
        $telefono       = $request->telefono;
        $isoNumber      = $request->isoNumber;
        $codigoNumber   = $request->codigoNumber;
        $sexoTitular    = $request->sexoTitular;
        $dianacTitular  = $request->dianacTitular;
        $mesnacTitular  = $request->mesnacTitular;
        $yearTitular    = $request->yearTitular;
        $fnacTitular    = $yearTitular . "-" . $mesnacTitular . "-" . $dianacTitular;
        $email          = $request->email;
        $nombretour     = $request->nombretour;
        $fechaviaje     = $request->fechaviaje;
        $horario        = $request->horario;
        $idPuntoPartida = $request->idPuntoPartida;

        //informacion del cupon y precio real
        $cupon              = $request->cupon;

        if ($request->totalConCupon != null) {
            $totalOriginal      = $request->totalConCupon;
        } else {
            $totalOriginal      = 0;
        }

        $totalOriginal      = str_replace(',', '', $totalOriginal);
        $totalOriginal      = number_format($totalOriginal, 2, '.', '');

        //Fecha seleccionada Por Dia Unico
        if ($request->fechaPorDia != null) {
            $fechaSeleccionada = $request->fechaPorDia;
        } else {
            $fechaSeleccionada = '';
        }

        //Informacion tipo cambio moneda
        $tipoCambio     = number_format($request->tipoCambio, 2, '.', '');
        $cambioMoneda   = number_format($request->cambioMoneda, 2, '.', '');

        //openpay
        $idopenpay      = isset($openPay->openpayID) ? $openPay->openpayID : " ";
        $openpayLINK    = isset($openPay->openpayLINK) ? $openPay->openpayLINK : " ";

        //Información general del viaje
        $idtour         = $request->idtour;
        $cadultos       = $request->cadultos;
        $cmenores       = $request->cmenores;
        $cinfantes      = $request->cinfantes;
        $padulto        = $request->padulto;
        $pmenor         = $request->pmenor;
        $pinfante       = $request->pinfante;

        $procesoDePagoSeleccionado  = $request->procesoDePagoSeleccionado;
        
        //procesoDePagoSeleccionado = 1 es por pago anticipo
        if($procesoDePagoSeleccionado == 1) {
            $totalAnticipo  = $request->cantidadAnticipo;
            $gtotal         = $request->precioOriginalTour;
        } else {
            $gtotal         = $request->gtotal;
        }

        $tipohabitacion = $request->tipohabitacion;
        $hoteleria      = $request->hoteleria;

        //Aplica solo para circuitos:
        $id_temporada           = isset($request->id_temporada) ? $request->id_temporada : '';
        $nombre_temporada       = isset($request->nombre_temporada) ? $request->nombre_temporada : '';
        $id_clase_servicio      = isset($request->id_clase_servicio) ? $request->id_clase_servicio : '';
        $nombre_servicio        = isset($request->nombre_servicio) ? $request->nombre_servicio : '';
        $fecha_inicio           = isset($request->fecha_inicio) ? $request->fecha_inicio : '';
        $fecha_fin              = isset($request->fecha_fin) ? $request->fecha_fin : '';
        $id_paquete_fecha       = isset($request->id_paquete_fecha) ? $request->id_paquete_fecha : '';
        $id_temporada_costo     = isset($request->id_temporada_costo) ? $request->id_temporada_costo : '';

        // Acompañantes adultos
        $nombreAcompa       = isset($request->nombreAcompa) ? $request->nombreAcompa : '';
        $apellidoAcompa     = isset($request->apellidoAcompa) ? $request->apellidoAcompa : '';
        $dianacAcompa       = isset($request->dianacAcompa) ? $request->dianacAcompa : '';
        $mesnacAcompa       = isset($request->mesnacAcompa) ? $request->mesnacAcompa : '';
        $yearnacAcompa      = isset($request->yearnacAcompa) ? $request->yearnacAcompa : '';
        $sexoAcompa         = isset($request->sexoAcompa) ? $request->sexoAcompa : '';
        $parentescoAcompa   = 'Otro';

        //Menores
        $nombreMenor    = isset($request->nombreMenor) ? $request->nombreMenor : '';
        $apellidoMenor  = isset($request->apellidoMenor) ? $request->apellidoMenor : '';
        $dianacMenor    = isset($request->dianacMenor) ? $request->dianacMenor : '';
        $mesnacMenor    = isset($request->mesnacMenor) ? $request->mesnacMenor : '';
        $yearnacMenor   = isset($request->yearnacMenor) ? $request->yearnacMenor : '';
        $sexoMenor      = isset($request->sexoMenor) ? $request->sexoMenor : '';

        //Recibimos informacion de promocion para tours de 1 dia
        $tipo_descuento_frm     = $request->tipo_descuento_frm;
        $valor_promocion_frm    = $request->valor_promocion_frm;
        $descuento_frm          = $request->descuento_frm;
        $idpromo_frm            = $request->idpromo_frm;
        $idexpromo_frm          = $request->idexpromo_frm;
        $aplicapromo            = $request->aplicapromo;

        $parentescoMenor        = 'Otro';

        $tadultos               = $cadultos * $padulto;
        $tmenores               = $cmenores * $pmenor;
        $tinfantes              = $cinfantes * $pinfante;

        //construyendo variables para la API de reservacion
        $formReserva["id_punto_partida"]    = $idPuntoPartida;
        $formReserva["horario"]             = $horario;
        $formReserva["id_fecha"]            = $id_paquete_fecha;
        $formReserva["id_promocion"]        = $idpromo_frm;
        if ($id_paquete_fecha > 0) {
            $formReserva["fecha_inicio"]    = $fecha_inicio;
            $formReserva["fecha_fin"]       = $fecha_fin;
        } else {
            $formReserva["fecha_inicio"]    = $fechaviaje;
            $formReserva["fecha_fin"]       = $fechaviaje;
        }
        $formReserva["id_paquete"]          = $idtour;
        $formReserva["tipohabitacion"]      = $tipohabitacion;

        $formReserva["idpromo_frm"]         = $idpromo_frm;
        $formReserva["aplica_promo"]        = $aplicapromo;
        $formReserva["idexpromo"]           = $idexpromo_frm;
        $formReserva["tipo_descuento"]      = $tipo_descuento_frm;
        $formReserva["valor_promocion"]     = $valor_promocion_frm;
        $formReserva["descuento"]           = $descuento_frm;

        $formReserva["id_temporada"]        = $id_temporada;
        $formReserva["nombre_temporada"]    = $nombre_temporada;
        $formReserva["id_clase_servicio"]   = $id_clase_servicio;
        $formReserva["id_paquete_fecha"]    = $id_paquete_fecha;
        $formReserva["id_temporada_costo"]  = $id_temporada_costo;

        $formReserva["cantidad_adultos"]    = $cadultos;
        $formReserva["cantidad_menores"]    = $cmenores;
        $formReserva["cantidad_infantes"]   = $cinfantes;

        $formReserva["precio_adultos"]      = $padulto;
        $formReserva["precio_menores"]      = $pmenor;
        $formReserva["precio_infantes"]     = $pinfante;

        if ($aplicapromo == 1 && $request->gtotalPromo != null) {
            $formReserva["precio_total"]        = number_format($request->gtotalPromo, 2, '.', '');
            $formReserva["totalOriginalPromo"]  = $gtotal;
        } else {
            $formReserva["precio_total"]        = $gtotal;
        }

        $formReserva["id_afiliado"]         = $afiliado;
        $formReserva["id_forma_pago"]       = 9; //Es una variable estatica: "sin pago"
        $formReserva["id_moneda"]           = session('monedaSeleccionada');
        $formReserva["pagado"]              = 0;
        $formReserva["hoteleria"]           = $hoteleria;

        $formReserva["tit_nombre"]          = $nombre;
        $formReserva["tit_apellido"]        = $apellido;
        $formReserva["tit_telefono"]        = $telefono;
        $formReserva["codigoNumber"]        = $codigoNumber;
        $formReserva["isoNumber"]           = $isoNumber;
        $formReserva["tit_email"]           = $email;
        $formReserva["tit_fec_nac"]         = $fnacTitular;
        $formReserva["idopenpay"]           = $idopenpay;
        $formReserva["afiliado"]            = $afiliado;
        $formReserva["cupon"]               = $cupon;
        $formReserva["fechaPorDia"]         = $fechaSeleccionada;

        if($cupon != null) {
            $formReserva["totalOriginal"]   = $totalOriginal;
        }

        if ($tipoCambio > 0) {
            $formReserva["valor_cambio"]         = $tipoCambio;
        } else {
            $formReserva["valor_cambio"]         = $cambioMoneda;
        }

        if($procesoDePagoSeleccionado == 1) {
            $formReserva["valor_anticipo"]       = $totalAnticipo;
        }

        $nombreImagen = "https://franquicia.mujerviaja.com/img/logo.png";
        $imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));

        //Acompañantes adultos
        if (is_array($nombreAcompa)) {
            if (count($nombreAcompa) > 0) {
                $acompa = 1;
                for ($i = 0; $i < count($nombreAcompa); $i++) {
                    $fnac = $yearnacAcompa[$i] . "/" . $mesnacAcompa[$i] . "/" . $dianacAcompa[$i];
                    $acompa++;

                    $acompaAdulto[$i]["nombre"]             = $nombreAcompa[$i];
                    $acompaAdulto[$i]["apellido"]           = $apellidoAcompa[$i];
                    $acompaAdulto[$i]["fecha_nacimiento"]   = $fnac;
                }
            }
            $formReserva["paxesAdultos"] = $acompaAdulto;
        } else {
            $formReserva["paxesAdultos"] = 0;
        }


        if (is_array($nombreMenor)) {
            if (count($nombreMenor) > 0) {

                $acompa = 1;
                for ($i = 0; $i < count($nombreMenor); $i++) {
                    $fnac_menor = $yearnacMenor[$i] . "/" . $mesnacMenor[$i] . "/" . $dianacMenor[$i];
                    $acompa++;
                    $acompaMenor[$i]["nombre"]              = $nombreMenor[$i];
                    $acompaMenor[$i]["apellido"]            = $apellidoMenor[$i];
                    $acompaMenor[$i]["fecha_nacimiento"]    = $fnac_menor;
                }
            }
            $formReserva["paxesMenores"] = $acompaMenor;
        } else {
            $formReserva["paxesMenores"] = 0;
        }

        $reservacion = $this->experiencias->agregarReservacion($formReserva);

        if($request->procesoDePagoSeleccionado == 2) {
            return response()->json($reservacion, 200);
        }

        if ($aplicapromo == 1) {
            if ($descuento_frm == 1) {
                //Porcentaje
                $subtotal   = $gtotal;
                $gtotal     = $subtotal - ($subtotal * ($valor_promocion_frm / 100));
                $descuento  = $subtotal - $gtotal;
            } else {
                //Monto
                $subtotal   = $gtotal;
                $gtotal     = $subtotal - $valor_promocion_frm;
                $descuento  = $subtotal - $gtotal;
            }
        } else {
        }
        return redirect()->to($openpayLINK);
    }

    public function guardarPaypal(Request $request)
    {
        $sitioWeb = json_decode($this->InfoWebEmpresa());
        $afiliado = session('idAfiliado');

        //Variables del sitio web
        $cc_email_reservas_uno = $sitioWeb[0]->cc_email_reservas_uno;
        $cc_email_reservas_dos = $sitioWeb[0]->cc_email_reservas_dos;

        //Información del titular
        $nombre         = $request->nombre;
        $apellido       = $request->apellido;
        $telefono       = $request->telefono;
        $isoNumber      = $request->isoNumber;
        $codigoNumber   = $request->codigoNumber;
        $sexoTitular    = $request->sexoTitular;
        $dianacTitular  = $request->dianacTitular;
        $mesnacTitular  = $request->mesnacTitular;
        $yearTitular    = $request->yearTitular;
        $fnacTitular    = $yearTitular . "-" . $mesnacTitular . "-" . $dianacTitular;
        $email          = $request->email;
        $nombretour     = $request->nombretour;
        $fechaviaje     = $request->fechaviaje;
        $horario        = $request->horario;
        $idPuntoPartida = $request->idPuntoPartida;

        //informacion del cupon y precio real
        $cupon           = $request->cupon;

        if ($request->totalConCupon != null) {
            $totalOriginal      = $request->totalConCupon;
        } else {
            $totalOriginal      = 0;
        }

        $totalOriginal      = str_replace(',', '', $totalOriginal);
        $totalOriginal      = number_format($totalOriginal, 2, '.', '');

        //Fecha seleccionada Por Dia Unico
        if ($request->fechaPorDia != null) {
            $fechaSeleccionada = $request->fechaPorDia;
        } else {
            $fechaSeleccionada = '';
        }

        //Informacion tipo cambio moneda
        $tipoCambio     = number_format($request->tipoCambio, 2, '.', '');
        $cambioMoneda   = number_format($request->cambioMoneda, 2, '.', '');

        //openpay
        // $idopenpay      = $openPay->openpayID;
        // $openpayLINK    = $openPay->openpayLINK;

        //Información general del viaje
        $idtour         = $request->idtour;
        $cadultos       = $request->cadultos;
        $cmenores       = $request->cmenores;
        $cinfantes      = $request->cinfantes;
        $padulto        = $request->padulto;
        $pmenor         = $request->pmenor;
        $pinfante       = $request->pinfante;

        $procesoDePagoSeleccionado  = $request->procesoDePagoSeleccionado;
        
        //procesoDePagoSeleccionado = 1 es por pago anticipo
        if($procesoDePagoSeleccionado == 1) {
            $totalAnticipo  = $request->cantidadAnticipo;
            $gtotal         = $request->precioOriginalTour;
        } else {
            $gtotal         = $request->gtotal;
        }
        
        $tipohabitacion = $request->tipohabitacion;
        $hoteleria      = $request->hoteleria;

        //Aplica solo para circuitos:
        $id_temporada           = isset($request->id_temporada) ? $request->id_temporada : '';
        $nombre_temporada       = isset($request->nombre_temporada) ? $request->nombre_temporada : '';
        $id_clase_servicio      = isset($request->id_clase_servicio) ? $request->id_clase_servicio : '';
        $nombre_servicio        = isset($request->nombre_servicio) ? $request->nombre_servicio : '';
        $fecha_inicio           = isset($request->fecha_inicio) ? $request->fecha_inicio : '';
        $fecha_fin              = isset($request->fecha_fin) ? $request->fecha_fin : '';
        $id_paquete_fecha       = isset($request->id_paquete_fecha) ? $request->id_paquete_fecha : '';
        $id_temporada_costo     = isset($request->id_temporada_costo) ? $request->id_temporada_costo : '';

        // Acompañantes adultos
        $nombreAcompa       = isset($request->nombreAcompa) ? $request->nombreAcompa : '';
        $apellidoAcompa     = isset($request->apellidoAcompa) ? $request->apellidoAcompa : '';
        $dianacAcompa       = isset($request->dianacAcompa) ? $request->dianacAcompa : '';
        $mesnacAcompa       = isset($request->mesnacAcompa) ? $request->mesnacAcompa : '';
        $yearnacAcompa      = isset($request->yearnacAcompa) ? $request->yearnacAcompa : '';
        $sexoAcompa         = isset($request->sexoAcompa) ? $request->sexoAcompa : '';
        $parentescoAcompa   = 'Otro';

        //Menores
        $nombreMenor    = isset($request->nombreMenor) ? $request->nombreMenor : '';
        $apellidoMenor  = isset($request->apellidoMenor) ? $request->apellidoMenor : '';
        $dianacMenor    = isset($request->dianacMenor) ? $request->dianacMenor : '';
        $mesnacMenor    = isset($request->mesnacMenor) ? $request->mesnacMenor : '';
        $yearnacMenor   = isset($request->yearnacMenor) ? $request->yearnacMenor : '';
        $sexoMenor      = isset($request->sexoMenor) ? $request->sexoMenor : '';

        //Recibimos informacion de promocion para tours de 1 dia
        $tipo_descuento_frm     = $request->tipo_descuento_frm;
        $valor_promocion_frm    = $request->valor_promocion_frm;
        $descuento_frm          = $request->descuento_frm;
        $idpromo_frm            = $request->idpromo_frm;
        $idexpromo_frm          = $request->idexpromo_frm;
        $aplicapromo            = $request->aplicapromo;

        $parentescoMenor        = 'Otro';

        $tadultos               = $cadultos * $padulto;
        $tmenores               = $cmenores * $pmenor;
        $tinfantes              = $cinfantes * $pinfante;

        //construyendo variables para la API de reservacion
        $formReserva["id_punto_partida"]    = $idPuntoPartida;
        $formReserva["horario"]             = $horario;
        $formReserva["id_fecha"]            = $id_paquete_fecha;
        $formReserva["id_promocion"]        = $idpromo_frm;
        if ($id_paquete_fecha > 0) {
            $formReserva["fecha_inicio"]    = $fecha_inicio;
            $formReserva["fecha_fin"]       = $fecha_fin;
        } else {
            $formReserva["fecha_inicio"]    = $fechaviaje;
            $formReserva["fecha_fin"]       = $fechaviaje;
        }
        $formReserva["id_paquete"]          = $idtour;
        $formReserva["tipohabitacion"]      = $tipohabitacion;

        $formReserva["idpromo_frm"]         = $idpromo_frm;
        $formReserva["aplica_promo"]        = $aplicapromo;
        $formReserva["idexpromo"]           = $idexpromo_frm;
        $formReserva["tipo_descuento"]      = $tipo_descuento_frm;
        $formReserva["valor_promocion"]     = $valor_promocion_frm;
        $formReserva["descuento"]           = $descuento_frm;

        $formReserva["id_temporada"]        = $id_temporada;
        $formReserva["nombre_temporada"]    = $nombre_temporada;
        $formReserva["id_clase_servicio"]   = $id_clase_servicio;
        $formReserva["id_paquete_fecha"]    = $id_paquete_fecha;
        $formReserva["id_temporada_costo"]  = $id_temporada_costo;

        $formReserva["cantidad_adultos"]    = $cadultos;
        $formReserva["cantidad_menores"]    = $cmenores;
        $formReserva["cantidad_infantes"]   = $cinfantes;

        $formReserva["precio_adultos"]      = $padulto;
        $formReserva["precio_menores"]      = $pmenor;
        $formReserva["precio_infantes"]     = $pinfante;

        if ($aplicapromo == 1 && $request->gtotalPromo != null) {
            $formReserva["precio_total"]        = number_format($request->gtotalPromo, 2, '.', '');
            $formReserva["totalOriginalPromo"]  = $gtotal;
        } else {
            $formReserva["precio_total"]        = $gtotal;
        }

        $formReserva["id_afiliado"]         = $afiliado;
        $formReserva["id_forma_pago"]       = 9; //Es una variable estatica: "sin pago"
        $formReserva["id_moneda"]           = session('monedaSeleccionada');
        $formReserva["pagado"]              = 0;
        $formReserva["hoteleria"]           = $hoteleria;

        $formReserva["tit_nombre"]          = $nombre;
        $formReserva["tit_apellido"]        = $apellido;
        $formReserva["tit_telefono"]        = $telefono;
        $formReserva["codigoNumber"]        = $codigoNumber;
        $formReserva["isoNumber"]           = $isoNumber;
        $formReserva["tit_email"]           = $email;
        $formReserva["tit_fec_nac"]         = $fnacTitular;
        $formReserva["idopenpay"]           = $request->transaccion;
        $formReserva["afiliado"]            = $afiliado;
        $formReserva["cupon"]               = $cupon;
        $formReserva["fechaPorDia"]         = $fechaSeleccionada;
        $formReserva["terminal"]            = $request->terminal;

        if ($cupon != null) {
            $formReserva["totalOriginal"]   = $totalOriginal;
        }

        if ($tipoCambio > 0) {
            $formReserva["valor_cambio"]         = $tipoCambio;
        } else {
            $formReserva["valor_cambio"]         = $cambioMoneda;
        }

        if($procesoDePagoSeleccionado == 1) {
            $formReserva["valor_anticipo"]       = $totalAnticipo;
        }

        $nombreImagen = "https://franquicia.mujerviaja.com/img/logo.png";
        $imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));

        //Acompañantes adultos
        if (is_array($nombreAcompa)) {
            if (count($nombreAcompa) > 0) {
                $acompa = 1;
                for ($i = 0; $i < count($nombreAcompa); $i++) {
                    $fnac = $yearnacAcompa[$i] . "/" . $mesnacAcompa[$i] . "/" . $dianacAcompa[$i];
                    $acompa++;

                    $acompaAdulto[$i]["nombre"]             = $nombreAcompa[$i];
                    $acompaAdulto[$i]["apellido"]           = $apellidoAcompa[$i];
                    $acompaAdulto[$i]["fecha_nacimiento"]   = $fnac;
                }
            }
            $formReserva["paxesAdultos"] = $acompaAdulto;
        } else {
            $formReserva["paxesAdultos"] = 0;
        }


        if (is_array($nombreMenor)) {
            if (count($nombreMenor) > 0) {

                $acompa = 1;
                for ($i = 0; $i < count($nombreMenor); $i++) {
                    $fnac_menor = $yearnacMenor[$i] . "/" . $mesnacMenor[$i] . "/" . $dianacMenor[$i];
                    $acompa++;
                    $acompaMenor[$i]["nombre"]              = $nombreMenor[$i];
                    $acompaMenor[$i]["apellido"]            = $apellidoMenor[$i];
                    $acompaMenor[$i]["fecha_nacimiento"]    = $fnac_menor;
                }
            }
            $formReserva["paxesMenores"] = $acompaMenor;
        } else {
            $formReserva["paxesMenores"] = 0;
        }

        $reservacion = $this->experiencias->agregarReservacion($formReserva);

        // if ($aplicapromo == 1) {
        //     if ($descuento_frm == 1) {
        //         //Porcentaje
        //         $subtotal   = $gtotal;
        //         $gtotal     = $subtotal - ($subtotal * ($valor_promocion_frm / 100));
        //         $descuento  = $subtotal - $gtotal;
        //     } else {
        //         //Monto
        //         $subtotal   = $gtotal;
        //         $gtotal     = $subtotal - $valor_promocion_frm;
        //         $descuento  = $subtotal - $gtotal;
        //     }
        // } else {
        // }
        return $reservacion;
    }

    public function graciasOpenpayExpriencias(Request $request)
    {
        if ($request->exists('terminal') && ($request->terminal !=  3)) {
            $terminal = $request->terminal;
        } else {
            $terminal = 3;
        }

        if ($terminal == 3) {
            $response = $this->graciasOpenPay($request);
        } else if ($terminal == 4) {
            $response = $this->graciasPaypalExperiencias($request);
        } else {
            return '';
        }

        $estatus = $response["estatus"];
        $mensaje = $response["mensaje"];

        return view('web.experiencias.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function graciasOpenPay(Request $request)
    {
        $sitioWeb = json_decode($this->InfoWebEmpresa());

        $idoperacion            = $request->id;
        $data["transaccion"]    = $idoperacion;
        $respuesta = $this->openpay->obtenerStatusPay($data);

        $autorizacion             = $respuesta->autorizacion;
        $tipo                     = $respuesta->tipo;
        $monto                    = $respuesta->monto;
        $estatus                  = $respuesta->estatus;
        $mensaje                  = $respuesta->mensaje;

        if ($estatus === 'completed') {
            $formData["autorizacion"] = $autorizacion;
            $formData["tipo"]         = $tipo;
            $formData["monto"]        = $monto;
            $formData["operacion"]    = $idoperacion;
            $update = $this->experiencias->actualizarReservacion($formData);

            //Preparamos envio de correo:

            //Variables del sitio web
            $cc_email_reservas_uno = $sitioWeb[0]->cc_email_reservas_uno;
            $cc_email_reservas_dos = $sitioWeb[0]->cc_email_reservas_dos;
        }

        return view('web.experiencias.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function graciasPaypalExperiencias(Request $request)
    {
        $estatus = 'completed';
        $mensaje = '';
        // return [$request->order, $request->monto, $request->id, (int)$request->monto];

        if ($estatus === 'completed') {
            $formData["autorizacion"] =  $request->order;
            $formData["tipo"]         = '';
            $formData["monto"]        = $request->monto;
            $formData["operacion"]    = $request->id;
            $update = $this->experiencias->actualizarReservacion($formData);
        }

        $formData['estatus'] = $estatus;
        $formData['mensaje'] = $mensaje;

        return $formData;
    }

    public function graciasOpenpayContacto()
    {
        $estatus= "completed";
        $mensaje= '';

        return view('web.experiencias.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function getPrices(Request $request)
    {

        $data           = json_decode($request->data);
        $idtour         = $data->tour;
        $dias           = $data->dias;
        $fecha          = $data->fecha;
        $clase          = $data->clase;

        $generales      = $data->generales;
        $mostrarpromo   = $data->mostrarpromo;
        $booking        = $data->booking;
        $travel         = $data->travel;
        $txtFechaPromo  = '';

        // if($generales === []) {

        //     return 'no hay generales' . count($generales);
        // }


        $tipoDecambio   = $this->tipoDeCambio();

        $endpoint = "https://app.bookingtrap.com/api/prices?tour=" . $idtour . "&dias=" . $dias . "&fecha=" . $fecha . "&clase=" . $clase;
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->get($endpoint);

        $precios = json_decode($response);

        if (array_key_exists('adulto_extra', $precios)) {
            $adulto_extra = $precios[0]->adulto_extra;
            $menor_extra = $precios[0]->menor_extra;
            $infante_extra = $precios[0]->infante_extra;
        } else {
            $adulto_extra = 0;
            $menor_extra = 0;
            $infante_extra = 0;
        }

        $tour = $this->experiencias->infoTour($idtour);
        $tipo_costo = $tour['paquete'][0]['tipo_costo'];
        $acepta_extra = $tour['paquete'][0]['acepta_extra'];

        if (count($generales) > 0) {

            $grales = 1;
            //array -> {} accedes al objeto
            $booking_window_inicio = $generales[0]->booking_window_inicio;
            $booking_window_fin    = $generales[0]->booking_window_fin;
            $travel_window_inicio  = $generales[0]->travel_window_inicio;
            $travel_window_fin     = $generales[0]->travel_window_fin;



            $promocion[0]["nombreDescuento"] = $generales[0]->nombreDescuento;
            $promocion[0]["descuento"] = $generales[0]->descuento;
            $promocion[0]["mensaje"] = $generales[0]->mensaje;
            $promocion[0]["tipo_descuento"] = $generales[0]->tipo_descuento;
            $promocion[0]["valor_promocion"] = $generales[0]->valor_promocion;
            $promocion[0]["paxes_promocion"] = $generales[0]->paxes_promocion;
            $promocion[0]["limitado"] = $generales[0]->limitado;
            $promocion[0]["limite"] = $generales[0]->limite;
            $promocion[0]["idexpromo"] = $generales[0]->idexpromo;
            $promocion[0]["booking_window_inicio"] = $generales[0]->booking_window_inicio;
            $promocion[0]["booking_window_fin"] = $generales[0]->booking_window_fin;
            $promocion[0]["travel_window_inicio"] = $generales[0]->travel_window_inicio;
            $promocion[0]["travel_window_fin"] = $generales[0]->travel_window_fin;
        } else {
            // return 'menor';
            $promocion = [];
            $grales = 0;
            $booking_window_fin    = '';
            $booking_window_inicio = '';
            $travel_window_inicio  = '';
            $travel_window_fin     = '';
        }

        if ($booking == 1 && $mostrarpromo == 1) {
            $txtFechaPromo = '<b style="color:#1e87f3;">';

            if ($booking_window_inicio != '') {
                $txtFechaPromo .= 'Reservando entre las fechas del ' . $this->fn->fechaAbreviada($booking_window_inicio) . ' al ' . $this->fn->fechaAbreviada($booking_window_fin);
            } else {
                $txtFechaPromo .= "Reservando en cualquier fecha";
            }


            if ($travel_window_inicio != '') {
                $txtFechaPromo .= ', y viajando entre las fechas del ' . $this->fn->fechaAbreviada($travel_window_inicio) . ' al ' . $this->fn->fechaAbreviada($travel_window_fin);
            } else {
                $txtFechaPromo .= ' y viajando en cualquier fecha';
            }
            $txtFechaPromo .= '</span';
        }

        if ($travel == 1 && $mostrarpromo == 1) {
            $txtFechaPromo = '<span class="text-danger">';
            $txtFechaPromo .= 'Viajando entre las fechas del ' . $this->fn->fechaAbreviada($travel_window_inicio) . ' al ' . $this->fn->fechaAbreviada($travel_window_fin);
            $txtFechaPromo .= '</span';
        }



        return view('web.experiencias.getPrices', compact(
            'precios',
            'fecha',
            'generales',
            'mostrarpromo',
            'booking',
            'travel',
            'tipoDecambio',
            'grales',
            'booking_window_inicio',
            'booking_window_fin',
            'travel_window_inicio',
            'travel_window_fin',
            'txtFechaPromo',
            'tipo_costo',
            'adulto_extra',
            'menor_extra',
            'infante_extra',
            'promocion',
            'acepta_extra'
        ));
    }

    function changeCurrency(Request $request)
    {
        $monedaSeleccionada = $request->moneda;
        session(['monedaSeleccionada' => $monedaSeleccionada]);
    }

    public function categoriasExperienciasUnica(Request $request, $categoria, $id)
    {
        $obtenerCategoria     = $this->experiencias->obtenerCategoriaUnica($id);
        $informacionCategoria = $obtenerCategoria['data']['tours'];
        $count                = count($informacionCategoria);
        $incluyes             = $obtenerCategoria["data"]["incluye"];
        $compara              = [];
        // return $informacionCategoria;

        //Funcionalidad de Filtros   
        $tiposExperiencias = $obtenerCategoria["data"]['filtros']['tipoexcursion'];
        $isFiltroGeografico = false;

        if ($obtenerCategoria["data"]['filtros']['geografico'] != null) {
            $geograficoExperiencias = $obtenerCategoria["data"]['filtros']['geografico'];
            $isFiltroGeografico = true;
            $tipoGeografico =  $obtenerCategoria["data"]['filtros']['tipogeografico'];
            if ($tipoGeografico == 0) {
                $conteoGeograficoExperiencia     = $this->fn->conteo_experiencias(count($obtenerCategoria["data"]['filtros']['geografico']), $geograficoExperiencias, $obtenerCategoria["data"]["tours"], "nombrepais");
            }
            if ($tipoGeografico == 1) {
                $conteoGeograficoExperiencia     = $this->fn->conteo_experiencias(count($obtenerCategoria["data"]['filtros']['geografico']), $geograficoExperiencias, $obtenerCategoria["data"]["tours"], "estado_comercial");
            }
        } else {
            $isFiltroGeografico = false;
            $conteoGeograficoExperiencia = [];
            $geograficoExperiencias = [];
        }
        //conteo tours
        $conteoTipoExperiencia      = $this->fn->conteo_experiencias(count($obtenerCategoria["data"]['filtros']['tipoexcursion']), $tiposExperiencias, $obtenerCategoria["data"]["tours"], "tipoexcursion");

        //Fin de funcionalidad de filtros

        foreach ($incluyes as $incluye) {
            $compara[] = $incluye["id_excursion"];
        }

        if ($count > 0) {
            foreach ($informacionCategoria as $i => $experiencia) {
                $precio = 0;
                if ($experiencia["adulto_sencilla"] > 0) {
                    $precio = $experiencia["adulto_sencilla"];
                }

                if ($experiencia["adulto_doble"] > 0) {
                    $precio = $experiencia["adulto_doble"];
                }

                if ($experiencia["adulto_triple"] > 0) {
                    $precio = $experiencia["adulto_triple"];
                }

                if ($experiencia["adulto_cuadruple"] > 0) {
                    $precio = $experiencia["adulto_cuadruple"];
                }

                $experienciasList[$i]["precioReal"]       = $this->fn->precio($precio, $experiencia["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
                $experienciasList[$i]["link"]             = "tours/" . mb_strtolower($experiencia["carpeta_seo"]) . "/" . $this->fn->stringToUrl($experiencia["nombre"]) . "/" . $experiencia["id"];
                $experienciasList[$i]["imagen"]           = $experiencia["imagen"];
                $experienciasList[$i]["nombre"]           = $experiencia["nombre"];
                $experienciasList[$i]["estado_comercial"] = $experiencia["estado_comercial"];
                $experienciasList[$i]["ciudad_comercial"] = $experiencia["ciudad_comercial"];
                $experienciasList[$i]["descripcion"]      = $this->fn->recortar_cadena($experiencia["descripcion"], 200);
                $experienciasList[$i]["cantidad_dias"]    = $experiencia["cantidad_dias"];
                $experienciasList[$i]["precioformato"]    = $experienciasList[$i]["precioReal"]["precioformato"];
                $experienciasList[$i]["iso"]              = $experienciasList[$i]["precioReal"]["iso"];
                $experienciasList[$i]["nombrepais"]       = $experiencia["nombrepais"];
                $experienciasList[$i]["tipoexcursion"]    = $experiencia["tipoexcursion"];
                $experienciasList[$i]['tipoDuracion']    =  $experiencia['tipo_duracion'];
            }
        } else {
            $experienciasList = [];
        }


        return view('web.experiencias.categoriasExperiencias', compact(
            'experienciasList',
            'categoria',
            'count',
            'tiposExperiencias',
            'isFiltroGeografico',
            'geograficoExperiencias',
            'conteoGeograficoExperiencia',
            'conteoTipoExperiencia'
        ));
    }

    // HOTELERIA
    //Listado de hoteles por region
    public function hotelesRegion(Request $request, $nombreDestino, $idregion)
    {
        $moneda             = session('monedaSeleccionada');
        $month              = date('m') + 1;
        $year               = $month == '13' ? date('Y') + 1 : date('Y');
        $month              = $month == '13' ? '1' : $month;
        $checkinDate        = $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-01";
        $checkoutDate       = $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-02";

        $linkRegion = "hotels-list?lang=es&nombreDestinoHotelero=${nombreDestino}&destinoHotelero=${idregion}&checkin=${checkinDate}&checkout=${checkoutDate}&adultos=2&menores=0";
        return redirect()->to($linkRegion);

        /*
        $dataHoteles   = $this->hoteles->hotelesRegion($idregion, $moneda, $this->sandBox(), $checkinDate, $checkoutDate);

        if ($dataHoteles->successful()) {
            if ($dataHoteles["hoteles"]["debug"]["validation_error"] !== null) {
                $error = $dataHoteles["hoteles"]["debug"]["validation_error"];
                return view("web.hoteles.error", compact('error'));
            } else {
                $hotelLink     = $dataHoteles["form"];
                return $this->datosHotelLista($request, $dataHoteles, $hotelLink, $nombreDestino, $checkinDate, $checkoutDate, $idregion);
            }
        } else {
            $error = $dataHoteles["message"];
            return view("web.hoteles.error", compact('error'));
        }
        */
    }

    //Listado de hoteles por motor - Official
    public function listaHoteles(Request $request)
    {
        $moneda        = session('monedaSeleccionada');
        $destinoHotelero = $request->destinoHotelero;
        if (is_numeric($destinoHotelero)) {
            //Es una region
            return $this->listaHotelesV2($request);
        } else {
            //Es un hotel
            $sitioWeb  = json_decode($this->InfoWebEmpresa());
            $residency = "MX";

            if ($request->menores > 0) {
                $menores = implode(",", $request->edad);
            } else {
                //Motor->HotelUnico->Directo
                $menores = 'cero';
            }

            $link = 'hotel/' . $this->fn->stringToUrl($request->nombreDestinoHotelero);
            $link .= "/" . $destinoHotelero;
            $link .= "/" . $request->checkin;
            $link .= "/" . $request->checkout;
            $link .= "/" . $request->adultos;
            $link .= "/" . $menores;

            if($request->exists('actualizarDetalle')) {
                $link .= "/" . $request->total;
            } else {
                $link .= "/0";
            }
            $link .= "/" . $residency;
            $link .= "/" . $sitioWeb[0]->comision_hoteleria;
            
            return redirect()->to($link);
        }
    }

    public function datosHotelLista(Request $request, $dataHoteles, $hotelLink, $nombreDestino, $checkinDate, $checkoutDate, $idregion)
    {
        //Hotel-Lista
        $sitioWeb = $this->InfoWebEmpresa();
        $sandbox  = $this->sandBox();

        $idRegion                = $request->destinoHotelero;
        if ($nombreDestino == '') {
            $nombreDestino       = $request->nombreDestinoHotelero;
        }

        if ($checkinDate == '') {
            $checkinDate             = $request->checkin;
        }

        if ($checkoutDate == '') {
            $checkoutDate            = $request->checkout;
        }

        $adultos                 = intval($request->adultos);
        //modificacion
        if ($adultos == 0) {
            $adultos = 2;
        }

        $menoresInput            = $request->menores; //Sirve para contabilizar la cantidad de huespedes
        $menoresTxt              = $menoresInput > 0 ? implode(",", $request->edad) : 'cero';

        $monedaSeleccionada      = session('monedaSeleccionada');
        $residency               = "MX";
        $currency                = $monedaSeleccionada;
        $language                = "es";

        if (isset($request->edad)) {
            foreach ($request->edad as $i => $edad) {
                $menoresarray[$i] = intval($edad);
            }
        } else {
            $menoresarray = [];
        }

        $guests["adults"]        = $adultos;
        $guests["children"]      = $menoresarray;

        $markup                  = $dataHoteles["comision"][0]["comision_hoteleria"];
        $hoteles                 = $dataHoteles["hoteles"]["data"]["hotels"];
        $hotelsBDs               = $dataHoteles["hotelesBD"];
        $hotelAds                = $dataHoteles["hotelAds"];
        $hotelesCount            = count($dataHoteles["hoteles"]["data"]["hotels"]);

        $registro = 1;
        $arrayMeals = [];
        $arrayStars = [];
        $arrayError = [];

        if ($hoteles != null) {
            // return $hoteles;
            foreach ($hoteles as $conteo => $hotel) {
                $idhotel = $hotel['id'];

                // return $hotel['rates'];
                if ($hotel['rates'] != null) {
                    if (count($hotel['rates']) > 0) {
                        // return 'problems id';
                        $price_night = $hotel['rates'][0]['daily_prices'];
                        $room_name = $hotel['rates'][0]['room_name'];
                        $allotment = $hotel['rates'][0]['allotment'];
                        $amenities = $hotel['rates'][0]['amenities_data'];

                        $total = 0;
                        foreach ($price_night as $price) {
                            $total = $total + $price;
                        }

                        $total = $this->fn->tarifaPublicaAgencias($total);
                        $totalPublico = $total / (1 - $markup / 100);

                        $imgLink = 'https://app.bookingtrap.com/storage/app/public/recursos/trabajando.png';
                        $clave = array_search($idhotel, array_column($hotelsBDs, 'idHotel'));
                        $claveAds = array_search($hotel['rates'][0]['meal'], array_column($hotelAds, 'name'));

                        switch ($hotel['rates'][0]['meal']) {
                            case 'breakfast-for-2':
                                $planHospedaje = 'breakfast';
                                break;
                            default:
                                $planHospedaje = $hotel['rates'][0]['meal'];
                        }

                        if ($clave != '') {
                            $hotelName = $hotelsBDs[$clave]['hotelName'];
                            $meal = $hotelAds[$claveAds]['es'];
                            $arrayMeals[] = $meal;

                            $imagenes = json_decode($hotelsBDs[$clave]['images']);
                            if (is_array($imagenes)) {
                                if (count($imagenes) > 0) {
                                    $imagen = $imagenes[0];
                                    $imgLink = str_replace('{size}', 'x500', $imagen);
                                }
                            }

                            $filters = json_decode($hotelsBDs[$clave]['serp_filters']);
                            if (is_array($filters)) {
                                $serp_filters = implode(' ', $filters);
                            } else {
                                $serp_filters = '';
                            }

                            $direccion = $hotelsBDs[$clave]['address'];
                            // return 'estrellas'.$hotelsBDs[$clave]['star_rating'];
                            $checkin = $hotelsBDs[$clave]['check_in_time'];
                            $checkout = $hotelsBDs[$clave]['check_out_times'];


                            $stars = $hotelsBDs[$clave]['star_rating'];
                            if ($stars == 0) {
                                $stars = 1;
                            }
                            $kind = $hotelsBDs[$clave]['kind'];
                        } else {
                            $hotelName = $idhotel;
                            $direccion = 'Esta propiedad aun no se carga en el sistema';
                            $checkin = '';
                            $checkout = '';
                            $stars = 1;
                            $kind = '';
                            $serp_filters = '';
                        }

                        $arrayStars[] = $stars;

                        if ($sandbox === true) {
                            $link = 'test_hotel_do_not_book';
                        } else {
                            $link = $idhotel;
                        }
                        $link .= '/' . $checkinDate;
                        $link .= '/' . $checkoutDate;
                        $link .= '/' . $adultos;
                        $link .= '/' . $menoresTxt;
                        $link .= '/' . $totalPublico;
                        $link .= '/' . $residency;
                        $link .= '/' . $markup . '/';
                    } else {
                        // return 'problems';
                        $idhotel = $hotel['id'];
                        $arrayError[$conteo] = $idhotel;
                    }

                    //Creamos array de resultados
                    $hotelesArray[$conteo]["stars"]              = $stars;
                    $hotelesArray[$conteo]["meal"]               = $meal;
                    $hotelesArray[$conteo]["filtroMeal"]         = $this->fn->reemplaza_espacios($meal);
                    $hotelesArray[$conteo]["filtroTotalPublico"] = ceil($totalPublico);

                    $hotelesArray[$conteo]["idhotel"]            = $idhotel;
                    $hotelesArray[$conteo]["hotelName"]          = $hotelName;

                    $hotelesArray[$conteo]["imgLink"]            = $imgLink;
                    $hotelesArray[$conteo]["link"]               = "hotel/" . $this->fn->stringToUrl($hotelName) . "/" . $link;
                    $hotelesArray[$conteo]["direccion"]          = $direccion;
                    $hotelesArray[$conteo]["allotment"]          = $allotment;
                    $hotelesArray[$conteo]["checkin"]            = $checkin;
                    $hotelesArray[$conteo]["checkout"]           = $checkout;
                    $hotelesArray[$conteo]["room_name"]          = $room_name;
                    $hotelesArray[$conteo]["monedaSeleccionada"] = $monedaSeleccionada;
                    $hotelesArray[$conteo]["totalPublico"]       = number_format($totalPublico, 2, '.', ',');
                    $statusBusqueda = true;
                } else {
                    $statusBusqueda = false;
                    // $hotelesArray = [];
                }
            }

            // return count($hotelesArray);
            if (isset($hotelesArray)) {
                $hotelesCount = count($hotelesArray);
                $statusBusqueda = true;
            } else {
                $hotelesCount = 0;
                $statusBusqueda = false;
                $hotelesArray = [];
            }
            // return $hotelesArray;
            // return count($hotelesArray);
        } else {
            // return redirect()->to('/');
            $hotelesArray = [];
            $statusBusqueda = false;
            // return view("web.hoteles.notSearchHotels", compact('nombreDestino'));
        }

        // return $arrayStars;

        return view('web.hoteles.index', compact(
            'nombreDestino',
            'idRegion',

            'checkinDate',
            'checkoutDate',
            'adultos',
            'menoresInput',
            'menoresTxt',
            'menoresarray',

            'arrayMeals',
            'arrayStars',
            'arrayError',
            'hotelesArray',
            'hotelesCount',

            'statusBusqueda',
            'idregion'
        ));
    }

    public function habitaciones(Request $request, $hotelName, $idHotel, $checkin, $checkout, $adultos, $menores, $total, $residency, $markup)
    {
        $sitioWeb           = json_decode($this->InfoWebEmpresa());
        $urlLink            = $request->root() . "/" . $request->path();
        $monedaSeleccionada = session('monedaSeleccionada');
        $arrayMenoresCount  = explode(",", $request->menores);
        $countMenores       = ($arrayMenoresCount[0] === 'cero') ? 0 : count($arrayMenoresCount);

        // menores = 0 or 'cero'
        $cantidadMenores = $menores;

        if($cantidadMenores == 0) {
            $menores = 1;
        }

        $sandbox = $this->sandBox();

        if ($sandbox === true) {
            $form['id']     = 'test_hotel_do_not_book';
        } else {
            $form["id"]     = $idHotel;
        }

        $form["checkin"]    = $checkin;
        $form["checkout"]   = $checkout;
        $form["adults"]     = $adultos;
        $form["menores"]    = $menores;
        $form["residency"]  = $residency;
        $form["currency"]  = $monedaSeleccionada;
        $form["sandbox"]    = $sandbox;

        $detHotel           = $this->hoteles->habitaciones($form);
        $idHotelName        = $detHotel["infoHotel"][0]["idHotel"];
        $nombreHotel        = $this->fn->letrasCapitales($this->fn->removeGuiones($hotelName));
        $markup             = $sitioWeb[0]->comision_hoteleria;

        $tarifasHotel       = $detHotel["tarifas"];
        $infoRes            = $tarifasHotel["debug"]["request"];

        // return $tarifasHotel["data"]["hotels"];
        // return $tarifasHotel["data"]["hotels"][0]["rates"];

        if ($tarifasHotel["data"] != null && count($tarifasHotel["data"]["hotels"]) > 0) {
            $dataRooms       = $tarifasHotel["data"]["hotels"][0]["rates"];
            if ($dataRooms != []) {
                $countRoomsUnica        = count($tarifasHotel["data"]["hotels"][0]["rates"]);
                $habitacionesActivas    = true;
            } else {
                $countRoomsUnica        = 0;
                $habitacionesActivas    = false;
            }
        } else {
            $dataRooms              = 0;
            $habitacionesActivas    = false;
            $countRoomsUnica        = 0;
        }

        // return count

        if($detHotel["infoHotel"] != []) {
            $informactionOfTheHotel = true;
            $infoHotel    = $detHotel["infoHotel"][0];
            $addressHotel = $detHotel["infoHotel"][0]['address'];
            $imagenes     = json_decode($infoHotel["images"]);
            if($imagenes != []) {
                $imgPrincipal = str_replace("{size}", "1024x768", $imagenes[0]);
            } else {
                $imgPrincipal = '';
            }
            $description  = json_decode($infoHotel["description_struct"]);
            $amenities    = json_decode($infoHotel["amenities"]);
            $stars        = $infoHotel["star_rating"];
            $reserva      = $detHotel["reserva"];
            $idhotelBD    = $infoHotel["id"];
            $hotelAds     = $detHotel["hotelAds"];
            $existInformationHotel = true;
        } else {
            // return 'entro aqui';
            $informactionOfTheHotel = false;
            $infoHotel = 'No hay información';
            $imagenes = '';
            $imgPrincipal = '';
            $description = '';
            $stars        = '';
            $amenities = "";
            $dataRooms = 0;
            $reserva      = '';
            $idhotelBD = '';
            $hotelAds = '';
            $addressHotel = '';
            $existInformationHotel = false;
        }

        // $infoHotel    = $detHotel["infoHotel"][0];

        if($habitacionesActivas) {
            if ($dataRooms > 0) {
                foreach ($dataRooms as $x => $data) {
                    $currency = $data["payment_options"]["payment_types"][0]["show_currency_code"];
                    $daily_prices = $data["daily_prices"];
                    $precio = 0;
                    $tablePrecios = '<div class="Heading">';
                    $listaPrecios = count($daily_prices);
                    $amenidades = $data["amenities_data"];
                    $roomsAvailable = $data["allotment"];

                    if (array_key_exists('taxes', $data["payment_options"]["payment_types"][0]["tax_data"])) {
                        $impuestos = $data["payment_options"]["payment_types"][0]["tax_data"]["taxes"];
                    }else{
                        $impuestos = [];
                    }
                    
                    $txtImpuestos = '';
                    foreach ($impuestos as $impuesto) {
                        $claveimpuesto = array_search($impuesto["name"], array_column($hotelAds, 'name'));
                        $txtImpuestos .= '<br />' . $hotelAds[$claveimpuesto]["es"] . ": " . $impuesto["amount"] . " " . $impuesto["currency_code"];
                        $txtImpuestos .= $impuesto["included_by_supplier"] == true ? '(Incluido)' : '(No incluido)';
                    }
            
                    $premeal    = $data["meal"];
                    $claveMeal  = array_search($data["meal"], array_column($hotelAds, 'name'));
                    $nombreMeal = $hotelAds[$claveMeal]["es"];
            
                    if ($data["allotment"] == 1) {
                        $allotment = '<small class="text-danger" style="font-size: 1rem">Sólo queda ' . $data["allotment"] . ' habitación </small>';
                    } else {
                        $allotment = '<small class="text-success" style="font-size: 1rem">Quedan ' . $data["allotment"] . ' habitaciones</small>';
                    }
            
                    foreach ($daily_prices as $key => $price) {
                        $fechaCobrada = $this->fn->sumaFechas($infoRes["checkin"], $key);
                        $precio = $precio + $price;
                        $tablePrecios .= '<div class="Cell"><p>' . $this->fn->fechaYearOut($fechaCobrada) . '</p></div>';
                    }
                    $tablePrecios .= '</div>';
            
                    $totalPrecio = $this->fn->tarifaPublicaAgencias($precio);
                    $totalPrecioPublico = $totalPrecio / (1 - ($markup / 100));
            
                    $tablePrecios .= '<div class="Row">';
                    foreach ($daily_prices as $key => $price) {
                        $fechaCobrada = $this->fn->sumaFechas($infoRes["checkin"], $key);
                        $priceShow = $totalPrecioPublico / $listaPrecios;
                        $tablePrecios .= '<div class="Cell"><p>$' . number_format($priceShow, 2, '.', ',') . '</p></div>';
                    }
                    $tablePrecios .= '</div>';
            
                    $cancelacion = $data["payment_options"]["payment_types"][0]["cancellation_penalties"]["policies"];
                    $free_cancelation = $data["payment_options"]["payment_types"][0]["cancellation_penalties"]["free_cancellation_before"];
                    if ($free_cancelation != null) {
                        $fecha = explode("T", $free_cancelation);
                        $fecha_cancelation = $this->fn->restaFechas($fecha[0], 1);
                        $fecha_cancelation = "<small>Hasta " . $this->fn->fechaYearOut($fecha_cancelation) . "</small>";
                        $hora_cancelation = $fecha[1];
            
                        $txtCancelation = '<ul>';
                        foreach ($cancelacion as $i => $dataCancelation) {
                            $subtotalCargo = $dataCancelation["amount_show"];
                            $totalCargo = $this->fn->tarifaPublicaAgencias($subtotalCargo);
            
                            $txtCancelation .= "<li><i class='far fa-check-circle'></i> Cargo de <b>$" . number_format($totalCargo, 2, '.', ',') . "</b> " . $currency;
                            if ($dataCancelation["start_at"] != '') {
                                $desde = $this->fn->restaFechas(date("Y-m-d", strtotime($dataCancelation["start_at"])), 1);
                                $horaDesde = date("H:i:s", strtotime($dataCancelation["start_at"]));
                                $txtCancelation .= " desde <b>" . $desde . " (" . $horaDesde . "*)</b>";
                            }
            
                            if ($dataCancelation["end_at"] != '') {
                                $hasta = $this->fn->restaFechas(date("Y-m-d", strtotime($dataCancelation["end_at"])), 1);
                                $horaHasta = date("H:i:s", strtotime($dataCancelation["end_at"]));
                                $txtCancelation .= " hasta el <b>" . $hasta . " (" . $horaHasta . "*)</b>";
                            } else {
                                $txtCancelation .= "</li>";
                            }
                        }
                        $txtCancelation .= '</ul><b>* <span class="text-danger">Tu hora local (UTC -5:00)</span></b>';
                    } else {
                        $fecha_cancelation  = "";
                        $txtCancelation     = "<ul><li><i class='far fa-check-circle'></i> Si se cancela la tarifa no es reembolsable</li></ul>";
                    }
            
                    $dataRoom = $data["room_data_trans"]["main_name"];
            
                    $habitacionUnicas[$x]['nombre']             = $dataRoom;
                    $habitacionUnicas[$x]['amenidades']         = $amenidades;
                    $habitacionUnicas[$x]['nombreMeal']         = $nombreMeal;
                    $habitacionUnicas[$x]['free_cancelation']   = $free_cancelation;
                    $habitacionUnicas[$x]['fecha_cancelation']  = $fecha_cancelation;
                    $habitacionUnicas[$x]['fecha']              = $free_cancelation;
                    $habitacionUnicas[$x]['totalPrecio']        = $totalPrecioPublico;
                    $habitacionUnicas[$x]['roomsAvailable']     = $roomsAvailable;
                    $habitacionUnicas[$x]['allotment']          = $allotment;
                    $habitacionUnicas[$x]['book_hash']          =  $data["book_hash"];
                    $habitacionUnicas[$x]['room_data_trans']    =  $data["room_data_trans"];
                    $habitacionUnicas[$x]['meal']               =  $data["meal"];
                    $habitacionUnicas[$x]['txtCancelation']     = $txtCancelation;
                    $habitacionUnicas[$x]['tablePrecios']       = $tablePrecios;
                }
            } else {
                $dataRooms = 0;
                $habitacionUnicas = [];
            }
        }else {
            $habitacionUnicas = [];
            $dataRooms = 0;
        }

        return view("web.hoteles.habitaciones", compact(
            'monedaSeleccionada',
            'hotelName',
            'nombreHotel',

            'detHotel',
            'urlLink',
            'tarifasHotel',

            'arrayMenoresCount',
            'menores',
            'markup',


            'infoRes',
            'infoHotel',
            'imagenes',
            'imgPrincipal',
            'description',
            'amenities',
            'stars',

            'reserva',
            'idhotelBD',
            'idHotelName',

            'hotelAds',
            'habitacionUnicas',

            'checkin',
            'checkout',
            'adultos',
            'addressHotel',
            'countMenores',
            'countRoomsUnica',
            'informactionOfTheHotel',
            'existInformationHotel',

            'total',
        ));
    }

    public function formularioHotel(Request $request)
    {
        $data       = $this->fn->decodificaUrl($request->link);
        $formulario = $this->hoteles->formularioHotel($data);

        // return view("web.hoteles.formulario", compact('data', 'formulario'));
    }

    public function getEstatusPaypal(Request $request)
    {
        $response = $this->paypal->getEstatus($request);
        $data     = json_decode($response->getBody(), true);

        return $data;
    }

    public function datosCompraHotel(Request $request)
    {
        $sandBox   = $this->sandBox();
        $hash      = $request->hash;
        $id        = $request->id;
        $checkin   = $request->checkin;
        $checkout  = $request->checkout;
        $adults    = $request->adults;
        $menores   = $request->menores;
        $fx        = $request->fx;
        $room      = $request->room;
        $pr        = $request->pr;
        $meal      = $request->meal;
        $cur       = $request->cur;
        $residency = $request->residency;
        $lan       = $request->lan;
        $hotelName = $request->hotelName;
        $imagen    = $request->foto;
        $idhotelbd = $request->hotbd;
        $markup    = $request->marte;

        //pedritocmenores
        //Si el get es 0, ya no me cuentes menores
        $menoresHabitacion = explode(',', $menores);
        $menoresHabitacion = $menores == "0" ? 0 : count($menoresHabitacion);

        return view('web.hoteles.formulario', compact(
            'hash',
            'id',
            'checkin',
            'checkout',
            'adults',
            'menores',
            'fx',
            'room',
            'pr',
            'meal',
            'cur',
            'residency',
            'lan',
            'hotelName',
            'imagen',
            'idhotelbd',
            'markup',
            'menoresHabitacion',
            'sandBox'
        ));
    }

    public function saveOpenPayHotel(Request $request)
    {
        if($request->ajax()){
            //Se usa para paypal
            $res = $this->guardarPaypalHotel($request);
            return $res;
        }else{
            //Se usa para openpay
            $openpayID   = $request->openpayID;
            $openpayLINK = $request->openpayLINK;

            $id_producto = 2;
    
            $nombre      = $request->nombre;
            $apellido    = $request->apellido;
            $telefono    = $request->telefono;
            $descripcion = "Hospedaje en el hotel :" . $request->nombrehotel;
            $total       = $request->gtotal;
            $email       = $request->email;
            $domain      = $request->getSchemeAndHttpHost();
            $gracias     = "gracias-openpay-hotel";
    
            $response = $this->openpay->obtenerLinkOpenPay([
                'nombre'        => $nombre,
                'apellido'      => $apellido,
                'telefono'      => $telefono,
                'descripcion'   => $descripcion,
                'total'         => $total,
                'email'         => $email,
                'domain'        => $domain,
                'gracias'       => $gracias,
                'currency'      => session('monedaSeleccionada'),
                'id_producto'   => $id_producto,
            ]);
    
            $reserva = $this->guardarOpenPayHotel($request, $response);
            return $reserva;
        }
    }

    public function guardarPaypalHotel(Request $request)
    {
        $afiliado = session('idAfiliado');

        //informacion del cupon
        $cupon          = $request->cupon;

        $valoresHotel                = $request->all();
        $valoresHotel['openpayID']   = $request->transaccion;
        $valoresHotel['openpayLINK'] = '';
        $valoresHotel['idafiliado']  = $afiliado;
        $valoresHotel['afiliado']    = $afiliado;
        $valoresHotel['cupon']       = $cupon;
        $valoresHotel['terminal']    = $request->terminal;

        //Guardamos la reserva en la plataforma:
        $reserva = $this->hoteles->agregarReservacion($valoresHotel);

        session(['reservaGuardada' => $reserva]);
        session(['reservaHotelera' => $valoresHotel]);

        return $reserva;
    }

    public function guardarOpenPayHotel(Request $request, $openPay)
    {
        $afiliado = session('idAfiliado');
        //openpay
        $idopenpay      = $openPay->openpayID;
        $openpayLINK    = $openPay->openpayLINK;

        //informacion del cupon
        $cupon          = $request->cupon;

        $valoresHotel                = $request->all();
        $valoresHotel['openpayID']   = $idopenpay;
        $valoresHotel['openpayLINK'] = $openpayLINK;
        $valoresHotel['idafiliado']  = $afiliado;
        $valoresHotel['afiliado']    = $afiliado;
        $valoresHotel['cupon']       = $cupon;

        //Guardamos la reserva en la plataforma:
        $reserva = $this->hoteles->agregarReservacion($valoresHotel);

        session(['reservaGuardada' => $reserva]);
        session(['reservaHotelera' => $valoresHotel]);

        // $prueba = session('reservaGuardada');
        return redirect()->to($openpayLINK);
    }

    public function graciasOpenPayHotel(Request $request)
    {
        $sitioWeb = json_decode($this->InfoWebEmpresa());
        $sandBox = $this->sandBox();

        $idoperacion            = $request->id;
        $data["transaccion"]    = $idoperacion;

        $respuesta    = $this->openpay->obtenerStatusPay($data);
        $valoresHotel = session("reservaHotelera");

        $formRate["partner_order_id"]   = $respuesta->reservacion[0]->controlinterno;
        $formRate["language"]           = "ES";
        $formRate["user_ip"]            = $request->ip();
        $formRate["book_hash"]          = $respuesta->reservacion[0]->book_hash;
        $formRate["reservaBD"]          = $respuesta->reservacion[0]->id;
        $formRate["nombre"]             = $valoresHotel['nombre'];
        $formRate["apellido"]           = $valoresHotel['apellido'];
        $formRate["sandbox"]            = $sandBox;

        $estatus                        = $respuesta->estatus;
        $mensaje                        = $respuesta->mensaje;
        $formRate["autorizacion"]       = $respuesta->autorizacion;
        $formRate["montopagado"]        = $respuesta->monto;

        $formRate["emailAfiliado"]      = $respuesta->reservacion[0]->email;
        $formRate["estatus"]            = $estatus;
        $formRate["email"]              = $respuesta->reservacion[0]->email_principal;

        $formRate["cc_email_reservas_uno"] = $sitioWeb[0]->cc_email_reservas_uno;
        $formRate["cc_email_reservas_dos"] = $sitioWeb[0]->cc_email_reservas_dos;

        $reservafinal = $this->hoteles->requestReservation($formRate);

        return view('web.hoteles.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function graciasHoteles(Request $request)
    {
        if ($request->exists('terminal') && ($request->terminal != 3)) {
            $terminal = $request->terminal;
        } else {
            $terminal = 3;
        }

        if ($terminal == 3) {
            $response = $this->graciasOpenPayHotel($request);
        }

        if ($terminal == 4) {
            $response = $this->graciasPaypalHotel($request);
        }

        $estatus = $response["estatus"];
        $mensaje = $response["mensaje"];

        return view('web.hoteles.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function graciasPaypalHotel($request)
    {

        $estatus = 'completed';
        $mensaje = '';

        $data["transaccion"]  = $request->id;
        $respuesta = $this->hoteles->requestTransaction($data);

        $valoresHotel         = session("reservaHotelera");
        $sitioWeb             = json_decode($this->InfoWebEmpresa());
        $sandBox              = $this->sandBox();

        $formRate["partner_order_id"]   = $respuesta[0]["controlinterno"];
        $formRate["language"]           = "ES";
        $formRate["user_ip"]            = $request->ip();
        $formRate["book_hash"]          = $respuesta[0]["book_hash"];
        $formRate["reservaBD"]          = $respuesta[0]["id"];
        $formRate["nombre"]             = $valoresHotel['nombre'];
        $formRate["apellido"]           = $valoresHotel['apellido'];
        $formRate["sandbox"]            = $sandBox;

        $estatus                        = "completed";
        $mensaje                        = "";
        $formRate["autorizacion"]       = $request->order;
        $formRate["montopagado"]        = number_format($request->monto, 2, '.ss', '');

        $formRate["emailAfiliado"]      = $respuesta[0]["email"];
        $formRate["estatus"]            = $estatus;
        $formRate["email"]              = $respuesta[0]["email_principal"];

        $formRate["cc_email_reservas_uno"] = $sitioWeb[0]->cc_email_reservas_uno;
        $formRate["cc_email_reservas_dos"] = $sitioWeb[0]->cc_email_reservas_dos;

        $reservafinal = $this->hoteles->requestReservation($formRate);

        $form["estatus"] = $estatus;
        $form["mensaje"] = $mensaje;

        return $form;
    }

    // CIVITATIS
    public function tourList(Request $request)
    {
        $idtourArray = explode("_", $request->idDestinoTour);
        if (count($idtourArray) == 2) {
            $link = 'actividad/actividades/' . $idtourArray[0];
            // tour-detail/actividad/actividades/172418
            return redirect()->to($link);
        }

        if (isset($request->nombreDestinoTour)) {
            $sandbox          = $this->sandbox();
            $form["lang"]     = 'es';
            $form["currency"] = session('monedaSeleccionada');
            $form["id"]       = $request->idDestinoTour;
            $form["sandbox"]  = $sandbox;

            $civitatis        = $this->civitatis->buscaToursMotor($request, $form["currency"], $sandbox);
            $markup           = $civitatis['empresa'][0]['comision_tours'];

            $nombreDestino    = $request->nombreDestinoTour;
            $count    = count($civitatis['actividades']);
            $civitatisActividades = $civitatis['actividades'];
        }

        $idDestinoTour = $request->idDestinoTour;
        $arrayTipoTours = [];

        return view('web.civitatis.index', compact(
            'nombreDestino',
            'markup',
            'civitatis',
            'idDestinoTour',
            'count',
            'arrayTipoTours',
            'civitatisActividades',
        ));
    }

    public function tourDetalle(Request $request, $seo, $idtour)
    {
        $moneda        = session('monedaSeleccionada');
        $monedas       = $this->monedas();
        $base          = $request->root();
        $sandbox       = $this->sandbox();

        $tour                   = $this->civitatis->tourDetalle($idtour, $moneda, $sandbox);
        $actividad              = $tour['actividad'];
        $categoriaUnica         = $actividad['category']['description'];
        $duracionTour           = $actividad['duration']['duration'];
        $foto                   = $actividad['photos']['header'][0]['paths']['original'];
        $title                  = $actividad['title'];
        $gallery                = $actividad['photos']['gallery'];
        $fotoActividad          = $actividad['photos']['header'][0]['paths']['original'];
        $score                  = $actividad['score'];
        $reviews                = $actividad['reviews'];
        $minimumPrice           = $actividad['minimumPrice'];
        $description            = $actividad['description'];
        $included               = $actividad['included'];
        $notIncluded            = $actividad['notIncluded'];
        $infoVoucher            = $actividad['infoVoucher'];
        $minutes_before         = $actividad['advance']['minutes_before'];
        $minimumPaxPerBooking   = $actividad['MinimumPaxPerBooking'];
        $minimumPaxPerActivity  = $actividad['minimumPaxPerActivity'];
        $minimumPrice           = $actividad['minimumPrice'];
        $cancelPolicies         = $actividad['cancelPolicies'];
        $actividadId            = $actividad['id'];
        $actividadTitle         = $actividad['title'];
        $ratesCategories        = $actividad['rates'][0]['categories'];
        $calendario             = $tour['calendario'];
        $calendarioSchedule     = $calendario['schedule'];
        $markup                 = $tour['empresa'][0]['comision_tours'];
        $countHorariosTimes     = count($calendarioSchedule[0]['times']);

        foreach ($actividad['rates'] as $rate) {
            $categoriasTours[$rate['id']] = $rate['text'];
        }

        foreach ($actividad['rates'][0]['categories'] as $tipo) {
            $tipos[$tipo['id']] = $tipo['text'];
        }

        return view("web.civitatis.detalle", compact(
            "monedas",
            "base",
            "tour",
            "actividad",
            "calendario",
            "calendarioSchedule",
            "markup",
            "foto",
            "title",
            "score",
            "reviews",
            "minimumPrice",
            "gallery",
            "description",
            "included",
            "notIncluded",
            "minutes_before",
            "infoVoucher",
            "minimumPaxPerBooking",
            "minimumPaxPerActivity",
            "minimumPrice",
            "cancelPolicies",
            "fotoActividad",
            "actividadId",
            "actividadTitle",
            "categoriasTours",
            "tipos",
            "ratesCategories",
            "categoriaUnica",
            "duracionTour",
            "countHorariosTimes"
        ));
    }

    public function datosCompraCivitatis(Request $request)
    {
        $sandBox     = $this->sandBox();
        $imagen      = $request->imagen;
        $idactividad = $request->idactividad;
        $markup      = $request->markup;
        $currency    = $request->currency;
        $precioTotal = $request->precioTotal;
        $rateselect  = $request->rate;
        $campo       = $request->campo;
        $cantidad    = $request->cantidad;
        $fecha       = $request->fecha;
        $horario     = $request->horario;
        $nombreAct   = $request->nombreActividad;
        $tipos       = $request->tipos;

        $form["activityId"]     = $idactividad;
        $form["date"]           = $fecha;
        $form["currency"]       = $currency;
        $form["time"]           = $horario;

        foreach ($campo as $i => $categoria) {
            $categories[$i]["id"]       = $categoria;
            $categories[$i]["quantity"] = $cantidad[$i];
        }

        $rate["categories"] = $categories;
        $rate["id"]         = $rateselect;
        $form["rate"]       = $rate;
        $form["sandbox"]    = $sandBox;

        //Creamos el carrito
        $response = $this->civitatis->agregarTourCarito($form);
        $cart     = $response['cart'];
        $fields   = $response['fields'];

        $cartId   = $cart['cartId'];
        $fieldsId = $fields['items'][0]['id'];
        $fieldsBooking = $fields['items'][0]['details']['booking'];

        return view('web.civitatis.formulario', compact(
            'nombreAct',
            'fecha',
            'horario',
            'cartId',
            'precioTotal',
            'fieldsId',
            'nombreAct',
            'campo',
            'cartId',
            'cantidad',
            'fieldsBooking',
            'tipos',
            'imagen'
        ));
    }

    public function saveOpenPayCivitatis(Request $request)
    {

        if($request->ajax()) {
            //Se usa para psarela de pago Paypal
            $response = $this->guardarPaypalCivitatis($request);
            return $response;
        } else {
            $nombre      = $request->nombre;
            $apellido    = $request->apellido;
            $telefono    = $request->telefono;
            $descripcion = "Paquete de viaje a : " . $request->nombretour;
            $total       = $request->gtotal;
            $email       = $request->email;

            $id_producto = 3;
    
            $domain      = $request->getSchemeAndHttpHost();
            $gracias     = "gracias-openpay-civitatis";
    
            $response = $this->openpay->obtenerLinkOpenPay([
                'nombre'        => $nombre,
                'apellido'      => $apellido,
                'telefono'      => $telefono,
                'descripcion'   => $descripcion,
                'total'         => $total,
                'email'         => $email,
                'domain'        => $domain,
                'gracias'       => $gracias,
                'currency'      => session('monedaSeleccionada'),
                'id_producto'   => $id_producto,
            ]);
    
            $reserva = $this->guardarOpenPayCivitatis($request, $response);
            return $reserva;
        }
    }

    public function guardarOpenPayCivitatis(Request $request, $openPay)
    {
        $sandBox        = $this->sandBox();

        //openpay
        $idopenpay      = $openPay->openpayID;
        $openpayLINK    = $openPay->openpayLINK;

        $afiliado       = session('idAfiliado');
        //informacion del cupon
        $cupon          = $request->cupon;

        $valoresCivitatis                = $request->all();
        $valoresCivitatis['openpayLINK'] = $openpayLINK;
        $valoresCivitatis['cupon']       = $cupon;
        $valoresCivitatis['sandbox']     = $sandBox;
        $valoresCivitatis['openpayID']   = $idopenpay;
        session(['reservaCivi' => $valoresCivitatis]);

        $reserva = $this->civitatis->agregarReserva($valoresCivitatis);

        return redirect()->to($openpayLINK);
    }

    public function guardarPaypalCivitatis(Request $request)
    {
        $sandBox        = $this->sandBox();

        $afiliado       = session('idAfiliado');
        //informacion del cupon
        $cupon          = $request->cupon;

        $valoresCivitatis                = $request->all();
        $valoresCivitatis['openpayLINK'] = '';
        $valoresCivitatis['cupon']       = $cupon;
        $valoresCivitatis['sandbox']     = $sandBox;
        $valoresCivitatis['openpayID']   = $request->transaccion;
        session(['reservaCivi' => $valoresCivitatis]);

        $reserva = $this->civitatis->agregarReserva($valoresCivitatis);

        return $reserva;
    }

    public function graciasCivitatis(Request $request)
    {
        if ($request->exists('terminal') && $request->terminal != 3) {
            $terminal = $request->terminal;
        } else {
            $terminal = 3;
        }

        if ($terminal == 3) {
            $response = $this->graciasOpenPayCivitatis($request);
        } else if ($terminal == 4) {
            $response = $this->graciasPaypalCivitatis($request);
        } else {
            return '';
        }

        $estatus = $response["estatus"];
        $mensaje = $response["mensaje"];

        return view('web.civitatis.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function graciasOpenPayCivitatis(Request $request)
    {
        $sitioWeb   = json_decode($this->InfoWebEmpresa());
        $sandBox    = $this->sandBox();

        $idoperacion            = $request->id;
        $data["transaccion"]    = $idoperacion;

        $respuesta              = $this->openpay->obtenerStatusPay($data);
        $autorizacion             = $respuesta->autorizacion;
        $tipo                     = $respuesta->tipo;
        $monto                    = $respuesta->monto;
        $estatus                  = $respuesta->estatus;
        $mensaje                  = $respuesta->mensaje;


        if ($estatus === 'completed') {
            $reservacion = session("reservaCivi");
            $form["idopenpay"] = $idoperacion;
            $form["cartid"]    = $reservacion["cartid"];
            $form["sandbox"]   = $sandBox;
            $update = $this->civitatis->confirmaPagoReservaCivitatis($form);
        }
        return view('web.civitatis.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function graciasPaypalCivitatis(Request $request)
    {
        $estatus = 'completed';
        $mensaje = '';

        $sandBox    = $this->sandBox();

        if ($estatus === 'completed') {
            $reservacion = session("reservaCivi");
            $form["idopenpay"] = $request->id;
            $form["cartid"]    = $request->order;
            $form["sandbox"]   = $sandBox;
            $update = $this->civitatis->confirmaPagoReservaCivitatis($form);
        }
        $response['estatus'] = "completed";
        $response['mensaje'] = "";

        return $response;
    }

    //Blog
    public function listBlog()
    {
        $blogs          = $this->blog->infoBlog();
        $categoriasBlog = $this->blog->categoriasBlog();

        return view('web.blog.index', compact('blogs', 'categoriasBlog'));
    }

    public function detalleArticulo(Request $request, $nombreArticulo, $idArticulo)
    {
        $detalleArticulo = $this->blog->informacionArticulo($idArticulo);
        $detalleArticuloInformation = $detalleArticulo['articulo'][0];
        $galeriaDelArticulo = $detalleArticulo['imagenes'];

        return view('web.blog.detalle', compact('detalleArticulo', 'detalleArticuloInformation', 'galeriaDelArticulo'));
    }

    public function listCategoriaArticulo(Request $request, $nombreCategoria, $idCategoria)
    {
        $listaCategoriaArticulo = $this->blog->articulosPorCategoria($idCategoria);
        $categoriasBlog         = $this->blog->categoriasBlog();

        // foreach($categoriasBlog as $categoriaNombre){
        //     if($categoriaNombre['id'] == $idCategoria) {
        //         $nombreCategoria = $categoriaNombre['nombre'];
        //     }
        // };

        /*$response = $this->blog->articulosPorCategoria([
            'categoria' => $idCategoria,
        ]);*/

        //return dd($response);
        return view('web.blog.categoria', compact('listaCategoriaArticulo', 'categoriasBlog', 'idCategoria', 'nombreCategoria'));
    }

    public function tester()
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->get('https://app.bookingtrap.com/api/testRequest');

        return $response;
    }

    //Transportaciones M1
    public function destinoTransporte(Request $request)
    {
        // return $request;
        $form["search"] = $request->search;
        $destinosJson = $this->transportacion->transportacionDestinations($form);
        // return $destinosJson;
        $destinos = json_decode($destinosJson);

        $lista = $destinos->results;

        foreach ($lista as $i => $registro) {
            $text = $registro->text;
            if ($i > 0) {
                if ($text == 'Destinos') {
                    break;
                    exit;
                } else {
                    $key = $i - 1;
                    $formList[$key]["id"]   = $registro->id;
                    $formList[$key]["text"] = $registro->text;
                    $formList[$key]["zona"] = $registro->zona;
                }
            }
        }

        return json_encode($formList);
    }

    public function transportationList(Request $request)
    {
        // return $request;
        $tipoServicio            = $request->tipoServicio; //1:Sencillo 2:Redondo

        //Datos del origen
        $origenTransporte        = $request->origenTransporte;
        $nombreOrigenTransporte  = $request->nombreOrigenTransporte;
        $idOrigenTransporte       = $request->idOrigenTransporte;
        $idZonaOrigen            = $request->idZonaOrigen;

        //Datos del destino
        $destinoTransporte       = $request->destinoTransporte;
        $nombreDestinoTransporte = $request->nombreDestinoTransporte;
        $idDestinoTransporte     = $request->idDestinoTransporte;
        $idZonaDestino           = $request->idZonaDestino;

        $fechaLlegada            = $request->fechaLlegada;
        $fechaSalida             = $request->fechaSalida;

        $adultos                 = $request->adultosTrans;
        $menores                 = $request->menoresTrans;

        $form["idOrigenTransporte"]  = $idOrigenTransporte;
        $form["idDestinoTransporte"] = $idDestinoTransporte;

        $form["idZonaOrigen"]        = $idZonaOrigen;
        $form["idZonaDestino"]       = $idZonaDestino;

        $form["fechaLlegada"]        = $fechaLlegada;
        $form["fechaSalida"]         = $fechaSalida;

        $form["adultos"]             = $adultos;
        $form["menores"]             = $menores;

        $data = $this->transportacion->transportacionServicesList($form)->json();
        // return $list;
        $list = $data["precios"];

        $lugar_uno = implode(",", $data["lugares"][0]);
        $lugar_dos = implode(",", $data["lugares"][1]);

        $transportacionLista = null; //decalramos la lista como nula para manejar respuestas vacias

        foreach ($list as $i => $lista) {
            // return $lista['id'];
            // Precios sencillos
            $adultoSencillo  = $this->fn->precio($lista["sencillo"], $lista["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
            $menorSencillo   = $this->fn->precio($lista["sencillo_menor"], $lista["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
            $infanteSencillo = $this->fn->precio($lista["sencillo_infante"], $lista["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());

            // Precios redondos
            $adultoRedondo   = $this->fn->precio($lista["redondo"], $lista["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
            $menorRedondo    = $this->fn->precio($lista["redondo_menor"], $lista["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());
            $infanteRedondo  = $this->fn->precio($lista["redondo_infante"], $lista["iso"], session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());

            $edades  = "menor_min=" . $lista["edad_menor_min"] . "&menor_max=" . $lista["edad_menor_max"] . "&infante_min=";
            $edades .= $lista["edad_infante_min"] . "&infante_max=" . $lista["edad_infante_max"];

            $linkSencillo = $edades . "&tipo=1&reg=" . $lista["id"] . "&za=" . $lista["id_zona_checkin"] . "&zb=" . $lista["id_zona_checkout"] . "&ad=" . $adultoSencillo["preciosimple"];
            $linkSencillo .= "&men=" . $menorSencillo["preciosimple"] . "&inf=" . $infanteSencillo["preciosimple"];

            $linkRedondo = $edades . "&tipo=2&reg=" . $lista["id"] . "&za=" . $lista["id_zona_checkin"] . "&zb=" . $lista["id_zona_checkout"] . "&ad=" . $adultoRedondo["preciosimple"];
            $linkRedondo .= "&men=" . $menorRedondo["preciosimple"] . "&inf=" . $infanteRedondo["preciosimple"];

            if ($lista["tipo_servicio"] == 1) {
                $nombreServicio = 'Privado';
            } else {
                $nombreServicio = 'Compartido';
            }

            $edades  = "menor_min=" . $lista["edad_menor_min"] . "&menor_max=" . $lista["edad_menor_max"] . "&infante_min=";
            $edades .= $lista["edad_infante_min"] . "&infante_max=" . $lista["edad_infante_max"];

            $linkSencillo  = $edades . "&tipo=1&reg=" . $lista["id"] . "&za=" . $lista["id_zona_checkin"] . "&zb=";
            $linkSencillo .= $lista["id_zona_checkout"] . "&ad=" . $adultoSencillo["preciosimple"];
            $linkSencillo .= "&men=" . $menorSencillo["preciosimple"] . "&inf=" . $infanteSencillo["preciosimple"];
            $linkSencillo .= "&tipo_servicio=" . $lista["tipo_servicio"] . "&tipo_pago=" . $lista["tipo_pago"];
            $linkSencillo .= "&origenTransporte=" . $idOrigenTransporte . "&destinoTransporte=" . $idDestinoTransporte;
            $linkSencillo .= "&adultos=" . $adultos . "&menores=" . $menores . "&lugar_uno=" . $lugar_uno . "&lugar_dos=" . $lugar_dos;
            $linkSencillo .= "&fechaLlegada=" . $fechaLlegada . "&fechaSalida=" . $fechaSalida;
            $linkSencillo .= "&unidad=" . $lista["idunidad"] . "&tipoUnidad=" . $lista["id_unidad"];
            $linkSencillo .= "&nombreOrigenTransporte=" . $nombreOrigenTransporte . "&nombreDestinoTransporte=" . $nombreDestinoTransporte;

            $linkRedondo =  $edades . "&tipo=2&reg=" . $lista["id"] . "&za=" . $lista["id_zona_checkin"] . "&zb=";
            $linkRedondo .= $lista["id_zona_checkout"] . "&ad=" . $adultoRedondo["preciosimple"];
            $linkRedondo .= "&men=" . $menorRedondo["preciosimple"] . "&inf=" . $infanteRedondo["preciosimple"];
            $linkRedondo .= "&tipo_servicio=" . $lista["tipo_servicio"] . "&tipo_pago=" . $lista["tipo_pago"];
            $linkRedondo .= "&origenTransporte=" . $idOrigenTransporte . "&destinoTransporte=" . $idDestinoTransporte;
            $linkRedondo .= "&adultos=" . $adultos . "&menores=" . $menores . "&lugar_uno=" . $lugar_uno . "&lugar_dos=" . $lugar_dos;
            $linkRedondo .= "&fechaLlegada=" . $fechaLlegada . "&fechaSalida=" . $fechaSalida;
            $linkRedondo .= "&unidad=" . $lista["idunidad"] . "&tipoUnidad=" . $lista["id_unidad"];
            $linkRedondo .= "&nombreOrigenTransporte=" . $nombreOrigenTransporte . "&nombreDestinoTransporte=" . $nombreDestinoTransporte;

            $transportacionLista[$i]['pasaje_max']      = $lista["pasaje_max"];
            $transportacionLista[$i]['maletas']         = $lista["maletas"];
            $transportacionLista[$i]['img_unid']        = $lista["img_unid"];
            $transportacionLista[$i]['marca']           = $lista["marca"];
            $transportacionLista[$i]['modelo']          = $lista["modelo"];
            $transportacionLista[$i]['linkSencillo']    = $linkSencillo;
            $transportacionLista[$i]['linkRedondo']     = $linkRedondo;
            $transportacionLista[$i]['linkImg']         = 'https://app.bookingtrap.com/public/storage/' . $lista["img_unid"];
            $transportacionLista[$i]['tiposervicio']    = $lista["tiposervicio"];
            $transportacionLista[$i]['tipo_pago']       = $lista["tipo_pago"];
            $transportacionLista[$i]['adultoSencillo']  = $adultoSencillo["precioformato"];
            $transportacionLista[$i]['adultoRedondo']   = $adultoRedondo["precioformato"];
            $transportacionLista[$i]['menorSencillo']   = $menorSencillo["precioformato"];
            $transportacionLista[$i]['menorRedondo']    = $menorRedondo["precioformato"];
            $transportacionLista[$i]['infanteSencillo'] = $infanteSencillo["precioformato"];
            $transportacionLista[$i]['infanteRedondo']  = $infanteRedondo["precioformato"];
            $transportacionLista[$i]['nombreServicio']  = $nombreServicio;
        }

        return view('web.transportaciones.index', compact(
            'transportacionLista',
            'tipoServicio',
            'fechaLlegada',
            'fechaSalida',
            'adultos',
            'menores',
            'origenTransporte',
            'nombreOrigenTransporte',
            'idOrigenTransporte',
            'idZonaOrigen',
            'destinoTransporte',
            'nombreDestinoTransporte',
            'idDestinoTransporte',
            'idZonaDestino'
        ));
    }


    public function datosCompraTransportacionM1(Request $request, $datosCompraTransporte)
    {
        // $this->sessionAfiliado($request);
        $cadena         = $datosCompraTransporte;
        $datosCompra    = $this->fn->decodificaUrl($cadena);

        $tipo                    = $datosCompra["tipo"]; //1: Sencillo, 2: Redondo
        $reg                     = $datosCompra["reg"];
        $idDesde                 = $datosCompra["za"];
        $idHasta                 = $datosCompra["zb"];
        $precioAdultos           = $datosCompra["ad"];
        $adultos                 = $datosCompra["adultos"];
        $precioMenores           = $datosCompra["men"];
        $menores                 = $datosCompra["menores"];
        $precioInfantes          = $datosCompra["inf"];
        $tipo_servicio           = $datosCompra["tipo_servicio"]; //Privado: 1 o compartido: 2
        $tipo_pago               = $datosCompra["tipo_pago"]; //Por persona: 1 o por unidad: 2
        $origenTransporte        = $datosCompra["origenTransporte"];
        $destinoTransporte       = $datosCompra["destinoTransporte"];
        $nombreOrigenTransporte  = $datosCompra["nombreOrigenTransporte"];
        $nombreDestinoTransporte = $datosCompra["nombreDestinoTransporte"];
        $fechaLlegada            = $datosCompra["fechaLlegada"];
        $fechaSalida             = $datosCompra["fechaSalida"];
        $id_unidad               = $datosCompra["unidad"];
        $tipo_unidad             = $datosCompra["tipoUnidad"];

        $lugar_uno               = explode(",", $datosCompra["lugar_uno"]);
        $lugar_dos               = explode(",", $datosCompra["lugar_dos"]);

        $lugares[0]["id"]        = $lugar_uno[0];
        $lugares[0]["vuelos"]    = $lugar_uno[1];

        $lugares[1]["id"]        = $lugar_dos[0];
        $lugares[1]["vuelos"]    = $lugar_dos[1];

        $claveOrigen  = array_search($origenTransporte, array_column($lugares, "id"));
        $vuelosOrigen = $lugares[$claveOrigen]["vuelos"];

        $claveDestino  = array_search($destinoTransporte, array_column($lugares, "id"));
        $vuelosDestino = $lugares[$claveDestino]["vuelos"];

        $menor_min      = $datosCompra["menor_min"];
        $menor_max      = $datosCompra["menor_max"];

        $infante_min    = $datosCompra["infante_min"];
        $infante_max    = $datosCompra["infante_max"];

        $productos      = json_decode($this->transportacion->productosTransportacion());
        $countProductos = count($productos);
        //declaramos la lista como nula para manejar respuestas vacias
        $productosTiendita = null;
        foreach ($productos as $p => $producto) {
            $precioProducto = $this->fn->precio($producto->precio, $producto->iso, session('monedaSeleccionada'), $this->MonedaDefault(), $this->Monedas());

            $productosTiendita[$p]['id']                = $producto->id;
            $productosTiendita[$p]['id_moneda']         = $producto->id_moneda;
            $productosTiendita[$p]['nombre']            = $producto->nombre;
            $productosTiendita[$p]['imagen']            = $producto->imagen;
            $productosTiendita[$p]['precio']            = $producto->precio;
            $productosTiendita[$p]['iso']               = $producto->iso;
            $productosTiendita[$p]['precioProducto']    = $precioProducto["precioformato"];
            $productosTiendita[$p]['preciosimple']      = $precioProducto["preciosimple"];
        }

        if ($tipo_pago == 1) {
            //Pago por persona
            $subAdultos = $adultos * $precioAdultos;
            $subMenores = $menores * $precioMenores;
            $total      = $subAdultos + $subMenores;
        } else {
            //Pago por unidad
            $total = $precioAdultos;
        }

        return view('web.transportaciones.datosCompra', compact(
            'productos',
            'tipo_servicio',
            'tipo_pago',
            'tipo',
            'reg',
            'idDesde',
            'idHasta',
            'origenTransporte',
            'destinoTransporte',
            'precioAdultos',
            'precioMenores',
            'precioInfantes',
            'adultos',
            'menores',
            'id_unidad',
            'tipo_unidad',
            'fechaLlegada',
            'fechaSalida',
            'total',
            'countProductos',
            'productosTiendita',
            'nombreOrigenTransporte',
            'nombreDestinoTransporte',
            'vuelosOrigen',
            'vuelosDestino'
        ));
    }

    public function saveOpenPayTransportacionM1(Request $request)
    {

        $sandBox                = $this->sandBox();

        $nombre                 = $request->nombre;
        $apellido               = $request->apellido;
        $telefono               = $request->telefono;
        $descripcion            = $request->descripcion;

        $afiliado               = session('idAfiliado');

        // $request['cupon'] = '';
        if ($request->cupon != "") {
            $totalNew                = $request->totalConCuponTable;
            $request['total']        = $totalNew;
        } else {
            $total                   = $request->total;
            $request['total']        = $total;
        }

        $email                  = $request->email;

        //openpay lo realiza ahora la API de reservar Transportacion

        $afiliado       = session('idAfiliado');

        //informacion del cupon
        $cupon          = $request->cupon;

        // // Si no existe el input name de cantidad y id (productos tienditas) crear los filds
        // if(!$request->exists('id') && !$request->exists('cantidad')) {
        //     $cantidad = [];
        //     $idProducts = [];
        //     $request->merge(['cantidad' => $cantidad]);
        //     $request->merge(['id' => $idProducts]);
        // }
        $CompraOpenPayTransportacionM1                = $request->all();
        $CompraOpenPayTransportacionM1['cupon']       = $cupon;
        $CompraOpenPayTransportacionM1['id_afiliado'] = $afiliado;

        //Guardamos la reserva en la plataforma:
        $data = $this->transportacion->guardarReserva($CompraOpenPayTransportacionM1);
        $openpayLINK = $data['openpayLINK'];

        return redirect()->to($openpayLINK);
    }

    public function guardarPaypalTransportacionM1(Request $request)
    {
        $sandBox                = $this->sandBox();

        $nombre                 = $request->nombre;
        $apellido               = $request->apellido;
        $telefono               = $request->telefono;
        $descripcion            = $request->descripcion;

        // $request['cupon'] = '';
        if ($request->cupon != "") {
            $totalNew                = $request->totalConCuponTable;
            $request['total']        = $totalNew;
        } else {
            $total                   = $request->total;
            $request['total']        = $total;
        }

        $email                  = $request->email;

        //openpay lo realiza ahora la API de reservar Transportacion

        $afiliado       = session('idAfiliado');

        //informacion del cupon
        $cupon          = $request->cupon;

        // // Si no existe el input name de cantidad y id (productos tienditas) crear los filds
        // if(!$request->exists('id') && !$request->exists('cantidad')) {
        //     $cantidad = [];
        //     $idProducts = [];
        //     $request->merge(['cantidad' => $cantidad]);
        //     $request->merge(['id' => $idProducts]);
        // }
        $CompraOpenPayTransportacionM1                = $request->all();
        $CompraOpenPayTransportacionM1['cupon']       = $cupon;
        $CompraOpenPayTransportacionM1['idopenpay']   = $request->transaccion;
        //Guardamos la reserva en la plataforma:
        $data = $this->transportacion->guardarReserva($CompraOpenPayTransportacionM1);

        return $data;
    }

    public function SaveOpenPayTransportaciones(Request $request)
    {
        // return $request->ajax(); = 1;
        // return dd($request->ajax()); = true;
        if ($request->ajax()) {
            $response = $this->guardarPaypalTransportacionM1($request);
            return $response;
        } else {
            $response = $this->saveOpenPayTransportacionM1($request);
            return $response;
        }
    }

    public function graciasOpenPayTransportacionesM1(Request $request)
    {
        if ($request->exists('terminal') && $request->terminal != 3) {
            $terminal = $request->terminal;
        } else {
            $terminal = 3;
        }

        if ($terminal == 3) {
            // return 'openpay';
            $response = $this->graciasOpenPaytransportacionM1($request);

            //    return dd($response);
        } else if ($terminal == 4) {
            // return 'paypal';
            $response = $this->graciasPaypalTransportacionM1($request);
        } else {
            return '';
        }


        // $estatus = $response->estatus;
        // $mensaje = $response->mensaje;
        $estatus = $response['estatus'];
        $mensaje = $response['mensaje'];

        return view('web.transportaciones.graciasOpenPay', compact('estatus', 'mensaje'));
    }

    public function graciasOpenPaytransportacionM1(Request $request)
    {

        $sandBox    = $this->sandBox();

        $idoperacion            = $request->id;
        $data["transaccion"]    = $idoperacion;

        $respuesta              = $this->openpay->obtenerStatusPay($data);

        $estatus                   = $respuesta->estatus;
        $formRate["autorizacion"]  = $respuesta->autorizacion;
        $formRate["montopagado"]   = $respuesta->monto;
        $formRate["tipo"]          = $respuesta->tipo;
        $formRate["idtransaccion"] = $idoperacion;

        if ($estatus === 'completed') {
            $reservafinal = $this->transportacion->actualizarReservacionTransportacion($formRate);
        }

        $formRate["estatus"] = $estatus;
        $formRate["mensaje"] = '';
        return $formRate;

        return view('web.transportaciones.graciasOpenPay', compact('estatus'));
    }

    public function graciasPaypalTransportacionM1(Request $request)
    {
        $estatus = 'completed';
        $mensaje = '';

        $sandBox    = $this->sandBox();

        // $idoperacion            = $request->id;
        // $data["transaccion"]    = $idoperacion;

        // $respuesta              = $this->openpay->obtenerStatusPay($data);

        $estatus                   = 'completed';
        $formRate["autorizacion"]  = $request->order;
        $formRate["montopagado"]   = $request->monto;
        $formRate["tipo"]          = '';
        $formRate["idtransaccion"] = $request->id;


        $reservafinal = $this->transportacion->actualizarReservacionTransportacion($formRate);

        $form["estatus"] = $estatus;
        $form["mensaje"] = $mensaje;

        $response["estatus"] = $estatus;
        $response["mensaje"] = $mensaje;

        return $response;
    }

    // pABLO - Enviamos Al Front End La Data from Motor
    public function listaHotelesV2(Request $request)
    {
        $vars = $request->all();
        // return $vars;

        if (isset($vars["edad"])) {
            foreach ($vars["edad"] as $i => $edad) {
                $edadesArray[$i] = $edad;
            }
            $vars['edad'] = $edadesArray;
        } else {
            $vars['edad'] = [];
        }

        // return $vars;
        return view("web.hoteles.listado", compact("vars"));
    }

    public function ajaxHotelLista(Request $request)
    {
        $moneda        = session('monedaSeleccionada');
        $dataHoteles   = $this->hoteles->buscaHotelesMotorB($request, $moneda, $this->sandBox());

        $hotelLink     = $dataHoteles["form"];
        $nombreDestino = '';
        $checkinDate   = '';
        $checkoutDate  = '';

        $sitioWeb = $this->InfoWebEmpresa();
        $sandbox  = $this->sandBox();

        $idRegion                = $request->destinoHotelero;
        if ($nombreDestino == '') {
            $nombreDestino       = $request->nombreDestinoHotelero;
        }

        if ($checkinDate == '') {
            $checkinDate             = $request->checkin;
        }

        if ($checkoutDate == '') {
            $checkoutDate            = $request->checkout;
        }

        $adultos                 = intval($request->adultos);
        //modificacion
        if ($adultos == 0) {
            $adultos = 2;
        }
        // return $adultos;
        $menoresInput            = $request->menores; //Sirve para contabilizar la cantidad de huespedes
        $menoresTxt              = $menoresInput > 0 ? implode(",", $request->edad) : 'cero';

        $monedaSeleccionada      = session('monedaSeleccionada');
        $residency               = "MX";
        $currency                = $monedaSeleccionada;
        $language                = "es";

        if (isset($request->edad)) {
            foreach ($request->edad as $i => $edad) {
                $menoresarray[$i] = intval($edad);
            }
        } else {
            $menoresarray = [];
        }

        $guests["adults"]        = $adultos;
        $guests["children"]      = $menoresarray;

        $markup                  = $dataHoteles["comision"][0]["comision_hoteleria"];
        $hoteles                 = $dataHoteles["hoteles"]["data"]["hotels"];
        $hotelsBDs               = $dataHoteles["hotelesBD"];
        $hotelAds                = $dataHoteles["hotelAds"];
        $hotelesCount            = count($dataHoteles["hoteles"]["data"]["hotels"]);

        $registro = 1;
        $arrayMeals = [];
        $arrayStars = [];
        $arrayError = [];


        foreach ($hoteles as $conteo => $hotel) {
            $idhotel = $hotel['id'];
            // return $hotel['rates'];
            if (count($hotel['rates']) > 0) {
                $price_night = $hotel['rates'][0]['daily_prices'];
                $room_name = $hotel['rates'][0]['room_name'];
                $allotment = $hotel['rates'][0]['allotment'];
                $amenities = $hotel['rates'][0]['amenities_data'];

                $total = 0;
                foreach ($price_night as $price) {
                    $total = $total + $price;
                }

                $total = $this->fn->tarifaPublicaAgencias($total);
                $totalPublico = $total / (1 - $markup / 100);

                $imgLink = 'https://app.bookingtrap.com/storage/app/public/recursos/trabajando.png';
                $clave = array_search($idhotel, array_column($hotelsBDs, 'idHotel'));
                $claveAds = array_search($hotel['rates'][0]['meal'], array_column($hotelAds, 'name'));

                switch ($hotel['rates'][0]['meal']) {
                    case 'breakfast-for-2':
                        $planHospedaje = 'breakfast';
                        break;
                    default:
                        $planHospedaje = $hotel['rates'][0]['meal'];
                }

                if ($clave != '') {
                    $hotelName = $hotelsBDs[$clave]['hotelName'];
                    $meal = $hotelAds[$claveAds]['es'];
                    $arrayMeals[] = $meal;

                    $imagenes = json_decode($hotelsBDs[$clave]['images']);
                    if (is_array($imagenes)) {
                        if (count($imagenes) > 0) {
                            $imagen = $imagenes[0];
                            $imgLink = str_replace('{size}', 'x500', $imagen);
                        }
                    }

                    $filters = json_decode($hotelsBDs[$clave]['serp_filters']);
                    if (is_array($filters)) {
                        $serp_filters = implode(' ', $filters);
                    } else {
                        $serp_filters = '';
                    }

                    $direccion = $hotelsBDs[$clave]['address'];
                    // return 'estrellas'.$hotelsBDs[$clave]['star_rating'];
                    $checkin = $hotelsBDs[$clave]['check_in_time'];
                    $checkout = $hotelsBDs[$clave]['check_out_times'];


                    $stars = $hotelsBDs[$clave]['star_rating'];
                    if ($stars == 0) {
                        $stars = 1;
                    }
                    $kind = $hotelsBDs[$clave]['kind'];
                } else {
                    $hotelName = $idhotel;
                    $direccion = 'Esta propiedad aun no se carga en el sistema';
                    $checkin = '';
                    $checkout = '';
                    $stars = 1;
                    $kind = '';
                    $serp_filters = '';
                }

                $arrayStars[] = $stars;

                if ($sandbox === true) {
                    $link = 'test_hotel_do_not_book';
                    $linkV2T = 'test_hotel_do_not_book';
                } else {
                    $link = $idhotel;
                    $linkV2T = $idhotel;
                }
                $link .= '/' . $checkinDate;
                $link .= '/' . $checkoutDate;
                $link .= '/' . $adultos;
                $link .= '/' . $menoresTxt;
                $link .= '/' . $totalPublico;
                $link .= '/' . $residency;
                $link .= '/' . $markup . '/';
            } else {
                $idhotel = $hotel['id'];
                $arrayError[$conteo] = $idhotel;
            }

            //Creamos array de resultados
            $hotelesArray[$conteo]["stars"]              = $stars;
            $hotelesArray[$conteo]["meal"]               = $meal;
            $hotelesArray[$conteo]["filtroMeal"]         = $this->fn->reemplaza_espacios($meal);
            $hotelesArray[$conteo]["filtroTotalPublico"] = ceil($totalPublico);

            $hotelesArray[$conteo]["idhotel"]            = $idhotel;
            $hotelesArray[$conteo]["hotelName"]          = $hotelName;

            $hotelesArray[$conteo]["imgLink"]            = $imgLink;
            $hotelesArray[$conteo]["link"]               = "hotel/" . $this->fn->stringToUrl($hotelName) . "/" . $link;
            $hotelesArray[$conteo]["direccion"]          = $direccion;
            $hotelesArray[$conteo]["allotment"]          = $allotment;
            $hotelesArray[$conteo]["checkin"]            = $checkin;
            $hotelesArray[$conteo]["checkout"]           = $checkout;
            $hotelesArray[$conteo]["room_name"]          = $room_name;
            $hotelesArray[$conteo]["monedaSeleccionada"] = $monedaSeleccionada;
            $hotelesArray[$conteo]["totalPublico"]       = number_format($totalPublico, 2, '.', ',');

            $hotelesArray[$conteo]["resindency"]         = $residency;
            $hotelesArray[$conteo]["markup"]             = $markup;
            $hotelesArray[$conteo]["menoresTxt"]         = $menoresTxt;
            $hotelesArray[$conteo]["linkV2"]             = "hotel/" . $this->fn->stringToUrl($hotelName) . "/" . $linkV2T;
        }


        $filtrosMeals = array_count_values($arrayMeals);
        arsort($filtrosMeals);

        asort($arrayStars); //Ordena el arreglo de estrellas
        $filtrosStars = array_count_values($arrayStars);

        $conteo = $conteo + 1;
        $hotelesArray[$conteo]["filtros"]["filtrosMeals"] = $filtrosMeals;
        $hotelesArray[$conteo]["filtros"]["filtrosStars"] = $filtrosStars;

        $conteo = $conteo + 1;
        $hotelesArray[$conteo]["hotelesCount"] = $hotelesCount;

        return array_chunk($hotelesArray, 10);
    }
    // pABLO

    //Daniel - new List From Ajax - Correctly
    public function ajaxHotelListaV2(Request $request)
    {
        $moneda        = session('monedaSeleccionada');
        $dataHoteles   = $this->hoteles->buscaHotelesMotorB($request, $moneda, $this->sandBox());

        $hotelLink     = $dataHoteles["form"];
        $nombreDestino = '';
        $checkinDate   = '';
        $checkoutDate  = '';

        $sitioWeb = $this->InfoWebEmpresa();
        $sandbox  = $this->sandBox();

        $idRegion                = $request->destinoHotelero;
        if ($nombreDestino == '') {
            $nombreDestino       = $request->nombreDestinoHotelero;
        }

        if ($checkinDate == '') {
            $checkinDate             = $request->checkin;
        }

        if ($checkoutDate == '') {
            $checkoutDate            = $request->checkout;
        }

        $adultos                 = intval($request->adultos);
        //modificacion
        if ($adultos == 0) {
            $adultos = 2;
        }
        // return $adultos;
        $menoresInput            = $request->menores; //Sirve para contabilizar la cantidad de huespedes
        $menoresTxt              = $menoresInput > 0 ? implode(",", $request->edad) : 'cero';

        $monedaSeleccionada      = session('monedaSeleccionada');
        $residency               = "MX";
        $currency                = $monedaSeleccionada;
        $language                = "es";

        if (isset($request->edad)) {
            foreach ($request->edad as $i => $edad) {
                $menoresarray[$i] = intval($edad);
            }
        } else {
            $menoresarray = [];
        }

        $guests["adults"]        = $adultos;
        $guests["children"]      = $menoresarray;

        $markup                  = $dataHoteles["comision"][0]["comision_hoteleria"];
        $hoteles                 = $dataHoteles["hoteles"]["data"]["hotels"];
        $hotelsBDs               = $dataHoteles["hotelesBD"];
        $hotelAds                = $dataHoteles["hotelAds"];
        $hotelesCount            = count($dataHoteles["hoteles"]["data"]["hotels"]);

        $registro = 1;
        $arrayMeals = [];
        $arrayStars = [];
        $arrayError = [];

        if ($hoteles != null) {
            foreach ($hoteles as $conteo => $hotel) {
                $idhotel = $hotel['id'];
                // return $hotel['rates'];
                if ($hotel['rates'] != null) {
                    if (count($hotel['rates']) > 0) {
                        $price_night = $hotel['rates'][0]['daily_prices'];
                        $room_name = $hotel['rates'][0]['room_name'];
                        $allotment = $hotel['rates'][0]['allotment'];
                        $amenities = $hotel['rates'][0]['amenities_data'];

                        $total = 0;
                        foreach ($price_night as $price) {
                            $total = $total + $price;
                        }

                        $total = $this->fn->tarifaPublicaAgencias($total);
                        $totalPublico = $total / (1 - $markup / 100);

                        $imgLink = 'https://app.bookingtrap.com/storage/app/public/recursos/trabajando.png';
                        $clave = array_search($idhotel, array_column($hotelsBDs, 'idHotel'));
                        $claveAds = array_search($hotel['rates'][0]['meal'], array_column($hotelAds, 'name'));

                        switch ($hotel['rates'][0]['meal']) {
                            case 'breakfast-for-2':
                                $planHospedaje = 'breakfast';
                                break;
                            default:
                                $planHospedaje = $hotel['rates'][0]['meal'];
                        }

                        if ($clave != '') {
                            $hotelName = $hotelsBDs[$clave]['hotelName'];
                            $meal = $hotelAds[$claveAds]['es'];
                            $arrayMeals[] = $meal;

                            $imagenes = json_decode($hotelsBDs[$clave]['images']);
                            if (is_array($imagenes)) {
                                if (count($imagenes) > 0) {
                                    $imagen = $imagenes[0];
                                    $imgLink = str_replace('{size}', 'x500', $imagen);
                                }
                            }

                            $filters = json_decode($hotelsBDs[$clave]['serp_filters']);
                            if (is_array($filters)) {
                                $serp_filters = implode(' ', $filters);
                            } else {
                                $serp_filters = '';
                            }

                            $direccion = $hotelsBDs[$clave]['address'];
                            // return 'estrellas'.$hotelsBDs[$clave]['star_rating'];
                            $checkin = $hotelsBDs[$clave]['check_in_time'];
                            $checkout = $hotelsBDs[$clave]['check_out_times'];


                            $stars = $hotelsBDs[$clave]['star_rating'];
                            if ($stars == 0) {
                                $stars = 1;
                            }
                            $kind = $hotelsBDs[$clave]['kind'];
                        } else {
                            $hotelName = $idhotel;
                            $direccion = 'Esta propiedad aun no se carga en el sistema';
                            $checkin = '';
                            $checkout = '';
                            $stars = 1;
                            $kind = '';
                            $serp_filters = '';
                        }

                        $arrayStars[] = $stars;

                        if ($sandbox === true) {
                            $link = 'test_hotel_do_not_book';
                            $linkV2T = 'test_hotel_do_not_book';
                        } else {
                            $link = $idhotel;
                            $linkV2T = $idhotel;
                        }

                        $link .= '/' . $checkinDate;
                        $link .= '/' . $checkoutDate;
                        $link .= '/' . $adultos;
                        $link .= '/' . $menoresTxt;
                        $link .= '/' . $totalPublico;
                        $link .= '/' . $residency;
                        $link .= '/' . $markup . '/';
                    } else {
                        $idhotel = $hotel['id'];
                        $arrayError[$conteo] = $idhotel;
                    }
                    //Creamos array de resultados
                    $hotelesArray[$conteo]["stars"]              = $stars;
                    $hotelesArray[$conteo]["meal"]               = $meal;
                    $hotelesArray[$conteo]["filtroMeal"]         = $this->fn->reemplaza_espacios($meal);
                    $hotelesArray[$conteo]["filtroTotalPublico"] = ceil($totalPublico);

                    $hotelesArray[$conteo]["idhotel"]            = $idhotel;
                    $hotelesArray[$conteo]["hotelName"]          = $hotelName;

                    $hotelesArray[$conteo]["imgLink"]            = $imgLink;
                    $hotelesArray[$conteo]["link"]               = "hotel/" . $this->fn->stringToUrl($hotelName) . "/" . $link;
                    $hotelesArray[$conteo]["direccion"]          = $direccion;
                    $hotelesArray[$conteo]["allotment"]          = $allotment;
                    $hotelesArray[$conteo]["checkin"]            = $checkin;
                    $hotelesArray[$conteo]["checkout"]           = $checkout;
                    $hotelesArray[$conteo]["room_name"]          = $room_name;
                    $hotelesArray[$conteo]["monedaSeleccionada"] = $monedaSeleccionada;
                    $hotelesArray[$conteo]["totalPublico"]       = number_format($totalPublico, 2, '.', ',');

                    $hotelesArray[$conteo]["resindency"]         = $residency;
                    $hotelesArray[$conteo]["markup"]             = $markup;
                    $hotelesArray[$conteo]["menoresTxt"]         = $menoresTxt;
                    $hotelesArray[$conteo]["linkV2"]             = "hotel/" . $this->fn->stringToUrl($hotelName) . "/" . $linkV2T;
                    $statusBusqueda = true;
                } else {
                    $statusBusqueda = false;
                }
            }
            // return count($hotelesArray);
            if (isset($hotelesArray)) {
                $hotelesCount = count($hotelesArray);
                $statusBusqueda = true;
            } else {
                $hotelesCount = 0;
                $statusBusqueda = false;
                $hotelesArray = [];
            }
            // return $hotelesArray;
            // return count($hotelesArray);
        } else {
            // return redirect()->to('/');
            $hotelesArray = [];
            $statusBusqueda = false;
            // return view("web.hoteles.notSearchHotels", compact('nombreDestino'));
        }

        $filtrosMeals = array_count_values($arrayMeals);
        arsort($filtrosMeals);

        asort($arrayStars); //Ordena el arreglo de estrellas
        $filtrosStars = array_count_values($arrayStars);

        $conteo = $conteo + 1;
        $hotelesArray[$conteo]["filtros"]["filtrosMeals"] = $filtrosMeals;
        $hotelesArray[$conteo]["filtros"]["filtrosStars"] = $filtrosStars;
        $hotelesArray[$conteo]["filtros"]["hotelesCount"] = $hotelesCount;

        // $conteo = $conteo + 1;
        // $hotelesArray[$conteo]["hotelesCount"] = $hotelesCount;

        return array_chunk($hotelesArray, 10);
    }

    //Listado de hoteles por motor - Official - Anterior MotorMain
    public function listaHotelesOld(Request $request)
    {
        $moneda        = session('monedaSeleccionada');
        $destinoHotelero = $request->destinoHotelero;

        if (is_numeric($destinoHotelero)) {
            //Es una region
            $dataHoteles   = $this->hoteles->buscaHotelesMotor($request, $moneda, $this->sandBox());

            if ($dataHoteles->successful()) {
                if ($dataHoteles["hoteles"]["debug"]["validation_error"] !== null) {
                    $error = $dataHoteles["hoteles"]["debug"]["validation_error"];
                    return view("web.hoteles.error", compact('error'));
                } else {
                    $hotelLink     = $dataHoteles["form"];
                    $nombreDestino = '';
                    $checkinDate   = '';
                    $checkoutDate  = '';
                    return $this->datosHotelLista($request, $dataHoteles, $hotelLink, $nombreDestino, $checkinDate, $checkoutDate, $destinoHotelero);
                    // return $this->listaHotelesV2($request);
                }
            } else {
                $error = $dataHoteles["message"];
                return view("web.hoteles.error", compact('error'));
            }
        } else {
            //Es un hotel
            $sitioWeb  = json_decode($this->InfoWebEmpresa());
            $residency = "MX";

            if ($request->menores > 0) {
                $menores = implode(",", $request->edad);
            } else {
                //Motor->HotelUnico->Directo
                $menores = 'cero';
            }

            $link = 'hotel/' . $this->fn->stringToUrl($request->nombreDestinoHotelero);
            $link .= "/" . $destinoHotelero;
            $link .= "/" . $request->checkin;
            $link .= "/" . $request->checkout;
            $link .= "/" . $request->adultos;
            $link .= "/" . $menores;
            $link .= "/0";
            $link .= "/" . $residency;
            $link .= "/" . $sitioWeb[0]->comision_hoteleria;
            return redirect()->to($link);
        }
    }
}
