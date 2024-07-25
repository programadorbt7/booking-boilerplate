@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp

@extends('layouts.master')

@section('metaSEO')
    <title>Transportación - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('assets/images/transporte.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Transportación
            </h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Transporte</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- MOTOR --}}
    @include('web.partials.motorTransportacionMV1')

    {{-- LIST --}}
    <section>
        <div style="margin: 5rem auto;">
            @if ($transportacionLista != null)
                @foreach ($transportacionLista as $transporte)
                    <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s" style="width: 100%;">
                        <div class="row row__Container__Unidad">
                            <div class="col-lg-4 col-md-4 position-relative" style="padding: 0;">
                                <div class="img_list imgHeight ">
                                    <a class="a__Img__Container"
                                        href="datos-compra-trans?tra={{ $fn->codificaUrl($transporte['linkSencillo']) }}">
                                        <img src="{{ $transporte['linkImg'] }}" alt="{{ $transporte['modelo'] }}"
                                            style="object-fit: cover; width: 100%;">
                                        {{-- <div class="short_info"></div> --}}
                                    </a>

                                    <div class="capacidad container__Information__paxs">
                                        <div class="container__icons__Transportation">
                                            <i aria-hidden="true" class="fas fa-users"></i>
                                            <span class="text-center">Pax máx: {{ $transporte['pasaje_max'] }}</span>
                                        </div>
                                        <div class="container__icons__Transportation">
                                            <i aria-hidden="true" class="fas fa-suitcase"></i>
                                            <span class="text-center">Maletas máx: {{ $transporte['maletas'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 pt-3 pt-xl-0 pt-lg-0 pt-md-0 px-0 px-lg-4 px-xl-4 px-md-4">
                                <div class="tour_list_desc container__table__info">
                                    <ul class="list_ok listServicesCont d-flex justify-content-around m-0 check__models"
                                        style="flex-wrap: wrap">
                                        <li><b>Servicio {{ $transporte['nombreServicio'] }}</b></li>
                                        <li><i aria-hidden="true" class="fas fa-check"></i> {{ $transporte['marca'] }} </li>
                                        <li><i aria-hidden="true" class="fas fa-check"></i> {{ $transporte['modelo'] }}
                                        </li>
                                        <li><i aria-hidden="true" class="fas fa-check"></i>
                                            {{ $transporte['tiposervicio'] }}
                                        </li>
                                    </ul>
                                    <div class="container__Table__Main">
                                        <table class="table m-0">
                                            <tbody>
                                                <tr style="border-bottom: 1px solid black;">
                                                    <th>Servicio</th>
                                                    <td>Sencillo</td>
                                                    <td>Redondo</td>
                                                </tr>
                                                @if ($transporte['tipo_pago'] == 1)
                                                    <tr>
                                                        <th>Adulto</th>
                                                        <td>$ {{ $transporte['adultoSencillo'] }} </td>
                                                        <td>$ {{ $transporte['adultoRedondo'] }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Menor</th>
                                                        <td>$ {{ $transporte['menorSencillo'] }}</td>
                                                        <td>$ {{ $transporte['menorRedondo'] }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Infante</th>
                                                        <td>$ {{ $transporte['infanteSencillo'] }}</td>
                                                        <td>$ {{ $transporte['infanteRedondo'] }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th>Traslado</th>
                                                        <td>$ {{ $transporte['adultoSencillo'] }}</td>
                                                        <td>$ {{ $transporte['adultoRedondo'] }}</td>
                                                    </tr>
                                                @endif

                                                <tr style="border-bottom: 0;">
                                                    <th></th>
                                                    <td>
                                                        <span class="hot-list-p3-4">
                                                            @if ($tipoServicio == 1)
                                                                <a href="{{ route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkSencillo'])]) }}"
                                                                    class="trevlo-btn trevlo-btn--base"><span>Reservar</span></a>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="hot-list-p3-4">
                                                            @if ($tipoServicio == 2)
                                                                <a href="{{ route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkRedondo'])]) }}"
                                                                    class="trevlo-btn trevlo-btn--base"><span>Reservar</span></a>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h1 style="text-align: center">Sin disponibilidad</h1>
            @endif
        </div>
    </section>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/stylesTransportacionListDaniel.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3/daterangepicker.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.1/css/all.min.css"
        integrity="sha512-BxQjx52Ea/sanKjJ426PAhxQJ4BPfahiSb/ohtZ2Ipgrc5wyaTSgTwPhhZ/xC66vvg+N4qoDD1j0VcJAqBTjhQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .search-bar .form-group {
            margin-top: 0px;
        }

        .boton {
            padding: 10px 40px;
            cursor: pointer;
            background: #0080a7;
            text-decoration: none;
            color: #fff;
            transition: all 0.2s ease;
            border: none;
            border-radius: 5px;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        let today = moment().add(1, 'days').format("YYYY/MM/DD");
        let maxday = moment().add(730, 'days').format("YYYY/MM/DD");

        $("#date_start").val(moment().add(5, 'days').format("YYYY-MM-DD"));
        $("#date_end").val(moment().add(6, 'days').format("YYYY-MM-DD"));
        $("#destinoTransporte").autocomplete({
            source: function(request, response) {
                $.ajax({
                    dataType: "json",
                    type: 'get',
                    data: {
                        search: request.term,
                    },
                    url: 'destination-transporte',
                    success: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                        response($.map(data, function(item) {
                            return {
                                label: item.text,
                                value: item.text,
                                id: item.id,
                                zona: item.zona
                            };
                        }));
                    },
                    error: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                    }
                });
            },
            minLength: 3,
            open: function() {
                $("#loadDestinoNames").hide();
            },
            close: function() {},
            focus: function(event, ui) {},
            search: function(event, ui) {
                $("#loadDestinoNames").show();
            },
            select: function(event, ui) {
                $("#nombreDestinoTransporte").val(ui.item.label);
                $("#idDestinoTransporte").val(ui.item.id);
                $("#idZonaDestino").val(ui.item.zona);
            }
        });

        $("#origenTransporte").autocomplete({
            source: function(request, response) {
                $.ajax({
                    dataType: "json",
                    type: 'get',
                    data: {
                        search: request.term,
                    },
                    url: 'destination-transporte',
                    success: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                        response($.map(data, function(item) {
                            return {
                                label: item.text,
                                value: item.text,
                                id: item.id,
                                zona: item.zona
                            };
                        }));
                    },
                    error: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                    }
                });
            },
            minLength: 3,
            open: function() {
                $("#loadOrigenNames").hide();
            },
            close: function() {},
            focus: function(event, ui) {},
            search: function(event, ui) {
                $("#loadOrigenNames").show();
            },
            select: function(event, ui) {
                $("#nombreOrigenTransporte").val(ui.item.label);
                $("#idOrigenTransporte").val(ui.item.id);
                $("#idZonaOrigen").val(ui.item.zona);
            }
        });

        $("#tipoServicio").on("change", function() {
            var servicio = $(this).val();
            if (parseInt(servicio) === 1) {
                $("#fechaRegreso").addClass("oculto");
            } else {
                $("#fechaRegreso").removeClass("oculto");
            }
        });

        let fechaDesde = moment('@php echo $fechaLlegada @endphp').format("YYYY/MM/DD");
        let fechaHasta = moment('@php echo $fechaSalida @endphp').format("YYYY/MM/DD");

        $('#fechaSalida').daterangepicker({
            autoApply: true,
            opens: 'left',
            singleDatePicker: true,
            minDate: today,
            maxDate: maxday,
            maxSpan: {
                "days": 30
            },
            startDate: fechaHasta,
            locale: {
                applyLabel: "Aplicar",
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            $("#date_start").val(start.format('YYYY-MM-DD'));
            $("#date_end").val(end.format('YYYY-MM-DD'));
        });

        $('#fechaLlegada').daterangepicker({
            autoApply: true,
            opens: 'left',
            minDate: today,
            singleDatePicker: true,
            maxDate: maxday,
            maxSpan: {
                "days": 30
            },
            startDate: fechaDesde,
            locale: {
                applyLabel: "Aplicar",
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            $("#date_start").val(start.format('YYYY-MM-DD'));
            $("#date_end").val(end.format('YYYY-MM-DD'));

            var fechaMinB = start.format('YYYY-MM-DD');
            $("#fechaSalida").data('daterangepicker').minDate = start;
            $("#fechaSalida").data('daterangepicker').startDate = start;
        });

        function verificarDestinos() {

            var nombreDestino = $("#nombreDestinoTransporte").val();
            var nombreOrigen = $("#nombreOrigenTransporte").val();

            if (nombreOrigen == nombreDestino) {
                $("#btn-transporte").prop('disabled', true);
                alert("El origen y destino no pueden ser iguales");
            } else {
                $("#btn-transporte").prop('disabled', false);
            }

        }
    </script>
@stop
