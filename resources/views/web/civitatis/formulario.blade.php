@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp

@extends('layouts.master')

@section('metaSEO')
    <title>Datos de compra - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url({{ asset('assets/images/datos-compra.webp') }})">
        </div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Datos de compra</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Actividades</li>
                    <li>{{ $nombreAct }}</li>
                    <li>Datos de compra</li>
                </ul>
            </div>
        </div>
    </section>
    {{-- MAIN --}}
    <section class="checkout-page section-space">
        <div class="container">
            <form class="checkout-page__form form-one" id="frmCompra" action="{{ route('save-openpay-civitatis') }}"
                method="post">
                @csrf
                <input type="hidden" id="politicas" value="{{ $sitioweb[0]->politicas }}">
                <input type="hidden" name="terminal" id="terminal" value="3">
                <input type="hidden" name="transaccion" id="transaccion" value="{{ Str::random(15) }}">
                <input type="hidden" name="bookingTech" id="bookingTech" value="0">

                <input type="hidden" name="cartid" value="{{ $cartId }}">
                <input type="hidden" name="gtotal" id="gtotal" value="{{ $precioTotal }}">
                <input type="hidden" name="idformulario" value="{{ $fieldsId }}">
                <input type="hidden" name="nombretour" id="nombretour" value="{{ $nombreAct }}">

                @foreach ($campo as $i => $tipoCampo)
                    <input type="hidden" name="campo[]" value="{{ $tipoCampo }}">
                    <input type="hidden" name="cantidad[]" value="{{ $cantidad[$i] }}">
                @endforeach

                <div class="row">
                    {{-- FORM --}}
                    <div class="col-xl-8 col-lg-8">
                        <div class="checkout-page__billing-address">
                            <h2 class="checkout-page__title">Datos de Reserva</h2>
                            <div class="row gutter-20">
                                {{-- NOMBRE --}}
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-one__group">
                                        <input required type="text" id="nombreTitular" name="nombre"
                                            class="form-one__input" placeholder="Nombres del titular de la reserva"
                                            autocomplete="off">
                                    </div>
                                </div>
                                {{-- APELLIDOS --}}
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-one__group">
                                        <input required type="text" id="apellidoTitular" name="apellido"
                                            class="form-one__input" placeholder="Apellidos del titular de la reserva"
                                            autocomplete="off">
                                    </div>
                                </div>
                                {{-- TELEFONO --}}
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-one__group">
                                        <input required type="tel" id="telefonoTitular" name="telefono"
                                            class="form-one__input" placeholder="Número de teléfono" autocomplete="off">
                                    </div>
                                </div>
                                {{-- SEXO --}}
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-one__group">
                                        <select required class="selectpicker" id="sexoTitular" name="sexoTitular">
                                            <option value="" selected disabled>Género</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- FECHA NAC --}}
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <div class="form-one__group">
                                        <select required class="selectpicker" id="dianacTitular" name="dianacTitular">
                                            <option value="" disabled selected>Día</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <div class="form-one__group">
                                        <select required class="selectpicker" id="mesnacTitular" name="mesnacTitular">
                                            <option value="" disabled selected>Mes</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <div class="form-one__group">
                                        <select required class="selectpicker" id="yearTitular" name="yearTitular">
                                            <option value="" disabled selected>Año</option>
                                            @for ($i = 1960; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                {{-- EXTRA CIVI --}}
                                @foreach ($fieldsBooking as $field)
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-one__group">
                                            <label for="telefonoTitular">{{ $field['labelTranslated'] }}</label>
                                            <input name="valueField[]" id="{{ $field['id'] }}"
                                                type="{{ $field['type'] }}" class="form-one__input"
                                                placeholder="{{ $field['labelTranslated'] }}"
                                                {{ $field['required'] == true ? 'required' : '' }}>
                                            <input type="hidden" class="campoSolicitado" name="idField[]"
                                                value="{{ $field['id'] }}">
                                        </div>
                                    </div>
                                @endforeach

                                {{-- CORREO --}}
                                <div class="col-12 mt-5">
                                    <div class="form-one__group">
                                        <h2 class="text-center">¿A dónde enviamos la confirmación de tu reservación?</h2>
                                        <p class="text-center">El e-mail que elijas será fundamental para que gestiones tu
                                            reserva
                                        </p>
                                        <input required="" type="email" class="form-one__input" name="email"
                                            id="email" placeholder="Escriba su email" required autocomplete="off">
                                    </div>
                                </div>
                                {{-- CUPON --}}
                                <div id="containerCounpon" class="form-group margin-form"
                                    style="display: none; width: 100%;">
                                    <label for="inputGetCoupon">¿Tienes algún cupón? - Ingresar código de cupón</label>
                                    <div class="containerCupones">
                                        {{-- INPUT & BTN --}}
                                        <div class="caja_cupon">
                                            <input type="text" class="form-one__input" name="cupon"
                                                id="inputGetCoupon" placeholder="Escriba su cupón" autocomplete="off">
                                            <button id="checkCoupon"
                                                class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base"
                                                onclick="comprobarCoupon(1);">
                                                <span>
                                                    <i aria-hidden="true" class="fa-solid fa-gift"
                                                        style="margin-right: 2px;"></i>Aplicar
                                                    Cupón
                                                </span>
                                            </button>
                                        </div>
                                        {{-- MSJ CUPON --}}
                                        <div id="mensajeCupon" class="alert-primary" style="display: none;"
                                            role="alert">
                                            <div class="mensajeStyleCupon" id="containerValid">
                                                <i aria-hidden="true" id="iconMenssage" style="margin-right: 4px;"></i>
                                                <p id="mensajeSucces" style="margin: 0;"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="containerTheMessageCuponResponse" id="mensajeCuponAplicado"
                                            style="display: none;">
                                            <i aria-hidden="true" id="iconMenssageSub" style="margin-right: 4px;"></i>
                                            <p id="mensajeSuccesInformationCoupon" style="margin: 0; padding: 0;">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div id="terminos-condiciones"></div>

                                {{-- TERMINALES --}}
                                @php
                                    $paypal = 0;
                                    $paypalClientId = 0;
                                @endphp
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h5>{{ count($sitioweb[0]->terminales) > 0 ? 'Métodos de pago:' : 'Pagar ahora' }}
                                        </h5>
                                        {{-- <hr> --}}
                                    </div>
                                    @if (count($sitioweb[0]->terminales) > 0)
                                        @foreach ($sitioweb[0]->terminales as $terminal)
                                            @if ($terminal->id == 3)
                                                {{-- Terminal Openpay --}}
                                                <div class="col-md-4 text-center">
                                                    <button type="submit" class="btn btnDatosCompra btnOpenPay"
                                                        id="btnPagar">
                                                        <img src="{{ asset('assets/images/openpay-logo.webp') }}"
                                                            alt="" style="height: auto; width: 110px;">
                                                    </button>
                                                    <p class="textCardPayment">Realiza tu pago de forma segura con
                                                        Openpay a través de BBVA. Solo se aceptan tarjetas mexicanas.
                                                    </p>
                                                </div>
                                            @endif

                                            @if ($terminal->id == 4)
                                                @php
                                                    $paypal = 1;
                                                    $paypalClientId = $terminal->id_afiliacion;
                                                @endphp
                                                <div class="col-md-4 text-center">
                                                    <div id="paypal-button-container"></div>
                                                    <p class="textCardPayment">Se aceptan tarjetas internacionales y
                                                        cuentas PayPal.</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TICKET --}}
                    <div class="col-xl-4 col-lg-4">
                        <div class="checkout-page__your-order">
                            <h2 class="checkout-page__title">Detalles de compra</h2>
                            <table class="table table_summary">
                                <tbody>
                                    <tr>
                                        <td class="bold">Nombre de actividad</td>
                                        <td>{{ $nombreAct }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Fecha</td>
                                        <td>{{ $fecha }}</td>
                                    </tr>
                                    @if ($horario != null)
                                        <tr>
                                            <td class="bold">Horario</td>
                                            <td>{{ $horario }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot id="tfooterTable">
                                    <tr class="total_row">
                                        <td><strong>TOTAL</strong></td>
                                        <td colspan="2" class="text-right">
                                            <input name="total" class="w-100 text-right border-0 bg-transparent bold"
                                                id="total"
                                                value="${{ $fn->moneda($precioTotal) }} {{ $monedaSeleccionada }}"
                                                disabled>
                                            <input type="hidden" name="totalConCupon" id="totalCivitatisFinal"
                                                value="{{ $fn->moneda($precioTotal) }}">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/stylesBotonOpenPay.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/intTelInputLocal.css') }}">
    <style>
        #currency {
            display: none;
        }
        .btnOpenPay {
            background-color: #ffc439;
        }
        .btn:hover {
            background: #ffcb00d4;
            filter: brightness(0.9);
        }
        #telefonoTitular {
            border: none;
        }
        #total {
            border: none;
            background: none;
            font-weight: 600;
        }
        
        @media (max-width: 1199px) {
            .iti--allow-dropdown input.iti__tel-input, .iti--allow-dropdown input.iti__tel-input[type=text], .iti--allow-dropdown input.iti__tel-input[type=tel] {
                width: 100%;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/js/prefijo_formulario.js') }}"></script>
    <script src="{{ asset('assets/helpers/js/hoteleria/datoscompras.js') }}"></script>
@if ($paypal == 1)
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $monedaSeleccionada }}&disable-funding=credit,card">
        </script>
        <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    let totalPaypal = $('#gtotal').val();
                    totalPaypal = parseFloat(totalPaypal).toFixed(2);
                    guardarReserva();

                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: totalPaypal
                            }
                        }],
                    });
                },
                onApprove: function(data, actions) {
                    obtenerEstatusPago(data.orderID);
                }
            }).render('#paypal-button-container');

            function guardarReserva(data) {
                $("#terminal").val("4");
                //Hacer que la reserva se guarde usando la funcion guardarOpenPay de sitioWebController

                let bookingTech = $("#bookingTech").val();
                if (bookingTech === "0") {
                    $.ajax({
                            method: "GET",
                            url: "save-openpay-civitatis",
                            data: $("#frmCompra").serialize(),
                            dataType: "json"
                        })
                        .done(function(e) {
                            if (e.transaccion !== '') {
                                $("#bookingTech").val("1");
                            }
                        })
                        .fail(function() {
                            console.log('error');
                        });
                }
            }

            function obtenerEstatusPago(orderID) {
                //Obtener el estatus de la transaccion de openpay, se utilizla esta misma funcion
                //lo unico que cambia es la url de gracias y modificar el controlador de gracias

                var dataLogs = {
                    _token: "{{ csrf_token() }}",
                    order: orderID
                };

                $.ajax({
                        method: "POST",
                        url: "paypalEstatus",
                        data: dataLogs,
                        dataType: "json"
                    })
                    .done(function(e) {
                        if (e.status === 'COMPLETED') {
                            let transaccion = $("#transaccion").val();
                            let total = $("#gtotal").val();
                            let url = "gracias-openpay-civitatis?id=" + transaccion + "&terminal=4&monto=" + total +
                                "&order=" + orderID;
                            location.href = url;
                        } else {
                            //Informar que el pago no se realizó con éxito
                            alert("El pago no se realizó con éxito. Intente de nuevo o seleccione otra forma de pago");
                        }
                    })
                    .fail(function() {

                    });
            }
        </script>
    @endif
<script>
    //first - ShowDi
    $('#email').on("change",function() {
        let emailValue = $('#email').val();
        evaluarEmail(emailValue);
    });

    //Second - buttonCouponVerif
    const couponResponse = (tipoServicio, coupon, emailValue, totalTourFinal, telefonoTitular) => {
        let dataJson = {
            data: {
                id_servicio : tipoServicio,
                email: emailValue,
                total: totalTourFinal,
                cupon: coupon,
                telefono: telefonoTitular,
            }
        }
        $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url:`/validarCupon`,
            method: "POST",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify(dataJson),
        }) .done(function(data) {
                responseData = data;
                informactionCoupon(responseData);
        });
    }

    //first finally - buttonCouponVerif
    const mensajeFrontEnd = (mensajeCupon, validStatus, total, descuento = 0, hasDescuent) => {
        let text = document.getElementById("mensajeSucces");
        let mensajeInformacionCupon = document.getElementById("mensajeSuccesInformationCoupon");
        // iconMenssage
        let nuestroMensaje;
        let mensajeConResumen;
        let mensajeConCuponAplicado;
        let bonos           = descuento;
        let gTotalJs        = total;
        let phpTotal        = "@php echo $fn->moneda($precioTotal) . ' ' . $monedaSeleccionada @endphp";
        let phpMonedaSelect = "<?php echo $monedaSeleccionada ?>";
        
        if(validStatus) {
            nuestroMensaje = 'Cupón aplicado';
            if(hasDescuent) {
                mensajeConCuponAplicado = `Obtienes un ${bonos}% de descuento al finalizar tu compra`;
                let tableHtmlRow = `<tr class="total_row" id="totalPriceNew">
                                    <td><strong>Nuevo Total</strong></td>
                                    <td colspan="2" class="text-right">
                                            <input name="total" class="text-right" id="total" value="$ ${total} ${phpMonedaSelect}" disabled="">
                                            <input type="hidden" name="totalConCuponTable" id="totalTourFinalTable" value="${total}">
                                    </td>
                                </tr>`;
                $("#tfooterTable").append(tableHtmlRow);
                $("#total").css("text-decoration", "Line-through");
                $("#iconMenssageSub").addClass( "fa-solid fa-gift" );
            } else {
                $("#total").css("text-decoration", "none");
            }
            mensajeConResumen = `${nuestroMensaje} : ${mensajeCupon}`;
        } else {
            nuestroMensaje = 'Cupón no aplicado';
            mensajeConCuponAplicado = '';
            mensajeConResumen = `${nuestroMensaje} : ${mensajeCupon}`;
            $("#total").css("text-decoration", "none");
        }
        text.innerText = mensajeConResumen;
        mensajeInformacionCupon.innerText = `${mensajeConCuponAplicado}`;
    }
    classNameFontAwesomeClose   = "fas fa-times";
</script>
@endsection