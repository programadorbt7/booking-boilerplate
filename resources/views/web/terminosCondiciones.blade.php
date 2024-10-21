@extends('layouts.master')

@section('metaSEO')
    <title>Terminos Y Condiciones - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Lee nuestros términos y condiciones antes de tomar uno de nuestros tours con nosotros. Aquí encontrarás toda la información importante que necesitas conocer.">
    <meta name="keywords" content="Terminos, Condiciones, Angencia de Viajes, Tours, Experiencias, Conoce, {{$nameEnterprise}}">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('travezo/img/banners/terminos.webp') }})">
        </div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Términos y
                Condiciones</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Términos y Condiciones</li>
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
                        <h3 class="tour-listing-details__title tour-listing-details__overview-title"></h3>
                    </div>
                    <p class="tour-listing-details__overview-text wow animated fadeInUp" data-wow-delay="0.1s"
                        data-wow-duration="1500ms">
                        {!! $terminosCondiciones !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
