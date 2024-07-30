@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp
@extends('layouts.master')

@section('metaSEO')
    <title>Blog - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('cucapah/img/categoriablog.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Entérate de lo último</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Blog</li>
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
                                            <a aria-label="Categoria"
                                                href="/blog/categoria/{{ $fn->stringToUrl($categoria['nombre']) }}/{{ $categoria['id'] }}">
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
                            @foreach ($blogs as $blog)
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
                                                    {{ $blog['descripcion'] }}
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
