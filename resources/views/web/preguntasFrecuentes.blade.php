@extends('layouts.master')

@section('metaSEO')
    <title>Preguntas Frecuentes - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Contacta con nosotros mediante nuestro formulario de contacto para cualquier duda o pregunta a cerca de nuestros tours. Nos pondremos en contacto contigo lo más antes posible Cucapah.">
    <meta name="keywords"
        content="Contacto, Comunicarte, Atención, Comunicate, Envia un Correo, Mensaje, Clientes, Usuarios, Agencia, Cucapah">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('cucapah/img/preguntas.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Preguntas Frecuentes
            </h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Preguntas Frecuentes</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- MAIN --}}
    <section class="contact-page section-space-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <h4 class="text-center">Esta página esta en proceso, puedes visitarnos más tarde, gracias.</h4>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
@endsection