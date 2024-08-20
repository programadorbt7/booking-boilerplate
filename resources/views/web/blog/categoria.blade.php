@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp
@extends('layouts.master')

@section('metaSEO')
    <title>Blog en {{ ucfirst(str_replace(['-'], ' ', $nombreCategoria)) }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="Blog oficial de {{$nameEnterprise}}">
    <meta name="keywords"
        content="blog de {{$nameEnterprise}}, blog de viajes, viajar, blog, blogs, blog de {{$nameEnterprise}}, noticias de {{$nameEnterprise}}, viajes, aventuras, tours, lugares, ciudades, ciudad">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('angie/img/banners/cateblog.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Entérate de "{{ ucfirst(str_replace(['-'], ' ', $nombreCategoria)) }}"</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Blog</li>
                    <li>{{ ucfirst(str_replace(['-'], ' ', $nombreCategoria)) }}</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- MAIN --}}
    <div class="blog-list-page section-space">
        <div class="container">
            <div class="row">
                {{-- FILTROS --}}
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar-blog sidebar-blog--left">
                        <aside class="widget-area">
                            <div class="sidebar-blog__single sidebar-blog__single--categories wow animated fadeInUp"
                                data-wow-delay="0.2s" data-wow-duration="1500ms">
                                <h4 class="sidebar-blog__title">Categorías</h4>
                                <ul class="sidebar-blog__categories ">
                                    @foreach ($categoriasBlog as $categoria)
                                        <li>
                                            @if ($categoria['id'] == $idCategoria)
                                                <a style="color: var(--colorSecundario)" aria-label="Categoria"
                                                    href="/blog/categoria/{{ $fn->stringToUrl($categoria['nombre']) }}/{{ $categoria['id'] }}">
                                                @else
                                                    <a aria-label="Categoria"
                                                        href="/blog/categoria/{{ $fn->stringToUrl($categoria['nombre']) }}/{{ $categoria['id'] }}">
                                            @endif
                                            {{ $categoria['nombre'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
                {{-- LIST --}}
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-list__inner-container">
                        <div class="row gutter-y-50">
                            @if ($listaCategoriaArticulo['total'] > 0)
                                @foreach ($listaCategoriaArticulo['data'] as $articulo)
                                    <div class="blog-card-two">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-md-7">
                                                <div class="blog-card-two__content">
                                                    <h3 class="blog-card-two__title">
                                                        <a aria-label="Leer más de {{ $articulo['titulo'] }}"
                                                            href="/blog/articulo/{{ $fn->stringToUrl($articulo['titulo']) }}/{{ $articulo['id'] }}">
                                                            {{ $fn->recortar_cadena($articulo['titulo'], 30) }}
                                                        </a>
                                                    </h3>
                                                    <p class="blog-cat">
                                                        <i aria-hidden="true" class="fa-regular fa-bookmark"></i>
                                                        {{ $articulo['categoria'] }}
                                                    </p>
                                                    <p class="blog-card-two__text">
                                                        {{ $articulo['descripcion'] }}
                                                    </p>
                                                    <div class="blog-card-two__meta">
                                                        <div class="blog-card-two__author">
                                                            <img src="{{ asset('angie/img/logo.png') }}"
                                                                alt="User blog {{$nameEnterprise}}">
                                                            <h5 class="blog-card-two__author__name">
                                                                <a aria-label="Leer más de {{ $articulo['titulo'] }}"
                                                                    href="/blog/articulo/{{ $fn->stringToUrl($articulo['titulo']) }}/{{ $articulo['id'] }}">
                                                                    Por: {{ $articulo['usuario'] }}
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <a aria-label="Leer más de {{ $articulo['titulo'] }}"
                                                            href="/blog/articulo/{{ $fn->stringToUrl($articulo['titulo']) }}/{{ $articulo['id'] }}"
                                                            class="blog-card-two__rm"><span
                                                                class="icon-right-arrow"></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <a aria-label="Leer más de {{ $articulo['titulo'] }}"
                                                    href="/blog/articulo/{{ $fn->stringToUrl($articulo['titulo']) }}/{{ $articulo['id'] }}"
                                                    class="blog-card-two__image">
                                                    <img src="{{ $articulo['carrousel'] }}"
                                                        alt="Imagen de {{ $articulo['titulo'] }}">
                                                    <div class="blog-card-two__image__overlay">
                                                        <span class="fa-brands fa-readme"></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12 col-md-12 mt-5 mb-5 text-center">
                                    <h3>
                                        No hay artículos para esta categoría por ahora.
                                    </h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
