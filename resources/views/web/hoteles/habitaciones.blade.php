@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp

@extends('layouts.master')

@section('metaSEO')
    <title>{{ $nombreHotel }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="{{ $nombreHotel }}">
@endsection

@section('contenido-principal')
    @if ($existInformationHotel == true)
        <section class="tour-listing-details tour-listing-details-right">
            {{-- GALERIA --}}
            <div class="tour-listing-details__top-carousel">
                <div class="tour-listing-details__top-carousel-wrapper trevlo-owl__carousel owl-theme owl-carousel">
                    @foreach ($imagenes as $i => $imagen)
                        @php
                            $imgLink = str_replace('{size}', 'x500', $imagen);
                            if ($i == 0) {
                                $imgPral = $imgLink;
                            }
                        @endphp
                        <a aria-label="Imagen" data-fancybox="gallery" data-src="{{ $imgLink }}">
                            <div class="tour-listing-details__top-carousel-item item">
                                <div class="tour-listing-details__top-carousel-image">
                                    <img src="{{ $imgLink }}" alt="Imagen de {{ $nombreHotel }}"
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
                                <h3 class="tour-listing-details__dastination-title">{{ $nombreHotel }}</h3>
                                <h4 class="tour-listing-details__dastination-price">
                                    <i aria-hidden="true"
                                        class="{{ $stars >= 1 ? 'text-yellow' : 'text-muted' }} fa fa-star"></i>
                                    <i aria-hidden="true"
                                        class="{{ $stars >= 2 ? 'text-yellow' : 'text-muted' }} fa fa-star"></i>
                                    <i aria-hidden="true"
                                        class="{{ $stars >= 3 ? 'text-yellow' : 'text-muted' }} fa fa-star"></i>
                                    <i aria-hidden="true"
                                        class="{{ $stars >= 4 ? 'text-yellow' : 'text-muted' }} fa fa-star"></i>
                                    <i aria-hidden="true"
                                        class="{{ $stars >= 5 ? 'text-yellow' : 'text-muted' }} fa fa-star"></i>
                                </h4>
                            </div>
                        </div>
                        {{-- INFO GENERAL --}}
                        <div class="col-xl-8">
                            <div class="tour-listing-details__destination-right">
                                {{-- UBICACION --}}
                                <div class="tour-listing-details__destination-info wow animated fadeInUp"
                                    data-wow-delay="0.1s" data-wow-duration="1500ms">
                                    <span class="icon-location-1"></span>
                                    <div class="tour-listing-details__destination-info-title">
                                        <h4 class="tour-listing-details__destination-info-top">Dirección</h4>
                                        <h4 class="tour-listing-details__destination-info-bottom">
                                            {{ $addressHotel }}
                                        </h4>
                                    </div>
                                </div>
                                {{-- CHECK IN --}}
                                <div class="tour-listing-details__destination-info wow animated fadeInUp"
                                    data-wow-delay="0.3s" data-wow-duration="1500ms">
                                    <i aria-hidden="true" class="fa-solid fa-door-open"></i>
                                    <div class="tour-listing-details__destination-info-title">
                                        <h4 class="tour-listing-details__destination-info-top">Después de las</h4>
                                        <h4 class="tour-listing-details__destination-info-bottom">
                                            {{ $infoHotel['check_in_time'] }}
                                        </h4>
                                    </div>
                                </div>
                                {{-- CHECK OUT --}}
                                <div class="tour-listing-details__destination-info wow animated fadeInUp"
                                    data-wow-delay="0.5s" data-wow-duration="1500ms">
                                    <i aria-hidden="true" class="fa-solid fa-door-closed"></i>
                                    <div class="tour-listing-details__destination-info-title">
                                        <h4 class="tour-listing-details__destination-info-top">Hasta las</h4>
                                        <h4 class="tour-listing-details__destination-info-bottom">
                                            {{ $infoHotel['check_out_times'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- MAIN --}}
            <div class="container">
                <div class="tour-listing-details__row row">
                    <div class="col-xl-8">
                        <div class="row justify-content-center mb-5 btn-reserva">
                            <div class="col-md-3 col-sm-6">
                                <a href="#form-reserva" class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base">
                                    <span>
                                        Ver detalles de reservación
                                    </span>
                                </a>
                            </div>
                        </div>
                        {{-- HABITACIONES --}}
                        <h3>Habitaciones</h3>
                        <div class="table_hab mb-4" id="habitaciones">
                            @if ($habitacionUnicas != null)
                                {{-- ESCRITORIO --}}
                                <table id="table-precios" class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <td>Habitación</td>
                                            <td>Alimentos</td>
                                            <td>Política de <br> cancelación</td>
                                            <td>Precio</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($habitacionUnicas as $data)
                                            <tr>
                                                <td><strong>{{ $data['nombre'] }}</strong> <br>
                                                    <ul class="p-0" style="list-style: none;">
                                                        <i aria-hidden="true"
                                                            class="fas fa-luggage-cart"></i>{!! $data['allotment'] !!}
                                                        @foreach ($data['amenidades'] as $amenidad)
                                                            @php
                                                                $claveAmenidad = array_search($amenidad, array_column($hotelAds, 'name'));
                                                                $nombreAmenidad = $hotelAds[$claveAmenidad]['es'];
                                                            @endphp
                                                            <li><i aria-hidden="true" class="fas fa-info-circle"></i>
                                                                {{ $nombreAmenidad }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td> {{ $data['nombreMeal'] }}</td>
                                                <td>
                                                    <p
                                                        class="helper {{ $data['free_cancelation'] == null ? 'text-danger bold' : 'text-success' }}">
                                                        {{ $data['free_cancelation'] == null ? 'Tarifa NO cancelable' : '$0 ' . $monedaSeleccionada }}
                                                        <small>
                                                            <a aria-label="Cancelar" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-title="{{ $data['txtCancelation'] }}">
                                                                <i aria-hidden="true"
                                                                    class="fa-regular fa-circle-question"></i>
                                                            </a>
                                                        </small>
                                                        <br>
                                                        <small>{!! $data['fecha_cancelation'] !!}</small>
                                                    </p>
                                                </td>
                                                <td><b><i aria-hidden="true" class="fas fa-dollar-sign"></i>
                                                        {{ number_format($data['totalPrecio'], 2, '.', ',') . ' ' . $monedaSeleccionada }}</b>
                                                </td>
                                                <td>
                                                    @php
                                                        if ($data['free_cancelation'] == null) {
                                                            $fx = 0;
                                                        } else {
                                                            $fx = $fn->restaFechas($data['fecha'][0], 1);
                                                        }

                                                        $hotelID = $reserva['id'];
                                                        $linkForm = 'hash=' . $data['book_hash'] . '&id=' . $hotelID . '&checkin=' . $reserva['checkin'] . '&checkout=' . $reserva['checkout'];
                                                        $linkForm .= '&adults=' . $reserva['guests'][0]['adults'] . '&menores=' . ($menores == 'cero' ? '0' : $menores) . '&fx=' . $fx;
                                                        $linkForm .= '&room=' . $data['room_data_trans']['main_name'] . '&pr=' . $data['totalPrecio'];
                                                        $linkForm .= '&meal=' . $data['meal'] . '&cur=' . $monedaSeleccionada . '&hotbd=' . $idhotelBD . '&residency=' . $reserva['residency'] . '&lan=' . $reserva['language'];
                                                        $linkForm .= '&hotelName=' . $infoHotel['hotelName'] . '&foto=' . $imgPrincipal . '&marte=' . $markup;
                                                    @endphp
                                                    <a aria-label="Reservar" href="/datos-compra-hotel?{{ $linkForm }}"
                                                        class="trevlo-btn trevlo-btn--base-three">
                                                        <span>Reservar</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- MOVIL --}}
                                <div class="habitacionesMovilContenedor">
                                    @foreach ($habitacionUnicas as $data)
                                        <div class="listaHabitaciones">
                                            <div class="text-center">
                                                <!-- CUERPO NOMBRE HABITACIÓN -->
                                                <div>
                                                    <h5 class="text-center"><strong>{{ $data['nombre'] }}</strong></h5>
                                                </div>
                                                <small><i aria-hidden="true" class="fas fa-luggage-cart"></i>
                                                    {!! $data['allotment'] !!}</small>
                                                <ul>
                                                    @foreach ($data['amenidades'] as $amenidad)
                                                        @php
                                                            $claveAmenidad = array_search($amenidad, array_column($hotelAds, 'name'));
                                                            $nombreAmenidad = $hotelAds[$claveAmenidad]['es'];
                                                        @endphp
                                                        <li style="list-style: none;"><i
                                                                class="fas fa-info-circle"></i>{{ $nombreAmenidad }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <!-- CUERPO ALIMENTOS -->
                                                <td class="text-center">
                                                    <strong>Alimentos</strong><br>
                                                    {{ $data['nombreMeal'] }}
                                                </td>

                                                <!-- POLITICA DE CANCELACIÓN -->
                                                <div class="text-center">
                                                    <strong>Políticas de cancelación</strong><br>
                                                    <small>{!! $data['fecha_cancelation'] !!}</small>
                                                    <p
                                                        class="helper {{ $data['free_cancelation'] == null ? 'text-danger bold' : 'text-success' }}">
                                                        {{ $data['free_cancelation'] == null ? 'Tarifa NO cancelable' : '$0 ' . $monedaSeleccionada }}
                                                        <small>
                                                            <ul class="add_info" style="list-style: none">
                                                                <li>
                                                                    <a aria-label="Cancelar" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" data-bs-html="true"
                                                                        data-bs-title="{{ $data['txtCancelation'] }}">
                                                                        <i aria-hidden="true"
                                                                            class="fa-regular fa-circle-question"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </small>

                                                    </p>
                                                </div>
                                                <div class="text-center">
                                                    <p>
                                                        <strong>{{ "$ " . number_format($data['totalPrecio'], 2, '.', ',') . ' ' . $monedaSeleccionada }}</strong>
                                                    </p>
                                                </div>
                                            </div>

                                            <div
                                                style="display: flex; justify-content: center; height: 64px; width: 100%; align-items: end;">
                                                <!-- PRECIO -->
                                                <div class="text-center">
                                                    @php
                                                        if ($data['free_cancelation'] == null) {
                                                            $fx = 0;
                                                        } else {
                                                            $fx = $fn->restaFechas($data['fecha'][0], 1);
                                                        }

                                                        $hotelID = $reserva['id'];
                                                        $linkForm = 'hash=' . $data['book_hash'] . '&id=' . $hotelID . '&checkin=' . $reserva['checkin'] . '&checkout=' . $reserva['checkout'];
                                                        $linkForm .= '&adults=' . $reserva['guests'][0]['adults'] . '&menores=' . ($menores == 'cero' ? '0' : $menores) . '&fx=' . $fx;
                                                        $linkForm .= '&room=' . $data['room_data_trans']['main_name'] . '&pr=' . $data['totalPrecio'];
                                                        $linkForm .= '&meal=' . $data['meal'] . '&cur=' . $monedaSeleccionada . '&hotbd=' . $idhotelBD . '&residency=' . $reserva['residency'] . '&lan=' . $reserva['language'];
                                                        $linkForm .= '&hotelName=' . $infoHotel['hotelName'] . '&foto=' . $imgPrincipal . '&marte=' . $markup;
                                                    @endphp

                                                    <a aria-label="Reservar"
                                                        href="/datos-compra-hotel?{{ $linkForm }}"
                                                        class="trevlo-btn trevlo-btn--base-three">
                                                        <span>Reservar</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h5 class="text-center">No hay habitaciones disponibles por el momento.</h5>
                            @endif
                        </div>
                        {{-- FRAME MAP --}}
                        <div class="row mt-4 mb-5">
                            <h3>Ubicación del hotel</h3>
                            <iframe class="map-hotel" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                src="https://maps.google.com/maps?q={{ $infoHotel['latitude'] }},{{ $infoHotel['longitude'] }}&hl=es&z=14&amp;output=embed">
                            </iframe>
                        </div>
                        {{-- DESCRIPCION --}}
                        @foreach ($description as $des)
                            <div class="tour-listing-details__overview">
                                <div class="wow animated fadeIn" data-wow-delay="0.1s" data-wow-duration="1500ms">
                                    <h3 class="tour-listing-details__title tour-listing-details__overview-title">
                                        {{ $des->title }}
                                    </h3>
                                </div>
                                <p class="tour-listing-details__overview-text wow animated fadeInUp" data-wow-delay="0.1s"
                                    data-wow-duration="1500ms">
                                    {{ $des->paragraphs[0] }}
                                </p>
                            </div>
                        @endforeach
                        {{-- INFO EXTRA --}}
                        @if ($infoHotel['metapolicy_extra_info'] != null)
                            <div class="tour-listing-details__overview">
                                <div class="wow animated fadeIn" data-wow-delay="0.1s" data-wow-duration="1500ms">
                                    <h3 class="tour-listing-details__title tour-listing-details__overview-title">
                                        Información Extra
                                    </h3>
                                </div>
                                <p class="tour-listing-details__overview-text wow animated fadeInUp" data-wow-delay="0.1s"
                                    data-wow-duration="1500ms">
                                    {!! $infoHotel['metapolicy_extra_info'] !!}
                                </p>
                            </div>
                        @endif
                        {{-- SERVICIOS --}}
                        <div class="tour-listing-details__plan">
                            <h3 class="tour-listing-details__title tour-listing-details__plan-title">Servicios del Hotel
                            </h3>
                            <div class="trevlo-accrodion tour-listing-details__faq"
                                data-grp-name="tour-listing-details__faq">
                                @foreach ($amenities as $i => $amenity)
                                    @php
                                        $listaAmenidades = $amenity->amenities;
                                    @endphp
                                    <div class="accrodion {{ $i == 0 ? 'active' : '' }} wow animated fadeInUp"
                                        data-wow-delay="0.1s" data-wow-duration="1500ms">
                                        <div class="accrodion-title">
                                            <h4><span>{{ $amenity->group_name }}</span></h4>
                                        </div>
                                        <div class="accrodion-content {{ $i > 0 ? 'oculto' : '' }}">
                                            <div class="inner">
                                                <ul class="accrodion-content-bottom">
                                                    @foreach ($listaAmenidades as $amenityDet)
                                                        <li><i aria-hidden="true" class="fa-solid fa-check"></i>
                                                            {{ $amenityDet }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row justify-content-center mb-5 mt-5">
                            <div class="col-md-3 col-sm-6">
                                <a href="#habitaciones" class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base">
                                    <span>
                                        Ver Habitaciones
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- TICKE PRE RESERVA --}}
                    <div id="form-reserva" class="col-xl-4">
                        <aside class="tour-listing-details__sidebar">
                            <div class="tour-listing-details__sidebar-book-tours tour-listing-details__sidebar-single wow animated fadeInUp"
                                data-wow-delay="0.1s" data-wow-duration="1500ms">
                                <h3 class="tour-listing-details__sidebar-title">Datos de Reserva</h3>
                                {{-- <div class="tour-listing-details__sidebar-form">
                                    <div class="tour-listing-details__sidebar-form-input">
                                        <label>Ubicación</label>
                                        <input type="text" value="{{ $addressHotel }}" disabled>
                                    </div>
                                    <div class="tour-listing-details__sidebar-form-input" disabled>
                                        <label>Check in</label>
                                        <input type="text" value="{{ $checkin }}" disabled>
                                    </div>
                                    <div class="tour-listing-details__sidebar-form-input">
                                        <label>Check out</label>
                                        <input type="text" value="{{ $checkout }}" disabled>
                                    </div>
                                    <table class="table table-responsive">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Adultos
                                                </td>
                                                <td class="text-end">
                                                    {{ $adultos }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Menores
                                                </td>
                                                <td class="text-end">
                                                    @if ($countMenores > 0 && $menores != 'cero')
                                                        {{ $countMenores }}
                                                    @else
                                                        {{ '0' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> --}}

                                <div class="col-sm-12 tour-listing-details__sidebar-form">
                                    {{-- FORM Obtener Nueva Consulta De Habitaciones --}}
                                    <form action="{{ route('listaHoteles') }}" method="get">
                                        @csrf
                                        <input type="hidden" name="total" value="{{ $total }}">
                                        <input type="hidden" name="destinoHotelero" id="destinoHotelero"
                                            value="{{ $idHotelName }}">
                                        <input type="hidden" name="actualizarDetalle" value="1">
                                        {{-- <input type="hidden" name="destinoHotelero " id="destinoHotelero " value="{{$idhotelBD}}"> --}}
                                        
                                        <div class="theiaStickySidebar">
                                            <div class="box_style_1" id="booking_box">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label><i aria-hidden="true" aria-hidden="true"
                                                                    class=" icon_set_1_icon-33"></i> Hotel</label>
                                                            <input type="hidden" name="nombreDestinoHotelero"
                                                                id="nombreDestinoHotelero" value="{{ $hotelName }}" />
                                                            <input type="hidden" name="hotelName" value="{{ $idHotelName }}">
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $nombreHotel }}" title="{{ $nombreHotel }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label><i aria-hidden="true" class=" icon_set_1_icon-41"></i>
                                                                Ubicación</label>
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $addressHotel }}" title="{{ $addressHotel }}">
                                                        </div>
                                                    </div>
            
                                                    {{-- <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label><i aria-hidden="true" class="icon-calendar-7"></i> Check-In</label>
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $checkin }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label><i aria-hidden="true" class=" icon-clock"></i> Check-Out</label>
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $checkout }}">
                                                        </div>
                                                    </div> --}}
            
                                                    <div class="col-sm-12">
                                                        <label><i aria-hidden="true" class=" icon-clock"></i> Fechas</label>
                                                        <input type="hidden" id="checkin" name="checkin"
                                                            value="{{ $checkin }}">
                                                        <input type="hidden" id="checkout" name="checkout"
                                                            value="{{ $checkout }}">
                                                        <input autocomplete="off" type="text" id="fechasHabitacion"
                                                            class="form-control">
                                                    </div>
            
                                                </div>
                                                <br>
                                                <table class="table table_summary">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Adultos
                                                            </td>
                                                            <td class="text-end">
            
                                                                {{-- <input type="hidden" name="adultos" id="adultos"
                                                                    value="{{ $adultos }}" /> --}}
                                                                    
            
                                                                <select autocomplete="off" name="adultos"
                                                                    class="form-control" id="adultos">
                                                                    <!-- QUITAR DISABLED -->
                                                                    @for ($i = 1; $i <= 10; $i++)
                                                                        <option value="{{ $i }}"
                                                                            @if (isset($adultos) && $adultos == $i) selected @endif>
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
            
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Menores
                                                            </td>
                                                            <td class="text-end">
                                                                {{-- <input type="hidden" name="menores" value="{{ $countMenores }}"> --}}
            
                                                                <select autocomplete="off" name="menores"
                                                                    class="form-control" id="menores"
                                                                    onchange="menoresEdadesPedrito(value)"> <!--Quitar disabled -->
                                                                    @for ($i = 0; $i <= 4; $i++)
                                                                        <option value="{{ $i }}"
                                                                            @if ($countMenores == $i) selected @endif>
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr id="edad1"
                                                        
                                                            @if ($countMenores < 1) style="display: none;" @endif>
            
                                                            <td>
                                                                Menor 1
                                                            </td>
                                                            <td>
                                                                <select required class="form-control" name="edad[]">
                                                                    <option value="" disabled selected>Selecciona</option>
                                                                    @for ($i = 0; $i <= 17; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ isset($arrayMenoresCount[0]) && $i == $arrayMenoresCount[0] ? 'selected' : '' }}>
                                                                            {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                        </tr>
            
                                                        <tr id="edad2"
                                                            @if ($countMenores < 2) style="display: none;" @endif>
            
                                                            <td>
                                                                Menor 2
                                                            </td>
                                                            <td>
                                                                <select required class="form-control" name="edad[]">
            
                                                                    <option value="" disabled selected>Selecciona</option>
                                                                    @for ($i = 0; $i <= 17; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ isset($arrayMenoresCount[1]) && $i == $arrayMenoresCount[1] ? 'selected' : '' }}>
                                                                            {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                        </tr>
            
                                                        <tr id="edad3"
                                                            @if ($countMenores < 3) style="display: none;" @endif>
            
                                                            <td>
                                                                Menor 3
                                                            </td>
                                                            <td>
                                                                <select required class="form-control" name="edad[]">
                                                                    <option value="" disabled selected>Selecciona</option>
                                                                    @for ($i = 0; $i <= 17; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ isset($arrayMenoresCount[2]) && $i == $arrayMenoresCount[2] ? 'selected' : '' }}>
                                                                            {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                        </tr>
            
                                                        <tr id="edad4"
                                                            @if ($countMenores < 4) style="display: none;" @endif>
            
                                                            <td>
                                                                Menor 4
                                                            </td>
                                                            <td>
                                                                <select required class="form-control" name="edad[]">
                                                                    <option value="" disabled selected>Selecciona</option>
                                                                    @for ($i = 0; $i <= 17; $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ isset($arrayMenoresCount[3]) && $i == $arrayMenoresCount[3] ? 'selected' : '' }}>
                                                                            {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    <button id="buttonSearch" class="btn_1 rounded w-100 button__input btn btn-primary"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Buscar Disponibilidad</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <a href="#habitaciones" class="btn_1 rounded w-100 button__input btn btn-primary button_flex"><i class="fa-solid fa-bed" aria-hidden="true"></i> Ver Habitaciones</a>
                                </div>
                            </div>
                            @if ($sitioweb[0]->telefono != '')
                                <div class="tour-listing-details__sidebar-post-box tour-listing-details__sidebar-single wow animated fadeInUp"
                                    data-wow-delay="0.1s" data-wow-duration="1500ms">
                                    <div class="faq-page__contact">
                                        <div class="faq-page__contact-icon">
                                            <span class="icon-phone-1"></span>
                                        </div>
                                        <h3 class="faq-page__contact-title">¿Necesitas Ayuda?</h3>
                                        <div class="faq-page__contact-number">
                                            <p class="faq-page__contact-number-title">No dudes en contactarnos por
                                                cualquiera
                                                de
                                                nuestros medios</p>
                                            <a aria-label="Teñéfono" href="tel:{{ $sitioweb[0]->telefono }}"
                                                class="faq-page__contact-number-text">{{ $sitioweb[0]->telefono }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="tour-listing-details tour-listing-details-right" style="padding-top:100px; padding-bottom:100px;">
            <p class="text-center">Por el momento no hay información disponible de este hotel</p>
        </section>
    @endif

@endsection

@section('css')
    {{-- FANCY BOX --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .map-hotel {
            width: 100%;
            height: 400px;
            border-radius: 15px;
        }

        @media (max-width: 380px) {
            .map-hotel {
                height: 280px;
            }
        }

        /* TABLA HAB */
        .table_hab {
            max-height: 70vh;
            overflow-y: scroll;
            border: solid 1px;
            border-color: #80808063;
            border-radius: 20px;
        }

        /* ESTILOS PARA TABLA HABITACIONES MOVIL */
        .habitacionesMovilContenedor {
            display: none;
        }

        .habitacionesMovilContenedor .listahabitaciones ul {
            list-style: none
        }

        @media(max-width:770px) {
            #table-precios {
                display: none;
            }

            .habitacionesMovilContenedor {
                display: block;
            }

            .btn-normal-4 {
                width: 100%;
            }

            .contenedorTabla {
                display: none;
            }

            .listaHabitaciones {
                border: 1px solid #afafaf;
                /* margin-bottom: 30px; */
                padding: 20px;
            }
        }

        @media(max-width:612px) {
            .habitacionesMovilContenedor {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                place-content: center;
            }
        }

        @media(max-width:467px) {

            .habitacionesMovilContenedor {
                grid-template-columns: 1fr;
                gap: 20px;
                place-content: center;
            }
        }

        #buttonSearch {
            background-color: var(--colorSecundario);
        }

        .btn-primary {
            background-color: var(--colorSecundario);
        }
    </style>
@endsection

@section('scripts')
    {{-- FANCY BOX --}}
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3/daterangepicker.min.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
        // TOOLTIP HAB
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

<script>
    // // FECHAS
    // var today = moment({{ $checkin }}).format("YYYY-MM-DD");
    var today = '{{ $checkin }}';
    // var todayEnd = moment({{ $checkout }}).format("YYYY-MM-DD");
    var todayEnd = '{{ $checkout }}';
    // let maxday = moment().add(730, 'days').format("YYYY/MM/DD");

    // $("#checkin").val(moment().add(5, 'days').format("YYYY-MM-DD"));
    // $("#checkout").val(moment().add(6, 'days').format("YYYY-MM-DD"));


    $('#fechasHabitacion').daterangepicker({

        autoApply: true,
        opens: 'left',
        minDate: {{ $checkin }},
        maxDate: {{ $checkout }},
        maxSpan: {
            "days": 30
        },
        startDate: {{ $checkin }},
        endDate: {{ $checkout }},
        locale: {
            applyLabel: "AplicarFechas",
            format: 'YYYY-MM-DD'
        }
    }, function(start, end, label) {
        $("#checkin").val(start.format('YYYY-MM-DD'));
        $("#checkout").val(end.format('YYYY-MM-DD'));
    });

    $("#fechasHabitacion").val(today + ' - ' + todayEnd);
</script>

<script>
    function menoresEdadesPedrito(menores) {
        for (i = 1; i <= 4; i++) {
            if (i <= menores) {
                $("#edad" + i).show();
                $(`#edad${i} select`).removeAttr('disabled')
            } else {
                $("#edad" + i).hide();
                $(`#edad${i} select`).prop("disabled", true);
                $(`#edad${i} select`).val(0);
            }
        }
    }

    menoresEdadesPedrito($('#menores').val());
</script>
@stop
