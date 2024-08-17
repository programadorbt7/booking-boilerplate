@extends('layouts.master')

@section('metaSEO')
    <title>Galería - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Cucapah visualiza todos las fotos de nuestros mejores tours y experiencias que tenemos para ofrecerte a para ti aqui mismo">
    <meta name="keywords" content="Galería">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('angie/img/banners/galeria.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Galería</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Galería</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- GALERIA --}}
    <div class="gallery-page section-space">
        @if ($countImagenes > 0)
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="cardHolder">
                            @foreach ($imagenes as $x => $imagen)
                                <a data-fancybox="gallery"
                                    href="https://app.bookingtrap.com/public/storage/{{ $imagen['archivo'] }}"
                                    class="image-link card-grid-popup">
                                    <img class="card-grid-popup2"
                                        src="https://app.bookingtrap.com/public/storage/{{ $imagen['archivo'] }}"
                                        alt="Galería Up Travel" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
                <div class="col-lg-12 col-12">
                    <h5 class="text-center">
                        No hay imagenes disponibles por el momento.
                    </h5>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('css')
    {{-- FANCY BOX --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endsection

@section('scripts')
    {{-- FANCY BOX --}}
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
    </script>
@endsection
