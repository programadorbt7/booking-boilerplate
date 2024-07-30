@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp
@extends('layouts.master')

@section('metaSEO')
    <title>Inicio - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Cucapah es una agencia de viajes caracterizada por el buen servicio y oferta de productos turisticos de calidad en diversos destinos, estamos comprometidos con cumplir los sueños de viaje de nuestros clientes.">
    <meta name="keywords"
        content="Agencias, Agencias viajes, Viajes, Tours, Niños, Adultos, Experiencias, Visitas, Paquetes Turisticos, Turismo, Vuelos, Ciudades, Lugares, Residencias, Hoteles, Playas, Cucapah">
@endsection

@section('contenido-principal')
    {{-- SLIDER & MOTOR --}}
    <section class="main-slider-one">
        <div class="main-slider-one__carousel trevlo-owl__carousel owl-carousel owl-theme">
            @if($slider != null)
                @foreach ($slider as $x => $image)
                    <div class="item">
                        <div class="main-slider-one__image"
                            style="background-image: url(https://app.bookingtrap.com/public/storage/{{ $image['archivo'] }});">
                        </div>
                        <div class="container">
                            <div class="main-slider-one__content">
                                <h5 class="main-slider-one__sub-title">Viajes y tours <img
                                        src="assets/images/shapes/slider-1-shape-1.png" alt="trevlo"></h5>
                                <h3 class="main-slider-one__title">Explora el mundo<img
                                        src="assets/images/shapes/slider-1-shape-2.png" alt="trevlo"></h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else 
                <div class="item">
                    <div class="main-slider-one__image"
                        style="background-image: url({{ asset('cucapah/img/experiencias1.webp') }});">
                    </div>
                    <div class="container">
                        <div class="main-slider-one__content">
                            <h5 class="main-slider-one__sub-title">Viajes y tours <img
                                    src="assets/images/shapes/slider-1-shape-1.png" alt="trevlo"></h5>
                            <h3 class="main-slider-one__title">Explora el mundo<img
                                    src="assets/images/shapes/slider-1-shape-2.png" alt="trevlo"></h3>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- MOTOR --}}
        @include('web.partials.miMotor')
    </section>

    {{-- PROMOCIONES --}}
    @if (count($promocionesExpress) > 0)
        <section style="padding-top: 80px !important;"
            class="pricing-page pricing-page-slider section-space correcion-pedrito-1 pb-3 promos">
            <div class="container overflow_hiden">
                {{-- TITULO --}}
                <div class="sec-title text-center ">
                    <p class="sec-title__tagline">Mira esto</p>
                    <h2 class="sec-title__title mb-5">Arma tu viaje con <span>nosotros</span></h2>
                </div>
                {{-- CARD --}}
                <div class="pricing-page__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav owl-theme owl-carousel"
                    style="padding: 140px 0 0">
                    @foreach ($promocionesExpress as $promocion)
                        <div class="pricing-page__carousel-item item">
                            <div class="pricing-card">
                               
                                    <div class="pricing-card__image-wrapper">
                                        <div class="pricing-card__image"
                                            style="background-image: url('{{ $promocion['imagen'] }}');">
                                        </div>
                                    </div>
                               
                                <h4 class="mt-5 text-center title_promo_card">{{ $promocion['promocion'] }}</h2>
                                    <div class="index_card_promo_footer">
                                        <div class="details-promo">
                                            <div>
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-title="{{ $promocion['transportacion_terrestre'] > 0 ? 'Incluye transportación terrestre' : 'No incluye transportación terrestre' }}"
                                                    class="fas fa-bus {{ $promocion['transportacion_terrestre'] > 0 ? 'text-yellow' : 'text-muted' }}"></span>
                                            </div>
                                            <div>
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-title="{{ $promocion['avion'] > 0 ? 'Incluye vuelos' : 'No incluye vuelos' }}"
                                                    class="fas fa-plane {{ $promocion['avion'] > 0 ? 'text-yellow' : 'text-muted' }}"></span>
                                            </div>
                                            <div>
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-title="{{ $promocion['hoteleria'] > 0 ? 'Incluye hotelería' : 'No incluye hotelería' }}"
                                                    class="fas fa-hotel {{ $promocion['hoteleria'] > 0 ? 'text-yellow' : 'text-muted' }}"></span>
                                            </div>
                                        </div>
                                        <div class="pricing-card__btn-box">
                                            <a target="_blank"
                                                href="https://wa.me/{{ $sitioweb[0]->whatsapp }}?text=Podr%C3%ADa%20darme%20informaci%C3%B3n%20de%20la%20promocion%20{{ $promocion['promocion'] }}"
                                                class="pricing-card__btn trevlo-btn trevlo-btn--base promo">
                                                <span><i aria-hidden="true" class="fa-brands fa-whatsapp"></i></span></a>
                                        </div>
                                    </div>
                                    <div class="pricing-card__overlay"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- EXP POP --}}
    @if ($countHomeTours > 0)
        <section class="tour-type-two mb-5">
            <div class="container">
                {{-- TITULO --}}
                <div class="sec-title text-center">
                    <p class="sec-title__tagline">Lo mejor de lo mejor</p>
                    <h2 class="sec-title__title">Los más solicitados</h2>
                </div>
                {{-- CARD --}}
                <div class="row">
                    @foreach ($favoritosTours as $i => $favoritosTour)
                        <div class="col-xl-4 col-md-6 wow correcion-pedrito-20" style="margin-bottom: 45px;">
                            <div class="tour-type-two__box">
                                <div class="tour-type-two__box__flipper">
                                    {{-- FRONT --}}
                                    <div class="tour-type-two__box__front">
                                        <span class="blog-card-two__rm mb-2"><i aria-hidden="true"
                                            class="icon-right-arrow"></i>
                                        </span>
                                        @if ($favoritosTour['promocion'])
                                            <div class="promo-exp">
                                                <strong>
                                                    <i aria-hidden="true" class="icon icon-discount text-yellow"></i>
                                                    En
                                                    promoción!
                                                </strong>
                                            </div>
                                            {{-- PRICE --}}
                                            <div class="price-exp exp-wht-promo">
                                                <a aria-label="Más información de {{ $favoritosTour['nombre'] }}">
                                                    <h5 class="tour-type-two__box__front__title">
                                                        {{ $favoritosTour['nombre'] }}
                                                    </h5>
                                                </a>
                                            </div>
                                        @else
                                            {{-- PRICE --}}
                                            <div class="price-exp">
                                                <a aria-label="Más información de {{ $favoritosTour['nombre'] }}">
                                                    <h5 class="tour-type-two__box__front__title">
                                                        {{ $favoritosTour['nombre'] }}
                                                    </h5>
                                                </a>
                                            </div>
                                        @endif

                                        {{-- DETAILS --}}
                                        <div class="details-exp">

                                            <span>
                                                <i aria-hidden="true" class="fa-regular fa-clock text-yellow"></i>
                                                {{ $favoritosTour['cantidad_dias'] }}
                                                {{ $favoritosTour['cantidad_dias'] > 1
                                                    ? ($favoritosTour['tipoDuracion'] == 0
                                                        ? '
                                                                                                                                                                                                                                                                                                                                                                                    días'
                                                        : ' horas')
                                                    : ($favoritosTour['tipoDuracion'] == 0
                                                        ? ' día'
                                                        : ' hora') }}
                                            </span>
                                            <br>
                                            <span class="index_card_experiencias_ciudad_container">
                                                <i aria-hidden="true" class="fa-solid fa-location-dot text-yellow"></i>
                                                {{ $favoritosTour['estado_comercial'] }} ,
                                                {{ $favoritosTour['ciudad_comercial'] }}
                                            </span>
                                            <p class="tour-type-two__box__front__text mb-3">
                                                Desde: <br> <i aria-hidden="true"
                                                    class="fa-solid fa-dollar-sign text-yellow"></i>
                                                <strong>
                                                    {{ $favoritosTour['precioformato'] }}
                                                    {{ $favoritosTour['iso'] }}
                                                </strong>
                                            </p>
                                        </div>

                                        {{-- IMG --}}
                                        <div class="tour-type-two__box__front__image">
                                            <a aria-label="Más información de {{ $favoritosTour['nombre'] }}">
                                                <img src="{{ $favoritosTour['imagen'] }}"
                                                    alt="Imagen de {{ $favoritosTour['nombre'] }}">
                                            </a>
                                        </div>
                                    </div>
                                    {{-- BACK --}}
                                    <div class="tour-type-two__box__back">
                                        <div class="tour-type-two__box__back__image">
                                            <img src="{{ $favoritosTour['imagen'] }}"
                                                alt="Imagen de {{ $favoritosTour['nombre'] }}">
                                        </div>
                                        <div class="tour-type-two__box__back__content">
                                            <h5 class="tour-type-two__box__back__title" style="display: none">
                                                {{ $fn->recortar_cadena($favoritosTour['nombre'], 30) }}</h5>
                                            <p class="tour-type-two__box__back__text">
                                                {{ $favoritosTour['descripcion'] }}
                                            </p>
                                            <a aria-label="Más información de {{ $favoritosTour['nombre'] }}"
                                                href="{{ $favoritosTour['link'] }}"
                                                class="trevlo-btn trevlo-btn--base"><span>Ver
                                                    más</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- {{-- MAS EXP --}}
                        @if ($countOtrasExperiencias != null)
                            <section class="tour-listing-one contenedor-otras-exp"
                                style="background-image: url({{ asset('assets/images/backgrounds/tour-bg-1.jpg') }});">
                                <div class="container">
                                    {{-- TITULO --}}
                                    <div class="sec-title text-center">
                                        <p class="sec-title__tagline">Te puede interesar</p>
                                        <h2 class="sec-title__title">Más de nuestras experiencias</h2>
                                    </div>
                                    {{-- CARD --}}
                                    <div
                                        class="tour-listing-one__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav owl-theme owl-carousel">
                                        @foreach ($otrasExperiencias as $i => $experiencia)
    <div class="tour-listing-one__carousel-item item">
                                                <div class="tour-type-two__box">
                                                    <div class="tour-type-two__box__flipper">
                                                        {{-- FRONT --}}
                                                        <div class="tour-type-two__box__front">
                                                            {{-- PRICE --}}
                                                            <div class="price-exp">
                                                                <p class="tour-type-two__box__front__text mb-3">
                                                                    Desde: <br> <i aria-hidden="true"
                                                                        class="fa-solid fa-dollar-sign text-yellow"></i>
                                                                    <strong>
                                                                        {{ $experiencia['precioformato'] }}
                                                                        {{ $experiencia['iso'] }}
                                                                    </strong>
                                                                </p>
                                                            </div>
                                                            {{-- DETAILS --}}
                                                            <div class="details-exp">
                                                                <a aria-label="Más información de {{ $favoritosTour['nombre'] }}">
                                                                    <h5 class="tour-type-two__box__front__title">
                                                                        {{ $fn->recortar_cadena($experiencia['nombre'], 30) }}
                                                                    </h5>
                                                                </a>
                                                                <span>
                                                                    <i aria-hidden="true" class="fa-regular fa-clock text-yellow"></i>
                                                                    {{ $experiencia['cantidad_dias'] }}
                                                                    {{ $experiencia['cantidad_dias'] > 1
                                                                        ? ($experiencia['tipoDuracion'] == 0
                                                                            ? ' días'
                                                                            : ' horas')
                                                                        : ($experiencia['tipoDuracion'] == 0
                                                                            ? ' día'
                                                                            : ' hora') }}
                                                                </span>
                                                                <br>
                                                                <span>
                                                                    <i aria-hidden="true" class="fa-solid fa-location-dot text-yellow"></i>
                                                                    {{ $experiencia['estado_comercial'] }} ,
                                                                    {{ $experiencia['ciudad_comercial'] }}
                                                                </span>
                                                                <br>
                                                                <span class="blog-card-two__rm mb-2"><i aria-hidden="true"
                                                                        class="icon-right-arrow"></i>
                                                                </span>
                                                            </div>
                                                            {{-- IMG --}}
                                                            <div class="tour-type-two__box__front__image">
                                                                <a aria-label="Más información de {{ $favoritosTour['nombre'] }}">
                                                                    <img src="{{ $experiencia['imagen'] }}"
                                                                        alt="Imagen de {{ $experiencia['nombre'] }}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        {{-- BACK --}}
                                                        <div class="tour-type-two__box__back">
                                                            <div class="tour-type-two__box__back__image">
                                                                <img src="{{ $experiencia['imagen'] }}"
                                                                    alt="Imagen de {{ $experiencia['nombre'] }}">
                                                            </div>
                                                            <div class="tour-type-two__box__back__content">
                                                                <h5 class="tour-type-two__box__back__title">
                                                                    {{ $fn->recortar_cadena($experiencia['nombre'], 30) }}</h5>
                                                                <p class="tour-type-two__box__back__text">
                                                                    {{ $fn->recortar_cadena($experiencia['descripcion'], 100) }}
                                                                </p>
                                                                <br>
                                                                <a aria-label="Más información de {{ $experiencia['nombre'] }}"
                                                                    href="{{ $experiencia['link'] }}"
                                                                    class="trevlo-btn trevlo-btn--base"><span>Ver
                                                                        más</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif -->

    {{-- SECCION EXTRA --}}
    <section class="benefit-one">
        <div class="benefit-one__bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="benefit-one__content">
                        <div class="sec-title text-left">

                            <p class="sec-title__tagline">Viaja con los EXPERTOS </p>

                            <h2 class="sec-title__title">Atención personalizada 24/7 por agentes calificados </h2>
                        </div>
                        {{-- <h5 class="benefit-one__content__heading">Best ways to enjoy adventures</h5>
                        <p class="benefit-one__content__text">
                            There are many variations of passages of Lorem Ipsum simply free text available, but the
                            majority.
                        </p> --}}
                        <div class="benefit-one__box-wrapper">
                            <div class="benefit-one__box">
                                <div class="benefit-one__box__icon"><span class="icon-airplane-1"></span></div>
                                <h3 class="benefit-one__box__title">Reserva ahora y paga después </h3>
                            </div>
                            <div class="benefit-one__box">
                                <div class="benefit-one__box__icon"><span class="icon-ticket-1"></span></div>
                                <h3 class="benefit-one__box__title">Mejor precio garantizado </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="benefit-one__image"><img src="{{ asset('assets/images/benefit-1-1.webp') }}"
                            alt="trevlo">
                    </div>
                    <div class="benefit-one__counter">
                        <div class="benefit-one__counter__icon"><span class="icon-satisfied"></span></div>
                        <!-- /.counter__icon -->
                        <div class="benefit-one__counter__number count-box"><span class="count-text" data-stop="3800"
                                data-speed="1500"></span> </div><!-- /.counter__number -->
                        <p class="benefit-one__counter__title">Clientes satisfechos</p><!-- /.counter__title -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HOME CIVITATIS --}}
    @if ($civitatisHome['total'] > 0)
        <section class="bg_cuadros_verdes">
            <div class="destination-two container overflow_hiden ">
                <div class="row wow mt-3">
                    {{-- TITULO --}}
                    <div class="col-xl-4">
                        <div class="destination-two__content">
                            <div class="sec-title text-left">
                                <p class="sec-title__tagline">Lista de actividades</p>
                                <h2 class="sec-title__title">Explora las mejores actividades</h2>
                            </div>
                        </div>
                    </div>
                    {{-- CARD --}}
                    <div class="col-xl-8">
                        <div class="trevlo-stretch-element-inside-column civi">
                            <div
                                class="tour-listing-one__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav owl-theme owl-carousel">
                                @foreach ($civitatisHome['result'] as $i => $civitatiHome)
                                    <div class="item">
                                        <div class="destination-two__card">
                                            @if ($civitatiHome['tipo'] == 'destino')
                                                <div
                                                    class="destination-two__card-img-box destination-two__card-img-box--circle">
                                                    <img src="{{ $civitatiHome['foto'] }}"
                                                        alt="Imagen de {{ $civitatiHome['nombre'] }}"
                                                        class="destination-two__card-img destination-two__card-img--circle">
                                                    <div class="destination-two__card-btn">
                                                        <a aria-label="Ir a destino de actividad en {{ $civitatiHome['nombre'] }}"
                                                            href="tours-list?lang=es&nombreDestinoTour={{ $fn->stringToUrl($civitatiHome['nombre']) }}&idDestinoTour={{ $civitatiHome['id'] }}"
                                                            class="trevlo-btn trevlo-btn--base-three">
                                                            <span>Ver Destino</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="destination-two__card-title-box">
                                                    <h4 class="destination-two__card-title">
                                                        <a aria-label="Ir a destino de actividad en {{ $civitatiHome['nombre'] }}"
                                                            href="tours-list?lang=es&nombreDestinoTour={{ $fn->stringToUrl($civitatiHome['nombre']) }}&idDestinoTour={{ $civitatiHome['id'] }}">
                                                            {{ $civitatiHome['nombre'] }}
                                                        </a>
                                                    </h4>
                                                </div>
                                            @else
                                                <div
                                                    class="destination-two__card-img-box destination-two__card-img-box--circle">
                                                    <img src="{{ $civitatiHome['foto'] }}"
                                                        alt="{{ $civitatiHome['nombre'] }}"
                                                        class="destination-two__card-img destination-two__card-img--circle">
                                                    <div class="destination-two__card-btn">
                                                        <a aria-label="Ir a actividad {{ $civitatiHome['nombre'] }}"
                                                            href="actividad/{{ $fn->stringToUrl($civitatiHome['nombre']) }}/{{ $civitatiHome['id'] }}"
                                                            class="trevlo-btn trevlo-btn--base-three">
                                                            <span>Ver Actividad</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="destination-two__card-title-box">
                                                    <h4 class="destination-two__card-title">
                                                        <a aria-label="Ir a actividad {{ $civitatiHome['nombre'] }}"
                                                            href="actividad/{{ $fn->stringToUrl($civitatiHome['nombre']) }}/{{ $civitatiHome['id'] }}">
                                                            {{ $civitatiHome['nombre'] }}
                                                        </a>
                                                    </h4>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    {{-- HOME HOTEL --}}
    @if ($hotelesHomeData != null)
        <section class="bg_cuadros_verdes2">
            <div class="destination-two container overflow_hiden">
                <div class="row" {{-- style="flex-direction: row-reverse;" --}}>
                    {{-- TITULO --}}
                    <div class="col-xl-4">
                        <div class="destination-two__content">
                            <div class="sec-title text-left">
                                <p class="sec-title__tagline">Lista de Hoteles</p>
                                <h2 class="sec-title__title">Explora los mejores destinos hoteleros</h2>
                            </div>
                        </div>
                    </div>
                    {{-- CARD --}}
                    <div class="col-xl-8">
                        <div class="trevlo-stretch-element-inside-column civi">
                            <div
                                class="tour-listing-one__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav owl-theme owl-carousel">
                                @foreach ($hotelesHome['data'] as $i => $hotelFavorito)
                                    <div class="item">
                                        <div class="destination-two__card">
                                            <div
                                                class="destination-two__card-img-box destination-two__card-img-box--circle">
                                                <img src="https://app.bookingtrap.com/public/storage/{{ $hotelFavorito['imagen'] }}"
                                                    alt="Imagen de {{ $hotelFavorito['nombre_destino'] }}"
                                                    class="destination-two__card-img destination-two__card-img--circle">
                                                <div class="destination-two__card-btn">
                                                    <a aria-label="Ir a hoteles en {{ $hotelFavorito['nombre_destino'] }}"
                                                        href="hoteles-en/{{ $fn->stringToUrl($hotelFavorito['nombre_destino']) }}/{{ $hotelFavorito['id_region'] }}"
                                                        class="trevlo-btn trevlo-btn--base-three">
                                                        <span>Ver Destino</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="destination-two__card-title-box">
                                                <h4 class="destination-two__card-title">
                                                    <a aria-label="Ir a hoteles en {{ $hotelFavorito['nombre_destino'] }}"
                                                        href="hoteles-en/{{ $fn->stringToUrl($hotelFavorito['nombre_destino']) }}/{{ $hotelFavorito['id_region'] }}">
                                                        {{ $hotelFavorito['nombre_destino'] }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- HOME CIRCUITOS --}}
    @if ($hasImage)
        @if ($megaTravel != null)
            <section class=" bg_cuadros_verdes3">
                <div class="destination-two bg-megat container overflow_hiden">
                    <div id="civitatis_roww" class="row">
                        {{-- TITULO --}}
                        <div class="col-xl-4">
                            <div class="destination-two__content">
                                <div class="sec-title text-left">
                                    <p class="sec-title__tagline">Te asesoramos para viajar por todo el mundo </p>
                                    <h2 class="sec-title__title">¡Viaja por todo el mundo!</h2>
                                </div>
                            </div>
                        </div>
                        {{-- CARD --}}
                        <div class="col-xl-8">
                            <div class="trevlo-stretch-element-inside-column civi">
                                <div
                                    class="tour-listing-one__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav owl-theme owl-carousel">
                                    @foreach ($megaTravel as $i => $circuitoUni)
                                        <div class="item">
                                            <div class="destination-two__card">
                                                <div
                                                    class="destination-two__card-img-box destination-two__card-img-box--circle">
                                                    <img src="{{ $circuitoUni['imagen'] ?? asset('assets/images/imagen-404.webp') }}"
                                                        alt="Imagen de {{ $circuitoUni['nombre'] }}"
                                                        class="destination-two__card-img destination-two__card-img--circle">
                                                    <div class="destination-two__card-btn">
                                                        <a aria-label="Ir a circuitos en {{ $circuitoUni['nombre'] }}"
                                                            href="{{ route('circuitosTuristicos.entidad.entidad2.id', ['entidad' => $fn->reemplaza_espacios($circuitoUni['nombre']), 'entidad2' => urlencode($circuitoUni['nombre']), 'id' => $circuitoUni['id_destino']]) }}"
                                                            class="trevlo-btn trevlo-btn--base-three">
                                                            <span>Ver Destino</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="destination-two__card-title-box">
                                                    <h4 class="destination-two__card-title">
                                                        <aaria-label="Ir a circuitos en {{ $circuitoUni['nombre'] }}"
                                                        href="{{ route('circuitosTuristicos.entidad.entidad2.id', ['entidad' => $fn->reemplaza_espacios($circuitoUni['nombre']), 'entidad2' => urlencode($circuitoUni['nombre']), 'id' => $circuitoUni['id_destino']]) }}">
                                                        {{ $circuitoUni['nombre'] }}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    {{-- BLOG --}}
    @if ($articulosRecientes != null)
        <div class="blog-two">
            <div class="blog-two__bg trevlo-splax"
                data-para-options='{
                "orientation": "down",
                "scale": 1.5,
                "delay": ".3",
                "transition": "cubic-bezier(0,0,0,1)",
                "overflow": true
                }'>
            </div>
            <div class="container">
                {{-- TITULO --}}
                <div class="sec-title text-center">
                    <p class="sec-title__tagline">Artículos</p>
                    <h2 class="sec-title__title">Las últimas noticias & artículos<br> en nuestro blog</h2>
                </div>
                {{-- CARD --}}
                <div id="blog"
                    class="blog-two__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav owl-theme owl-carousel">
                    @foreach ($articulosRecientes as $b => $blog)
                        <div class="item">
                            <div class="blog-card-two">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-7">
                                        <div class="blog-card-two__content">
                                            <h3 class="blog-card-two__title">
                                                <a aria-label="Leer más de {{ $blog['titulo'] }}"
                                                    href="/blog/articulo/{{ $fn->stringToUrl($blog['titulo']) }}/{{ $blog['id'] }}">
                                                    {{ $fn->recortar_cadena($blog['titulo'], 30) }}
                                                </a>
                                            </h3>
                                            <p class="blog-cat">
                                                <i aria-hidden="true" class="fa-regular fa-bookmark"></i>
                                                {{ $blog['categoria'] }}
                                            </p>
                                            <p class="blog-card-two__text">
                                                {{ $fn->recortar_cadena($blog['descripcion'], 60) }}
                                            </p>
                                            <div class="blog-card-two__meta">
                                                <div class="blog-card-two__author">
                                                    <img src="{{ asset('cucapah/img/logo-cucapah.png') }}"
                                                        alt="User blog Cucapah">
                                                    <h5 class="blog-card-two__author__name">
                                                        <a aria-label="Leer más de {{ $blog['titulo'] }}"
                                                            href="/blog/articulo/{{ $fn->stringToUrl($blog['titulo']) }}/{{ $blog['id'] }}">
                                                            Por: {{ $blog['usuario'] }}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <a aria-label="Leer más de {{ $blog['titulo'] }}"
                                                    href="/blog/articulo/{{ $fn->stringToUrl($blog['titulo']) }}/{{ $blog['id'] }}"
                                                    class="blog-card-two__rm"><span class="icon-right-arrow"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <a aria-label="Leer más de {{ $blog['titulo'] }}"
                                            href="/blog/articulo/{{ $fn->stringToUrl($blog['titulo']) }}/{{ $blog['id'] }}"
                                            class="blog-card-two__image">
                                            <img src="{{ $blog['carrousel'] }}" alt="Imagen de {{ $blog['titulo'] }}">
                                            <div class="blog-card-two__image__overlay">
                                                <span class="fa-brands fa-readme"></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    {{-- REVIEWS --}}
    @if ($sitioweb[0]->snippet_reviews != null)
        <section class="counter-three mt-0 mb-0">
            <div class="counter-three__bg"
                style="background-image: url({{ asset('assets/images/shapes/counter-bg-3.png') }});">
            </div>
            <div class="counter-three__shape-top"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="sec-title text-center">
                            <p class="sec-title__tagline">Reseñas de clientes</p>
                            <h2 class="sec-title__title">¿Qué dicen nuestros clientes?</h2>
                        </div>
                        <div class="mt-5">
                            {!! $sitioweb[0]->snippet_reviews !!}
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="counter-three__shape-bottom"></div> --}}

        </section>
    @endif

    {{-- DISTINTIVOS --}}
    @if ($distintivos['total'] > 0)
        @include('web.partials.distintivos', ['distintivos' => $distintivos])
    @endif

    </section>




@endsection

@section('css')
    {{-- SPECIFIC CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- FANCY BOX --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        #myTabContent {
            position: relative;
        }

        #civitatis_row {
            flex-flow: row-reverse;
        }

        @media(max-width: 1199px) {
            #civitatis_row {
                flex-flow: column;
            }
        }

        /* .blog-card-two__rm{
                position: absolute;
                bottom: 0;
                right: 3px;
                z-index: 99;
            } */
        #fechas {
            background-color: #fff;
        }
        .nav-link.active {
            background: #ffffffc7 !important;
        }

        .trevlo-btn {
            background-color: #344fc875;
        }

        .trevlo-btn::after {
            background-color: var(--colorSecundario);
        }
    </style>
@endsection

@section('scripts')
    {{-- SPECIFIC SCRIPTS --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3/daterangepicker.min.js"></script>
    {{-- FANCY BOX --}}
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
        // TOOLTIP HAB
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    <script>
        // ---------- FECHAS ----------
        let today = moment().add(7, 'days').format("YYYY/MM/DD");
        let maxday = moment().add(730, 'days').format("YYYY/MM/DD");

        //Transportacion
        let todayTrans = moment().add(1, 'days').format("YYYY/MM/DD");

        $("#checkin").val(moment().add(7, 'days').format("YYYY-MM-DD"));
        $("#checkout").val(moment().add(8, 'days').format("YYYY-MM-DD"));

        //Transportacion
        $("#date_start").val(moment().add(5, 'days').format("YYYY-MM-DD"));
        $("#date_end").val(moment().add(6, 'days').format("YYYY-MM-DD"));

        if ($('#fechas').length > 0) {
            $('#fechas').daterangepicker({

                autoApply: true,
                opens: 'left',
                minDate: today,
                maxDate: maxday,
                maxSpan: {
                    "days": 30
                },
                startDate: today,
                endDate: moment().add(8, 'days').format("YYYY/MM/DD"),
                locale: {
                    applyLabel: "Aplicar",
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                $("#checkin").val(start.format('YYYY-MM-DD'));
                $("#checkout").val(end.format('YYYY-MM-DD'));
            });
        }

        // ---------- BUSCADOR HOTELERIA ----------
        $('#buscador1').select2({
            minimumInputLength: 3,
            dropdownPosition: 'below',
            allowClear: true,
            width: '100%',
            placeholder: "Destino / Hotel",
            language: "es",
            ajax: {
                url: '/buscar-hotel',
                delay: 150,
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                }
            },
            templateResult: formatStateHotels
        });
        $('#buscador1').on('select2:select', function(e) {
            var data = e.params.data;
            $("#nombreDestinoHotelero").val(data.text);
        });

        // ---------- ICONS MOTOR HOTEL ----------
        function formatStateHotels(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><i aria-hidden="true" style="color:#ffb11b" class="fa ' + state.icono + '"></i> ' + state.text +
                '</span>'
            );
            return $state;
        };

        // ---------- BUSCADOR CIVITATIS ----------
        $('#buscador2').select2({
            minimumInputLength: 3,
            dropdownPosition: 'below',
            allowClear: true,
            delay: 150,
            width: '100%',
            placeholder: 'Destino / Actividad',
            language: "es",
            templateResult: formatState,
            ajax: {
                url: '/buscar-tour',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
                    return query;

                }
            },

        });

        $('#buscador2').on('select2:select', function(e) {
            var data = e.params.data;
            $("#nombreDestinoTour").val(data.text);
        });

        // ---------- ICONS MOTOR CIVI ----------
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><i aria-hidden="true" style="color:#ffb11b" class="fa ' + state.icon + '"></i> ' + state.text +
                '</span>'
            );
            return $state;
        };

        // ---------- MENORES ----------
        function menoresEdadesPedrito(menores) {
            for (i = 1; i <= 4; i++) {
                if (i <= menores) {
                    $("#edad" + i).show();
                    $(`#edad${i} select`).removeAttr('disabled')
                } else {
                    $("#edad" + i).hide();
                    $(`#edad${i} select`).prop("disabled", true);
                }
            }
        }

        // ---------- TRANSPORTACION ----------
        $("#destinoTransporte").autocomplete({
            source: function(request, response) {
                $.ajax({
                    dataType: "json",
                    type: 'get',
                    data: {
                        search: request.term,
                    },
                    url: '/destination-transporte',
                    success: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                        response($.map(data, function(item) {
                            return {
                                label: item.text,
                                value: item.text,
                                id: item.id,
                                zona: item.zona
                            };
                        }));
                    },
                    error: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                    }
                });
            },
            minLength: 3,
            open: function() {
                $("#loadDestinoNames").hide();
            },
            close: function() {},
            focus: function(event, ui) {},
            search: function(event, ui) {
                $("#loadDestinoNames").show();
            },
            select: function(event, ui) {
                $("#nombreDestinoTransporte").val(ui.item.label);
                $("#idDestinoTransporte").val(ui.item.id);
                $("#idZonaDestino").val(ui.item.zona);
            }
        });

        $("#tipoServicio").on("change", function() {
            var servicio = $(this).val();
            if (parseInt(servicio) === 1) {
                $("#fechaRegreso").addClass("oculto");
            } else {
                $("#fechaRegreso").removeClass("oculto");
            }
        });

        $("#origenTransporte").autocomplete({
            source: function(request, response) {
                $.ajax({
                    dataType: "json",
                    type: 'get',
                    data: {
                        search: request.term,
                    },
                    url: '/destination-transporte',
                    success: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                        response($.map(data, function(item) {
                            return {
                                label: item.text,
                                value: item.text,
                                id: item.id,
                                zona: item.zona
                            };
                        }));
                    },
                    error: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                    }
                });
            },
            minLength: 3,
            open: function() {
                $("#loadOrigenNames").hide();
            },
            close: function() {},
            focus: function(event, ui) {},
            search: function(event, ui) {
                $("#loadOrigenNames").show();
            },
            select: function(event, ui) {
                $("#nombreOrigenTransporte").val(ui.item.label);
                $("#idOrigenTransporte").val(ui.item.id);
                $("#idZonaOrigen").val(ui.item.zona);
            }
        });

        $('#fechaSalida').daterangepicker({
            autoApply: true,
            opens: 'left',
            singleDatePicker: true,
            minDate: today,
            maxDate: maxday,
            maxSpan: {
                "days": 30
            },
            startDate: moment().add(2, 'days').format("YYYY/MM/DD"),
            locale: {
                applyLabel: "Aplicar",
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            $("#date_start").val(start.format('YYYY-MM-DD'));
            $("#date_end").val(end.format('YYYY-MM-DD'));
        });

        $('#fechaLlegada').daterangepicker({
            autoApply: true,
            opens: 'left',
            minDate: todayTrans,
            singleDatePicker: true,
            maxDate: maxday,
            maxSpan: {
                "days": 30
            },
            startDate: moment().add(1, 'days').format("YYYY/MM/DD"),
            locale: {
                applyLabel: "Aplicar",
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            $("#date_start").val(start.format('YYYY-MM-DD'));
            $("#date_end").val(end.format('YYYY-MM-DD'));

            $("#fechaSalida").data('daterangepicker').minDate = start;
            $("#fechaSalida").data('daterangepicker').startDate = start;
        });

        function verificarDestinos() {

            var nombreDestino = $("#nombreDestinoTransporte").val();
            var nombreOrigen = $("#nombreOrigenTransporte").val();

            if (nombreOrigen == nombreDestino) {
                $("#btn-transporte").prop('disabled', true);
                alert("El origen y destino no pueden ser iguales");
            } else {
                $("#btn-transporte").prop('disabled', false);
            }

        }
    </script>
@stop
