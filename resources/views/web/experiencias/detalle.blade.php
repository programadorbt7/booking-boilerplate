@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp

@extends('layouts.master')

@section('metaSEO')
    <title>{{ $tour['paquete'][0]['nombre'] }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="{{ $tour['paquete'][0]['descripcion_sitio'] }}">
    <meta name="keywords" content="{{ $tour['paquete'][0]['keywords_sitio'] }}">
@endsection

@section('contenido-principal')
    <section class="tour-listing-details tour-listing-details-right">
        {{-- GALERIA --}}
        <div class="tour-listing-details__top-carousel">
            <div class="tour-listing-details__top-carousel-wrapper trevlo-owl__carousel owl-theme owl-carousel">
                @foreach ($tour['imagenes'] as $i => $imagen)
                    <a aria-label="Imagen" data-fancybox="gallery" href="{{ $imagen['imagen'] }}">
                        <div class="tour-listing-details__top-carousel-item item">
                            <div class="tour-listing-details__top-carousel-image">
                                <img src="{{ $imagen['imagen'] }}" alt="Imagen de {{ $tour['paquete'][0]['nombre'] }}"
                                    style="height: 400px; object-fit: cover;">
                                <div class="tour-listing-details__top-carousel-overlay">
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        {{-- GENERAL --}}
        <div class="tour-listing-details__destination">
            <div class="container">
                <div class="tour-listing-details__destination-row row">
                    {{-- TITLE & PRICE --}}
                    <div class="col-xl-4 wow animated fadeInLeft" data-wow-delay="0.1s" data-wow-duration="1500ms">
                        <div class="tour-listing-details__destination-left">
                            <h3 class="tour-listing-details__dastination-title">{{ $tour['paquete'][0]['nombre'] }}</h3>
                            <h4 class="tour-listing-details__dastination-price">
                                <span>$ {{ $precioMinimo['precioformato'] }} {{ $precioMinimo['iso'] }}</span>
                                <span class="tour-listing-details__dastination-person">/ Por persona</span>
                            </h4>
                        </div>
                    </div>
                    {{-- INFO GENERAL --}}
                    <div class="col-xl-8">
                        <div class="tour-listing-details__destination-right">
                            {{-- DURACION --}}
                            <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1500ms">
                                <span class="icon-clock-1"></span>
                                <div class="tour-listing-details__destination-info-title">
                                    <h4 class="tour-listing-details__destination-info-top">Duración</h4>
                                    <h4 class="tour-listing-details__destination-info-bottom">
                                        {{ $tour['paquete'][0]['cantidad_dias'] > 1 ? $tour['paquete'][0]['cantidad_dias'] . ($tipoDuracion == 0 ? ' días' : ' horas') : $tour['paquete'][0]['cantidad_dias'] . ($tipoDuracion == 0 ? ' día' : ' hora') }}
                                    </h4>
                                </div>
                            </div>
                            {{-- CATEGORIA --}}
                            <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.3s"
                                data-wow-duration="1500ms">
                                <span class="icon-hiking-4"></span>
                                <div class="tour-listing-details__destination-info-title">
                                    <h4 class="tour-listing-details__destination-info-top">Categoría</h4>
                                    <h4 class="tour-listing-details__destination-info-bottom">
                                        {{ $tour['paquete'][0]['tipoexcursion'] }}
                                    </h4>
                                </div>
                            </div>
                            {{-- CALIFICACION --}}
                            <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.7s"
                                data-wow-duration="1500ms">
                                <span class="icon-star"></span>
                                <div class="tour-listing-details__destination-info-title">
                                    <h4 class="tour-listing-details__destination-info-top">Ubicación</h4>
                                    <h4 class="tour-listing-details__destination-info-bottom">
                                        {{ $tour['paquete'][0]['ciudad_comercial'] . ', ' . $tour['paquete'][0]['estado_comercial'] }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- MAIN --}}
        <div class="container mt-5">
            {{-- DETALLE TOUR --}}
            <div class="tour-listing-details__row row">
                <div class="col-xl-8">
                    {{-- BTN RESERVA --}}
                    <div class="row justify-content-center mb-5 btn-reserva">
                        <div class="col-md-3 col-sm-6">
                            <a href="#form-reserva" class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base">
                                <span>
                                    Reservar Ahora
                                </span>
                            </a>
                        </div>
                    </div>
                    {{-- DESCRIPCION --}}
                    <div class="tour-listing-details__overview">
                        <div class="wow animated fadeIn" data-wow-delay="0.1s" data-wow-duration="1500ms">
                            <h3 class="tour-listing-details__title tour-listing-details__overview-title">Acerca de</h3>
                        </div>
                        <p class="tour-listing-details__overview-text wow animated fadeInUp" data-wow-delay="0.1s"
                            data-wow-duration="1500ms">
                            {!! $tour['paquete'][0]['descripcion'] !!}
                        </p>
                    </div>
                    <hr>
                    {{-- INCLUYE, NO INCLUYE, RECOMENDACIONES --}}
                    <div class="tour-listing-details__reviews">
                        <div class="destination-details__overview">
                            <h3 class="destination-details__overview-title destination-details__title">Consideraciones</h3>
                            <ul class="destination-details__overview-content wow animated fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1500ms">
                                <li>
                                    <p>Incluye</p>
                                    <p>
                                        @foreach ($tour['incluye'] as $incluye)
                                            <i aria-hidden="true" class="fas fa-check-circle text-success"></i>
                                            {{ $incluye['nombre'] }}
                                            <br>
                                        @endforeach
                                    </p>
                                </li>
                                @if ($tour['noincluye'] != null)
                                    <li>
                                        <p>No Incluye</p>
                                        <p>
                                            @foreach ($tour['noincluye'] as $noincluye)
                                                <i aria-hidden="true" class="fas fa-times text-danger"></i>
                                                {{ $noincluye['nombre'] }}
                                                <br>
                                            @endforeach
                                        </p>
                                    </li>
                                @endif
                                @if ($recomendacionesTour != null)
                                    <li>
                                        <p>Recomendaciones</p>
                                        <p>
                                            @foreach ($recomendacionesTour as $recomendacion)
                                                <i aria-hidden="true" class="fa-regular fa-lightbulb text-warning"></i>
                                                {{ $recomendacion['nombre'] }}
                                                <br>
                                            @endforeach
                                        </p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    {{-- VIDEO --}}
                    @if ($youtube != '')
                        <hr>
                        <div class="tour-listing-details__reviews">
                            <h3 class="tour-listing-details__reviews-title tour-listing-details__title">
                                Video
                            </h3>
                            <div class="tour-listing-details__reviews-comment">
                                <iframe class="video-exp" src="{{ $youtube }}" allow="accelerometer; autoplay;"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                    <hr>
                    {{-- ITINERARIO --}}
                    <div class="tour-listing-details__plan">
                        <h3 class="tour-listing-details__title tour-listing-details__plan-title">Itinerario</h3>
                        <div class="trevlo-accrodion tour-listing-details__faq" data-grp-name="tour-listing-details__faq">
                            @foreach ($tour['itinerarios'] as $itinerario)
                                <div class="accrodion {{ $i == 0 ? 'active' : '' }} wow animated fadeInUp"
                                    data-wow-delay="0.1s" data-wow-duration="1500ms">
                                    <div class="accrodion-title">
                                        <h4><span>Día :</span>{{ $itinerario['dia'] }}</h4>
                                    </div>
                                    <div class="accrodion-content {{ $i > 0 ? 'oculto' : '' }}">
                                        <div class="inner">
                                            <ul style="list-style: none;">{!! $itinerario['contenido'] !!}</ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                </div>
                {{-- FORM --}}
                <div id="form-reserva" class="col-xl-4">
                    <aside class="tour-listing-details__sidebar">
                        {{-- PDF --}}
                        @if ($itinerario_es != null)
                            <div class="tour-listing-details__sidebar-post-box tour-listing-details__sidebar-single wow animated fadeInUp"
                                data-wow-delay="0.1s" data-wow-duration="1500ms">
                                <div class="faq-page__contact">
                                    <div class="faq-page__contact-icon">
                                        <a aria-label="Itinerario"
                                            href="https://app.bookingtrap.com/public/storage/{{ $itinerario_es }}"
                                            target="_blank">
                                            <img src="{{ asset('assets/images/pdf.webp') }}" alt="PDF Itinerario"
                                                style="height: 100px; width: 100px;"></a>
                                    </div>
                                    <h3 class="faq-page__contact-title">Más Información</h3>
                                </div>
                            </div>
                        @endif
                        {{-- FORM --}}
                        <div class="tour-listing-details__sidebar-book-tours tour-listing-details__sidebar-single wow animated fadeInUp"
                            data-wow-delay="0.1s" data-wow-duration="1500ms">
                            <h3 class="tour-listing-details__sidebar-title">Haz tu Reserva!</h3>
                            <form method="post" class="fields" action="{{ route('datos-compra') }}" id="check_avail"
                                autocomplete="off">

                                @csrf
                                <input type="hidden" id="mindate_experiencia" name="mindate_experiencia"
                                    value="{{ $release }}">
                                <input type="hidden" name="pais_comercial"
                                    value="{{ $tour['paquete'][0]['pais_comercial'] ?? '' }}">
                                <input type="hidden" name="imagen" value="{{ $imagenUnica }}">
                                <input type="hidden" name="idtour" value="{{ $tour['paquete'][0]['id'] }}">
                                <input type="hidden" name="nombretour" value="{{ $tour['paquete'][0]['nombre'] }}">
                                <input type="hidden" name="fechaviaje" id="fechaviaje">
                                <input type="hidden" id="tipo_reserva_hotelera" name="tipo_reserva_hotelera"
                                    value="{{ $tour['paquete'][0]['tipo_reserva_hotelera'] }}">
                                <input type="hidden" name="tipo_costo" id="tipo_costo" value="{{ $tipo_costo }}">
                                <input type="hidden" name="cant_pax_max" id="cant_pax_max"
                                    value="{{ $cant_pax_max }}">
                                <input type="hidden" name="cant_pax_min" id="cant_pax_min"
                                    value="{{ $cant_pax_min }}">
                                <input type="hidden" name="cadultos" id="cadultos">
                                <input type="hidden" name="cmenores" id="cmenores">
                                <input type="hidden" name="cinfantes" id="cinfantes">
                                <input type="hidden" name="padulto" id="padulto">
                                <input type="hidden" name="pmenor" id="pmenor">
                                <input type="hidden" name="pinfante" id="pinfante">
                                <input type="hidden" name="gtotal" id="gtotal">
                                <input type="hidden" name="gtotalPromo" id="gtotalPromo">
                                <input type="hidden" name="hoteleria" value="{{ $tour['paquete'][0]['hoteleria'] }}"
                                    id="hoteleria">
                                <input type="hidden" name="id_temporada" id="id_temporada">
                                <input type="hidden" name="nombre_temporada" id="nombre_temporada">
                                <input type="hidden" name="id_clase_servicio" id="id_clase_servicio">
                                <input type="hidden" name="nombre_servicio" id="nombre_servicio">
                                <input type="hidden" name="fecha_inicio" id="fecha_inicio">
                                <input type="hidden" name="fecha_fin" id="fecha_fin">
                                <input type="hidden" name="id_paquete_fecha" id="id_paquete_fecha">
                                <input type="hidden" name="id_temporada_costo" id="id_temporada_costo">
                                <input type="hidden" name="tipo_descuento_frm" id="tipo_descuento_frm">
                                <input type="hidden" name="valor_promocion_frm"id="valor_promocion_frm">
                                <input type="hidden" name="descuento_frm" id="descuento_frm">
                                <input type="hidden" name="idpromo_frm" id="idpromo_frm">
                                <input type="hidden" name="idexpromo_frm" id="idexpromo_frm">
                                <input type="hidden" name="aplicapromo" id="aplicapromo">
                                <input type="hidden" name="tipohabitacion" id="tipohabitacion">
                                <input type="hidden" name="tour_name" id="tour_name" value="">

                                <input type="hidden" id="aceptaInfantes" value="{{ $tour['paquete'][0]['infantes'] }}">
                                <input type="hidden" id="aceptaMenores" value="{{ $tour['paquete'][0]['menores'] }}">

                                <input type="hidden" id="acepta_extras" value="{{ $acepta_extras }}">
                                <input type="hidden" id="tipo_ind_comb" value="{{ $tipo_ind_comb }}">
                                <input type="hidden" id="pax_max_extra" value="{{ $pax_max_extra }}">
                                <input type="hidden" id="nombre_promo" value="{{ $nombre_promo }}">

                                <input type="hidden" name="tipoCambio" id="tipoCambio" value="{{ $tipoCambio }}">
                                <input type="hidden" name="cambioMoneda" id="cambioMoneda" value="{{ $cambioMoneda }}">
                                <input type="hidden" name="procesoPago" id="procesoPago" value="{{ $procesoPago }}">
                                <input type="hidden" name="anticipo" id="anticipo" value="{{ $anticipo }}">
                                <input type="hidden" name="tipoValor" id="tipoValor" value="{{ $tipo_valor }}">

                                <div class="form-group">
                                    @if (
                                        $tour['paquete'][0]['calendario'] == 1 ||
                                            ($tour['paquete'][0]['calendario'] == 0 && $tour['paquete'][0]['hoteleria'] == 1))
                                        @php
                                            $fechas = $tour['fechas'];
                                            $cpromos = count($tour['promociones']);
                                            if ($cpromos > 0) {
                                                $promociones = $tour['promociones'][0];
                                            } else {
                                                $promociones = '';
                                            }
                                        @endphp

                                        <!-- Descripción de la promoción -->
                                        <input type="hidden" name="descripcion" id="descripcion"
                                            value="{{ $cpromos > 0 ? $promociones['descripcion'] : '' }}">
                                        <!-- Paxes min de la promoción -->
                                        <input type="hidden" name="paxes_promocion_cir" id="paxes_promocion_cir"
                                            value="{{ $cpromos > 0 ? $promociones['paxes_promocion'] : '' }}">

                                        <!-- Travel Windows -->
                                        <input type="hidden" name="travel_window_inicio" id="travel_window_inicio"
                                            value="{{ $cpromos > 0 ? $promociones['travel_window_inicio'] : '' }}">
                                        <input type="hidden" name="travel_window_fin" id="travel_window_fin"
                                            value="{{ $cpromos > 0 ? $promociones['travel_window_fin'] : '' }}">

                                        <input type="hidden" name="tipo_descuento_cir" id="tipo_descuento_cir"
                                            value="{{ $cpromos > 0 ? $promociones['tipo_descuento'] : '' }}">
                                        <input type="hidden" name="valor_promocion_cir" id="valor_promocion_cir"
                                            value="{{ $cpromos > 0 ? $promociones['valor_promocion'] : '' }}>">
                                        <input type="hidden" name="descuento_cir" id="descuento_cir"
                                            value="{{ $cpromos > 0 ? $promociones['descuento'] : '' }}">


                                        <input type="hidden" id="adulto_precio_extra" value="{{ $adulto_extra }}">


                                        @if ($tipo_costo == 0)
                                            <select id="fecha_viaje" name="fecha" class="form-control"
                                                onchange="mostrarPreciosCircuitos(this);  @if ($tour['paquete'][0]['hoteleria'] == 0) calculaPreciosCircuito() @endif"
                                                required>
                                            @else
                                                <script>
                                                    console.log("El tour es de tipo grupal")
                                                </script>
                                                <select id="fecha_viaje" name="fecha" class="form-control"
                                                    onchange="mostrarPreciosCircuitosGrupal(this); @if ($tour['paquete'][0]['hoteleria'] == 0) calculaPreciosCircuitoGrupal() @endif"
                                                    required>
                                        @endif


                                        @if (count($fechas) > 0)
                                            <script>
                                                console.log("Si hay fechas");
                                            </script>

                                            @if ($tour['paquete'][0]['calendario'] == 0)
                                                <option value="" disabled selected>Selecciona una
                                                    temporada</option>
                                            @else
                                                <option value="" disabled selected>Selecciona una fecha
                                                </option>
                                                <script>
                                                    console.log("Dentro de selecciona una fecha");
                                                </script>
                                            @endif
                                            <optgroup label="{{ 'Temporada ' . $fechas[0]['nombre_temporada'] }}"
                                                style="color: #EC237F; font-size: 16px;">
                                                @php
                                                    $indice = 0;
                                                    $temp = '';

                                                    $hoy = date('Y-m-d');
                                                    if ($cpromos > 0) {
                                                        $nombrepromo = $promociones['nombre'];
                                                        $descripcionpromo = $promociones['descripcion'];

                                                        $travel_win_inicio = $promociones['travel_window_inicio'];
                                                        $travel_win_fin = $promociones['travel_window_fin'];

                                                        $booking_win_inicio = $promociones['booking_window_inicio'];
                                                        $booking_win_fin = $promociones['booking_window_fin'];
                                                    }
                                                @endphp

                                                @foreach ($fechas as $fecha)
                                                    @php
                                                        $finicio = $fecha['fecha_inicio'];

                                                        if ($cpromos > 0) {
                                                            //Verifica si la fecha de hoy está dentro del rango de booking
                                                            if (
                                                                $fn->check_in_range(
                                                                    $booking_win_inicio,
                                                                    $booking_win_fin,
                                                                    $hoy,
                                                                ) == 1
                                                            ) {
                                                                $promo_booking_win = 1;
                                                                $title =
                                                                    'title="Promoción disponible si reservas hoy: ' .
                                                                    $descripcionpromo .
                                                                    '"';
                                                            } elseif (
                                                                //Si booking viene vacio y si la fecha de inicio del tour está dentro del rango de travel
                                                                //promo_booking_win será 1
                                                                $booking_win_inicio == null &&
                                                                $fn->check_in_range(
                                                                    $travel_win_inicio,
                                                                    $travel_win_fin,
                                                                    $finicio,
                                                                ) == 1
                                                            ) {
                                                                $promo_booking_win = 1;
                                                                $title =
                                                                    'title="Promoción disponible si reservas hoy: ' .
                                                                    $descripcionpromo .
                                                                    '"';
                                                            } else {
                                                                //Si booking_win no está dentro del rango, o viene vacio y no estamos dentro del rango de travel
                                                                //promo_booking será 0
                                                                $promo_booking_win = 0;
                                                                $title = '';
                                                            }

                                                            //Verifica si la fecha de inicio del tour está dentro del rango de la fecha de viaje
                                                            if (
                                                                $fn->check_in_range(
                                                                    $travel_win_inicio,
                                                                    $travel_win_fin,
                                                                    $finicio,
                                                                ) == 1
                                                            ) {
                                                                $promo_travel_win = 1;
                                                                $title =
                                                                    'title="Promoción disponible: ' .
                                                                    $descripcionpromo .
                                                                    '"';
                                                            } elseif (
                                                                //Si la fecha de travel no está dentro del rango, evaluaremos si es nulo y si booking contiene algo
                                                                //y si promo_booking vale 1
                                                                $travel_win_inicio === null &&
                                                                $booking_win_inicio != null &&
                                                                $promo_booking_win == 1
                                                            ) {
                                                                $promo_travel_win = 1;
                                                                $title =
                                                                    'title="Promoción disponible: ' .
                                                                    $descripcionpromo .
                                                                    '"';
                                                            } else {
                                                                $promo_travel_win = 0;
                                                                $title = '';
                                                            }
                                                        } else {
                                                            $promo_travel_win = 0;
                                                            $promo_booking_win = 0;
                                                            $title = '';
                                                        }

                                                    @endphp


                                                    @if ($indice == 0)
                                                        <option {{ $title }} value="{{ $fecha['id'] }}"
                                                            data-booking="{{ $promo_booking_win }}"
                                                            data-travel="{{ $promo_travel_win }}">
                                                            {{ $fn->fechaAbreviada($fecha['fecha_inicio']) . ' - ' . $fn->fechaAbreviada($fecha['fecha_fin']) . ': ' . $fecha['nombre_servicio'] }}
                                                        </option>
                                                    @else
                                                        @if ($temp == $fecha['id_temporada'])
                                                            <option {{ $title }} value="{{ $fecha['id'] }}"
                                                                data-booking="{{ $promo_booking_win }}"
                                                                data-travel="{{ $promo_travel_win }}">
                                                                {{ $fn->fechaAbreviada($fecha['fecha_inicio']) . ' - ' . $fn->fechaAbreviada($fecha['fecha_fin']) . ': ' . $fecha['nombre_servicio'] }}
                                                            </option>
                                                        @else
                                            </optgroup>

                                            <optgroup label="{{ 'Temporada ' . $fecha['nombre_temporada'] }}"
                                                style="color: #EC237F; font-size: 16px;">
                                                <option {{ $title }} value="{{ $fecha['id'] }}"
                                                    data-booking="{{ $promo_booking_win }}"
                                                    data-travel="{{ $promo_travel_win }}">
                                                    {{ $fn->fechaAbreviada($fecha['fecha_inicio']) . ' - ' . $fn->fechaAbreviada($fecha['fecha_fin']) . ': ' . $fecha['nombre_servicio'] }}
                                                </option>
                                        @endif
                                    @endif
                                    @php
                                        $temp = $fecha['id_temporada'];
                                        $indice++;
                                    @endphp
                                    @endforeach
                                @else
                                    <option value="" selected disabled>No hay fechas disponibles</option>
                                    @endif
                                    </select>

                                    @foreach ($fechas as $fecha)
                                        <input type="hidden" id="fecha_inicio_{{ $fecha['id'] }}"
                                            value="{{ $fecha['fecha_inicio'] }}">
                                        <input type="hidden" id="fecha_fin_{{ $fecha['id'] }}"
                                            value="{{ $fecha['fecha_fin'] }}">
                                        <input type="hidden" id="id_temporada_{{ $fecha['id'] }}"
                                            value="{{ $fecha['id_temporada'] }}">
                                        <input type="hidden" id="nombre_temporada_{{ $fecha['id'] }}"
                                            value="{{ $fecha['nombre_temporada'] }}">
                                        <input type="hidden" id="id_clase_servicio_{{ $fecha['id'] }}"
                                            value="{{ $fecha['id_clase_servicio'] }}">
                                        <input type="hidden" id="nombre_servicio_{{ $fecha['id'] }}"
                                            value="{{ $fecha['nombre_servicio'] }}">
                                        <input type="hidden" id="id_temporada_costo_{{ $fecha['id'] }}"
                                            value="{{ $fecha['id_temporada_costo'] }}">

                                        @php

                                            $adulto_sencilla = $fn->precio(
                                                $fecha['adulto_sencilla'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $adulto_doble = $fn->precio(
                                                $fecha['adulto_doble'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $adulto_triple = $fn->precio(
                                                $fecha['adulto_triple'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $adulto_cuadruple = $fn->precio(
                                                $fecha['adulto_cuadruple'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );

                                            $menor_sencilla = $fn->precio(
                                                $fecha['menor_sencilla'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $menor_doble = $fn->precio(
                                                $fecha['menor_doble'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $menor_triple = $fn->precio(
                                                $fecha['menor_triple'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $menor_cuadruple = $fn->precio(
                                                $fecha['menor_cuadruple'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );

                                            $infante_sencilla = $fn->precio(
                                                $fecha['infante_sencilla'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $infante_doble = $fn->precio(
                                                $fecha['infante_doble'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $infante_triple = $fn->precio(
                                                $fecha['infante_triple'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                            $infante_cuadruple = $fn->precio(
                                                $fecha['infante_cuadruple'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );

                                            $adulto_extra = $fn->precio(
                                                $fecha['adulto_extra'],
                                                $isotour,
                                                $monedaSeleccionada,
                                                $monedaDefault,
                                                $monedas,
                                            );
                                        @endphp

                                        <input type="hidden" id="adulto_sen_{{ $fecha['id'] }}"
                                            value="{{ $adulto_sencilla['preciosimple'] }}">
                                        <input type="hidden" id="adulto_dbl_{{ $fecha['id'] }}"
                                            value="{{ $adulto_doble['preciosimple'] }}">
                                        <input type="hidden" id="adulto_tpl_{{ $fecha['id'] }}"
                                            value="{{ $adulto_triple['preciosimple'] }}">
                                        <input type="hidden" id="adulto_cpl_{{ $fecha['id'] }}"
                                            value="{{ $adulto_cuadruple['preciosimple'] }}">

                                        <input type="hidden" id="menor_sen_{{ $fecha['id'] }}"
                                            value="{{ $menor_sencilla['preciosimple'] }}">
                                        <input type="hidden" id="menor_dbl_{{ $fecha['id'] }}"
                                            value="{{ $menor_doble['preciosimple'] }}">
                                        <input type="hidden" id="menor_tpl_{{ $fecha['id'] }}"
                                            value="{{ $menor_triple['preciosimple'] }}">
                                        <input type="hidden" id="menor_cpl_{{ $fecha['id'] }}"
                                            value="{{ $menor_cuadruple['preciosimple'] }}">

                                        <input type="hidden" id="infante_sen_{{ $fecha['id'] }}"
                                            value="{{ $infante_sencilla['preciosimple'] }}">
                                        <input type="hidden" id="infante_dbl_{{ $fecha['id'] }}"
                                            value="{{ $infante_doble['preciosimple'] }}">
                                        <input type="hidden" id="infante_tpl_{{ $fecha['id'] }}"
                                            value="{{ $infante_triple['preciosimple'] }}">
                                        <input type="hidden" id="infante_cpl_{{ $fecha['id'] }}"
                                            value="{{ $infante_cuadruple['preciosimple'] }}">


                                        <input type="hidden" id="adulto_precio_extra_{{ $fecha['id'] }}"
                                            value="{{ $adulto_extra['preciosimple'] }}">
                                    @endforeach

                                    {{-- FechaPorDia --}}
                                    <input type="hidden" name="fechaInicioDeLaTemporada" id="fechaInicioDeLaTemporada">
                                    <input type="hidden" name="fechaFinDeLaTemporada" id="fechaFinDeLaTemporada">
                                    <input type="hidden" name="fechaSeleccionadaPorDia" id="fechaSeleccionadaPorDia">

                                    @if ($tour['paquete'][0]['calendario'] == 0 && $tour['paquete'][0]['hoteleria'] == 1)

                                        <label for="datepickerCalendario" style="margin-top: 10px;">Selecciona una
                                            fecha</label>
                                        <div id="contenedorCalendario">
                                            <input required type="text" name="fecha" id="datepickerCalendario"
                                                class="form-control" placeholder="Fecha" readonly>
                                        </div>
                                    @endif
                                @else
                                    <label>Selecciona una fecha</label>
                                    <input required type="text" name="fecha" id="fecha_viaje_input"
                                        class="form-control" placeholder="Fecha">

                                    {{-- SERVICIO --}}
                                    @if (count($clases) > 1)
                                        <div class="mt-2">
                                            <label for="">Selecciona el servicio</label>
                                            <select required name="clase" id="clase"
                                                class="selectBook form-control" style="margin-bottom:10px;"
                                                onchange="buscaPrecios()">
                                                <option value="" disabled selected>Selecciona una opción
                                                </option>
                                                @foreach ($clases as $clase)
                                                    <option value="{{ $clase['id'] }}">{{ $clase['nombre'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        @if ($clases != null)
                                            <input type="hidden" name="clase" id="clase"
                                                value="{{ $clases[0]['id'] }}">
                                        @else
                                            <select class="form-control" id="clase" name="clase" required>
                                                <option value="" disabled selected>Sin servicio disponible
                                                </option>
                                            </select>
                                        @endif
                                    @endif
                                @endif
                                </div>

                                @if ($tipo_costo == 0)
                                    <div id="precios" class="mleft10 mright10">
                                        <div class="table-responsive" id="contieneprecios">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ADULTOS</th>
                                                        <th scope="col">MENORES</th>
                                                        <th scope="col">INFANTES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="3"
                                                            style="background-color: #c7dff2; color:black;">
                                                            <p class="text-center">Seleccione una fecha para
                                                                ver los precios</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div id="loadingPrices" class="row oculto">
                                            <img src={{ asset('assets/images/loading.gif') }} alt="Cargando precios"
                                                class="imgLoading">
                                        </div>
                                    </div>
                                @else
                                    <div id="precios" class="mleft10 mright10">
                                        <div class="table-responsive" id="contieneprecios">
                                            <table class="table table-bordered text-center" style="margin-top:20px;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">COSTO GENERAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="3"
                                                            style="background-color: #c7dff2; color:black;">
                                                            <p class="text-center">Seleccione una fecha para ver
                                                                los precios
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div id="loadingPrices" class="row oculto">
                                            <img src={{ asset('assets/images/loading.gif') }} alt="Cargando precios"
                                                class="imgLoading">
                                        </div>
                                    </div>
                                @endif

                                <!-- Eleccion de numero de habitaciones cuando el paquete incluye hoteleria -->
                                @if ($tour['paquete'][0]['hoteleria'] == 1)
                                    <div class="form-group">
                                        <!-- <label>Seleccione habitación</label> -->
                                        <select required name="tip_habitacion" id="tip_habitacion_1"
                                            class="form-control selecthabitacion"
                                            @if ($tour['paquete'][0]['cantidad_dias'] > 1) onchange="calculaPreciosCircuito()"
                                                    @else
                                                    onchange="calculaPrecios()" @endif>

                                            <option value="" selected="" disabled="">Seleccione tipo
                                                de habitación</option>
                                            @if ($tour['fechas'] != null)
                                                @if ($tour['fechas'][0]['adulto_sencilla'] > 0)
                                                    <option value="sen">Habitación sencilla</option>
                                                @endif

                                                @if ($tour['fechas'][0]['adulto_doble'] > 0)
                                                    <option value="dbl">Habitación doble</option>
                                                @endif

                                                @if ($tour['fechas'][0]['adulto_triple'] > 0)
                                                    <option value="tpl">Habitación triple</option>
                                                @endif

                                                @if ($tour['fechas'][0]['adulto_cuadruple'] > 0)
                                                    <option value="cpl">Habitación cuádruple</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                @endif

                                @if (count($tour['puntosPartida']) > 0)
                                    <div class="form-group">
                                        <select name="id_punto_partida" id="puntoPartida"
                                            class="form-control selecthabitacion" onchange="mostrarHorario(value)"
                                            required>
                                            <option value="">Seleccione un punto de partida</option>
                                            @foreach ($tour['puntosPartida'] as $puntoPartida)
                                                <option value="{{ $puntoPartida['id'] }}">
                                                    {{ $puntoPartida['punto_partida'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if (count($tour['horarios']) > 0)
                                        <div class="form-group oculto" id="divHorarios">
                                            <select name="horario" id="horario" class="form-control"></select>
                                        </div>
                                    @endif
                                @endif

                                <div class="table-responsive">

                                    <table id="tickets" class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Cantidad</th>
                                                <th class="text-center"><span>Subtotal</span></th>
                                            </tr>
                                        </thead>
                                        <!-- Total de reserva -->
                                        <tfoot>
                                            <tr class="total_row">
                                                <td colspan="1"><strong>TOTAL</strong></td>
                                                <td colspan="2" class="text-center">
                                                    <!-- COLOCAR LA MONEDA DENTRO DEL PROPIO VALOR DEL INPUT -->
                                                    <input type="text" name="total" id="totalDummy" value=""
                                                        class="text-center line d-none" readonly>

                                                    <div class="inputTotal">
                                                        $<input name="total" id="total" value=""
                                                            class="text-center" readonly>{{ $monedaSeleccionada }}
                                                    </div>

                                                </td>
                                            </tr>
                                        </tfoot>
                                        <!-- Cantidad de turistas -->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong>Adultos</strong>
                                                    <p><sup>{{ $rangoAdultos }}</sup></p>
                                                </td>
                                                <td>
                                                    <div class="styled-select">
                                                        <select style="background-color: white;" class="form-control"
                                                            name="adultos" id="adultos"
                                                            @if ($tour['paquete'][0]['cantidad_dias'] > 1 && $tour['paquete'][0]['hoteleria'] == 1) onchange="calculaPreciosCircuito()"
                                                            @else
                                                                @if ($tipo_costo == 0)
                                                                    @if ($tour['paquete'][0]['calendario'] == 0)
                                                                        onchange="calculaPrecios()" 
                                                                    @else
                                                                    onchange="calculaPreciosIndividual()" 
                                                                    @endif
                                                                @else
                                                                     @if ($tour['paquete'][0]['calendario'] == 0) onchange="calculaPreciosGrupal()" 
                                                                        @else
                                                                            onchange="calculaPreciosCircuitoGrupal()" 
                                                                    @endif
                                                                @endif
                                                            @endif disabled>

                                                            @php
                                                                $cant_options = $cant_pax_max;
                                                                if ($acepta_extras == 1) {
                                                                    $cant_options = $pax_max_extra + $cant_pax_max;
                                                                }
                                                            @endphp

                                                            @if ($acepta_extras == 1)
                                                                @for ($i = 0; $i <= $cant_options; $i++)
                                                                    <option value="{{ $i }}"
                                                                        {{ $i == 0 ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            @else
                                                                @for ($i = 0; $i <= $cant_options; $i++)
                                                                    <option value="{{ $i }}"
                                                                        {{ $i == 0 ? 'selected' : '' }}>
                                                                        {{ $i }}</option>
                                                                @endfor
                                                            @endif



                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="text-center">$<span class="subtotal subtotalAdulto">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Menores</strong>
                                                    <p><sup>{{ $rangoMenores }}</sup></p>
                                                </td>
                                                <td>
                                                    <div class="styled-select">
                                                        <select style="background-color: white;" class="form-control"
                                                            name="menores" id="menores"
                                                            @if ($tour['paquete'][0]['cantidad_dias'] > 1 && $tour['paquete'][0]['hoteleria'] == 1) onchange="calculaPreciosCircuito()"
                                                @else
                                                    @if ($tipo_costo == 0)
                                                        @if ($tour['paquete'][0]['calendario'] == 0)
                                                            onchange="calculaPrecios()" 
                                                        @else
                                                        onchange="calculaPreciosIndividual()" @endif
                                                        @else
                                                            @if ($tour['paquete'][0]['calendario'] == 0) onchange="calculaPreciosGrupal()" 
                                                    @else
                                                    onchange="calculaPreciosCircuitoGrupal()" @endif
                                                            @endif
                                                            @endif
                                                            disabled>

                                                            @for ($i = 0; $i <= $cant_options; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ $i == 0 ? 'selected' : '' }}>
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="text-center">$<span class="subtotal subtotalMenor">0</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Infantes</strong>
                                                    <p><sup>{{ $rangoInfantes }}</sup></p>
                                                </td>
                                                <td>
                                                    <div class="styled-select">
                                                        <select style="background-color: white;" class="form-control"
                                                            name="infantes" id="infantes"
                                                            @if ($tour['paquete'][0]['cantidad_dias'] > 1 && $tour['paquete'][0]['hoteleria'] == 1) onchange="calculaPreciosCircuito()"
                                                @else
                                                    @if ($tipo_costo == 0)
                                                        @if ($tour['paquete'][0]['calendario'] == 0)
                                                            onchange="calculaPrecios()" 
                                                        @else
                                                        onchange="calculaPreciosIndividual()" @endif
                                                        @else
                                                            @if ($tour['paquete'][0]['calendario'] == 0) onchange="calculaPreciosGrupal()" 
                                                    @else
                                                    onchange="calculaPreciosCircuitoGrupal()" @endif
                                                            @endif
                                                            @endif
                                                            disabled>

                                                            @for ($i = 0; $i <= 10; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ $i == 0 ? 'selected' : '' }}>
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="text-center">$<span class="subtotal subtotalInfante">0</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- AGREGAR CONDICIONAL AQUÍ PARA QUE NO APAREZCA LIMITES DE MINIMO Y MAXIMO-->
                                @if ($tour['paquete'][0]['hoteleria'] == 0)

                                    <div id="mensajeLimiteGroup">
                                        <p class="messageGroup" style="margin-bottom: 10px">
                                            <i class="fas fa-users"></i>
                                            El {{ $tipo_costo == 1 ? 'grupo' : 'tour' }} tiene un límite de
                                            {{ $cant_pax_max }}
                                            personas

                                            @if ($tipo_costo == 1)
                                                @if ($acepta_extras == 1)
                                                    (+{{ $pax_max_extra }} extras)
                                                @endif
                                            @endif
                                        </p>
                                    </div>

                                    @if ($cant_pax_min != null)
                                        <div id="contenedorMensajeMin">
                                            <p class="messageGroup" style="margin-bottom: 10px">
                                                <i class="fas fa-users"></i>
                                                El {{ $tipo_costo == 1 ? 'grupo' : 'tour' }} tiene un minimo de
                                                {{ $cant_pax_min }}
                                                personas
                                            </p>
                                        </div>
                                    @endif

                                    <div id="mensajeLimiteContadorPersonas"></div>
                                    <div id="mensajeMinimoContadorPersonas"></div>

                                @endif

                                <div class="form-group w-100">
                                    <div class="text-center">
                                        <button id="btngetprices" type="submit"
                                            class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base"><span>Reservar</span></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        {{-- AYUDA --}}
                        @if ($sitioweb[0]->telefono != '')
                            <div class="tour-listing-details__sidebar-post-box tour-listing-details__sidebar-single wow animated fadeInUp"
                                data-wow-delay="0.1s" data-wow-duration="1500ms">
                                <div class="faq-page__contact">
                                    <div class="faq-page__contact-icon">
                                        <span class="icon-phone-1"></span>
                                    </div>
                                    <h3 class="faq-page__contact-title">¿Necesitas Ayuda?</h3>
                                    <div class="faq-page__contact-number">
                                        <p class="faq-page__contact-number-title">No dudes en contactarnos por cualquiera
                                            de
                                            nuestros medios</p>
                                        <a aria-label="Teléfono" href="tel:{{ $sitioweb[0]->telefono }}"
                                            class="faq-page__contact-number-text">{{ $sitioweb[0]->telefono }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
        {{-- EXP SIMILARES --}}
        @if ($countToursRelacionados > 0)
            <div class="bg-exp-sim mt-4">
                {{-- TITULO --}}
                <div class="container">
                    <div class="sec-title text-center">
                        <p class="sec-title__tagline">Explora más</p>
                        <h2 class="sec-title__title">Experiencias Similares</h2>
                    </div>
                    <div
                        class="tour-listing-one__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav trevlo-owl__carousel--with-shadow owl-theme owl-carousel">
                        @foreach ($enlistadoRelacionados as $tourRelacionadoUnico)
                            <div class="tour-listing-one__carousel-item item">
                                <div class="tour-type-two__box">
                                    <div class="tour-type-two__box__flipper">
                                        {{-- FRONT --}}
                                        <div class="tour-type-two__box__front">
                                            {{-- PRICE --}}
                                            <div class="price-exp">

                                                <a aria-label="Más información de {{ $tourRelacionadoUnico['nombre'] }}"
                                                    href="/{{ $tourRelacionadoUnico['link'] }}">
                                                    <h5 class="tour-type-two__box__front__title">
                                                        {{ $fn->recortar_cadena($tourRelacionadoUnico['nombre'], 30) }}
                                                    </h5>
                                                </a>
                                            </div>
                                            {{-- DETAILS --}}
                                            <div class="details-exp">
                                                {{-- <a aria-label="Más información de {{ $tourRelacionadoUnico['nombre'] }}"
                                                    href="/{{ $tourRelacionadoUnico['link'] }}">
                                                    <h5 class="tour-type-two__box__front__title">
                                                        {{ $fn->recortar_cadena($tourRelacionadoUnico['nombre'], 30) }}
                                                    </h5>
                                                </a> --}}
                                                <span>
                                                    <i aria-hidden="true" class="fa-regular fa-clock text-yellow"></i>
                                                    {{ $tourRelacionadoUnico['cantidad_dias'] }}
                                                    {{ $tourRelacionadoUnico['cantidad_dias'] > 1 ? ($tourRelacionadoUnico['tipoDuracion'] == 0 ? ' días' : ' horas') : ($tourRelacionadoUnico['tipoDuracion'] == 0 ? ' día' : ' hora') }}
                                                </span>
                                                <br>
                                                <span class="index_card_experiencias_ciudad_container">
                                                    <i aria-hidden="true"
                                                        class="fa-solid fa-location-dot text-yellow"></i>
                                                    {{ $tourRelacionadoUnico['estado_comercial'] }} ,
                                                    {{ $tourRelacionadoUnico['ciudad_comercial'] }}
                                                </span>
                                                <br>
                                                <p class="tour-type-two__box__front__text mb-3">
                                                    Desde: <br> <i aria-hidden="true"
                                                        class="fa-solid fa-dollar-sign text-yellow"></i>
                                                    <strong>
                                                        {{ $tourRelacionadoUnico['precioformato'] }}
                                                        {{ $tourRelacionadoUnico['iso'] }}
                                                    </strong>
                                                </p>
                                                <span class="blog-card-two__rm mb-2"><i aria-hidden="true"
                                                        class="icon-right-arrow"></i>
                                                </span>
                                            </div>
                                            {{-- IMG --}}
                                            <div class="tour-type-two__box__front__image">
                                                <a aria-label="Más información de {{ $tourRelacionadoUnico['nombre'] }}"
                                                    href="/{{ $tourRelacionadoUnico['link'] }}">
                                                    <img src="{{ $tourRelacionadoUnico['imagen'] }}"
                                                        alt="Imagen de {{ $tourRelacionadoUnico['nombre'] }}">
                                                </a>
                                            </div>
                                        </div>
                                        {{-- BACK --}}
                                        <div class="tour-type-two__box__back">
                                            <div class="tour-type-two__box__back__image">
                                                <img src="{{ $tourRelacionadoUnico['imagen'] }}"
                                                    alt="Imagen de {{ $tourRelacionadoUnico['nombre'] }}">
                                            </div>
                                            <div class="tour-type-two__box__back__content">
                                                {{-- <h5 class="tour-type-two__box__back__title">
                                                    {{ $tourRelacionadoUnico['nombre']}}</h5> --}}
                                                <p class="tour-type-two__box__back__text">
                                                    <i aria-hidden="true"
                                                        class="fa-solid fa-location-dot text-yellow"></i>
                                                    {{ $tourRelacionadoUnico['estado_comercial'] }} ,
                                                    {{ $tourRelacionadoUnico['ciudad_comercial'] }}
                                                </p>
                                                <p class="tour-type-two__box__back__text">
                                                    <i aria-hidden="true" class="fa-regular fa-clock text-yellow"></i>
                                                    {{ $tourRelacionadoUnico['cantidad_dias'] }}
                                                    {{ $tourRelacionadoUnico['cantidad_dias'] > 1 ? ($tourRelacionadoUnico['tipoDuracion'] == 0 ? ' días' : ' horas') : ($tourRelacionadoUnico['tipoDuracion'] == 0 ? ' día' : ' hora') }}
                                                </p>
                                                <br>
                                                <a aria-label="Más información de {{ $tourRelacionadoUnico['nombre'] }}"
                                                    href="/{{ $tourRelacionadoUnico['link'] }}"
                                                    class="trevlo-btn trevlo-btn--base"><span>Ver más</span></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styleMessageGroup.css') }}" type="text/css">
    {{-- FANCY BOX --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .index_card_experiencias_ciudad_container {
            margin-block: 0;
        }

        @media(max-width:375px) {
            .tour-type-two__box__front__text {
                margin-top: 0px;
            }
        }

        .ui-datepicker .ui-datepicker-prev,
        .ui-datepicker .ui-datepicker-next {
            margin-top: 15px !important;
        }
    </style>
@endsection

@section('scripts')
    {{-- SPECIFIC SCRIPTS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    {{-- FANCY BOX --}}
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
    </script>
    {{-- VALIDACION ADULTOS --}}
    <script>
        //Script pedrito 1
        document.querySelector("#check_avail").addEventListener("submit", function(e) {
            const adultos = document.forms.check_avail.adultos.value;
            if (adultos == 0) {
                alert("Favor de seleccionar un adulto")
                e.preventDefault()
                return
            }
            const total = document.forms.check_avail.total.value
            if (total == "NaN" || total == "0") {
                alert("Favor de seleccionar un producto válido")
                e.preventDefault()
                return
            }
        })
    </script>

    <script>
        var objeto;
        var generales;
        var dias_operacion = @php echo $dias_operacion != "" ? $dias_operacion:"[]" @endphp;

        var promos;
        var booking;
        var travel;

        var nombreDescuento;
        var descuento;
        var mensaje;
        var tipo_descuento;
        var valor_promocion;
        var paxes_promocion;
        var limitado;
        var limite;
        var id; //id de la promocion
        var idexpromo; //id de la fecha promovida  

        var booking_window_inicio;
        var booking_window_fin;
        var travel_window_inicio;
        var travel_window_fin;
        var travelinicio;
        var travelfin;
        var bookingInicio;
        var bookingFin;

        @if (count($tour['puntosPartida']) > 0)
            const horarios = new Array();
            @foreach ($tour['horarios'] as $horario)
                horarios.push({
                    "id_punto_partida": "{{ $horario['id_punto_partida'] }}",
                    "hora": "{{ $horario['hora'] }}"
                });
            @endforeach

            function mostrarHorario(idPuntoPartida) {
                $("#divHorarios").show();
                $("#horario").empty();
                for (var clave in horarios) {
                    if (parseInt(horarios[clave]["id_punto_partida"]) === parseInt(idPuntoPartida)) {
                        $('#horario').append("<option value='" + horarios[clave]["hora"] + "' >" + horarios[clave]["hora"] +
                            " hrs.</option>");
                    }
                }
            }
        @endif



        $(document).ready(function() {
            $("#tip_habitacion_1").change(function() {
                valor = $(this).val();
                $("#tipohabitacion").val(valor);
            });

            if (("#fecha_viaje_input").length > 0) {

                objeto = {};
                generales = [];

                @php
                    $promociones = $tour['promociones'];
                    $cpromos = count($promociones) > 0 ? count($promociones) : 0;
                    //Declarar variable fecha que representa el array de fechas
                    $fechas = $tour['fechas'];
                @endphp

                promos = {{ count($promociones) == 0 ? '0' : count($promociones) }};
                booking = '{{ $cpromos > 0 ? $promociones[0]['booking_window_inicio'] : '' }}';
                travel = '{{ $cpromos > 0 ? $promociones[0]['travel_window_inicio'] : '' }}';
                //Si no hay fechas disponibles, finicio se declara vacio
                finicio = '{{ $fechas != null ? $fechas[0]['fecha_inicio'] : '' }}';
                var hoy = moment().format('YYYY-MM-DD');

                nombreDescuento = '{{ $cpromos > 0 ? $promociones[0]['nombre'] : '' }}';
                descuento = '{{ $cpromos > 0 ? $promociones[0]['descuento'] : '' }}';
                mensaje = '{{ $cpromos > 0 ? $promociones[0]['descripcion'] : '' }}';
                tipo_descuento = '{{ $cpromos > 0 ? $promociones[0]['tipo_descuento'] : '' }}';
                valor_promocion = '{{ $cpromos > 0 ? $promociones[0]['valor_promocion'] : '' }}';
                paxes_promocion = '{{ $cpromos > 0 ? $promociones[0]['paxes_promocion'] : '' }}';
                limitado = '{{ $cpromos > 0 ? $promociones[0]['limitado'] : '' }}';
                limite = '{{ $cpromos > 0 ? $promociones[0]['limite'] : '' }}';
                id = '{{ $cpromos > 0 ? $promociones[0]['id'] : '' }}'; //id de la promocion
                idexpromo = '{{ $cpromos > 0 ? $promociones[0]['idexpromo'] : '' }}'; //id de la fecha promovida  

                booking_window_inicio = '{{ $cpromos > 0 ? $promociones[0]['booking_window_inicio'] : '' }}';
                booking_window_fin = '{{ $cpromos > 0 ? $promociones[0]['booking_window_fin'] : '' }}';
                travel_window_inicio = '{{ $cpromos > 0 ? $promociones[0]['travel_window_inicio'] : '' }}';
                travel_window_fin = '{{ $cpromos > 0 ? $promociones[0]['travel_window_fin'] : '' }}';

                objeto["nombreDescuento"] = nombreDescuento;
                objeto["descuento"] = descuento;
                objeto["mensaje"] = mensaje;
                objeto["tipo_descuento"] = tipo_descuento;
                objeto["valor_promocion"] = valor_promocion;
                objeto["paxes_promocion"] = paxes_promocion;
                objeto["limitado"] = limitado;
                objeto["limite"] = limite;
                objeto["id"] = id;
                objeto["idexpromo"] = idexpromo;

                objeto["booking_window_inicio"] = booking_window_inicio;
                objeto["booking_window_fin"] = booking_window_fin;
                objeto["travel_window_inicio"] = travel_window_inicio;
                objeto["travel_window_fin"] = travel_window_fin;

                $("#tipo_descuento_frm").val(tipo_descuento);
                $("#valor_promocion_frm").val(valor_promocion);
                $("#descuento_frm").val(descuento);
                $("#idpromo_frm").val(id);
                $("#idexpromo_frm").val(idexpromo);

                // BT7: La siguiente estructura esa la misma lógica que se usa para las promociones de hoteleria
                //      este bloque de código aún está en pruebas para tours que no lo contienen.

                <?php if (count($promociones) > 0) { ?>

                generales.push(objeto);


                //Condicional para verificar status de booking

                if (check_in_range(booking_window_inicio, booking_window_fin, hoy) == 1) {
                    booking = 1;
                } else {
                    if ((booking_window_inicio == null || booking_window_inicio == '') && check_in_range(
                            travel_window_inicio, travel_window_fin,
                            finicio) == 1) {
                        booking = 1;
                    } else {
                        booking = 0;
                    }
                }

                //Condicional para verificar status de travel
                if (check_in_range(travel_window_inicio, travel_window_fin, finicio) == 1) {
                    travel = 1;
                } else {
                    if ((travel_window_inicio == null || booking_window_inicio == '' && booking_window_inicio !=
                            null) && booking == 1) {
                        travel = 1;
                    } else {
                        travel = 0;
                    }
                }

                <?php } else { ?>
                travel = 0;
                booking = 0;
                <?php } ?>


                let mindate_experiencia = $("#mindate_experiencia").val();

                $("#fecha_viaje_input").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    minDate: mindate_experiencia,
                    beforeShowDay: function(date) {

                        if ($.inArray(date.getDay().toString(), dias_operacion) == -1) {
                            return [false, "closed", "unAvailable"];
                        }

                        var fecha = $.datepicker.formatDate('mm/dd/yy', date);
                        if (booking === 1) {
                            if (validaFecha(bookingInicio, bookingFin, fecha) === 1) {
                                if (travel === 1) {
                                    return [true, "eventBooking",
                                        'Reserva esta fecha y obtén: ' +
                                        nombreDescuento + ' para viajar del ' +
                                        travelinicio +
                                        ' al ' + travelfin
                                    ];
                                } else {
                                    return [true, "eventBooking",
                                        'Reserva esta fecha y obtén: ' +
                                        nombreDescuento +
                                        ' para viajar en la fecha que desees'
                                    ];
                                }
                            } else {
                                return [true, '', ''];
                            }
                        } else {
                            if (travel === 1) {
                                if (validaFecha(travelinicio, travelfin, fecha) === 1) {
                                    return [true, "event", 'Promoción disponible: ' +
                                        nombreDescuento
                                    ];
                                } else {
                                    return [true, '', ''];
                                }
                            } else {
                                return [true, '', ''];
                            }
                        }
                    },
                    onSelect: function(dateText) {
                        // debugger


                        $("#contieneprecios").empty();
                        $("#fechaviaje").val(dateText);

                        $("#adultos").val(0);
                        $("#menores").val(0);
                        $("#infantes").val(0);

                        $(".subtotal").text("0");

                        var fecha = updateFecha(dateText);
                        var hoy = formatoFecha(new Date(), 'mm/dd/yyyy')

                        var mostrarpromo = 0;
                        if (booking === 1) {
                            if (validaFecha(booking_window_inicio, booking_window_fin, hoy) === 1) {
                                mostrarpromo = 1;
                            } else {
                                mostrarpromo = 0;
                            }
                        } else {
                            if (travel === 1) {
                                if (validaFecha(travel_window_inicio, travel_window_fin, fecha) === 1) {
                                    mostrarpromo = 1;
                                } else {
                                    mostrarpromo = 0;
                                }
                            } else {
                                mostrarpromo = 0;
                            }
                        }
                        var clase = $("#clase").val();
                        var tipo_costo = $("#tipo_costo").val();

                        if (clase > 0 && tipo_costo == 0) {
                            $("#loadingPrices").removeClass("d-none");
                            cargaPrecios({{ $tour['paquete'][0]['id'] }},
                                {{ $tour['paquete'][0]['cantidad_dias'] }}, dateText,
                                generales,
                                mostrarpromo, booking, travel, clase);
                            console.log('carga precio cuando clase > 0');

                        } else if (clase > 0 && tipo_costo == 1) {


                            cargaPreciosGrupal({{ $tour['paquete'][0]['id'] }},
                                {{ $tour['paquete'][0]['cantidad_dias'] }}, dateText,
                                generales,
                                mostrarpromo, booking, travel, clase);
                            // return crearOptionsExcursion('{{ $cant_pax_max }}',
                            //     '{{ $cant_pax_min }}');
                            return crearOptionsExcursion('{{ $cant_pax_max }}');

                        } else {
                            return '';
                        }

                    }
                });
            }


        });

        function buscaPrecios() {




            $("#contieneprecios").empty();

            $("#adultos").val(0);
            $("#menores").val(0);
            $("#infantes").val(0);

            $(".subtotal").text("0");

            var dateText = $("#fechaviaje").val();
            var idtour = '<?php echo $tour['paquete'][0]['id']; ?>';
            var dias = '<?php echo $tour['paquete'][0]['cantidad_dias']; ?>';

            var fecha = updateFecha(dateText);
            var hoy = formatoFecha(new Date(), 'mm/dd/yyyy')
            var mostrarpromo = 0;
            if (booking === 1) {
                if (validaFecha(bookingInicio, bookingFin, hoy) === 1) {
                    mostrarpromo = 1;
                } else {
                    mostrarpromo = 0;
                }
            } else {
                if (travel === 1) {
                    if (validaFecha(travelinicio, travelfin, fecha) === 1) {
                        mostrarpromo = 1;
                    } else {
                        mostrarpromo = 0;
                    }
                } else {
                    mostrarpromo = 0;
                }
            }
            var clase = $("#clase").val();
            var tipo_costo = $("#tipo_costo").val();
            console.log("clase: " + clase);
            if (dateText != '' && (clase != '' && clase != 0 && tipo_costo == 0)) {
                $("#loadingPrices").removeClass("d-none");
                cargaPrecios(idtour, dias, dateText, generales, mostrarpromo, booking, travel, clase);
                console.log('Estoy en cargaprecios abajote');
            } else {
                $("#loadingPrices").removeClass("d-none");
                cargaPreciosGrupal(idtour, dias, dateText, generales, mostrarpromo, booking, travel, clase);
            }
        }


        $('#adultos').on("change", function() {
            obtenerValorInputsSelected('{{ $cant_pax_max }}');
        });

        $('#menores').on("change", function() {
            obtenerValorInputsSelected('{{ $cant_pax_max }}');
        });
    </script>

    <script>
        @if ($tour['paquete'][0]['calendario'] == 0 && $tour['paquete'][0]['hoteleria'] == 1)


            $('#fecha_viaje').on("change", function() {
                let fechaElegida = $('#fechaSeleccionadaPorDia').val('');
                let fechaInicioDeLaTemporada = $('#fechaInicioDeLaTemporada').val();
                let fechaFinDeLaTemporada = $('#fechaFinDeLaTemporada').val();


                if (fechaElegida != '') {
                    $('#btngetprices').prop("disabled", true);
                } else {
                    $('#btngetprices').prop("disabled", false);
                }

                const {
                    dia,
                    mes,
                    yyy,
                    diaFinal,
                    mesFinal,
                    yyyFinal
                } = getNewDateOfTheUnicDay(fechaInicioDeLaTemporada, fechaFinDeLaTemporada);
                resetInformationAndElementsDOM();

                $("#datepickerCalendario").datepicker({
                    dateFormat: 'yy-mm-dd',
                    showButtonPanel: true,
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(yyy, mes, dia),
                    maxDate: new Date(yyyFinal, mesFinal, diaFinal),
                    inline: true,
                    onSelect: function(dateText, inst) {
                        $('#fechaSeleccionadaPorDia').val(dateText);
                        $('#btngetprices').prop("disabled", false);
                    }
                });
            });
        @endif
    </script>
@stop
