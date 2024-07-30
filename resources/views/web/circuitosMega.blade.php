@extends('layouts.master')

@section('metaSEO')
    <title>Circuitos - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('cucapah/img/mega.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Circuitos en <span>{{ urldecode($nombre) }}</span>
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
    <section class="contact-page section-space-top">
        <div class="container">
            <div class="row">
                {{-- INFO EMPRESA --}}
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar-blog sidebar-blog--left">
                        <aside class="widget-area">
                            <div class="sidebar-blog__single sidebar-blog__single--posts wow animated fadeInUp"
                                data-wow-delay="0.1s" data-wow-duration="1500ms">
                                <h4 class="sidebar-blog__title text-center">
                                    <img style="width: 150px" src="{{ asset('cucapah/img/logo-cucapah-mobile.webp') }}"
                                        alt="Logo Cucapah">
                                </h4>
                                <ul class="sidebar-blog__posts ">
                                    @if ($sitioweb[0]->email_publico != '')
                                        <li class="sidebar-blog__posts-item align-items-center">
                                            <div class="sidebar-blog__posts-image">
                                                <span class="icon icon-envelope"></span>
                                            </div>
                                            <div class="sidebar-blog__posts-content">
                                                <h4 class="sidebar-blog__posts-title" style="text-transform: lowercase;">
                                                    <a aria-label="Correo Electrónico"
                                                        href="mailto:{{ $sitioweb[0]->email_publico }}">
                                                        {{ $sitioweb[0]->email_publico }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($sitioweb[0]->telefono != '')
                                        <li class="sidebar-blog__posts-item align-items-center">
                                            <div class="sidebar-blog__posts-image">
                                                <span class="icon icon-phone-1"></span>
                                            </div>
                                            <div class="sidebar-blog__posts-content">
                                                <h4 class="sidebar-blog__posts-title">
                                                    <a aria-label="Número Telefónico"
                                                        href="tel:{{ $sitioweb[0]->telefono }}">
                                                        {{ $sitioweb[0]->telefono }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($sitioweb[0]->horario_atencion != '')
                                        <li class="sidebar-blog__posts-item align-items-center">
                                            <div class="sidebar-blog__posts-image">
                                                <span class="icon icon-clock-1"></span>
                                            </div>
                                            <div class="sidebar-blog__posts-content">
                                                <h4 class="sidebar-blog__posts-title">
                                                    {{ $sitioweb[0]->horario_atencion }}
                                                </h4>
                                            </div>
                                        </li>
                                    @endif
                                    <li class="sidebar-blog__posts-item align-items-center">
                                        <div class="sidebar-blog__posts-image">
                                            <span class="icon icon-location-1"></span>
                                        </div>
                                        <div class="sidebar-blog__posts-content">

                                            <h4 class="sidebar-blog__posts-title"> Quintana roo, Cancun Q.R.</h4>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
                {{-- FORM --}}
                <div class="col-xl-8 col-lg-7 pb-5">
                    <div class="sec-title text-center">
                        <p class="sec-title__tagline">{{ urldecode($nombre) }}</p>
                    </div>
                    <iframe src="{{ $imagen }}" frameborder="0" style="min-height: 500px; width: 100%"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
