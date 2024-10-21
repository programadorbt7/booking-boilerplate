@extends('layouts.master')

@section('metaSEO')
    <title>{{ $detalleArticuloInformation['titulo'] }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="{{ $detalleArticuloInformation['description'] }}">
    <meta name="keywords" content="{{ $detalleArticuloInformation['keywords'] }}">
    <meta property="og:image" content="{{ $detalleArticuloInformation['slide'] }}">
@endsection

@section('contenido-principal')
    <section class="page-header blog-banner">
        <div class="page-header__bg" style="background-image: url({{ $detalleArticuloInformation['slide'] }})"></div>
    </section>

    {{-- MAIN --}}
    <div class="blog-details-page section-space-top">
        <div class="container">
            <div class="blog-details-page__row row">

                {{-- DESCRIPCION --}}
                <div class="col-lg-12">
                    <div class="blog-details">
                        <div class="blog-card-three">
                            <div class="blog__card">
                                <div class="blog__card-content wow animated fadeInUp" data-wow-delay="0.1s"
                                    data-wow-duration="1500ms">
                                    <h3 class="blog__card-title">
                                        {{ $detalleArticuloInformation['titulo'] }}
                                    </h3>
                                    <ul class="blog__card-meta">
                                        <li>
                                            <span class="blog__card-meta-icon icon-user"></span>
                                            <span class="blog__card-meta-author">
                                                Autor: {{ $detalleArticuloInformation['usuario'] }}
                                            </span>
                                        </li>
                                        <li>
                                            <span class="blog__card-meta-icon icon-calendar-5"></span>
                                            <span class="blog__card-meta-author">
                                                Fecha: {{ $detalleArticuloInformation['fecha'] }}
                                            </span>
                                        </li>
                                        <li>
                                            <span class="blog__card-meta-icon fa-regular fa-bookmark"></span>
                                            <span class="blog__card-meta-author">
                                                Categoria: {{ $detalleArticuloInformation['categoria'] }}
                                            </span>
                                        </li>
                                    </ul>
                                    <p class="blog__card-text">
                                        {!! $detalleArticuloInformation['descripcion'] !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pdg" style="margin: 20px 0;">
                        <div class="text-center d-flex-shared">
                            <h4>Compartir en:</h4>
                            <ul class="social-icons-2">
                                <li> <a href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}" target="_blank"
                                        class="fab fa-facebook"></a> </li>

                                <li> <a href="https://twitter.com/intent/tweet?text={{ $detalleArticuloInformation['titulo'] }}&url={{ request()->url() }}&hashtags={{ $detalleArticuloInformation['categoria'] }}" target="_blank"
                                        class="fab fa-twitter"></a> </li>

                                <li> <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ request()->url() }}" target="_blank"
                                        class="fab fa-linkedin"></a> </li>

                                <li> <a href="https://api.whatsapp.com/send?text={{ $detalleArticuloInformation['titulo'] }} {{ request()->url() }}"
                                        target="_blank" class="fab fa-whatsapp"></a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- GALERIA --}}
                <div id="blog-gallery" class="row justify-content-center">
                    <div
                        class="{{ $detalleArticuloInformation['video'] != '' || $detalleArticuloInformation['video'] != null ? 'col-lg-6' : 'col-lg-8' }}">
                        <div class="tour-listing-details__slider">
                            <div
                                class="tour-listing-details__carousel trevlo-owl__carousel trevlo-owl__carousel--basic-nav owl-theme owl-carousel">
                                @foreach ($detalleArticulo['imagenes'] as $imagenArt)
                                    <div class="tour-listing-details__carousel-item item">
                                        <div class="tour-listing-details__carousel-image-box">
                                            <a data-fancybox="gallery" href="{{ asset($imagenArt['imagen']) }}">
                                                <img class="tour-listing-details__carousel-image"
                                                    src="{{ asset($imagenArt['imagen']) }}"
                                                    alt="Imagen de {{ $detalleArticuloInformation['titulo'] }}">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if ($detalleArticuloInformation['video'] != '' || $detalleArticuloInformation['video'] != null)
                        <div class="col-lg-6">
                            <iframe class="video-exp"
                                src="https://www.youtube.com/embed/{{ $detalleArticuloInformation['video'] }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@section('css')
    {{-- FANCY BOX --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .d-flex-shared {
        display: flex;
        align-items: center;
        justify-content: end;
        margin-right: 20px;
        flex-wrap: wrap;
    }

    .d-flex-shared .social-icons-2 {
        margin: 0;
    }

    .d-flex-shared ul {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
        margin: 0;
        padding: 0;
        font-size: 25px;
    }

    .d-flex-shared ul li {
        margin-left: 15px;
    }
    </style>
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
