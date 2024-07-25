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
        <div class="page-header__bg" style="background-image: url({{ asset('assets/images/datos-compra.webp') }})">
        </div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Datos de compra</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Experiencias</li>
                    <li>{{ $nombretour }}</li>
                    <li>Datos de compra</li>
                </ul>
            </div>
        </div>
    </section>
    {{-- MAIN --}}
    <section class="checkout-page section-space">
        <div class="container">
            <form class="checkout-page__form form-one" id="frmCompra" action="{{ route('save-openpay') }}" method="post">
                @csrf

                <input type="hidden" id="politicas" value="{{ $sitioweb[0]->politicas }}">
                <input type="hidden" name="terminal" id="terminal" value="3">
                <input type="hidden" name="transaccion" id="transaccion" value="{{ Str::random(15) }}">
                <input type="hidden" name="bookingTech" id="bookingTech" value="0">

                <input type="hidden" name="tipohabitacion" id="tipohabitacion" value="{{ $tipohabitacion }}">
                <input type="hidden" name="totalConCupon" id="totalTourPrecioCupon" value="">
                <input type="hidden" name="hoteleria" value="{{ $hoteleria }}">
                <input type="hidden" name="idtour" value="{{ $idtour }}">
                <input type="hidden" name="cadultos" value="{{ $cadultos }}">
                <input type="hidden" name="cmenores" value="{{ $cmenores }}">
                <input type="hidden" name="cinfantes" value="{{ $cinfantes }}">
                <input type="hidden" name="padulto" value="{{ $padulto }}">
                <input type="hidden" name="pmenor" value="{{ $pmenor }}">
                <input type="hidden" name="pinfante" value="{{ $pinfante }}">
                <input type="hidden" name="nombretour" id="nombretour" value="{{ $nombretour }}">
                <input type="hidden" name="fechaviaje" value="{{ $fechaviaje }}">
                <input type="hidden" name="gtotal" id="gtotal" value="{{ $gtotal }}">
                <input type="hidden" name="gtotalPromo" id="gtotalPromo" value="{{ $gtotalPromo }}">
                <input type="hidden" name="idPuntoPartida" value="{{ $idPuntoPartida }}">
                <input type="hidden" name="horario" value="{{ $horario }}">

                <input type="hidden" name="id_temporada" value="{{ $id_temporada }}">
                <input type="hidden" name="nombre_temporada" value="{{ $nombre_temporada }}">
                <input type="hidden" name="id_clase_servicio" value="{{ $id_clase_servicio }}">
                <input type="hidden" name="nombre_servicio" value="{{ $nombre_servicio }}">
                <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
                <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">
                <input type="hidden" name="id_paquete_fecha" value="{{ $id_paquete_fecha }}">
                <input type="hidden" name="id_temporada_costo" value="{{ $id_temporada_costo }}">
                <input type="hidden" name="fechaPorDia" value="{{ $fechaPorDia }}">

                <input type="hidden" name="tipo_descuento_frm" id="tipo_descuento_frm"
                    value="{{ $tipo_descuento_frm }}">
                <input type="hidden" name="valor_promocion_frm" id="valor_promocion_frm"
                    value="{{ $valor_promocion_frm }}">
                <input type="hidden" name="descuento_frm" id="descuento_frm" value="{{ $descuento_frm }}">
                <input type="hidden" name="idpromo_frm" id="idpromo_frm" value="{{ $idpromo_frm }}">
                <input type="hidden" name="idexpromo_frm" id="idexpromo_frm" value="{{ $idexpromo_frm }}">
                <input type="hidden" name="aplicapromo" id="aplicapromo" value="{{ $aplicapromo }}">

                <input type="hidden" name="tipoCambio" id="tipoCambio" value="{{ $tipoCambio }}">
                <input type="hidden" name="cambioMoneda" id="cambioMoneda" value="{{ $cambioMoneda }}">
                <input type="hidden" name="procesoPago" id="procesoPago" value="{{ $procesoPago }}">
                <input type="hidden" name="anticipo" id="anticipo" value="{{ $anticipo }}">
                <input type="hidden" name="tipoValor" id="tipoValor" value="{{ $tipoValor }}">

                <div class="row">
                    {{-- FORM --}}
                    <div class="col-xl-8 col-lg-8">
                        <div class="checkout-page__billing-address">
                            <h2 class="checkout-page__title">Datos de Reserva</h2>
                            <div class="row gutter-20">
                                <div>
                                    <h4> Datos del Titular
                                    </h4>
                                </div>
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
                                {{-- PASAPORTE --}}
                                @if ($paiscomercial != 'MX')
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-one__group">
                                            <label>Número de pasaporte</label>
                                            <input id="pasaporteTitular" name="pasaporteTitular" type="text"
                                                class="form-one__input" placeholder="Ingrese pasaporte"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                @endif
                                {{-- ACOMPAÑANTE ADULTO --}}
                                @if ($cadultos > 1)
                                    <div>
                                        <h4> {{ $cadultos == 2 ? 'Datos del acompañante adulto' : 'Datos de los acompañantes adultos' }}
                                        </h4>
                                    </div>
                                    @php $indiceAdulto = 2 @endphp
                                    @for ($e = 0; $e < $cadultos - 1; $e++)
                                        <h6>Adulto {{ $indiceAdulto }}</h6>
                                        {{-- NOMBRE --}}
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="form-one__group">
                                                <label for="nombreAcompa_{{ $indiceAdulto }}">Nombres</label>
                                                <input required type="text" id="nombreAcompa_{{ $indiceAdulto }}"
                                                    name="nombreAcompa[]" class="form-one__input"
                                                    placeholder="Escriba los nombres" autocomplete="off">
                                            </div>
                                        </div>
                                        {{-- APELLIDOS --}}
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="form-one__group">
                                                <label for="apellidoAcompa_{{ $indiceAdulto }}">Apellidos</label>
                                                <input required type="text" id="apellidoAcompa_{{ $indiceAdulto }}"
                                                    name="apellidoAcompa[]" class="form-one__input"
                                                    placeholder="Escriba los apellidos" autocomplete="off">
                                            </div>
                                        </div>
                                        {{-- SEXO --}}
                                        <div class="col-xl-12 col-lg-12 col-md-6">
                                            <div class="form-one__group">
                                                <label for="sexoAcompa_{{ $indiceAdulto }}">Sexo</label>
                                                <select required require class="selectpicker"
                                                    id="sexoAcompa_{{ $indiceAdulto }}" name="sexoAcompa[]">
                                                    <option value="0" selected disabled>Selecciona una opción
                                                    </option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- FECHA NAC --}}
                                        <div class="col-xl-4 col-lg-4 col-md-12">
                                            <div class="form-one__group">
                                                <select required class="selectpicker"
                                                    id="dianacAcompa_{{ $indiceAdulto }}" name="dianacAcompa[]">
                                                    <option value="" disabled selected>Día</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-12">
                                            <div class="form-one__group">
                                                <select required class="selectpicker"
                                                    id="mesnacAcompa_{{ $indiceAdulto }}" name="mesnacAcompa[]">
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
                                                <select required class="selectpicker"
                                                    id="yearnacAcompa_{{ $indiceAdulto }}" name="yearnacAcompa[]">
                                                    <option value="" disabled selected>Año</option>
                                                    @for ($i = 1960; $i <= date('Y'); $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        {{-- PASAPORTE --}}
                                        @if ($paiscomercial != 'MX')
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="form-one__group">
                                                    <label>Número de pasaporte</label>
                                                    <input type="text" id="pasaporteAcompa_{{ $indiceAdulto }}"
                                                        name="pasaporteAcompa[]" class="form-one__input"
                                                        placeholder="Ingrese pasaporte" autocomplete="off">
                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $indiceAdulto++;
                                        @endphp
                                    @endfor
                                @endif
                                {{-- ACOMPAÑANTE MENOR --}}
                                @if ($cmenores > 0)
                                    <div>
                                        <h4> {{ $cmenores == 1 ? 'Datos del acompañante menor' : 'Datos de los acompañantes menores' }}
                                        </h4>
                                    </div>
                                    @for ($e = 0; $e < $cmenores; $e++)
                                        <h6>Menor {{ $indiceMenor }}</h6>
                                        {{-- NOMBRE --}}
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="form-one__group">
                                                <label for="nombreMenor_{{ $indiceMenor }}">Nombres</label>
                                                <input required type="text" id="nombreMenor_{{ $indiceMenor }}"
                                                    name="nombreMenor[]" class="form-one__input"
                                                    placeholder="Escriba los nombres" autocomplete="off">
                                            </div>
                                        </div>
                                        {{-- APELLIDOS --}}
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="form-one__group">
                                                <label for="apellidoMenor_{{ $indiceMenor }}">Apellidos</label>
                                                <input required type="text" id="apellidoMenor_{{ $indiceMenor }}"
                                                    name="apellidoMenor[]" class="form-one__input"
                                                    placeholder="Escriba los apellidos" autocomplete="off">
                                            </div>
                                        </div>
                                        {{-- SEXO --}}
                                        <div class="col-xl-12 col-lg-12 col-md-6">
                                            <div class="form-one__group">
                                                <label for="sexoMenor_{{ $indiceMenor }}">Sexo</label>
                                                <select required require class="selectpicker"
                                                    id="sexoMenor_{{ $indiceMenor }}" name="sexoMenor[]">
                                                    <option value="0" selected disabled>Selecciona una opción
                                                    </option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- FECHA NAC --}}
                                        <div class="col-xl-4 col-lg-4 col-md-12">
                                            <div class="form-one__group">
                                                <select required class="selectpicker"
                                                    id="dianacMenor_{{ $indiceMenor }}" name="dianacMenor[]">
                                                    <option value="" disabled selected>Día</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-12">
                                            <div class="form-one__group">
                                                <select required class="selectpicker"
                                                    id="mesnacMenor_{{ $indiceMenor }}" name="mesnacMenor[]">
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
                                                <select required class="selectpicker"
                                                    id="yearnacMenor_{{ $indiceMenor }}" name="yearnacMenor[]">
                                                    <option value="" disabled selected>Año</option>
                                                    @for ($i = 1960; $i <= date('Y'); $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        {{-- PASAPORTE --}}
                                        @if ($paiscomercial != 'MX')
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="form-one__group">
                                                    <label>Número de pasaporte</label>
                                                    <input type="text" id="pasaporteMenor_{{ $indiceMenor }}"
                                                        name="pasaporteMenor[]" class="form-one__input"
                                                        placeholder="Ingrese pasaporte" autocomplete="off">
                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $indiceMenor++;
                                        @endphp
                                    @endfor
                                @endif
                                {{-- CORREO --}}
                                <div class="col-12 mt-5">
                                    <div class="form-one__group">
                                        <h2 class="text-center">¿A dónde enviamos la confirmación de tu reservación?</h2>
                                        <p class="text-center">El e-mail que elijas será fundamental para que gestiones tu
                                            reserva
                                        </p>
                                        <input type="email" class="form-one__input" name="email" id="email"
                                            placeholder="Escriba su email" required autocomplete="off">
                                    </div>
                                </div>
                                {{-- CUPON --}}
                                @if ($aplicapromo == '0' or $aplicapromo == null)
                                    <div id="containerCounpon" class="form-group margin-form"
                                        style="display: none; width: 100%;">
                                        <label for="inputGetCoupon">¿Tienes algún cupón? - Ingresar código de cupón</label>
                                        <div class="containerCupones">
                                            {{-- INPUT & BTN --}}
                                            
                                                <input type="text" class="form-one__input" name="cupon"
                                                    id="inputGetCoupon" placeholder="Escriba su cupón"
                                                    autocomplete="off">
                                                <button id="checkCoupon"
                                                    class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base"
                                                    onclick="comprobarCoupon(5);">
                                                    <span>
                                                        <i aria-hidden="true" class="fa-solid fa-gift"
                                                            style="margin-right: 2px;"></i>Aplicar
                                                        Cupón
                                                    </span>
                                                </button>
                                            
                                            {{-- MSJ CUPON --}}
                                            <div id="mensajeCupon" class="alert-primary" style="display: none;"
                                                role="alert">
                                                <div class="mensajeStyleCupon" id="containerValid">
                                                    <i aria-hidden="true" id="iconMenssage"
                                                        style="margin-right: 4px;"></i>
                                                    <p id="mensajeSucces" style="margin: 0;"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="containerTheMessageCuponResponse" id="mensajeCuponAplicado"
                                                style="display: none;">
                                                <i aria-hidden="true" id="iconMenssageSub"
                                                    style="margin-right: 4px;"></i>
                                                <p id="mensajeSuccesInformationCoupon" style="margin: 0; padding: 0;">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div id="terminos-condiciones"></div>
                                <div id="procesosPagos"></div>
                                {{-- TERMINALES --}}
                                @php
                                    $paypal = 0;
                                    $paypalClientId = 0;
                                @endphp
                                <div class="row" id="contenedorTerminales">
                                    <div class="col-sm-12">
                                        <h5>{{ count($sitioweb[0]->terminales) > 0 ? 'Métodos de pago:' : 'Pagar ahora' }}
                                        </h5>
                                    </div>
                                    <div class="row">
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
                                                    {{-- Terminal Paypal --}}
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
                    </div>
                    {{-- TICKET --}}
                    <div class="col-xl-4 col-lg-4">
                        <div class="checkout-page__your-order">
                            <h2 class="checkout-page__title">Detalles de compra</h2>
                            <input type="hidden" id="adultos" class="form-control" value="{{ $cadultos }}">
                            <input type="hidden" id="menores" class="form-control" value="{{ $cmenores }}">
                            <input type="hidden" id="infantes" class="form-control" value="{{ $cinfantes }}">
                            <table class="table table_summary">
                                <tbody>
                                    <tr>
                                        <td class="bold">Nombre del Tour</td>
                                        <td>{{ $nombretour }}</td>
                                    </tr>
                                    @php
                                        if ($fechaviaje != '') {
                                            $fechita = $fn->fechaAbreviada($fechaviaje);
                                        } else {
                                            $fechita = $fn->fechaAbreviada($fecha_inicio);
                                        }
                                    @endphp
                                    <tr>
                                        <td class="bold">Fecha</td>
                                        <input type="hidden" id="fecha_viaje_input" class="form-control" value="{{ $fechita }}">
                                        <td>{{ $fechita }}</td>
                                    </tr>
                                    @php
                                        // if ($aplicapromo == 1) {
                                        //     $padulto_old = $padulto;
                                        //     $pmenor_old = $pmenor;
                                        //     $pinfante_old = $pinfante;

                                        //     if ($descuento_frm == 1) {
                                        //         //Porcentaje
                                        //         $padulto = $padulto - $padulto * ($valor_promocion_frm / 100);
                                        //         $pmenor = $pmenor - $pmenor * ($valor_promocion_frm / 100);
                                        //         $pinfante = $pinfante - $pinfante * ($valor_promocion_frm / 100);
                                        //     } else {
                                        //         //Monto
                                        //         $padulto = $padulto - $valor_promocion_frm;
                                        //         $pmenor = $pmenor - $valor_promocion_frm;
                                        //         $pinfante = $pinfante - $valor_promocion_frm;
                                        //     }
                                        // }
                                    @endphp
                                    <tr>
                                        <td class="bold">Adultos: {{ $cadultos }}</td>
                                        <td>
                                            @if ($tipo_costo == 0)
                                                {{ "$ " . $fn->moneda($padulto * $cadultos) }}
                                            @else
                                                @if ($aplicapromo == 1)
                                                    {{ "$ " . $fn->moneda($gtotalPromo) }}
                                                @else
                                                    {{ "$ " . $fn->moneda($gtotal) }}
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Menores: {{ $cmenores }}</td>
                                        <td>
                                            @if ($tipo_costo == 0)
                                                {{ "$ " . $fn->moneda($pmenor * $cmenores) }}
                                            @else
                                                {{ "$ " . '0' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold">Infantes: {{ $cinfantes }}</td>
                                        <td>
                                            @if ($tipo_costo == 0)
                                                {{ "$ " . $fn->moneda($pinfante * $cinfantes) }}
                                            @else
                                                {{ "$ " . '0' }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot id="tfooterTable">
                                    <tr class="total_row">
                                        <td><strong>TOTAL</strong></td>
                                        <td colspan="2" class="text-right">
                                            @if ($aplicapromo == 1 && $gtotalPromo != '')
                                                <input class="w-100 text-right border-0 bg-transparent bold"
                                                    name="total" id="total"
                                                    value="{{ "$ " . $fn->moneda($gtotalPromo) . ' ' . $monedaSeleccionada }}"
                                                    disabled>
                                            @else
                                                <input class="w-100 text-right border-0 bg-transparent bold"
                                                    name="total" id="total"
                                                    value="{{ "$ " . $fn->moneda($gtotal) . ' ' . $monedaSeleccionada }}"
                                                    disabled>
                                                <input type="hidden" name="totalConCupon" id="totalExperienciaFinal"
                                                    value="{{ $fn->moneda($gtotal) }}">
                                            @endif
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
@endSection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/stylesBotonOpenPay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stylesCouponMessage.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/helpers/css/experiencias/datosCompras.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/intTelInputLocal.css')}}">

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

        #inputprecioTotalAnticipoTable, #total {
            border: none;
            background: none;
            text-align: start !important;
            font-weight: 700;
        }
        .containerCupones {
            width: 80%;
            flex-direction: initial;
        }

        .containerCupones > input {
            width: 40%;
        }
        .containerCupones > button {
            width: max-content;
        }
        .labelWP {
            margin-top: 15px;
        }
        #telefonoTitular {
            border: none;
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
    <script src="{{ asset('assets/helpers/js/experiencias/datoscompras.js') }}"></script>
    <script src="{{asset('assets/js/prefijo_formulario.js')}}"></script>
    @if ($paypal == 1)
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $monedaSeleccionada }}&disable-funding=credit,card">
        </script>

        <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    let totalPaypal = totalPaypalTour();
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
                            url: "save-openpay",
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
                            let url = "gracias-openpay?id=" + transaccion + "&terminal=4&monto=" + total +
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

            function totalPaypalTour() {
                let totalPaypal;
                let gTotalPromo = $('#gtotalPromo').val();
                let aplicapromo = $('#aplicapromo').val();
                let gtotalTour = $('#gtotal').val();

                if (aplicapromo == 1) {
                    totalPaypal = gTotalPromo;
                } else {
                    totalPaypal = gtotalTour;
                }

                return parseFloat(totalPaypal).toFixed(2);
            };
        </script>
    @endif

    <script>
        //first - ShowDi
        $('#email').on("change", function() {
            let emailValue = $('#email').val();
            evaluarEmail(emailValue);
        });

        //Second - buttonCouponVerif
        const couponResponse = (tipoServicio, coupon, emailValue, totalTourFinal, telefonoTitular) => {
            let dataJson = {
                data: {
                    id_servicio: tipoServicio,
                    email: emailValue,
                    total: totalTourFinal,
                    cupon: coupon,
                    telefono: telefonoTitular,
                }
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax({
                url: `/validarCupon`,
                method: "POST",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify(dataJson),
            }).done(function(data) {
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
            let bonos = descuento;
            let gTotalJs = total;
            let phpTotal = "@php echo $fn->moneda($gtotal) . ' ' . $monedaSeleccionada @endphp";
            let phpMonedaSelect = "<?php echo $monedaSeleccionada; ?>";

            if (validStatus) {
                nuestroMensaje = 'Cupón aplicado';
                if (hasDescuent) {
                    mensajeConCuponAplicado = `Obtienes un ${bonos}% de descuento al finalizar tu compra`;
                    let tableHtmlRow = `<tr class="total_row" id="totalPriceNew">
                            <td><strong>Nuevo Total</strong></td>
                            <td colspan="2" class="text-right">
                                    <input name="total" class="text-right" id="total" value="$ ${total} ${phpMonedaSelect}" disabled="">
                                    <input type="hidden" name="totalConCuponTable" id="totalTourFinalTable" value="${total}">
                            </td>
                        </tr>`;
                    removerNewPriceTours("totalPriceNew");
                    $("#tfooterTable").append(tableHtmlRow);
                    $("#total").css("text-decoration", "Line-through");
                    $("#iconMenssageSub").addClass("fa-solid fa-gift");
                } else {
                    $("#total").css("text-decoration", "none");
                }
                mensajeConResumen = `${nuestroMensaje} : ${mensajeCupon}`;
            } else {
                nuestroMensaje = 'Cupón no aplicado';
                mensajeConCuponAplicado = '';
                mensajeConResumen = `${nuestroMensaje} : ${mensajeCupon}`;
                if(document.getElementById("strongprecioTotalAnticipoTable")) {
                    $("#total").css("text-decoration", "Line-through");
                } else {
                    $("#total").css("text-decoration", "none");
                }
            }
            text.innerText = mensajeConResumen;
            mensajeInformacionCupon.innerText = `${mensajeConCuponAplicado}`;
        }
    </script>

    <script>
        let politicas = document.getElementById('politicas').value;
        let seccion_politicas = `
                        <div class="mt-3">
                            <div>
                                <input id="check-politicas" type="checkbox">
                                <a class="txt-check" onclick="openModal('modal-1')">Aceptar <span style="color:#2465ff">Términos y Condiciones</span></a>
                            </div>
                            <div id="modal-1" class="jw-modal">
                                <div class="jw-modal-body">

                                    <div class="row titulo_terms" style="display:flex; align-items:flex-start; justify-content:space-between;">
                                        <div class="col-9 col-lg-10">
                                            <h2>Términos y Condiciones</h2>
                                        </div>

                                        <div class="col-2 col-lg-2">
                                            <a class="close-modal" aria-label="cerrar ventana emergente de términos y condiciones"
                                                onclick="closeModal()">
                                                <i aria-hidden="true" class="fa-solid fa-xmark"></i>
                                            </a>
                                        </div>
                                    </div>
                                   
                                    <div class="txt-politicas">
                                        ${politicas}
                                    </div>
                                </div>
                            </div>
                        </div>`;
        $("#terminos-condiciones").after(seccion_politicas);


        function openModal(id) {
            document.getElementById(id).classList.add('open');
            document.body.classList.add('jw-modal-open');
        }


        function closeModal() {
            document.querySelector('.jw-modal.open').classList.remove('open');
            document.body.classList.remove('jw-modal-open');
        }


        window.addEventListener('load', function() {
            document.addEventListener('click', event => {
                if (event.target.classList.contains('jw-modal')) {
                    closeModal();
                }
            });
        });


        $("#btnPagar").prop("disabled", true);
        $("#paypal-button-container").addClass("dissabled-btn");
        $(".btnOpenPay").addClass("dissabled-btn");


        const checkbox_politicas = document.getElementById('check-politicas');


        checkbox_politicas.addEventListener('change', (event) => {
            if (event.currentTarget.checked) {
                $("#btnPagar").prop("disabled", false);
                $("#paypal-button-container").removeClass("dissabled-btn");
                $(".btnOpenPay").removeClass("dissabled-btn");
            } else {
                $("#btnPagar").prop("disabled", true);
                $("#paypal-button-container").addClass("dissabled-btn");
                $(".btnOpenPay").addClass("dissabled-btn");

            }
        })
    </script>
    <script>
        classNameFontAwesome            = "fa-solid fa-money-bill";
        classNameFontAwesomeWP          = "fa-brands fa-whatsapp";
        classNameFontAwesomeClose       = "fa-solid fa-xmark";
        classNameFontAwesomeNoneCoupon  = 'fa-solid fa-circle-xmark';
    </script>
@endsection
