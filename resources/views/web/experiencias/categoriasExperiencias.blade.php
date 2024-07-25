@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp
@extends('layouts.master')

@section('metaSEO')
    <title>{{ ucfirst(str_replace(['-'], ' ', $categoria)) }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- BTN FILTROS --}}
    <button id="navbtn2" onclick="openCloseNav()" type="button" class="btn btn-primary">
        <i aria-hidden="true" class="fa fa-filter" style="margin-left: -3px;"></i>
    </button>

    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('cucapah/img/categoriasexpe.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Experiencias en
                <span>{{ ucfirst(str_replace(['-'], ' ', $categoria)) }}</span>
            </h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Experiencias</li>
                    <li>{{ ucfirst(str_replace(['-'], ' ', $categoria)) }}</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- MAIN --}}
    <section class="tour-type-two">
        <div class="container">
            <div class="row">
                {{-- FILTROS --}}
                <div class="col-lg-4">
                    <aside id="filtros-nav" class="tour-listing-sidebar">
                        <div class="tour-listing-sidebar__form tour-listing-sidebar__item wow animated fadeInUp"
                            data-wow-delay="0.1s" data-wow-duration="1500ms">
                            {{-- Países --}}
                            @if ($isFiltroGeografico == true)
                                <div class="tour-listing-sidebar__amenities">
                                    <h3 class="tour-listing-sidebar__title tour-listing-sidebar__amenities-title">
                                        Países
                                    </h3>
                                    <div class="tour-listing-sidebar__amenities-box" id="geograficoTour">
                                    </div>
                                </div>
                            @endif
                            {{-- Tipo --}}
                            <div class="tour-listing-sidebar__amenities">
                                <h3 class="tour-listing-sidebar__title tour-listing-sidebar__amenities-title">
                                    Tipos
                                </h3>
                                <div class="tour-listing-sidebar__amenities-box" id="tipoTour">
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
                {{-- LIST --}}
                <div class="col-lg-8">
                    <div class="tour-listing-filter__row row">
                        {{-- COUNT & ORDER BY --}}
                        <div class="col-12">
                            <div class="showing-result tour-listing-one__showing-result">
                                <div class="showing-result__info-top">
                                    <div class="showing-result__text-box">
                                        <h3 class="showing-result__text" id="toursEncontrados"
                                            data-total="{{ $count }}">
                                            Mostrando <strong>{{ $count }}</strong> experiencias encontradas
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- CARDS --}}
                        <div class="row">
                            @if ($count > 0)
                                @foreach ($experienciasList as $i => $experiencia)
                                    @php
                                        $estadoExperiencias = $fn->reemplaza_espacios($experiencia['estado_comercial']);
                                        $paisExperiencias = $fn->reemplaza_espacios($experiencia['nombrepais']);
                                        $tipoExperiencias = $fn->reemplaza_espacios($experiencia['tipoexcursion']);
                                    @endphp
                                    <div class="col-lg-12 col-md-12 wow fadeInUp filaTour geografico_{{ $fn->eliminar_acentos($paisExperiencias) }} geografico_{{ $fn->eliminar_acentos($estadoExperiencias) }} tipo_{{ $fn->eliminar_acentos($tipoExperiencias) }}"
                                        data-length="{{ $i }}" data-posicion="" data-wow-delay="100ms">
                                        <div class="tour-type-two__box">
                                            <div class="tour-type-two__box__flipper">
                                                {{-- FRONT --}}
                                                <div class="tour-type-two__box__front">
                                                    <span class="blog-card-two__rm mb-2"><i aria-hidden="true" class="icon-right-arrow"></i></span>
                                                    {{-- PRICE --}}
                                                    <div class="price-exp correcion-nopromocion-23">
                                                        <a aria-label="Más información de {{ $experiencia['nombre'] }}"
                                                            href="/{{ $experiencia['link'] }}">
                                                            <h5 class="tour-type-two__box__front__title">
                                                                {{ $experiencia['nombre'] }}
                                                            </h5>
                                                        </a>
                                                    </div>
                                                    {{-- DETAILS --}}
                                                    <div class="details-exp">
                                                        <span>
                                                            <i aria-hidden="true"
                                                                class="fa-regular fa-clock text-yellow"></i>
                                                            {{ $experiencia['cantidad_dias'] }}
                                                            {{ $experiencia['cantidad_dias'] > 1 ? ($experiencia['tipoDuracion'] == 0 ? ' días' : ' horas') : ($experiencia['tipoDuracion'] == 0 ? ' día' : ' hora') }}
                                                        </span>
                                                        <br>
                                                        <span class="index_card_experiencias_ciudad_container">
                                                            <i aria-hidden="true"
                                                                class="fa-solid fa-location-dot text-yellow"></i>
                                                            {{ $experiencia['estado_comercial'] }} ,
                                                            {{ $experiencia['ciudad_comercial'] }}
                                                        </span>
                                                        <p class="tour-type-two__box__front__text mb-3">
                                                            Desde: <br> <i aria-hidden="true"
                                                                class="fa-solid fa-dollar-sign text-yellow"></i>
                                                            <strong>
                                                                {{ $experiencia['precioformato'] }}
                                                                {{ $experiencia['iso'] }}
                                                            </strong>
                                                        </p>
                                                    </div>
                                                    {{-- IMG --}}
                                                    <div class="tour-type-two__box__front__image">
                                                        <a aria-label="Más información de {{ $experiencia['nombre'] }}"
                                                            href="/{{ $experiencia['link'] }}">
                                                            <img src="{{ $experiencia['imagen'] }}"
                                                                alt="Imagen de {{ $experiencia['nombre'] }}">
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- BACK --}}
                                                <div class="tour-type-two__box__back">
                                                    <div class="tour-type-two__box__back__image">
                                                        <img src="{{ $experiencia['imagen'] }}"
                                                            alt="Imagen de {{ $experiencia['nombre'] }}">
                                                    </div>
                                                    <div class="tour-type-two__box__back__content">
                                                        {{-- <h5 class="tour-type-two__box__back__title">
                                                            {{ $experiencia['nombre'] }}</h5> --}}
                                                        <p class="tour-type-two__box__back__text">
                                                            {{ $experiencia['descripcion'] }}
                                                        </p>
                                                        <br>
                                                        <a aria-label="Más información de {{ $experiencia['nombre'] }}"
                                                            href="/{{ $experiencia['link'] }}"
                                                            class="trevlo-btn trevlo-btn--base"><span>Ver más</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-lg-12">
                                    <h5 class="text-center">
                                        Por el momento no hay experiencias disponibles, inténtelo más tarde</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/stylesFiltros.css') }}">
    <style>
    .row {
    --bs-gutter-y: 0 !important;
    --bs-gutter-x: 30px;
    }
    .tour-type-two__box__front__title{
            margin-right: 70px;
        }
        .blog-card-two__rm{
            margin-top: 20px;
        }
        .index_card_experiencias_ciudad_container{
            margin-bottom: 40px;
            margin-top: 17px;
        }

        @media(max-width:767px){
            .tour-type-two__box__front__title{
                margin-right: 50px;
            }
            .index_card_experiencias_ciudad_container{
                margin-bottom: 10px;
                margin-top: 10px;
            }
        }
        @media(max-width:425px){
            .tour-type-two__box__front__title{
                margin-right: 30px;
            }
        }
        @media(max-width:375px){
            .tour-type-two__box__front__title{
                margin-right: 20px;
            }
        }
        @media(max-width:320px){
            .tour-type-two__box__front__title{
                margin-right: 10px;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        //Ocultar filtros
        function openCloseNav() {
            document.getElementById("filtros-nav").classList.toggle("active-nav");
        }

        function removeAddBody(e) {
            if (!document.querySelector("#filtros-nav").contains(e.target)) {
                document.getElementById("filtros-nav").classList.toggle("active-nav");
                document.querySelector(".wrapper").removeEventListener('click', removeAddBody);
                console.log(e.target)
            }
        }

        $("#filtros-nav").add(document).scroll(function() {
            document.querySelector("#ui-id-1").style.display = "none"
        });




        (function($) {
            "use strict";
            $.fn.numericFlexboxSorting = function(options) {
                const settings = $.extend({
                    elToSort: ".filaTour"
                }, options);

                const $select = this;
                const ascOrder = (a, b) => a - b;
                const descOrder = (a, b) => b - a;

                $select.on("change", () => {
                    const selectedOption = $select.find("option:selected").attr(
                        "data-sort"); //tipo de orden
                    // console.log("tipo de orden enviado: "+selectedOption); (Ej: price:asc)
                    sortColumns(settings.elToSort, selectedOption);
                });

                function sortColumns(el, opt) {
                    //Filas que se afectaran, tipo de orden
                    const optArr = opt.split(":");
                    const attr = "data-" + opt.split(":")[0];
                    const sortMethod = (opt.includes("asc")) ? ascOrder : descOrder;
                    const sign = (opt.includes("asc")) ? "" : "-";
                    const sortArray = $(el).map((i, el) => $(el).attr(attr)).sort(sortMethod);
                    for (let i = 0; i < sortArray.length; i++) {
                        $(el).filter(`[${attr}="${sortArray[i]}"]`).css("order", sign + sortArray[i]);
                    }
                }

                return $select;
            };
        })(jQuery);

        $(document).ready(function() {


            // inicia filtro tours

            @php
                $filtrosGeograficoTours = array_count_values($geograficoExperiencias);
                $filtrosTipoTours = array_count_values($tiposExperiencias);
            @endphp
            @php $n = 0; @endphp
            @foreach ($filtrosGeograficoTours as $filtroTourName => $filtroTourCount)
                $("#geograficoTour").append(
                    '<li style="margin: 0.5rem; list-style: none;"><input class="form-check-input" type="checkbox" value="geografico_{{ $fn->stringToUrl($filtroTourName) }}"> {{ $filtroTourName }} <span class="iconCountdates" style="float: right;">({{ $conteoGeograficoExperiencia[$n] }})</span></li>'
                );
                @php $n++; @endphp
            @endforeach

            @php $n = 0; @endphp
            @foreach ($filtrosTipoTours as $filtroTourName => $filtroTourCount)
                $("#tipoTour").append(
                    '<li style="margin: 0.5rem; list-style: none;"><input class="form-check-input" type="checkbox" value="tipo_{{ $fn->stringToUrl($filtroTourName) }}"> {{ $filtroTourName }} <span class="iconCountdates" style="float: right;">({{ $conteoTipoExperiencia[$n] }})</span></li>'
                );
                @php $n++; @endphp
            @endforeach

            $(".form-check-input").click(function() {
                let filtros = [];
                $(".form-check-input").each(function() {
                    if ($(this).is(':checked')) {
                        let valor = $(this).val();
                        filtros.push(valor);
                    }
                });
                FiltrarResultados(filtros);
            });
            //Ocultar filtros
            $("#nombreTour").autocomplete({
                minLength: 3,
                classes: {
                    "ui-autocomplete": "listaHotelNames"
                },
                source: nombreTours,
                select: function(event, ui) {
                    $("#filtros-nav").removeClass("active-nav");
                    var label = ui.item.label;
                    var value = ui.item.value;
                    var buscar = ui.item.buscar;
                    filtrarPorTour(buscar);
                }
            });
        });

        function FiltrarResultados(filtros) {
            $("#nombreTour").val('');
            let toursEncontrados = parseInt($("#toursEncontrados").data("total"));
            let cfiltros = filtros.length;
            let filtrados = 0;
            if (cfiltros > 0) {
                $(".filaTour").each(function() {
                    let elem = $(this);
                    var elemento = elem.attr("class");

                    for (i = 0; i < cfiltros; i++) {
                        let filtro = filtros[i];
                        if (elem.hasClass(filtro)) {
                            elem.show();
                            filtrados++;
                            break;
                        } else {
                            elem.hide();
                        }
                    }
                });
                if (filtrados === 1) {
                    $("#toursEncontrados").html(filtrados + " tour filtrado de " + toursEncontrados + " tours encontrados");
                } else {
                    $("#toursEncontrados").html(filtrados + " tours filtrados de " + toursEncontrados +
                        " tours encontrados");
                }

            } else {
                $(".filaTour").show();
                $("#toursEncontrados").html("Se encontraron " + toursEncontrados + " tours");
            }

        }
    </script>
@stop
