@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp

@extends('layouts.master')
@section('metaSEO')
    <title>{{ ucfirst($nombreDestino) }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- BTN FILTROS --}}
    <button id="navbtn2" onclick="openCloseNav()" type="button" class="btn btn-primary">
        <i aria-hidden="true" class="fa fa-filter" style="margin-left: -3px;"></i>
    </button>
    <script>
        var nombreTours = [];
    </script>
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('angie/img/banners/civitatis.webp') }}); background-position: center;"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Actividades en {{ ucfirst($nombreDestino) }}
            </h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Actividades</li>
                    <li>{{ ucfirst($nombreDestino) }}</li>
                </ul>
            </div>
        </div>
    </section>
    {{-- MOTOR --}}
    @include('web.partials.motorTour')
    {{-- MAIN --}}
    <section class="tour-listing-style tour-listing section-space">
        <div class="container">
            <div class="row">
                {{-- FILTROS --}}
                <div class="col-lg-4">
                    <aside id="filtros-nav" class="tour-listing-sidebar">
                        <div class="tour-listing-sidebar__form tour-listing-sidebar__item wow animated fadeInUp"
                            data-wow-delay="0.1s" data-wow-duration="1500ms">
                            {{-- NOMBRE TOUR --}}
                            <div class="tour-listing-sidebar__price-ranger">
                                <h3 class="tour-listing-sidebar__title tour-listing-sidebar__price-ranger-title">Nombre
                                    Actividad</h3>
                                <br>
                                <div class="form-group">
                                    <div class="field-inner">
                                        <div class="d-flex">
                                            <input type="text" class="form-control textInput" name="nombreTour"
                                                id="nombreTour" onkeyup="filtrPorNombre(value)"
                                                placeholder="Nombre del tour" oninput="return cleanText()">
                                            <button class="img cleanText"><i aria-hidden="true"
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- TIPO ACT --}}
                            <div class="tour-listing-sidebar__amenities">
                                <h3 class="tour-listing-sidebar__title tour-listing-sidebar__amenities-title">Tipo de
                                    Actividad</h3>
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
                                            Mostrando <strong>{{ $count }}</strong> actividades encontradas
                                        </h3>
                                    </div>
                                    <div class="showing-result__sort">
                                        <select id="popularidad" class="form-control">
                                            <option data-sort="length:asc">Popularidad</option>
                                            <option data-sort="price:asc">Precio (bajo a alto)</option>
                                            <option data-sort="price:desc">Precio (alto a bajo)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- CARDS --}}
                        <div class="row">
                            @foreach ($civitatisActividades as $i => $actividad)
                                @php
                                    $categoriaTour = $fn->reemplaza_espacios($actividad['category']['description']);
                                    $arrayTipoTours[] = $actividad['category']['description'];
                                @endphp
                                <div class="col-12 filaHotel {{ $fn->stringToUrl($categoriaTour) }} {{ $fn->stringToUrl($actividad['title']) }}"
                                    data-length="{{ $i }}" data-price="{{ ceil($actividad['minimumPrice']) }}">
                                    <div class="tour-listing-three__card tour-listing__card">
                                        {{-- IMG --}}
                                        <a aria-label="Actividad"
                                            href="actividad/{{ $fn->stringToUrl($actividad['title']) }}/{{ $actividad['id'] }}"
                                            class="tour-listing-three__card-image-box tour-listing__card-image-box">
                                            <img src="{{ $actividad['photos']['gallery'][0]['paths']['original'] ?? asset('assets/images/imagen-404.webp') }}"
                                                alt="Imagen de {{ $actividad['title'] }}"
                                                class="tour-listing-three__card-image tour-listing__card-image"
                                                style="height: 100%; width: 100%; object-fit: cover;">
                                            <div
                                                class="tour-listing-three__card-image-overlay tour-listing__card-image-overlay">
                                            </div>
                                        </a>
                                        {{-- INFO --}}
                                        <div class="tour-listing-three__card-content tour-listing__card-content">
                                            {{-- TITULO --}}
                                            <h3 class="tour-listing-three__card-title tour-listing__card-title">
                                                <a aria-label="actividad"
                                                    href="actividad/{{ $fn->stringToUrl($actividad['title']) }}/{{ $actividad['id'] }}">
                                                    {{ $actividad['title'] }}
                                                </a>
                                            </h3>
                                            {{-- DESCRIPCION --}}
                                            <p class="tour-listing__card-text text-small">
                                                {!! $actividad['raw_description'] !!}
                                            </p>
                                            {{-- CAJA --}}
                                            <div
                                                class="tour-listing-three__card-inner-content tour-listing__card-inner-content">
                                                {{-- TOP --}}
                                                <div class="tour-listing-three__card-top-content">
                                                    <div class="tour-listing__card-review-box">
                                                        <span class="icon-star"></span>
                                                        <p class="tour-listing__card-review-text text-small">
                                                            {{ $actividad['score'] < 5 ? '8' : $actividad['score'] }}/10
                                                            {{ $actividad['score'] <= 7 ? 'Bueno' : 'Excelente' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- LINEA DIVISORA --}}
                                                <div class="tour-listing-three__card-divider tour-listing__card-divider">
                                                </div>
                                                {{-- BTM --}}
                                                <div class="tour-listing__card-bottom">
                                                    <div class="tour-listing__card-bottom-left">
                                                        <div class="tour-listing__card-day">
                                                            @if ($actividad['duration']['duration'] / 60 > 24)
                                                                @php
                                                                    $horas = $actividad['duration']['duration'] / 60;
                                                                    $dias = $horas / 24;
                                                                @endphp
                                                                <span class="icon-calendar-5"></span>
                                                                <p class="tour-listing__card-day-text text-small">
                                                                    Duración {{ $dias }}
                                                                    {{ $dias > 1 ? 'días' : 'día' }}
                                                                </p>
                                                            @else
                                                                <span class="icon-clock-1"></span>
                                                                <p class="tour-listing__card-day-text text-small">
                                                                    Duración
                                                                    {{ ceil($actividad['duration']['duration'] / 60) }}
                                                                    {{ $actividad['duration']['duration'] / 60 > 1 ? 'Horas' : 'Hora' }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="tour-listing__card-people">
                                                            <span class="icon-Duration"></span>
                                                            <p class="tour-listing__card-people-text text-small">
                                                                {{ $actividad['reviews'] }}
                                                                {{ $actividad['reviews'] > 1 ? 'Reseñas' : 'Reseña' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="tour-listing__card-bottom-right">
                                                        <h4 class="tour-listing__card-price">
                                                            <small>Desde</small>
                                                            $
                                                            {{ $fn->tarifaPublicaAgenciasTours($actividad['minimumPrice'], $markup) }}
                                                            {{ $actividad['currency'] }}
                                                        </h4>
                                                    </div>
                                                </div>
                                                <a aria-label="Ver detalles de actividad  {{ $actividad['title'] }}"
                                                    href="actividad/{{ $fn->stringToUrl($actividad['title']) }}/{{ $actividad['id'] }}"
                                                    class="mt-4 float-end trevlo-btn trevlo-btn--base"><span>Ver
                                                        más</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    nombreTours.push({
                                        "value": "<?php echo $actividad['title']; ?>",
                                        "label": "<?php echo $actividad['title']; ?>",
                                        "buscar": "<?php echo $fn->stringToUrl($actividad['title']); ?>"
                                    });
                                </script>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/stylesFiltros.css') }}">
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>
    <script>
        $("#nombreDestinoTour").val('{{ $nombreDestino }}');

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
                    elToSort: ".filaHotel"
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
            $("#popularidad").numericFlexboxSorting();

            @php
                asort($arrayTipoTours);
                $filtrosTipoTours = array_count_values($arrayTipoTours);
            @endphp

            @foreach ($filtrosTipoTours as $filtroTourName => $filtroTourCount)
                $("#tipoTour").append(
                    '<li style="margin: 0.5rem; list-style: none;"><input class="form-check-input" type="checkbox" value="{{ $fn->stringToUrl($filtroTourName) }}"> {{ $filtroTourName }} <span class="iconCountdates" style="float: right;">({{ $filtroTourCount }})</span></li>'
                );
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

        function filtrarPorTour(tourName) {
            let toursEncontrados = parseInt($("#toursEncontrados").data("total"));
            $(".form-check-input").each(function() {
                $(this).prop("checked", false)
            });

            $(".filaHotel").show();
            $(".filaHotel").not('.' + tourName).hide();

            $("#toursEncontrados").html("1 tour filtrado de " + toursEncontrados + " tours encontrados");
        }

        function filtrPorNombre(tour) {
            if (tour === '') {
                $(".filaHotel").show();
            }
        }

        function FiltrarResultados(filtros) {
            $("#nombreTour").val('');
            let toursEncontrados = parseInt($("#toursEncontrados").data("total"));
            let cfiltros = filtros.length;
            let filtrados = 0;
            if (cfiltros > 0) {
                $(".filaHotel").each(function() {
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
                $(".filaHotel").show();
                $("#toursEncontrados").html("Se encontraron " + toursEncontrados + " tours");
            }

        }
        // BUSQUEDA CIVITATIS
        $('#buscador2').select2({
            minimumInputLength: 3,
            dropdownPosition: 'below',
            allowClear: true,
            delay: 150,
            width: '100%',
            placeholder: 'Zona/Actividad',
            language: 'es',
            templateResult: formatState,
            ajax: {
                url: '/buscar-tour',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
                    return query;

                }
            },

        });

        $('#buscador2').on('select2:select', function(e) {
            var data = e.params.data;
            $("#nombreDestinoTour").val(data.text);
        });
        // ICONS MOTOR
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            if (state.icon == "fa-map-marker-alt") state.icon = "fa-map-marker-alt"
            if (state.icon == "fa-hiking") state.icon = "fa-hiking"
            var $state = $(
                '<span><i style="color:#ffb11b" class="fas ' + state.icon + '"></i> ' + state.text + '</span>'
            );
            return $state;
        };
    </script>
@stop
