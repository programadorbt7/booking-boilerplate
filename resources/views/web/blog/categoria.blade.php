@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp
@extends('layouts.master')

@section('metaSEO')
    <title>Blog en {{ ucfirst(str_replace(['-'], ' ', $nombreCategoria)) }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="Blog oficial de {{ $nameEnterprise }}">
    <meta name="keywords"
        content="blog de {{ $nameEnterprise }}, blog de viajes, viajar, blog, blogs, blog de {{ $nameEnterprise }}, noticias de {{ $nameEnterprise }}, viajes, aventuras, tours, lugares, ciudades, ciudad">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('travezo/img/banners/cateblog.webp') }})"></div>
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
                                    <div class="row mt-7">
                                        <div class="preview-card">
                                            <div class="preview-card__wrp">
                                                <div class="preview-card__item">
                                                    <a
                                                        href="/blog/articulo/{{ $fn->stringToUrl($articulo['titulo']) }}/{{ $articulo['id'] }}">
                                                        <div class="preview-card__img">
                                                            <img src="{{ $articulo['carrousel'] }}"
                                                                alt="{{ $articulo['titulo'] }}">
                                                        </div>
                                                    </a>
                                                    <div class="preview-card__content">
                                                        <span class="preview-card__code">{{ $articulo['usuario'] }}</span>
                                                        <div class="preview-card__title">{{ $articulo['titulo'] }}</div>
                                                        <div class="preview-card__text">
                                                            {{ $fn->recortar_cadena($articulo['descripcion'], 100) }}</div>
                                                        <a href="/blog/articulo/{{ $fn->stringToUrl($articulo['titulo']) }}/{{ $articulo['id'] }}"
                                                            class="preview-card__button">Leer Articulo</a>
                                                    </div>
                                                </div>

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
