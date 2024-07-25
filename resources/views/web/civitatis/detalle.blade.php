@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
    $monedaSeleccionada = session('monedaSeleccionada');
@endphp

@extends('layouts.master')

@section('metaSEO')
    <title>
        Detalle {{ $title }} - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Disfruta de nuestro tour de viaje que tenemos para ofrecerte una experiencias inolvidable.">
    <meta name="keywords"
        content="Tour, Actividad, Detalle, Vuelo, Turiso, Parques, Personas, Paisajes, Galería, Incluido, No incluido, Reserva, Visitas, Viajar, Fecha">
@endsection

@section('contenido-principal')
    @foreach ($categoriasTours as $c => $categoriaTour)
        @foreach ($tipos as $t => $catTipo)
            <input type="hidden" id="precio_{{ $c }}_{{ $t }}"
                value="{{ $fn->tarifaPublicaAgenciasToursSinFormato($calendario['schedule'][0]['rates'][$c][$t]['price'], $markup) }}">
        @endforeach
    @endforeach

    <section class="tour-listing-details tour-listing-details-right">
        {{-- GALERIA --}}
        <div class="tour-listing-details__top-carousel">
            <div class="tour-listing-details__top-carousel-wrapper trevlo-owl__carousel owl-theme owl-carousel">
                @foreach ($gallery as $i => $imagen)
                    <a aria-label="Imagen" data-fancybox="gallery" data-src="{{ $imagen['paths']['original'] }}">
                        <div class="tour-listing-details__top-carousel-item item">
                            <div class="tour-listing-details__top-carousel-image">
                                <img src="{{ $imagen['paths']['original'] }}" alt="{{ $title }}">
                                <div class="tour-listing-details__top-carousel-overlay">
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        {{-- GENERAL --}}
        <div class="tour-listing-details__destination">
            <div class="container">
                <div class="tour-listing-details__destination-row row">
                    {{-- TITLE & PRICE --}}
                    <div class="col-xl-4 wow animated fadeInLeft" data-wow-delay="0.1s" data-wow-duration="1500ms">
                        <div class="tour-listing-details__destination-left">
                            <h3 class="tour-listing-details__dastination-title">{{ $title }}</h3>
                            <h4 class="tour-listing-details__dastination-price">
                                <span>$ {{ $fn->tarifaPublicaAgenciasTours($minimumPrice, $markup) }}
                                    {{ $monedaSeleccionada }}</span>
                                <span class="tour-listing-details__dastination-person">/ Por persona</span>
                            </h4>
                        </div>
                    </div>
                    {{-- INFO GENERAL --}}
                    <div class="col-xl-8">
                        <div class="tour-listing-details__destination-right">
                            {{-- DURACION --}}
                            <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1500ms">
                                <span class="icon-clock-1"></span>
                                <div class="tour-listing-details__destination-info-title">
                                    <h4 class="tour-listing-details__destination-info-top">Duración</h4>
                                    <h4 class="tour-listing-details__destination-info-bottom">
                                        {{ ceil($duracionTour / 60) }}
                                        {{ ceil($duracionTour / 60) == 1 ? 'Hora' : 'Horas' }}
                                    </h4>
                                </div>
                            </div>
                            {{-- RESEÑAS --}}
                            <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.3s"
                                data-wow-duration="1500ms">
                                <span class="icon-Duration"></span>
                                <div class="tour-listing-details__destination-info-title">
                                    <h4 class="tour-listing-details__destination-info-top">Reseñas</h4>
                                    <h4 class="tour-listing-details__destination-info-bottom">
                                        {{ $reviews }} {{ $reviews > 1 ? 'Reseñas' : 'Reseña' }}
                                    </h4>
                                </div>
                            </div>
                            {{-- CATEGORIA --}}
                            <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.5s"
                                data-wow-duration="1500ms">
                                <span class="icon-hiking-1"></span>
                                <div class="tour-listing-details__destination-info-title">
                                    <h4 class="tour-listing-details__destination-info-top">Categoría</h4>
                                    <h4 class="tour-listing-details__destination-info-bottom">{{ $categoriaUnica }}</h4>
                                </div>
                            </div>
                            {{-- CALIFICACION --}}
                            <div class="tour-listing-details__destination-info wow animated fadeInUp" data-wow-delay="0.7s"
                                data-wow-duration="1500ms">
                                <span class="icon-star"></span>
                                <div class="tour-listing-details__destination-info-title">
                                    <h4 class="tour-listing-details__destination-info-top">Calificación</h4>
                                    <h4 class="tour-listing-details__destination-info-bottom">
                                        {{ $score < 5 ? '8' : $score }}/10
                                        @if ($score <= 7)
                                            Bueno
                                        @elseif ($score >= 8)
                                            Excelente
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- MAIN --}}
        <div class="container">
            <div class="tour-listing-details__row row">
                <div class="col-xl-8">
                    {{-- BTN RESERVA --}}
                    <div class="row justify-content-center mb-5 btn-reserva">
                        <div class="col-md-3 col-sm-6">
                            <a href="#form-reserva" class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base">
                                <span>
                                    Reservar Ahora
                                </span>
                            </a>
                        </div>
                    </div>
                    {{-- DESCRIPCION --}}
                    <div class="tour-listing-details__overview">
                        <div class="wow animated fadeIn" data-wow-delay="0.1s" data-wow-duration="1500ms">
                            <h3 class="tour-listing-details__title tour-listing-details__overview-title">Acerca de</h3>
                        </div>
                        <p class="tour-listing-details__overview-text wow animated fadeInUp" data-wow-delay="0.1s"
                            data-wow-duration="1500ms">
                            {!! $description !!}
                        </p>
                    </div>
                    {{-- INFO GENERAL --}}
                    <div class="tour-listing-details__reviews">
                        <div class="destination-details__overview">
                            <h3 class="destination-details__overview-title destination-details__title">General</h3>
                            <ul class="destination-details__overview-content wow animated fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1500ms">
                                <li>
                                    <p>¿Cuándo Reservar?</p>
                                    <p>
                                        @if ($minutes_before / 60 > 24)
                                            @php
                                                $horas = $minutes_before / 60;
                                                $dias = $horas / 24;
                                                echo 'Hasta ' . $dias;
                                                echo $dias > 1 ? ' Días' : ' Día';
                                                echo ' antes si aún se cuenta con disponibilidad';
                                            @endphp
                                        @else
                                            @php
                                                $horas = $minutes_before / 60;
                                                echo $horas . ' horas antes si aún se cuenta con disponibilidad';
                                            @endphp
                                        @endif
                                    </p>
                                </li>
                                <li>
                                    <p>Mínimo de personas</p>
                                    <p>
                                        @if ($actividad['minimumPaxPerActivity'] > 1)
                                            {{ $actividad['minimumPaxPerActivity'] . ' personas, si no se completa la cantidad de personas nos comunicaremos contigo para ofrecerte otras alternativas' }}
                                        @else
                                            {{ 'No hay un minimo de personas para esta actividad' }}
                                        @endif
                                    </p>
                                </li>
                                <li>
                                    <p>Políticas de cancelación</p>
                                    <p>
                                        @foreach ($cancelPolicies as $politica)
                                            @if ($politica['penalty'] == 0)
                                                ¡Gratis! Cancela sin gastos hasta
                                                {{ $politica['hours'] }} horas antes de la actividad.
                                                Si cancelas con
                                                menos tiempo, llegas tarde o no te presentas, no se
                                                ofrecerá
                                                ningún reembolso.
                                            @else
                                                {{ $politica['penalty'] }} % de penalización al
                                                cancelar antes de {{ $politica['hours'] }} horas antes de
                                                la actividad
                                            @endif
                                        @endforeach
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="tour-listing-details__reviews">
                        <div class="destination-details__overview">
                            <h3 class="destination-details__overview-title destination-details__title">Consideraciones</h3>
                            <ul class="destination-details__overview-content wow animated fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1500ms">
                                <li>
                                    <p>Incluye</p>
                                    <p>
                                        @foreach ($included as $i => $incluye)
                                            <i aria-hidden="true" class="fas fa-check-circle text-success"></i>
                                            {{ $incluye }}
                                            <br>
                                        @endforeach
                                    </p>
                                </li>
                                @if (count($notIncluded) > 0)
                                    <li>
                                        <p>No Incluye</p>
                                        <p>
                                            @foreach ($notIncluded as $i => $noincluye)
                                                <i aria-hidden="true" class="fas fa-times text-danger"></i>
                                                {{ $noincluye }}
                                                <br>
                                            @endforeach
                                        </p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    {{-- MAS DETALLES --}}
                    <div class="tour-listing-details__plan">
                        <h3 class="tour-listing-details__title tour-listing-details__plan-title">Información adicional</h3>
                        <div class="trevlo-accrodion tour-listing-details__faq" data-grp-name="tour-listing-details__faq">
                            <div class="accrodion active wow animated fadeInUp" data-wow-delay="0.1s"
                                data-wow-duration="1500ms">
                                <div class="accrodion-content">
                                    <div class="inner">
                                        <p>{!! $infoVoucher !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FORM --}}
                <div id="form-reserva" class="col-xl-4">
                    <aside class="tour-listing-details__sidebar">
                        {{-- FORM --}}
                        <div class="tour-listing-details__sidebar-book-tours tour-listing-details__sidebar-single wow animated fadeInUp"
                            data-wow-delay="0.1s" data-wow-duration="1500ms">
                            <h3 class="tour-listing-details__sidebar-title">Haz tu Reserva!</h3>
                            <form class="tour-listing-details__sidebar-form" id="check_avails" method="post"
                                action="{{ route('datos-compra-civitatis') }}" autocomplete="off">
                                @csrf
                                <input type="hidden" name="idactividad" value="{{ $actividadId }}">
                                <input type="hidden" name="nombreActividad" value="{{ $actividadTitle }}">
                                <input type="hidden" name="markup" value="{{ $markup }}">
                                <input type="hidden" name="currency" value="{{ $monedaSeleccionada }}">
                                <input type="hidden" name="imagen" value="{{ $fotoActividad }}">
                                <input type="hidden" name="precioTotal" id="precioTotal" value="">

                                <div class="tour-listing-details__sidebar-form-input">
                                    <label>Fecha</label>
                                    <input required type="text" name="fecha" id="fecha" placeholder="Fecha"
                                        autocomplete="off">
                                </div>
                                <div class="tour-listing-details__sidebar-form-input campoReserva">
                                    <label>Tipo de actividad</label>
                                    <select class="form-control" name="rate" id="rate"
                                        onchange="muestraPrecios(value)" required>
                                        <option value="" disabled selected>Selecciona una
                                            opción</option>
                                        @foreach ($categoriasTours as $c => $categoriaTour)
                                            <option value="{{ $c }}">
                                                {{ $categoriaTour }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @foreach ($tipos as $t => $tipoCat)
                                    <div class="tour-listing-details__sidebar-form-input campoReserva">
                                        <label>{{ $tipoCat }}</label>
                                        <select
                                            class="{{ $ratesCategories[$t]['canBookAlone'] ? 'adulto_canBook' : '' }} form-control tipoCat"
                                            name="campo[]" id="tipoCat_{{ $t }}"
                                            data-id="{{ $t }}" data-precio=""
                                            onchange="calculaPrecio(); poneCantidad(this, '{{ $t }}');">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="precio" disabled>$ ---
                                                {{ $monedaSeleccionada }}
                                            </option>
                                            @for ($i = 0; $i <= 10; $i++)
                                                <option value="{{ $t }}" rel="{{ $i }}">
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        <input type="hidden" name="cantidad[{{ $t }}]"
                                            id="cantidad_{{ $t }}">
                                    </div>
                                @endforeach
                                <div class="tour-listing-details__sidebar-form-input campoReservaHorario">
                                    <label>Horario</label>
                                    <select class="form-control" name="horario" id="horario" required>
                                    </select>
                                </div>
                                <div class="tour-listing-details__sidebar-form-input campoReserva">
                                    <label>Total a pagar</label>
                                    <input type="text" readonly class="form-control" id="total">
                                </div>
                                <div class="errores-adultos" style="color: red; transition: all 0.5s ease;">
                                </div>
                                <button type="submit"
                                    class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base">
                                    <span>Reservar</span></button>
                            </form>
                        </div>
                        {{-- INFO --}}
                        @if ($sitioweb[0]->telefono != '')
                            <div class="tour-listing-details__sidebar-post-box tour-listing-details__sidebar-single wow animated fadeInUp"
                                data-wow-delay="0.1s" data-wow-duration="1500ms">
                                <div class="faq-page__contact">
                                    <div class="faq-page__contact-icon">
                                        <span class="icon-phone-1"></span>
                                    </div>
                                    <h3 class="faq-page__contact-title">¿Necesitas Ayuda?</h3>
                                    <div class="faq-page__contact-number">
                                        <p class="faq-page__contact-number-title">No dudes en contactarnos por cualquiera
                                            de
                                            nuestros medios</p>
                                        <a aria-label="Teléfono" href="tel:{{ $sitioweb[0]->telefono }}"
                                            class="faq-page__contact-number-text">{{ $sitioweb[0]->telefono }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- FANCY BOX --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .campoReserva,
        .campoReservaHorario {
            display: none;
        }

        .ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next{margin-top: 15px !important;}
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3/daterangepicker.min.js"></script>
    {{-- FANCY BOX --}}
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
    </script>
    <!-- SPECIFIC SCRIPTS -->
    <script>
        const arrayFechas = [];
        const arrayRates = [];

        let horarios = [];
        let rates = [];
        let ratesDetail = [];

        $(document).ready(function() {
            let availableDates = [
                <?php foreach ($calendarioSchedule as $fechitas) { ?> '{{ $fn->datePickerFormat($fechitas['date']) }}',
                <?php } ?>
            ];


            <?php foreach ($calendarioSchedule as $fechitasB) { ?>
            <?php foreach ($fechitasB['times'] as $h => $horarios) { ?>
            horarios[{{ $h }}] = ['{{ $horarios['time'] }}', '{{ $horarios['quota'] }}',
                '{{ $horarios['quotaAvailable'] }}', '{{ $fechitasB['availability'] }}'
            ];
            <?php } ?>


            <?php foreach ($fechitasB['rates'] as $t => $typeRate) { ?>
            <?php foreach ($typeRate as $r => $rates) { ?>
            ratesDetail[{{ $r }}] = '{{ $rates['price'] }}';
            <?php } ?>
            rates[{{ $t }}] = [...ratesDetail];
            <?php } ?>

            arrayRates['{{ $fechitasB['date'] }}'] = [...rates];
            arrayFechas['{{ $fechitasB['date'] }}'] = [...horarios];
            <?php } ?>

            $("#fecha").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 7,
                maxDate: 270,
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
                    'Nov', 'Dic'
                ],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                beforeShowDay: function(d) {
                    var dmy = (d.getMonth() + 1);
                    if (d.getMonth() < 9)
                        dmy = "0" + dmy;
                    dmy += "-";

                    if (d.getDate() < 10) dmy += "0";
                    dmy += d.getDate() + "-" + d.getFullYear();

                    if ($.inArray(dmy, availableDates) != -1) {
                        return [true, "", "Available"];
                    } else {
                        return [false, "", "unAvailable"];
                    }
                },
                onSelect: function(date) {
                    var chorarios = arrayFechas[date].length;
                    if (chorarios === 1) {
                        var hora = arrayFechas[date][0][0];
                        //Horarios
                        if (hora !== '') {
                            var quota = arrayFechas[date][0][1];
                            var quotaAvailable = arrayFechas[date][0][2];
                            var availability = arrayFechas[date][0][3];
                            if (quotaAvailable === true) {
                                if (availability > 0) {
                                    $('#horario').append('<option rel="avail" value="' + hora + '">' +
                                        hora + '</option>');
                                } else {
                                    $('#horario').append('<option rel="notavail" value="' + hora +
                                        '" disabled>' + hora + ' (no disponible)</option>');
                                }
                                $(".campoReservaHorario").show();
                            } else {
                                if (hora !== '') {
                                    $(".campoReservaHorario").show();
                                    $("#horario").prop("required", false)
                                    $('#horario').append('<option rel="noquota" value="' + hora + '">' +
                                        hora + '</option>');
                                }
                            }
                        } else {
                            $(".campoReservaHorario").hide();
                            $("#horario").prop("required", false)
                        }

                    } else {
                        $(".campoReservaHorario").show();
                        $("#horario").empty();

                        $('#horario').append('<option value="" selected disabled>Horario</option>');
                        for (i = 0; i < chorarios; i++) {
                            var hora = arrayFechas[date][i][0];
                            var quota = arrayFechas[date][i][0];
                            var quotaAvailable = arrayFechas[date][i][0];
                            var availability = arrayFechas[date][i][0];

                            if (quotaAvailable === true) {
                                if (availability > 0) {
                                    $('#horario').append('<option value="' + hora + '">' + hora +
                                        '</option>');
                                } else {
                                    $('#horario').append('<option value="' + hora + '" disabled>' +
                                        hora + ' (no disponible)</option>');
                                }

                            } else {
                                $('#horario').append('<option value="' + hora + '">' + hora +
                                    '</option>');
                            }
                        }
                    }

                    //Precios
                    var cprecios = arrayRates[date].length;
                    var lista = arrayRates[date];

                    for (i = 0; i < cprecios; i++) { //i=Tipo de actividad
                        details = lista[i];
                        cdetails = details.length;

                        for (d = 0; d < cdetails; d++) { //d=tipo de pax + precios
                            //Actualizamos tarifas
                            $("#precio_" + i + "_" + d).val(tarifaPublicaAgenciasTours(details[d],
                                '{{ $tour['empresa'][0]['comision_tours'] }}'));
                        }
                    }

                    var tipoActividad = $("#rate").val();
                    console.log('la actividad es' + tipoActividad);
                    muestraPrecios(tipoActividad);

                    $(".campoReserva").show();
                }
            });
        });

        function mostrarCaja() {
            $("#subcajita").removeClass("d-none");
            $("#btnActiva").hide();
        }

        function muestraPrecios(tipoActividad) {
            $(".tipoCat").each(function() {
                var id_cat = $(this).data("id");
                var precio = $(`#precio_${tipoActividad}_${id_cat}`).val();
                console.log(precio)

                $(`#tipoCat_${id_cat} option[value=precio]`).text(`$ ${formatearMoneda(precio)} ` + $("#currency")
                    .val())
                $('#tipoCat_' + id_cat).data('precio', precio)
            });

            calculaPrecio();
        }

        function formatearMoneda(valor, options = {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) {
            return Number(valor).toLocaleString('es-MX', options)
        }

        function cerrarCaja() {
            $("#subcajita").addClass("d-none");
            $("#btnActiva").show();
        }

        function calculaPrecio() {
            console.log('calculaprecio')
            let suma = 0;
            $(".tipoCat").each(function() {
                var id_cat = $(this).data("id");
                var precio = $(this).data("precio");
                var cant = $('option:selected', this).attr("rel");

                if (precio > 0 && cant > 0) {
                    suma = suma + (cant * precio);
                } else {
                    suma = suma + 0;
                }
            });


            $("#total").val("$ " + formatearMoneda(suma.toFixed(2)) + " {{ $monedaSeleccionada }}");
            $("#precioTotal").val(suma.toFixed(2));
        }

        function formatearMoneda(valor, options = {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) {
            return Number(valor).toLocaleString('es-MX', options)
        }

        // VALIDACION ADULTOS
        document.querySelector("#check_avails").addEventListener("submit", function(e) {
            const sels = document.querySelectorAll(".adulto_canBook")
            console.log(sels);
            //const adultos = sel.options[sel.selectedIndex].text;
            for (var i = 0; i < sels.length; i++) {
                var empty = true;
                const adultos = sels[i].options[sels[i].selectedIndex].text;
                console.log(adultos)
                if (adultos != "Seleccione..." && adultos != "0") {
                    empty = false;
                    break
                }
            }
            if (empty) {
                document.querySelector(".errores-adultos").innerHTML = "La actividad requiere adultos"
                e.preventDefault()
                return
            }
        })
    </script>
@stop
