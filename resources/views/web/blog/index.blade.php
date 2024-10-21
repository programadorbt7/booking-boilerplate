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
        <div class="page-header__bg" style="background-image: url({{ asset('travezo/img/banners/blog.webp') }})"></div>
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
                                <div class="row mt-7">
                                    <div class="preview-card">
                                        <div class="preview-card__wrp">
                                            <div class="preview-card__item">
                                                <a
                                                    href="/blog/articulo/{{ $fn->stringToUrl($blog['titulo']) }}/{{ $blog['id'] }}">
                                                    <div class="preview-card__img">
                                                        <img src="{{ $blog['carrousel'] }}" alt="{{ $blog['titulo'] }}">
                                                    </div>
                                                </a>
                                                <div class="preview-card__content">
                                                    <span class="preview-card__code">{{ $blog['usuario'] }}</span>
                                                    <div class="preview-card__title">{{ $blog['titulo'] }}</div>
                                                    <div class="preview-card__text">
                                                        {{ $fn->recortar_cadena($blog['descripcion'], 100) }}</div>
                                                    <a href="/blog/articulo/{{ $fn->stringToUrl($blog['titulo']) }}/{{ $blog['id'] }}"
                                                        class="preview-card__button">Leer Articulo</a>
                                                </div>
                                            </div>

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
