@extends('layouts.master')

@section('metaSEO')
    <title>Aviso De Privacidad - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Tu privacidad es fundamental para nosotros. por ello, te invitamos a leer nuestra política de privacidad para conocer cómo protegemos tus datos mientras conoces cada uno de nuestros tours.">
    <meta name="keywords"
        content="Privacidad, Tours, Funtastic, Política, Viajes, Vuelos, Lugares, Avisos del Viaje, Condiciones del Viaje, Responsabilidad, Acuerdo legal, Información Importante, Reglas de Viaje">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('cucapah/img/aviso.webp')}})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Aviso de
                Privacidad</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Aviso de privacidad</li>
                </ul>
            </div>
        </div>
    </section>
    {{-- MAIN --}}
    <div class="container mt-5">
        <div class="tour-listing-details__row row">
            <div class="col-xl-12">
                <div class="tour-listing-details__overview">
                    <div class="wow animated fadeIn" data-wow-delay="0.1s" data-wow-duration="1500ms">
                        <h3 class="tour-listing-details__title tour-listing-details__overview-title">
                        </h3>
                    </div>
                    <p class="tour-listing-details__overview-text wow animated fadeInUp" data-wow-delay="0.1s"
                        data-wow-duration="1500ms">
                        {!!$avisoPrivacidad!!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
