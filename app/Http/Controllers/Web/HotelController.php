<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\ApiController;
use Illuminate\Support\Facades\Cache;

class HotelController extends Controller
{

    public $api;
    public $token;
    public $fn;

    public function __construct()
    {
        $this->api     = new  ApiController();
        $this->token   = $this->api->token();
        $this->fn      = new FnController();
    }

    public function destinosHotelerosFavoritos()
    {
        if(Cache::has("destinosHoteleros")) {
            return Cache::get('destinosHoteleros');
        } else {
            $response = Http::withToken($this->token)
                ->withHeaders([
                    'realip'  => $_SERVER['REMOTE_ADDR'],
                    'dominio' => $_SERVER['SERVER_NAME']
                ])
                ->get('https://app.bookingtrap.com/api/getHomeHotels')->json();
            
            Cache::put('destinosHoteleros', $response);
            return $response;
        }
    }

    public function buscaHotel(Request $request)
    {
        $form["search"] = $request->search;
        $endpoint = 'https://app.bookingtrap.com/api/keywordDestinationSearch';

        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->get($endpoint, [
                'search'    => $request->search
            ]);

        $responseArray = json_decode($response);
        $lista = $responseArray->results;

        foreach ($lista as $i => $registro) {
            $text = $registro->text;

            if ($text != 'Hoteles' || $text != 'Regiones') {
                if (property_exists($registro, 'id')) {
                    $formList[$i]["id"] = $registro->id;
                    if (is_numeric($registro->id)) {
                        $formList[$i]["icono"] = 'fa-map-marker-alt';
                    } else {
                        $formList[$i]["icono"] = 'fa-hotel';
                    }
                } else {
                    $formList[$i]["icono"] = '';
                }

                $formList[$i]["text"] = $text;
            }
        }

        $results["results"] = $formList;
        echo json_encode($results);
    }

    public function hotelesRegion($idRegion, $monedaSeleccionada, $sandbox, $checkinDate, $checkoutDate)
    {
        $endpoint = 'https://app.bookingtrap.com/api/v2/hotelesRegion';

        $idRegion           = $idRegion;
        $adultos            = 2;
        $menoresInput       = intval(0);
        $menoresTxt         = 'cero';
        $paxs               = [];
        $menoresarray       = [];

        $residency          = "MX";
        $currency           = $monedaSeleccionada;
        $language           = 'es';

        $guests["adults"]        = intval($adultos);
        $guests["children"]      = $menoresarray;
        $menoresTxt              = '0';

        $paxs[0] = $guests;

        $response = Http::asForm()
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withToken($this->token)
            ->get($endpoint, [
                "region_id"   => intval($idRegion),
                "checkin"     => $checkinDate,
                "checkout"    => $checkoutDate,
                "currency"    => $currency,
                "adultos"     => $adultos,
                "residency"   => $residency,
                "language"    => $language,
                "guests"      => $paxs,
                "menores"     => 0,
                "sandbox"     => $sandbox
            ]);

        return $response;
    }

    public function buscaHotelesMotor(Request $request, $monedaSeleccionada, $sandbox)
    {
        $endpoint = 'https://app.bookingtrap.com/api/v2/hotelesRegion';

        $idRegion           = $request->destinoHotelero;
        $adultos            = $request->adultos;
        $menoresInput       = intval($request->menores);
        $menoresTxt         = $menoresInput > 0 ? implode(",", $request->edad) : 'cero';
        $paxs               = [];
        $menoresarray       = [];

        if ($menoresInput > 0) {
            foreach ($request->edad as $i => $edad) {
                if ($edad != '') {
                    $menoresarray[$i] = intval($edad);
                }
            }
        }

        $checkinDate        = $request->checkin;
        $checkoutDate       = $request->checkout;

        $residency          = "MX";
        $currency           = $monedaSeleccionada;
        $language           = 'es';

        $guests["adults"]        = intval($adultos);
        $guests["children"]      = $menoresarray;
        $menoresTxt              = 'cero';

        $paxs[0] = $guests;

        $response = Http::asForm()
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withToken($this->token)
            ->get($endpoint, [
                "region_id"   => intval($idRegion),
                "checkin"     => $checkinDate,
                "checkout"    => $checkoutDate,
                "currency"    => $currency,
                "adultos"     => $adultos,
                "residency"   => $residency,
                "language"    => $language,
                "guests"      => $paxs,
                "menores"     => $request["menores"],
                "sandbox"     => $sandbox
            ]);

        return $response;
    }

    public function habitaciones($data)
    {
        $endpoint = 'https://app.bookingtrap.com/api/getHotel';
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->get($endpoint, [
                'id'        => $data["id"],
                'checkin'   => $data["checkin"],
                'checkout'  => $data["checkout"],
                'adults'    => $data["adults"],
                'menores'   => $data["menores"],
                'residency' => $data["residency"],
                'currency' => $data["currency"],
            ]);

        return $response;
    }

    public function formularioHotel($data)
    {
        $endpoint = 'https://app.bookingtrap.com/api/v2/hoteles/formulario';
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->get($endpoint, [
                'hash'      => $data["hash"],
                'id'        => $data["id"],
                'checkout'  => $data["checkout"],
                'checkin'   => $data["checkin"],
                'adults'    => $data["adults"],
                'menores'   => $data["menores"],
                'fx'        => $data["fx"],
                'room'      => $data["room"],
                'pr'        => $data["pr"],
                'meal'      => $data["meal"],
                'cur'       => $data["cur"],
                'hotbd'     => $data["hotbd"],
                'residency' => $data["residency"],
                'lan'       => $data["lan"],
                'hotelName' => $data["hotelName"],
                'foto'      => $data["foto"],
                'marte'     => $data["marte"],
            ]);

        return $response;
    }

    public function obtenerHotelesPorRegion($data)
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($data), 'application/json')
            ->get('https://app.bookingtrap.com/api/getHotelByRegion');
        return $response;
    }

    public function agregarReservacion($data)
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($data), 'application/json')
            ->post('https://app.bookingtrap.com/api/saveReservation');
        return $response;
    }

    public function requestReservation($data)
    {
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($data), 'application/json')
            ->post('https://app.bookingtrap.com/api/requestHotelReservation');
        return $response;
    }

    public function buscaHotelesMotorB(Request $request, $monedaSeleccionada, $sandbox)
    {
        $endpoint = 'https://app.bookingtrap.com/api/v2/hotelesRegion';

        $data = json_decode($request->data);

        $idRegion           = $data->destinoHotelero;
        $adultos            = $data->adultos;
        $menoresInput       = intval($data->menores);
        // $menoresTxt         = $menoresInput > 0 ? implode(",", $data->edad) : 'cero';
        $paxs               = [];
        $menoresarray       = [];

        if ($menoresInput > 0) {
            foreach ($data->edad as $i => $edad) {
                if ($edad != '') {
                    $menoresarray[$i] = intval($edad);
                }
            }
        }

        $checkinDate        = $data->checkin;
        $checkoutDate       = $data->checkout;

        $residency          = "MX";
        $currency           = $monedaSeleccionada;
        $language           = 'es';

        $guests["adults"]        = intval($adultos);
        $guests["children"]      = $menoresarray;
        $menoresTxt              = 'cero';

        $paxs[0] = $guests;

        $response = Http::asForm()
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withToken($this->token)
            ->get($endpoint, [
                "region_id"   => intval($idRegion),
                "checkin"     => $checkinDate,
                "checkout"    => $checkoutDate,
                "currency"    => $currency,
                "adultos"     => $adultos,
                "residency"   => $residency,
                "language"    => $language,
                "guests"      => $paxs,
                "menores"     => $data->menores,
                "sandbox"     => $sandbox
            ]);

        return $response;
    }

    public function buscaHotelesMotorSEO($request, $monedaSeleccionada, $sandbox)
    {
        $endpoint = 'https://app.bookingtrap.com/api/v2/hotelesRegion';

        $data = $request;

        $idRegion           = $data->destinoHotelero;
        $adultos            = $data->adultos;
        $menoresInput       = intval($data->menores);
        // $menoresTxt         = $menoresInput > 0 ? implode(",", $data->edad) : 'cero';
        $paxs               = [];
        $menoresarray       = [];

        if ($menoresInput > 0) {
            foreach ($data->edad as $i => $edad) {
                if ($edad != '') {
                    $menoresarray[$i] = intval($edad);
                }
            }
        }

        $checkinDate        = $data->checkin;
        $checkoutDate       = $data->checkout;

        $residency          = "MX";
        $currency           = $monedaSeleccionada;
        $language           = 'es';

        $guests["adults"]        = intval($adultos);
        $guests["children"]      = $menoresarray;
        $menoresTxt              = 'cero';

        $paxs[0] = $guests;

        $response = Http::asForm()
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withToken($this->token)
            ->get($endpoint, [
                "region_id"   => intval($idRegion),
                "checkin"     => $checkinDate,
                "checkout"    => $checkoutDate,
                "currency"    => $currency,
                "adultos"     => $adultos,
                "residency"   => $residency,
                "language"    => $language,
                "guests"      => $paxs,
                "menores"     => $data->menores,
                "sandbox"     => $sandbox
            ]);

        return $response;
    }
    
    // Paypal solicitud de transaccion
    public function requestTransaction($data){
        $response = Http::withToken($this->token)
            ->withHeaders([
                'realip'  => $_SERVER['REMOTE_ADDR'],
                'dominio' => $_SERVER['SERVER_NAME']
            ])
            ->withBody(json_encode($data), 'application/json')
            ->get('https://app.bookingtrap.com/api/v2/hoteles/getReservacion');

        return $response;
    }
}
