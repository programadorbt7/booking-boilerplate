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
    <section class="mt-80">
        <div class="container">
            <div class="row" style="grid-row-gap: 50px; margin:0;">
                <div class="col-lg-12">
                    @if ($transportacionLista != null)
                        <h6>Se encontraron {{ count($transportacionLista) }} transportes
                            disponibles</h6>
                    @else
                        <h6>Por el momento no hay transportes disponibles</h6>
                    @endif
                </div>
                @if ($transportacionLista != null)
                    @foreach ($transportacionLista as $transporte)
                        <div class="col-12 row cards-transporte">
                            <!-- Muestra imagen -->
                            <div class="col-lg-4 col-md-6">
                                <a href="{{ $tipoServicio == 1 ? route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkSencillo'])]) : route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkRedondo'])]) }}"
                                    class="tour-listing-three__card-image-box tour-listing__card-image-box">
                                    <img src="{{ $transporte['linkImg'] }}" alt="{{ $transporte['modelo'] }}"
                                        class="tour-listing-three__card-image tour-listing__card-image">
                                </a>
                            </div>

                            <!-- Nombre y servicios -->
                            <div class="col-lg-4 col-md-6">
                                <h5 class="tour-listing-three__card-title tour-listing__card-title">
                                    <a
                                        href="{{ $tipoServicio == 1 ? route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkSencillo'])]) : route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkRedondo'])]) }}">
                                        Servicio {{ $transporte['nombreServicio'] }}
                                        {{ $tipoServicio == 1 ? 'Sencillo' : 'Redondo' }}
                                    </a>
                                </h5>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:0">
                                        <div class="tour-one__stars">
                                            <i class="fas fa-car"></i>
                                            {{ $transporte['marca'] }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:0">
                                        <div class="tour-one__stars">
                                            <i class="fas fa-car"></i>
                                            {{ $transporte['modelo'] }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:0">
                                        <div class="tour-one__stars">
                                            <i class="fas fa-stream"></i>
                                            {{ $transporte['tiposervicio'] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="tour-one__stars">
                                            <i class="fas fa-user-plus"></i> Pax máx:
                                            {{ $transporte['pasaje_max'] }}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="tour-one__stars">
                                            <i class="fas fa-luggage-cart"></i> Maletas máx:
                                            {{ $transporte['maletas'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarifas -->
                            <div class="col-lg-4 col-md-12 card-tarifas">
                                <ul class="tour-one__meta list-unstyled">
                                    <table class="table m-0">
                                        <tbody>
                                            @if ($transporte['tipo_pago'] == 1)
                                                <tr style="border-bottom: 1px solid black;">
                                                    <th>Adulto
                                                        <small>
                                                            <i data-toggle="tooltip" data-placement="top"
                                                                title="El precio es por Pasajero"
                                                                class="fa-solid fa-circle-info"></i>
                                                        </small>
                                                    </th>

                                                    @if ($transporte['menorSencillo'] != 0 || $transporte['menorRedondo'] != 0)
                                                        <td>
                                                            Menor
                                                            <small><i data-toggle="tooltip" data-placement="top"
                                                                    title="{{ $transporte['edadMenorMin'] }} años a {{ $transporte['edadMenorMax'] }} años"
                                                                    class="fa-solid fa-circle-info"></i></small>
                                                        </td>
                                                    @endif

                                                    @if ($transporte['infanteSencillo'] != 0 || $transporte['infanteRedondo'] != 0)
                                                        <td>
                                                            Infante
                                                            <small><i data-toggle="tooltip" data-placement="top"
                                                                    title="{{ $transporte['edadInfanteMin'] }} años - {{ $transporte['edadInfanteMax'] }} años"
                                                                    class="fa-solid fa-circle-info"></i></small>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @else
                                                @if ($transporte['id_rango'] != null)
                                                    <tr style="border-bottom: 1px solid black;">
                                                        <th>Por Pasajero
                                                            <small><i data-toggle="tooltip" data-placement="top"
                                                                    title="El precio es por Pasajero"
                                                                    class="fa-solid fa-circle-info"></i></small>
                                                        </th>
                                                    </tr>
                                                @else
                                                    <tr style="border-bottom: 1px solid black;">
                                                        <th>Por Unidad <small><i data-toggle="tooltip" data-placement="top"
                                                                    title="El precio es por Unidad"
                                                                    class="fa-solid fa-circle-info"></i></small>
                                                        </th>
                                                    </tr>
                                                @endif
                                            @endif

                                            @if ($transporte['tipo_pago'] == 1)
                                                <th>$
                                                    {{ $tipoServicio == 1 ? $transporte['adultoSencillo'] : $transporte['adultoRedondo'] }}
                                                </th>


                                                @if ($transporte['menorSencillo'] != 0 || $transporte['menorRedondo'] != 0)
                                                    <th>$
                                                        {{ $tipoServicio == 1 ? $transporte['menorSencillo'] : $transporte['menorRedondo'] }}
                                                    </th>
                                                @endif

                                                @if ($transporte['infanteSencillo'] != 0 || $transporte['infanteRedondo'] != 0)
                                                    <th>$
                                                        {{ $tipoServicio == 1 ? $transporte['infanteSencillo'] : $transporte['infanteRedondo'] }}
                                                    </th>
                                                @endif
                                            @else
                                                <th>$
                                                    {{ $tipoServicio == 1 ? $transporte['adultoSencillo'] : $transporte['adultoRedondo'] }}
                                                </th>
                                            @endif
                                        </tbody>
                                    </table>
                                </ul>

                                @if ($tipoServicio == 1)
                                    <div style="display: flex; justify-content: center;" class="mt-2 mb-2">
                                        <a class="trevlo-btn trevlo-btn--base"
                                            href="{{ route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkSencillo'])]) }}">
                                            <span>
                                                Seleccionar
                                            </span>
                                        </a>
                                    </div>
                                @else
                                    <div style="display: flex; justify-content: center;" class="mt-2 mb-2">
                                        <a class="trevlo-btn trevlo-btn--base"
                                            href="{{ route('datos-compra-transportacion-m1', ['datosCompraTransporte' => $fn->codificaUrl($transporte['linkRedondo'])]) }}">
                                            <span>
                                                Seleccionar
                                            </span>
                                        </a>
                                    </div>
                                @endif


                            </div>
                        </div>
                    @endforeach
                @else
                    <h1 style="text-align: center">Sin disponibilidad</h1>
                @endif
            </div>
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
