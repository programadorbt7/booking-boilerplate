@extends('layouts.master')

@section('metaSEO')
    <title>Ofertas Megatravel  - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Descubre emocionantes tours internacionales. Explora el mundo con nosotros.">
    <meta name="keywords" content="tours internacionales, viajes al extranjero, destinos turísticos, Circuitos MegaTravel, reservas de tours, experiencias de viaje">
@endsection

@section('contenido-principal')
{{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('angie/img/banners/ofertas.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Todas las ofertas disponibles</span>
            </h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Circuitos</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- MAIN --}}
    <section class="contact-page py-5">
        <div class="container-fluid">
            <div class="row">
                {{-- FORM --}}
                <div class="col-12">
                  <iframe class="w-100" src="https://www.megatravel.com.mx/tools/ofertas-viaje.php?Dest=&txtColor=1D1D1D&lblTPaq=9900FF&lblTRange=570090&lblNumRange=9900FF&itemBack=D5D5D5&ItemHov=360058&txtColorHov=ffffff&ff=1" width="800" height="1200" border="0" align="center" allowtransparency="true" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection