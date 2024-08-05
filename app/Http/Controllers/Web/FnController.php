<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FnController extends Controller
{
    public function tarifaPublicaAgencias($tarifa){
        $sitioWeb = session('sitioWeb');
        $comiHot  = $sitioWeb["0"]["comiHot"];

        $precio = $tarifa / $comiHot;
        return $precio;
    }    

    public function tarifaNetaAgenciasTours($tarifa){
        //Precio que bookingtrap le da a las agencias
        $sitioWeb = session('sitioWeb');
        $comiCiv  = $sitioWeb["0"]["comiCiv"];
        
        
        $precio = $tarifa / $comiCiv;
        return $precio;
    }     

    public function tarifaPublicaAgenciasTours($tarifa, $markup){
        //Tarifa que le dara la agencia al cliente final
        $tarifaAgencia = $this->tarifaNetaAgenciasTours($tarifa);
        $precio = $tarifaAgencia / (1- ($markup/100) );
        return number_format($precio, 2, '.', ',');
    }

    public function precioMinimoLista($precios){
        $temporal1 = array_map('intval', $precios);
        $temporal2 = array_diff($temporal1, array(0));
        $arrayFinal = empty($temporal2) ? $temporal1 : $temporal2;
        return min($arrayFinal);
    }

    public function tarifaPublicaAgenciasToursSinFormato($tarifa, $markup){
        //Tarifa que le dara la agencia al cliente final
        $tarifaAgencia = $this->tarifaNetaAgenciasTours($tarifa);
        $precio = $tarifaAgencia / (1- ($markup/100) );
        return number_format($precio, 2, '.', '');
    }    

    public function precioMinimo($precios){
        $sgl = min(array_column($precios, 'adulto_sencilla'));
        $dbl = min(array_column($precios, 'adulto_doble'));
        $tpl = min(array_column($precios, 'adulto_triple'));
        $cpl = min(array_column($precios, 'adulto_cuadruple'));

        if($sgl > 0){
            $form["sgl"] = $sgl;
        }else{
            $form["sgl"] = 99999999999;
        }

        if($dbl > 0){
            $form["dbl"] = $dbl;
        }else{
            $form["dbl"] = 99999999998;
        }
        
        if($tpl > 0){
            $form["tpl"] = $tpl;
        }else{
            $form["tpl"] = 99999999997;
        }
        
        if($cpl > 0){
            $form["cpl"] = $cpl;
        }else{
            $form["cpl"] = 99999999996;
        }      

        $minimo = min($form);        
        
        return $minimo;
    }

    public function check_in_range($fecha_inicio, $fecha_fin, $fecha)
    {
        $fecha_inicio = strtotime($fecha_inicio);
        $fecha_fin = strtotime($fecha_fin);
        $fecha = strtotime($fecha);

        if (($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin)) {
            // echo "Fi: ".$fecha_inicio." Ff: ".$fecha_fin." Fe: ".$fecha." y si esta"; 
            return 1;
        } else {
            // echo "Fi: ".$fecha_inicio." Ff: ".$fecha_fin." Fe: ".$fecha." y no esta"; 
            return 0;
        }
    }     

    //Sirve para los TOURS PROPIOS
    public function precio($precioBase, $monedaPrecio, $monedaSeleccionada, $monedaDefault, $monedasJson){
        $monedasData = json_decode($monedasJson);
        
        // if(is_object($monedasJson)){
        //     // Respuesta de la API
        //     return "ES un objeto";
        //     $monedasData = $monedasJson;            
        // }else{
        //     //Es una sesion}
        //     return "No es un objeto";
        //     $monedasData =  json_decode($monedasJson);
        // }
        
        foreach($monedasData->data as $i => $moneda){
            $monedas["data"][$i]["id"]     = $moneda->id;
            $monedas["data"][$i]["nombre"] = $moneda->nombre;
            $monedas["data"][$i]["iso"]    = $moneda->iso;
            $monedas["data"][$i]["tipo_cambio"]    = $moneda->tipo_cambio;
        }

        if($monedaPrecio == $monedaSeleccionada){
            $precioReal = $precioBase;
        }else{
            //Obtiene el tipo de cambio de la moneda del tour respecto al precio base
            $keyPrecio        = array_search($monedaPrecio, array_column($monedas["data"], 'iso')); 
            $tipoCambioPrecio = $monedas["data"][$keyPrecio]["tipo_cambio"]; 
            $precioReal = $precioBase * $tipoCambioPrecio;

            if($monedaPrecio == $monedaDefault){
                $keyPrecio        = array_search($monedaSeleccionada, array_column($monedas["data"], 'iso')); 
                $tipoCambioPrecio = $monedas["data"][$keyPrecio]["tipo_cambio"];    

                $precioReal = $precioBase / $tipoCambioPrecio;
            }

            if($monedaPrecio != $monedaDefault){
                //Convertimos el precio a la moneda default
                $keyPrecio        = array_search($monedaPrecio, array_column($monedas["data"], 'iso')); 
                $tipoCambioPrecio = $monedas["data"][$keyPrecio]["tipo_cambio"];  
                $precioMonedaDefault = $precioBase * $tipoCambioPrecio;

                $keyPrecioMonedaSeleccionada        = array_search($monedaSeleccionada, array_column($monedas["data"], 'iso')); 
                $tipoCambioPrecioMonedaSeleccionada = $monedas["data"][$keyPrecioMonedaSeleccionada]["tipo_cambio"];   
                
                $precioReal = $precioMonedaDefault / $tipoCambioPrecioMonedaSeleccionada;
            }
        }

        $form["preciosimple"]  = number_format($precioReal, 2, '.', '');
        $form["precioformato"] = number_format($precioReal, 2, '.', ',');
        $form["iso"]           = $monedaSeleccionada;
        
        return $form;
    }

    public function stringToUrl($string)
    {
        //Rememplazamos caracteres especiales latinos 
        $stringlower = mb_strtolower($string);
        $findA = array('-');
        $replA = array('');
        $cadena = str_replace($findA, $replA, $stringlower);

        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ', ' ', "+", ":", "(", ")", ",");
        $repl = array('a', 'e', 'i', 'o', 'u', 'n', '-', '', '', '', '', '');
        $cadena = str_replace($find, $repl, $cadena);

        $patterns[0] = '/--/';
        $replacements[0] = '-';
        $cadena = preg_replace($patterns, $replacements, $cadena);

        return $this->minusculas($cadena);
    }

    public function reemplaza_espacios($string){
        $string         = $this->minusculas($string);
        $searchString   = " ";
        $replaceString  = "-";         
        $outputString   = str_replace($searchString, $replaceString, $string);         

        return $outputString;
    }    

    public function removeCorchetes($string){
        $caracteres = array("[", "]");
        $resultado = str_replace($caracteres, "", $string);  
        return $resultado;      
    }

    public function removeGuiones($string){
        $string         = $this->minusculas($string);
        $searchString   = "-";
        $replaceString  = " ";         
        $outputString   = str_replace($searchString, $replaceString, $string);         

        return $outputString;       
    }

    public function removeTime($string, $buscar){
        $resultado = str_replace($buscar, "", $string);
        return $resultado;      
    }
    
    public function removeGuionBajo($string){

        $searchString   = "_";
        $replaceString  = " ";         
        $outputString   = str_replace($searchString, $replaceString, $string);         

        return $outputString;
    }

    public function minusculas($cadena)
    {
        $res = mb_strtolower($cadena);
        return $res;
    }

    public function letraCapital($string){
        $string = $this->minusculas($string);
        $string = ucfirst($string);
        return $string;
    }
    
    public function letrasCapitales($string){
        $string = $this->minusculas($string);
        $string = ucwords($string);
        return $string;
    }    

    public function baseMeta()
    {
        $url = $_SERVER['HTTP_HOST'];
        $path = $url == 'localhost' ? 'http://localhost/detinmarin-1/' : 'https://detinmarintravel.com';

        return $path;
    }

    public function moneda($numero)
    {
        return number_format($numero, 2, ".", ",");
    }

    public function fechaAbreviada($fecha){
        //YYYY-MM-DD
        $fechas = explode('-', $fecha);
        $y = $fechas[0];
        $m = $fechas[1];
        $d = $fechas[2];

        $mes = $this->fnMes($m);
        return $d."/".$mes["abre"]."/".$y;
    }

    private function fnMes($mes)
    {
        $month = [];
        switch ($mes) {
            case "01":
                $month["abre"] = 'Ene';
                $month["comp"] = 'Enero';
                break;
            case "02":
                $month["abre"] = 'Feb';
                $month["comp"] = 'Febrero';
                break;
            case "03":
                $month["abre"] = 'Mar';
                $month["comp"] = 'Marzo';
                break;
            case "04":
                $month["abre"] = 'Abr';
                $month["comp"] = 'Abril';
                break;
            case "05":
                $month["abre"] = 'May';
                $month["comp"] = 'Mayo';
                break;
            case "06":
                $month["abre"] = 'Junio';
                $month["comp"] = 'Julio';
                break;
            case "07":
                $month["abre"] = 'Jul';
                $month["comp"] = 'Julio';
                break;
            case "08":
                $month["abre"] = 'Ago';
                $month["comp"] = 'Agosto';
                break;
            case "09":
                $month["abre"] = 'Sep';
                $month["comp"] = 'Septiembre';
                break;
            case "10":
                $month["abre"] = 'Oct';
                $month["comp"] = 'Octubre';
                break;
            case "11":
                $month["abre"] = 'Nov';
                $month["comp"] = 'Noviembre';
                break;
            case "12":
                $month["abre"] = 'Dic';
                $month["comp"] = 'Diciembre';
                break;
        }
        return $month;
    }

    public function recortar_cadena($texto, $limite=100){
        $texto = trim($texto);
        $texto = strip_tags($texto);
        $tamano = strlen($texto);
        $resultado = '';
        if($tamano <= $limite){
          return $texto;
        }else{
        $texto = substr($texto, 0, $limite);
        $palabras = explode(' ', $texto);
        $resultado = implode(' ', $palabras);
        $resultado .= '...';
      }
        return $resultado;
      }  

      public function datePickerFormat($fecha){
        //Convierte yyyy-mm-dd a mm-dd-yy
        $array = explode("-", $fecha);
        $dia   = $array[2];
        $mes   = $array[1];
        $year  = $array[0];        
        $nuevo = $mes."-".$dia."-".$year;

        return $nuevo;

    }
    
    public function recortar_cadena_title($texto, $limite=100){        
        $texto = trim($texto);
        $texto = strip_tags($texto);
        $tamano = strlen($texto);
        $resultado = '';
        if($tamano <= $limite){
          return $texto;
        }else{
        $texto = substr($texto, 0, $limite);
        $palabras = explode(' ', $texto);
        $resultado = implode(' ', $palabras);
        $resultado .= '...';
      }
        return $resultado;
    }
    
    public function restaFechas($fecha, $dias){
        $date_now = $fecha;
        $date_past = strtotime('-'.$dias.' day', strtotime($date_now));
        $date_past = date('Y-m-d', $date_past);
        return $date_past;
    }

    public function sumaFechas($fecha, $dias){
        $date_now = $fecha;
        $date_past = strtotime('+'.$dias.' day', strtotime($date_now));
        $date_past = date('Y-m-d', $date_past);
        return $date_past;
    }   
    
    public function fechaYearOut($fecha){
        //YYYY-MM-DD
        $fechas = explode('-', $fecha);
        $y = $fechas[0];
        $m = $fechas[1];
        $d = $fechas[2];

        $mes = $this->fnMes($m);
        return $d."/".$mes["comp"];        
    }  

    public function codificaUrl($cadena){
        $cadena = mb_convert_encoding($cadena, 'UTF-8');
        $cadena = base64_encode($cadena);
        return $cadena;        
    }

    public function decodificaUrl($cadena){
        $cadena = base64_decode($cadena);
        $cadena_get = explode("&",$cadena);
        foreach($cadena_get as $value)
          {
            $val_gets = explode("=",$value); 
            // $_GET[$val_gets[0]]=mb_convert_encoding($val_gets[1], 'ISO-8859-1');
            $_GET[$val_gets[0]]=$val_gets[1];
          } 

        return $_GET;

    }

    function eliminar_acentos($cadena)
    {

        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
        );

        return $cadena;
    }

    function conteo_experiencias($longitud, $conteoExperiencia, $experiencias, $filtro)
    {
        $conteo = [$longitud];
        foreach ($conteoExperiencia as $i => $nombreFiltro) {
            $conteo[$i] = 0;
            foreach ($experiencias as $j => $experiencia) {
                if (array_key_exists($filtro, $experiencia)) {
                    $arreglo = explode(",",$experiencia[$filtro]);
                    if (is_array($arreglo)) {
                        foreach ($arreglo as $nombre) {
                                if ($nombre == $nombreFiltro) {
                                    $conteo[$i]++;
                                }
                        }
                    }
                    else {
                        if ($experiencia[$filtro] == $nombreFiltro) {
                            $conteo[$i]++;
                        }
                    }
                }
            }
        }
        return $conteo;
    }

    public function ordena_objetos ( $array_de_objetos, $propiedad_a_considerar, $orden_ascendente=TRUE ) {
        $a_ordenar  = array();
        $resultado  = array();

        foreach ($array_de_objetos as $i => $objeto) {
            $a_ordenar[$i] = $objeto[$propiedad_a_considerar];
        }

        asort($a_ordenar);
    
        foreach ($a_ordenar as $i => $valor) {
            $resultado[] = $array_de_objetos[$i];
        }

        return ($orden_ascendente) ? $resultado : array_reverse($resultado);
    }
    
    public function capitalizeCadena($texto) {
        $cadena         = $texto;
        $minusculas     = mb_strtolower($cadena);
        $capitalized    = ucfirst($minusculas);
        return $capitalized;
    }
}
