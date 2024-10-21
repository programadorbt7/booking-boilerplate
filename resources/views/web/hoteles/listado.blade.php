@extends('layouts.master')

@section('metaSEO')
    <title>Hoteles en {{ $vars['nombreDestinoHotelero'] }} - {{ $nameEnterprise }} </title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- BTN FILTROS --}}
    <button id="navbtn2" onclick="openCloseNav()" type="button" class="btn btn-primary">
        <i aria-hidden="true" class="fa fa-filter" style="margin-left: -3px;"></i>
    </button>
    <script>
        var nombresHotels = [];
        var arrayTotalStars = [];
    </script>

    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('travezo/img/banners/hotels.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms"
                id="destinoHotelero">
                {{ $vars['nombreDestinoHotelero'] }}
            </h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>{{ $vars['nombreDestinoHotelero'] }}</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- MOTOR --}}
    @include('web.partials.motorHotelV2')

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
                                    Hotel</h3>
                                <br>
                                <div class="form-group">
                                    <div class="field-inner">
                                        <div class="d-flex">
                                            <input type="text" class="form-control textInput" name="nombreHotel"
                                                id="nombreHotel" onkeyup="filtrPorNombre(value)"
                                                placeholder="Nombre del Hotel" oninput="return cleanText()">
                                            <button class="img cleanText"><i aria-hidden="true"
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ESTRELLAS --}}
                            <div class="tour-listing-sidebar__amenities">
                                <h3 class="tour-listing-sidebar__title tour-listing-sidebar__amenities-title">Estrellas</h3>
                                <div class="tour-listing-sidebar__amenities-box" id="cantEstrellas">
                                </div>
                            </div>
                            {{-- ALIMENTO --}}
                            <div class="tour-listing-sidebar__amenities">
                                <h3 class="tour-listing-sidebar__title tour-listing-sidebar__amenities-title">Plan de
                                    Alimento</h3>
                                <div class="tour-listing-sidebar__amenities-box" id="planAlimentos">
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
                {{-- LIST --}}
                <div class="col-lg-8">
                    <div id="json" class="tour-listing-filter__row row">
                        {{-- COUNT & ORDER BY --}}
                        <div class="col-12" style="order: -9999999;">
                            <div class="showing-result tour-listing-one__showing-result">
                                <div class="showing-result__info-top">
                                    <div class="showing-result__text-box">
                                        <h3 class="showing-result__text"id="hotelesEncontrados">
                                            <span id="totalText">Cargando hoteles . . .</span>
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
                        {{-- CARD HOTEL --}}
                        <div class="row">
                            <div id='hotelCardSkeleton'>
                                <div class="row item-list">
                                    <div class="col-xs-12 col-sm-5 col-md-5 backgroundCoverHotel">
                                    </div>

                                    <div class="col-xs-12 col-sm-7 col-md-7">
                                        <div class="item-desc">
                                            <h5 class="item-title lineInfo">
                                            </h5>

                                            <div class=" d-inline-flex lineInfoSmall" style="font-size:13px;">
                                                <div></div>
                                            </div>
                                            <div class="sub-title lineInfoSmall"></div>

                                            <!-- CHECK IN Y CHECKOUT -->
                                            <div class="middle" style="margin: 14px 0;">
                                                <div class="lineInfoSmall"></div>
                                                <div class="lineInfoSmall"></div>
                                                <div class="lineInfoSmall"></div>
                                            </div>
                                        </div>

                                        <div class="item-book containerBtnPrice"
                                            style="display: flex; justify-content: space-between;">
                                            <div class="lineHeightLetters"></div>
                                            {{-- link ver habitaciones --}}
                                            <div class="btnContainerMain verHabitacionesLink"
                                                style="width: 130px; height: 34px; border-radius: 2px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/stylesFiltros.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/stylesLoadingHotel.css') }}">
@endsection

@section('scripts')
    {{-- SPECIFIC SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>

    {{-- SCRIPTS LAZY LOAD & MOTOR --}}
    <script>
        var taloe = 0;
        var motorDataAll;
        var arrayEdades;
        lazyload();

        window.onload = function() {
            update();
        };

        function dataBusquedaMotorSearch(data) {
            motorDataAll = data;
            return motorDataAll;
        }

        function update() {
            $("#buttonSearch").prop("disabled", true);
            let dataPay = {};

            let edadesArray = [];
            @if (isset($vars['edad']))
                @foreach ($vars['edad'] as $i => $edad)
                    edadesArray['{{ $i }}'] = '{{ $edad }}';
                @endforeach
            @endif

            let dataHotel = {};
            let destinoHotelero = $('#buscador1').val();
            let checkout = $('#checkout').val();
            let checkin = $('#checkin').val();
            let adultos = $('#adultos').val();
            let nombreDestinoHotelero = $('#nombreDestinoHotelero').val();
            let lang = '{{ $vars['lang'] }}';
            // let lang = $('#lang').val();
            let menores = $('#menores').val();

            arrayEdades = [];
            if (menores != 0) {
                // let edadesUni = document.getElementsByName('edad[]');
                const arraysInputsEdad = [...document.getElementsByName('edad[]')];

                for (let $i = 0; $i < arraysInputsEdad.length; $i++) {
                    if (!arraysInputsEdad[$i].disabled) {
                        let inputValueEdad = arraysInputsEdad[$i].value;
                        console.log('adentro del for');
                        if (inputValueEdad != '') {
                            arrayEdades.push(inputValueEdad);
                        } else {
                            arrayEdades.push(0);
                        }
                    }
                }
                console.log(arrayEdades);
            } else {
                arrayEdades = 0;
            }

            //Daniel Dev Http request -> Js Native
            dataHotel.lang = '{{ $vars['lang'] }}';
            // dataHotel.nombreDestinoHotelero = nombreDestinoHotelero;
            dataHotel.nombreDestinoHotelero = getValueTextOptions();
            dataHotel.destinoHotelero = destinoHotelero;
            dataHotel.checkin = checkin;
            dataHotel.checkout = checkout;
            dataHotel.adultos = adultos;
            dataHotel.menores = menores;
            dataHotel.edad = arrayEdades;

            dataBusquedaMotorSearch(dataHotel);
            if (!parseInt(destinoHotelero)) {
                let newUrlDetailsHotel = urlRequestHotelUnic();
                return location.replace(newUrlDetailsHotel);
            }

            //Daniel Dev Http request -> Laravel Native
            dataPay.lang = '{{ $vars['lang'] }}';
            dataPay.nombreDestinoHotelero = '{{ $vars['nombreDestinoHotelero'] }}';
            dataPay.destinoHotelero = '{{ $vars['destinoHotelero'] }}';
            dataPay.checkin = '{{ $vars['checkin'] }}';
            dataPay.checkout = '{{ $vars['checkout'] }}';
            dataPay.adultos = '{{ $vars['adultos'] }}';
            dataPay.menores = '{{ $vars['menores'] }}';
            dataPay.edad = edadesArray;
            arrayEdades = null;

            let dataPayJson = JSON.stringify(dataHotel);
            // let dataPayJson = JSON.stringify(dataPay);
            // return console.log(dataPayJson);
            var formDataPay = {
                _token: "{{ csrf_token() }}",
                data: dataPayJson,
            };

            $.ajax({
                    method: "GET",
                    url: "hotels-list-ajax",
                    data: formDataPay,
                    dataType: "json",
                    statusCode: {
                        500: function(xhr) {
                            // if (window.console) console.log(xhr.responseText);
                        }
                    }
                })
                .done(function(e) {
                    console.log('adentro de la respuesta del ajax');
                    // console.log(e);
                    var total = e.length;
                    console.log(e[e.length - 1]);
                    console.log('Total');
                    console.log(total);
                    // console.log(e[e(slice-1)]);
                    for (let i in e) {
                        sum = i * 1000;
                        escribir(e[i]);
                        if ((e.length - 1) == i) {
                            getEstrellas();
                            var countHotels33 = getCountHotels(e[i]);
                            $("#buttonSearch").prop("disabled", false);
                        }
                    }

                    $("#nombreHotel").autocomplete('option', 'source', nombresHotels);
                })
                .fail(function() {
                    console.log('error 500');
                    $("#hotelCardSkeleton").empty();
                    let nombreDestinnoHotelero = nombreDestinoHotelero;
                    let contenedorHtml = $('#json');
                    let totalText = $('#totalText');
                    let fila =
                        `<div><h4 class="text-center mb-4">Lo sentimos no pudimos encontrar algun resultado, no hay hoteles disponibles en ${nombreDestinnoHotelero}.</h4></div>`;
                    contenedorHtml.append(fila);
                    $("#buttonSearch").prop("disabled", false);
                    totalText.text('0 Hoteles encontrados');
                });
        }

        //Contamos la cantidad de Hoteles en el Penultimo item y Obtenemos el valor total
        function getCountHotels(count) {
            for (let i in count) {
                if ((count.length - 1) == i) {
                    taloe = count[i]["filtros"]["hotelesCount"];
                    console.log('count' + taloe);
                    if (taloe != 1) {
                        $('#totalText').html(`Se encontraron ${taloe} hoteles`);
                    } else {
                        $('#totalText').html(`Se encontro ${taloe} hotel`);
                    }
                }
            }
            return taloe;
        }

        //Obtenemos los parametros de la URL para poder crear la nueva version del linkV2 al hotel
        function motorData() {
            const valores = window.location.search;

            //Creamos la instancia
            const urlParams = new URLSearchParams(valores);

            //Accedemos a los valores
            let nombreDestinoHotelero = urlParams.get('nombreDestinoHotelero');
            let destinoHotelero = urlParams.get('destinoHotelero');
            let checkin = urlParams.get('checkin');
            let checkout = urlParams.get('checkout');
            let adultos = urlParams.get('adultos');
            let menores = urlParams.get('menores');

            let edades = [];
            @if (isset($vars['edad']))
                @foreach ($vars['edad'] as $i => $edad)
                    edades['{{ $i }}'] = '{{ $edad }}';
                @endforeach
            @endif

            let dataSearchMotor = [];
            dataSearchMotor.push(nombreDestinoHotelero, destinoHotelero, checkin, checkout, adultos, menores, edades);

            return dataSearchMotor;
        }

        function capitalize(text) {
            const firstLetter = text.charAt(0);
            const rest = text.slice(1);
            return firstLetter.toUpperCase() + rest;
        }

        async function escribirFiltro() {
            console.log("Escribimos fltro");
        }

        async function escribir(e) {

            let dataBusqueda = motorData();
            var total = e.length;
            var countGlobal = 0;

            for (let i in e) {
                if (e[i]["filtros"] !== undefined) {
                    //Filtro de alimentos:
                    alimentos = e[i]["filtros"]["filtrosMeals"]
                    for (let a in alimentos) {
                        let f = a.toLowerCase();
                        $("#planAlimentos")
                            .append(
                                `<li style="margin: 0.5rem; list-style: none;"><input class="form-check-input" type="checkbox" value="meal_${f.replace(/ /g, "-")}"> ${a} <span class="float-end iconCountdates">(${alimentos[a]})</span></li>`
                            );
                    }

                    //Filtro de estrellas
                    estrellas = e[i]["filtros"]["filtrosStars"]
                    for (let es in estrellas) {
                        estrellasTxt = '';

                        estrellasTxt += es >= 1 ?
                            '<span class="text-yellow"><i aria-hidden="true" class="fa fa-star"></i>' :
                            '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
                        estrellasTxt += es >= 2 ?
                            '<span class="text-yellow"><i aria-hidden="true" class="fa fa-star"></i>' :
                            '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
                        estrellasTxt += es >= 3 ?
                            '<span class="text-yellow"><i aria-hidden="true" class="fa fa-star"></i>' :
                            '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
                        estrellasTxt += es >= 4 ?
                            '<span class="text-yellow"><i aria-hidden="true" class="fa fa-star"></i>' :
                            '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
                        estrellasTxt += es >= 5 ?
                            '<span class="text-yellow"><i aria-hidden="true" class="fa fa-star"></i>' :
                            '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';

                        $("#cantEstrellas")
                            .append(
                                `<li style="margin: 0.5rem; list-style: none;"><input class="form-check-input" type="checkbox" value="stars_${es}"> ${estrellasTxt} <span class="float-end text-muted"> (${estrellas[es]})</span></li>`
                            );
                    }
                    countGlobal++;
                } else {

                    if (e[i]["allotment"] != null) {

                        let habitacionesD = e[i]["allotment"] > 1 ? e[i]["allotment"] + ' habitaciones disponibles' :
                            '1 habitación disponible';

                        var countHotels = e[i]["hotelesCount"];
                        const {
                            adultos,
                            checkin,
                            checkout,
                            destinoHotelero,
                            edad,
                            lang,
                            menores,
                            nombreDestinnoHotelero
                        } = motorDataAll;

                        if (menores > 0) {
                            edades = edad;
                        } else {
                            edades = 'cero';
                        }

                        let linkV3Hotel =
                            `/${e[i]["linkV2"]}/${checkin}/${checkout}/${adultos}/${edades}/${e[i]["filtroTotalPublico"]}/${e[i]["resindency"]}/${e[i]["markup"]}/`;

                        var fila = `
                                    <div class="col-12 filaHotel stars_${e[i]["stars"]} meal_${e[i]["filtroMeal"]} ${e[i]["idhotel"]}" data-length="${i}" data-price="${e[i]["filtroTotalPublico"]}" data-posicion="">
                                        <div class="tour-listing-three__card tour-listing__card">
                                            {{-- IMG --}}
                                            <a aria-label="Ver detalles del hotel "${e[i]["hotelName"]}" href="${linkV3Hotel}"
                                                class="tour-listing-three__card-image-box tour-listing__card-image-box">
                                                <img class="lazyload" data-src="${e[i]["imgLink"]}"
                                                    alt="imagen de ${e[i]["hotelName"]}"
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
                                                    <a
                                                        href="${linkV3Hotel}">
                                                        ${e[i]["hotelName"]}
                                                    </a>
                                                </h3>
                                                {{-- DESCRIPCION --}}
                                                <p class="tour-listing__card-text text-small">
                                                    <br>
                                                    <ul style="list-style: none;">
                                                        <li>
                                                            <i aria-hidden="true" class="fa-solid fa-circle-info"></i> ${habitacionesD}
                                                        </li>
                                                        <li>
                                                            <i aria-hidden="true" class="fa-solid fa-door-open"></i> Checkin: ${e[i]["checkin"]} | Checkout: ${e[i]["checkout"]}
                                                        </li>
                                                        <li>
                                                            <i aria-hidden="true" class="fa-solid fa-bed"></i> ${e[i]["room_name"]}
                                                        </li>
                                                        <li>
                                                            <i aria-hidden="true" class="fa-solid fa-utensils"></i> ${e[i]["meal"]}
                                                        </li>
                                                    </ul>
                                                </p>
                                                {{-- CAJA --}}
                                                <div
                                                    class="tour-listing-three__card-inner-content tour-listing__card-inner-content">
                                                    {{-- TOP --}}
                                                    <div class="tour-listing-three__card-top-content">
                                                        <div class="tour-listing__card-review-box">
                                                            {{-- ESTRELLAS --}}
                                                            <p class="tour-listing__card-review-text text-small">
                                                                <i aria-hidden="true" class="${e[i]["stars"] >= 1 ? 'text-yellow' : 'text-muted'} fa fa-star"></i>
                                                                <i aria-hidden="true" class="${e[i]["stars"] >= 2 ? 'text-yellow' : 'text-muted'} fa fa-star"></i>
                                                                <i aria-hidden="true" class="${e[i]["stars"] >= 3 ? 'text-yellow' : 'text-muted'} fa fa-star"></i>
                                                                <i aria-hidden="true" class="${e[i]["stars"] >= 4 ? 'text-yellow' : 'text-muted'} fa fa-star"></i>
                                                                <i aria-hidden="true" class="${e[i]["stars"] >= 5 ? 'text-yellow' : 'text-muted'} fa fa-star"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    {{-- LINEA DIVISORA --}}
                                                    <div class="tour-listing-three__card-divider tour-listing__card-divider">
                                                    </div>
                                                    {{-- BTN --}}
                                                    <div class="tour-listing__card-bottom">
                                                        <div class="tour-listing__card-bottom-left">
                                                            <div class="tour-listing__card-day">
                                                                <span class="icon-location-1"></span>
                                                                <p class="tour-listing__card-location-text text-small">
                                                                    ${e[i]["direccion"]}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="tour-listing__card-bottom-right">
                                                            <h4 class="tour-listing__card-price">
                                                                <small>Desde</small> $ ${e[i]["totalPublico"]} ${e[i]["monedaSeleccionada"]}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a aria-label="Ver detalles del hotel "${e[i]["hotelName"]}"
                                                            href="${linkV3Hotel}"
                                                            class="mt-4 float-end trevlo-btn trevlo-btn--base"><span>Ver más</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    `;

                        $("#hotelCardSkeleton").empty();
                        $("#json").append(fila);

                        lazyload();
                    } else {
                        $('#totalText').html(`Se encontro ${countGlobal} hotel`);
                    }
                }

                //Daniel
                nombresHotels.push({
                    "value": e[i]["hotelName"],
                    "label": e[i]["hotelName"],
                    "buscar": e[i]["idhotel"]
                });

            }
        }

        // console.log('fuera del ajax');
        let dataSS = motorData();
        $("#checkin").val(dataSS[2]);
        $("#checkout").val(dataSS[3]);

        function openCloseNav() {
            document.getElementById("filtros-nav").classList.toggle("active-nav");
        }

        $("#filtros-nav").add(document).scroll(function() {
            document.querySelector("#ui-id-1").style.display = "none";
        });

        (function($) {
            console.log('document-$');
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
                    // $("#filtroresultados").show();
                    for (let i = 0; i < sortArray.length; i++) {
                        $(el).filter(`[${attr}="${sortArray[i]}"]`).css("order", sign + sortArray[i]);
                    }
                    // const myTimeout = setTimeout(quitarFiltro, 1500);
                }

                return $select;
            };
        })(jQuery);

        function getEstrellas() {
            console.log('getEstrellas');
            $(".form-check-input").click(function() {
                console.log('click');
                let filtros = [];
                $(".form-check-input").each(function() {
                    if ($(this).is(':checked')) {
                        let valor = $(this).val();
                        filtros.push(valor);
                    }
                });
                FiltrarResultados(filtros);
            });
        }

        //Funciones de filtros
        function FiltrarResultados(filtros) {
            $("#nombreHotel").val('');
            let hotelesEncontrados = parseInt(taloe);
            $('#hotelesEncontrados').data('total', taloe);
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
                    $("#hotelesEncontrados").html(filtrados + " hotel filtrado de " + hotelesEncontrados +
                        " hoteles encontrados");
                } else {
                    $("#hotelesEncontrados").html(filtrados + " hoteles filtrados de " + hotelesEncontrados +
                        " hoteles encontrados");
                }

            } else {
                $(".filaHotel").show();
                $("#hotelesEncontrados").html("Se encontraron " + hotelesEncontrados + " hoteles");
            }
        }

        function filtrarPorHotel(hotelName) {
            let hotelesEncontrados = parseInt($("#hotelesEncontrados").data("total"));
            $(".form-check-input").each(function() {
                $(this).prop("checked", false)
            });

            $(".filaHotel").show();
            $(".filaHotel").not('.' + hotelName).hide();

            $("#hotelesEncontrados").html("1 hotel filtrado de " + hotelesEncontrados + " hoteles encontrados");
        }

        function filtrPorNombre(hotel) {
            if (hotel === '') {
                $(".filaHotel").show();
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#popularidad").numericFlexboxSorting();

            console.log('document-ready');
            $(".form-check-input").click(function() {
                console.log('click');
                let filtros = [];
                $(".form-check-input").each(function() {
                    if ($(this).is(':checked')) {
                        let valor = $(this).val();
                        filtros.push(valor);
                    }
                });
                FiltrarResultados(filtros);
            });


            $("#nombreHotel").autocomplete({
                minLength: 3,
                classes: {
                    "ui-autocomplete": "listaHotelNames"
                },
                source: nombresHotels,
                select: function(event, ui) {
                    var label = ui.item.label;
                    var value = ui.item.value;
                    var buscar = ui.item.buscar;
                    filtrarPorHotel(buscar);
                }
            });
        });

        $(document).on("scroll", function() {
            var sv = $(document).scrollTop();
            // console.log(sv);
        });

        let today =
            @if (isset($checkinDate))
                '{{ $checkin }}'
            @else
                moment().add(5, 'days').format("YYYY/MM/DD")
            @endif ;
        let todayEnd =
            @if (isset($checkoutDate))
                '{{ $checkout }}'
            @else
                moment().add(6, 'days').format("YYYY/MM/DD")
            @endif ;
        let maxday = moment().add(730, 'days').format("YYYY/MM/DD");

        $('#fechas').daterangepicker({
            autoApply: true,
            opens: 'left',
            minDate: today,
            maxDate: maxday,
            maxSpan: {
                "days": 30
            },
            startDate: '{{ $vars['checkin'] }}',
            endDate: '{{ $vars['checkout'] }}',
            locale: {
                applyLabel: "Aplicar",
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            $("#checkin").val(start.format('YYYY-MM-DD'));
            $("#checkout").val(end.format('YYYY-MM-DD'));
        });

        $('#buscador1').select2({
            minimumInputLength: 3,
            dropdownPosition: 'below',
            allowClear: true,
            width: 'resolve',
            // placeholder: "Lugar",
            language: "es",
            ajax: {
                url: '/buscar-hotel',
                delay: 150,
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                }
            },
            templateResult: formatStateHotels
        });
        $('#buscador1').on('select2:select', function(e) {
            var data = e.params.data;
            $("#nombreDestinoHotelero").val(data.text);
            $("#buscador1").val(data.id);

        });

        function formatStateHotels(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><i style="color:#ffb11b" class="fa ' + state.icono + '"></i> ' + state.text + '</span>'
            );
            return $state;
        };

        function menoresEdadesPedrito(menores) {
            for (i = 1; i <= 4; i++) {
                if (i <= menores) {
                    $("#edad" + i).show();
                    $(`#edad${i} select`).removeAttr('disabled')
                } else {
                    $("#edad" + i).hide();
                    $(`#edad${i} select`).prop("disabled", true);
                    $(`#edad${i} select`).val(0);
                }
            }
        }

        menoresEdadesPedrito($('#menores').val());

        function openCloseNav() {
            document.getElementById("filtros-nav").classList.toggle("active-nav");
        }
        $("#filtros-nav").add(document).scroll(function() {
            document.querySelector("#ui-id-1").style.display = "none";
        });

        const resetInformationHoteleria = () => {
            constructSkeleton();
            $("#json").empty();
            $('#totalText').text('Cargando Hoteles . . .');
            $("#cantEstrellas").empty();
            $("#planAlimentos").empty();
            addInformationHoteleria();
        }

        const addInformationHoteleria = () => {
            let htmlCount = `
                            <div class="col-12" style="order: -9999999;">
                                <div class="showing-result tour-listing-one__showing-result">
                                    <div class="showing-result__info-top">
                                        <div class="showing-result__text-box">
                                            <h3 class="showing-result__text"id="hotelesEncontrados">
                                                <span id="totalText">Cargando hoteles . . .</span>
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
                            <div class="row"><div id='hotelCardSkeleton'></div></div>
                                `;
            $("#json").append(htmlCount);
            $("#popularidad").numericFlexboxSorting();
        }

        const getHoteleria = () => {
            nombresHotels = [];
            resetInformationHoteleria();
            constructSkeleton();
            update();
            modifityURLGetNewRequest(motorDataAll);
        };

        const constructSkeleton = () => {
            let hotelSkeleton = `
                            <div class="row item-list">
                                <div class="col-xs-12 col-sm-5 col-md-5 backgroundCoverHotel">
                                </div>
                                <div class="col-xs-12 col-sm-7 col-md-7">
                                    <div class="item-desc">
                                        <h5 class="item-title lineInfo">
                                        </h5>

                                        <div class=" d-inline-flex lineInfoSmall" style="font-size:13px;">
                                            <div></div>
                                        </div>
                                        <div class="sub-title lineInfoSmall"></div>

                                        <!-- CHECK IN Y CHECKOUT -->
                                        <div class="middle" style="margin: 14px 0;">
                                            <div class="lineInfoSmall"></div>
                                            <div class="lineInfoSmall"></div>
                                            <div class="lineInfoSmall"></div>
                                        </div>
                                    </div>

                                    {{-- <div class="item-book" style="display: flex; justify-content: space-around;">
                                        <div class="lineInfo" style="width: 30%;"></div>
                                        <div class="lineInfo" style="width: 30%;"></div>
                                    </div> --}}

                                    <div class="item-book containerBtnPrice" style="display: flex; justify-content: space-between;">
                                        <div class="lineHeightLetters"></div>
                                        {{-- link ver habitaciones --}}
                                        <div class="btnContainerMain verHabitacionesLink" style="width: 130px; height: 34px; border-radius: 2px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
            $("#hotelCardSkeleton").append(hotelSkeleton);
        }

        const modifityURLGetNewRequest = (motorDataAll) => {
            const {
                adultos,
                checkin,
                checkout,
                destinoHotelero,
                edad,
                lang,
                menores,
                nombreDestinoHotelero
            } = motorDataAll;
            const urlHostName = window.location.origin;
            const url = new URL(`${urlHostName}/hotels-list?`);
            const nombreDestinoHoteleroSelect = $('#select2-buscador1-container').text();

            getValueTextOptions();
            // getUpdateDataDOM(nombreDestinoHotelero);
            getUpdateDataDOM(nombreDestinoHoteleroSelect);

            let menoresUrl;
            let langV2 = $('#lang').val();
            url.searchParams.append('lang', langV2);
            // url.searchParams.append('nombreDestinoHotelero', nombreDestinoHotelero);
            url.searchParams.append('nombreDestinoHotelero', nombreDestinoHoteleroSelect);
            url.searchParams.append('destinoHotelero', destinoHotelero);
            url.searchParams.append('checkin', checkin);
            url.searchParams.append('checkout', checkout);
            url.searchParams.append('adultos', adultos);

            if (menores > 0) {
                url.searchParams.append('menores', menores);
                for ($i = 0; $i < menores; $i++) {
                    url.searchParams.append('edad[]', edad[$i]);
                    menoresUrl = menores;
                }
            } else {
                url.searchParams.append('menores', 0);
            }

            const numberOfEntries = history.length;
            history.pushState(null, "", url);
        }

        const getValueTextOptions = () => {
            const countOptions = document.getElementById('buscador1').options.length;
            for ($i = 0; $i <= countOptions; $i++) {
                if ($i == countOptions) {
                    let indice = $i - 1;
                    let option = document.getElementById('buscador1').options[indice];
                    let optionText = document.getElementById('buscador1').options[indice].innerText;
                    // console.log('Result:' + option + optionText);
                    // console.log($i);
                    // $('#destinoHotelero').text('Hospédate en ' + optionText);

                    // Daniel Dev
                    let nombreDestinoHoteleroSelect = $('#select2-buscador1-container').text();
                    $('#destinoHotelero').text('Hospédate en ' + nombreDestinoHoteleroSelect);
                    return optionText;
                }
            }
        }

        const getUpdateDataDOM = (nombreDestinoHotelero) => {
            document.querySelector('title').innerText = nombreDestinoHotelero + ' - {{ $nameEnterprise }}';
        }
        const urlRequestHotelUnic = () => {
            const {
                adultos,
                checkin,
                checkout,
                destinoHotelero,
                edad,
                lang,
                menores,
                nombreDestinoHotelero
            } = motorDataAll;
            const urlHostName = window.location.origin;
            const residency = 'MX';
            const comisionHoteleria = '{{ $sitioweb[0]->comision_hoteleria }}';
            const hotelDetails = `echo $fn->stringToUrl(<script type="text/JavaScript">nombreDestinoHotelero</script)`;
            const hotelLinkDetailsName = nombreDestinoHotelero;
            let hotelLinkDetailsUrlName = hotelLinkDetailsName.replaceAll(' ', '-');
            hotelLinkDetailsUrlName = hotelLinkDetailsUrlName.replaceAll('ú', 'u');

            if (menores > 0) {
                edades = edad;
            } else {
                edades = 'cero';
            }
            let url = new URL(
                `${urlHostName}/hotel/${hotelLinkDetailsUrlName}/${destinoHotelero}/${checkin}/${checkout}/${adultos}/${edades}/0/${residency}/${comisionHoteleria}`
            );
            return url;
        }
    </script>
@stop
