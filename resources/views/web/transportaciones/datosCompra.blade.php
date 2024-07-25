@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp

@extends('layouts.master')

@section('metaSEO')
    <title>Datos Compra Transportación</title>
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
                    <li>Transportación</li>
                    <li>Datos de compra</li>
                </ul>
            </div>
        </div>
    </section>
    {{-- MAIN --}}
    <section id="tour_details_main" class="section_padding" style="margin-top: 20px; margin-bottom: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 add_bottom_15">
                    <form id="frmCompra" action="{{ route('save-openpay-transportacion-m1') }}" method="post">
                        @csrf
                        <input type="hidden" id="politicas" value="{{ $sitioweb[0]->politicas }}">
                        <input type="hidden" name="terminal" id="terminal" value="3">
                        <input type="hidden" name="transaccion" id="transaccion" value="{{ Str::random(15) }}">
                        <input type="hidden" name="bookingTech" id="bookingTech" value="0">

                        <input type="hidden" name="tipo_servicio" value="{{ $tipo_servicio }}">
                        <input type="hidden" name="tipo_pago" value="{{ $tipo_pago }}">

                        <input type="hidden" name="tipoServicio" id="tipoServicio" value="{{ $tipo }}">
                        <input type="hidden" name="idtarifa" value="{{ $reg }}">

                        <input type="hidden" name="zonaDesde" value="{{ $idDesde }}">
                        <input type="hidden" name="zonaHasta" value="{{ $idHasta }}">

                        <input type="hidden" name="origenTransporte" value="{{ $origenTransporte }}">
                        <input type="hidden" name="destinoTransporte" value="{{ $destinoTransporte }}">

                        <input type="hidden" name="precioUnidad" id="precioUnidad" value="{{ $precioAdultos }}">
                        <input type="hidden" name="precioAdulto" id="precioAdulto" value="{{ $precioAdultos }}">
                        <input type="hidden" name="precioMenor" id="precioMenor" value="{{ $precioMenores }}">
                        <input type="hidden" name="precioInfante" id="precioInfante" value="{{ $precioInfantes }}">

                        <input type="hidden" name="adultos" value="{{ $adultos }}">
                        <input type="hidden" name="menores" value="{{ $menores }}">

                        <input type="hidden" name="id_unidad" value="{{ $id_unidad }}">
                        <input type="hidden" name="tipo_unidad" value="{{ $tipo_unidad }}">

                        <input type="hidden" name="openpayID" id="openpayID">
                        <input type="hidden" name="openpayLINK" id="openpayLINK">
                        <input type="hidden" name="domain" value="{{ Request::root() }}">
                        {{-- <input type="hidden" name="gracias" value="gracias-openpay-transportacion-m1"> --}}
                        <input type="hidden" name="gracias" value="gracias-openpay-transportaciones">
                        <input type="hidden" name="descripcion" value="Servicio de transportación">
                        <input type="hidden" name="currency" value="{{ $monedaSeleccionada }}">

                        <input type="hidden" name="fechaLlegada" value="{{ $fechaLlegada }}">
                        <input type="hidden" name="fechaSalida" value="{{ $fechaSalida }}">

                        <input type="hidden" name="total" id="total" value="{{ $total }}">
                        <input type="hidden" name="totalTransportacionFinal" id="totalTransportacionFinal" value="{{ $total }}">
                        <input type="hidden" name="idafiliado" value="{{ Session::get('idAfiliado') }}">
                        
                        <div class="form_title my-4">
                            <h3><strong>1 - </strong>¿Quieres agregar algún producto a tu reservación?</h3>
                        </div>

                        <div class="row">
                            @if ($countProductos > 0)
                                @foreach ($productosTiendita as $producto)
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 mb-2" style="margin-bottom: 15px;">
                                        <div style="border: 1px solid #B2A59B; border-radius: 5px;">
                                            <div
                                                style="background-color: #ffff; border-bottom: 1px solid #B2A59B; border-top-left-radius: 5px; border-top-right-radius: 5px; height: 35px; display:flex; justify-content: center; align-items: center;">
                                                <b>{{ $producto['nombre'] }}</b>
                                                {{-- {{ $producto->id}} --}}
                                            </div>
                                            <div class="card-body" style="background-color: #ffff; position: relative;">
                                                <div id="totalProducto_{{ $producto['id'] }}" class="totalProducto"
                                                    style="display: none;">
                                                    $ <span class="total"></span>
                                                    <br>
                                                    <small>{{ $monedaSeleccionada }}</small>
                                                </div>
                                                <div
                                                    style="background-color: #fff; display: flex; justify-content: center; align-items: center;">
                                                    <img src="{{ $producto['imagen'] }}" alt=""
                                                        style="height: 140px; width: auto;">
                                                </div>
                                                <div
                                                    style="background-color: #fff; display: flex; justify-content: center; align-items: center;">
                                                    <b style="font-weight: 400;">$
                                                        {{ $producto['precioProducto'] }}</b>
                                                    <span style="font-weight: 300; margin-left: 1px;">
                                                        {{ $monedaSeleccionada }}</span>
                                                </div>
                                            </div>
                                            <div class="card-footer p-0" style="width: 100%; height: 100%;">
                                                {{-- RESUMEN PROD --}}
                                                <div id="resumen_producto_{{ $producto['id'] }}" class="row oculto"
                                                    style="height: inherit; margin: 0; background-color: #f7f7f7; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; align-items: center;
                                                    padding: 20px 12px;">
                                                    {{-- ADD PRODUCTO --}}
                                                    <div class="col-sm-6"
                                                        style="height: inherit; display: flex; align-items: center;">
                                                        <input type="hidden" name="idproducto[]"
                                                            value="{{ $producto['id'] }}">
                                                        <select
                                                            style="padding: 5px 5px; text-align: center; height: 33.6px;"
                                                            name="cantidad[]" id="cantidad_{{ $producto['id'] }}"
                                                            class="form-control selectProducts"
                                                            onchange="subtotalProducto('{{ $producto['id'] }}', this, '{{ $producto['preciosimple'] }}', '{{ $monedaSeleccionada }}')">
                                                            @for ($i = 0; $i <= 20; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    {{-- BTN ELIMINAR --}}
                                                    <div class="col-sm-6"
                                                        style="height: inherit; display: flex; align-items: center;">
                                                        <button type="button" class="btn btn-danger w-100 compra"
                                                            onclick="eliminarProducto('{{ $producto['id'] }}', this)">
                                                            <i aria-hidden="true" class="fas fa-trash-alt"></i> Eliminar
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- AGREGAR PROD --}}
                                                <div id="agregar_producto_{{ $producto['id'] }}" class="row"
                                                    style="text-align: center; width: inherit; height: inherit; padding: 10px 40px; margin: 0; background-color: #f7f7f7; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                                                    <button type="button"
                                                        class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base compra"
                                                        onclick="agregarProducto('{{ $producto['id'] }}', this)">
                                                        <span>
                                                            <i aria-hidden="true" class="fas fa-plus"></i>
                                                            Agregar producto
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h6 class="textSinDisponibilidad">No hay productos disponibles</h6>
                            @endif
                        </div>

                        <div class="form_title my-4">
                            <h3><strong>2 - </strong>Resumen de la cuenta</h3>
                        </div>

                        <div class="steps">
                            <div class="row" style="padding: 5px;">
                                <table class="table table-hover table__Container__Ticket"
                                    style="background-color: #f6f6f6;">
                                    <thead>
                                        <tr class="table-primary fw-bold" style="background-color: #cfe2ff;">
                                            <td><b>Servicio</b></td>
                                            <td><b>Precio</b></td>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <tr>
                                            <td>
                                                <b>
                                                    {{ $tipo == 1 ? 'Traslado sencillo' : 'Traslado redondo' }}
                                                    <br>
                                                    {{ $tipo_servicio == 1 ? 'Servicio privado' : 'Servicio compartido' }}
                                                </b>
                                                <br>
                                                {{ $adultos }} {{ $adultos > 1 ? 'Adultos' : 'Adulto' }}
                                                @if ($menores > 0)
                                                    <br>{{ $menores }} {{ $menores > 1 ? 'Menores' : 'Menor' }}
                                                @endif
                                                <br>
                                                <b>Servicio:</b>
                                                <br>
                                                {{ $nombreOrigenTransporte }}
                                                - {{ $nombreDestinoTransporte }}
                                                @if ($tipo == 2)
                                                    - {{ $nombreOrigenTransporte }}
                                                @endif
                                            </td>
                                            <td class="text-end">$ <span id="totalTraslado">{{ $total }}</span>
                                                <small id="isoCuenta">{{ $monedaSeleccionada }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Productos varios</b></td>
                                            <td class="text-end">$ <span id="totalProductos">0</span> <small
                                                    id="isoCuenta">{{ $monedaSeleccionada }}</small></td>
                                        </tr>
                                    </tbody>
                                    <tfoot id="tfooterTable">
                                        <tr class="table-danger fw-bold" style="background-color:#f8d7da;">
                                            <td><b>Total: </b></td>
                                            <td class="text-end oldCuenta">$ <span
                                                    id="totalCuenta">{{ $total }}</span> <small
                                                    id="isoCuenta">{{ $monedaSeleccionada }}</small></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">

                        </div>

                        <div class="form_title my-4">
                            <h3><strong>3 - </strong>Información del titular</h3>
                            <p>
                                Inserte sus datos en los respectivos campos
                            </p>
                        </div>
                        <div class="step">
                            <div class="row mb-5">
                                <div class="col-sm-6 my-2">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="form-group">
                                        <label>Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-sm-6 my-2">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="number" name="telefono" id="telefono" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <select required class="form-control" id="sexoTitular" name="sexoTitular">
                                            <option value="0" selected disabled>Selecciona una
                                                opción</option>
                                            <option value="M">Masculino
                                            </option>
                                            <option value="F">Femenino
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <h4>Fecha de nacimiento</h4>
                                <div class="col-sm-4 my-3">
                                    <div class="form-group">
                                        <select required class="form-control" id="dianacTitular" name="dianacTitular">
                                            <option value="0" disabled selected>
                                                Día</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 my-3">
                                    <div class="form-group">
                                        <select required class="form-control" id="mesnacTitular" name="mesnacTitular">
                                            <option value="0" disabled selected>
                                                Mes</option>
                                            <option value="1">Enero
                                            </option>
                                            <option value="2">
                                                Febrero</option>
                                            <option value="3">Marzo
                                            </option>
                                            <option value="4">Abril
                                            </option>
                                            <option value="5">Mayo
                                            </option>
                                            <option value="6">Junio
                                            </option>
                                            <option value="7">Julio
                                            </option>
                                            <option value="8">Agosto
                                            </option>
                                            <option value="9">
                                                Septiembre</option>
                                            <option value="10">
                                                Octubre</option>
                                            <option value="11">
                                                Noviembre</option>
                                            <option value="12">
                                                Diciembre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 my-3">
                                    <div class="form-group">
                                        <select required class="form-control" id="yearTitular" name="yearTitular">
                                            <option value="0" disabled selected>
                                                Año</option>
                                            @for ($i = 1960; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}">
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form_title my-4">
                            <h3><strong>4 - </strong>Datos del servicio</h3>
                            <p class="text-danger">
                                Es importante que te asegures de escribir todos los datos correctamente
                            </p>
                        </div>
                        <div class="step" style="padding: 5px;">
                            <!-- Datos del traslado de IDA -->
                            <div class="row mb-5">
                                <div class="col-12">
                                    <h6 class="fw-bold">
                                        <i aria-hidden="true" class="fas fa-check-circle"></i>
                                        {{ $nombreOrigenTransporte }} - {{ $nombreDestinoTransporte }}
                                    </h6>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-sm-4 my-3">
                                    <div class="form-group">
                                        <label>Saliendo desde</label>
                                        <div class="styled-select-common">
                                            <input type="text" class="form-control" readonly
                                                value="{{ $nombreOrigenTransporte }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 my-3">
                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <div class="styled-select-common">
                                            <input type="text" class="form-control" readonly
                                                value="{{ $fn->fechaAbreviada($fechaLlegada) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 my-3">
                                    <div class="form-group">
                                        <label>¿A qué hora pasamos por ti?</label>
                                        <div class="styled-select-common">
                                            <input type="time" name="horarioServicioLlegada"
                                                id="horarioServicioLlegada" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- vuelosOrigen -->
                            @if ($vuelosOrigen == 1)
                                <div class="row mb-5">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Aerolínea de llegada</label>
                                            <div class="styled-select-common">
                                                <input type="text" class="form-control" name="aerolineaLlegada"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Núm de vuelo</label>
                                            <div class="styled-select-common">
                                                <input type="text" class="form-control" name="vueloLlegada" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Hora de llegada</label>
                                            <div class="styled-select-common">
                                                <input type="time" name="horaLlegada" id="horaLlegada"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row mb-5">
                                <div class="col-sm-12 mb-3">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Destino del traslado</label>
                                            <div class="styled-select-common">
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $nombreDestinoTransporte }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($vuelosDestino == 1)
                                <div class="row mb-5">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Aerolínea de salida</label>
                                            <div class="styled-select-common">
                                                <input type="text" class="form-control" name="aerolineaSalida"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Núm de vuelo</label>
                                            <div class="styled-select-common">
                                                <input type="text" class="form-control" name="vueloSalida" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Hora de llegada</label>
                                            <div class="styled-select-common">
                                                <input type="time" name="horaSalida" id="horaSalida"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- Termina datos del traslado de IDA -->

                            <!-- Inicia datos del servicio de regreso (cuando es redondo) -->
                            @if ($tipo == 2)
                                <div class="row mt-5 mb-5">
                                    <div class="col-12">
                                        <h6 class="fw-bold">
                                            <i aria-hidden="true" class="fas fa-check-circle"></i>
                                            {{ $nombreDestinoTransporte }} {{ $nombreOrigenTransporte }}
                                        </h6>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Saliendo desde</label>
                                            <div class="styled-select-common">
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $nombreDestinoTransporte }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <div class="styled-select-common">
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $fn->fechaAbreviada($fechaSalida) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>¿A qué hora pasamos por ti?</label>
                                            <div class="styled-select-common">
                                                <input type="time" name="horarioServicioSalida"
                                                    id="horarioServicioSalida" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- vuelosDestino -->
                                @if ($vuelosOrigen == 1)
                                    <div class="row mb-5">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Aerolínea de salida</label>
                                                <div class="styled-select-common">
                                                    <input type="text" class="form-control" name="aerolineaSalida"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Núm de vuelo</label>
                                                <div class="styled-select-common">
                                                    <input type="text" class="form-control" name="vueloSalida"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Hora de salida</label>
                                                <div class="styled-select-common">
                                                    <input type="time" name="horaSalida" id="horaSalida"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-5">
                                    <div class="col-sm-12 mb-3">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Destino del traslado</label>
                                                <div class="styled-select-common">
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ $nombreOrigenTransporte }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-sm-12 mb-3">
                                        <div class="row">
                                            <div class="col-12" style="padding: 10px;">
                                                <label>Tienes alguna observación para tu servicio?</label>
                                                <div class="styled-select-common">
                                                    <textarea name="comentarios" id="comentarios" cols="30" rows="10" class="form-control textArea"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="form_title my-4">
                            <h3><strong>5 - </strong>¿A dónde enviamos la confirmación de tu reservación?</h3>
                        </div>

                            <div class="step">
                                {{-- CORREO --}}
                                <div class="row mb-5">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>El e-mail que elijas será fundamental para que gestiones tu
                                                reserva</label>
                                            <div class="styled-select-common">
                                                <input type="email" name="email" id="email"
                                                    placeholder="Escriba su email" required autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- CUPONES --}}
                                <div class="row mb-2">
                                    <div id="containerCounpon" class="form-group margin-form mb-5"
                                        style="display: none; width: 90%;">
                                        <label for="inputGetCoupon">¿Tienes algún cupón? - Ingresar código de
                                            cupón</label>
                                        <div class="containerCupones">
                                            {{-- INPUT & BTN --}}
                                            <div class="caja_cupon">
                                                <input type="text" class="form-control" name="cupon"
                                                    id="inputGetCoupon" placeholder="Escriba su cupón" autocomplete="off">
                                                <button aria-label="Aplicar cupón" id="checkCoupon"
                                                    onclick="comprobarCoupon(3);"
                                                    class="tour-listing-details__sidebar-btn trevlo-btn trevlo-btn--base"><span><i
                                                            class="fa-solid fa-gift" style="margin-right: 2px;"></i> Aplicar
                                                        Cupón</span></button>
                                            </div>
                                            {{-- MSJ CUPON --}}
                                            <div id="mensajeCupon" class="alert-primary" style="display: none;"
                                                role="alert">
                                                <div class="mensajeStyleCupon" id="containerValid">
                                                    <i id="iconMenssage" style="margin-right: 4px;"></i>
                                                    <p id="mensajeSucces" style="margin: 0;"></p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- MESSAGE CUPON --}}
                                        <div>
                                            <div class="containerTheMessageCuponResponse" id="mensajeCuponAplicado"
                                                style="display: none;">
                                                <i id="iconMenssageSub" style="margin-right: 4px;"></i>
                                                <p id="mensajeSuccesInformationCoupon" style="margin: 0; padding: 0;">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="terminos-condiciones"></div>

                        {{-- TERMINALES --}}
                        @php
                            $paypal = 0;
                            $paypalClientId = 0;
                        @endphp
                        <div class="row mb-5 mt-5">
                            <div class="col-sm-12">
                                <h5>{{ count($sitioweb[0]->terminales) > 0 ? 'Métodos de pago:' : 'Pagar ahora' }}</h5>
                                {{-- <hr> --}}
                            </div>
                            @if (count($sitioweb[0]->terminales) > 0)
                                @foreach ($sitioweb[0]->terminales as $terminal)
                                    @if ($terminal->id == 3)
                                        {{-- Terminal Openpay --}}
                                        <div class="col-md-4 text-center">
                                            <button type="submit" class="btn btnDatosCompra btnOpenPay" id="btnPagar">
                                                <img src="{{ asset('assets/images/openpay-logo.webp') }}" alt=""
                                                    style="height: auto; width: 110px;">
                                            </button>
                                            <p class="textCardPayment">Realiza tu pago de forma segura con Openpay a
                                                través
                                                de BBVA. Solo se aceptan tarjetas mexicanas.</p>
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
                                            <p class="textCardPayment">Se aceptan tarjetas internacionales y cuentas
                                                PayPal.</p>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        {{-- <input type="hidden" name="cantidad[]" value="[]"> --}}
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stylesTransportacionListDaniel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stylesBotonOpenPay.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/intTelInputLocal.css')}}">
    <style>
        #currency {
            display: none;
        }

        .oculto2 {
            display: flex;
        }
        .btnOpenPay {
            background-color: #ffc439;
        }

        .btn:hover {
            background: #ffcb00d4;
            filter: brightness(0.9);
        }
        #telefono {
            border: var(--bs-border-width) solid var(--bs-border-color);
            padding-top: 7px;
            padding-bottom: 7px;
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

        .titulo_terms {
            padding: 15px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/helpers/js/hoteleria/datoscompras.js') }}"></script>
    @if ($paypal == 1)
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $monedaSeleccionada }}&disable-funding=credit,card">
        </script>
        <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    let totalPaypal = $('#total').val();
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
                            url: "/save-openpay-transportaciones",
                            data: $("#frmCompra").serialize(),
                            dataType: "json"
                        })
                        .done(function(e) {
                            if (e.transaccion !== '') {
                                $("#bookingTech").val("1");
                            }
                        })
                        .fail(function(e) {
                            console.log('error al reservar');
                            console.log(e);
                            console.log(e.responseJSON);
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
                        url: "/paypalEstatus",
                        data: dataLogs,
                        dataType: "json"
                    })
                    .done(function(e) {
                        if (e.status === 'COMPLETED') {
                            let transaccion = $("#transaccion").val();
                            let total = $("#total").val();
                            let url = "/gracias-openpay-transportaciones?id=" + transaccion + "&terminal=4&monto=" + total +
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
        function agregarProducto(producto, elem) {
            $("#resumen_producto_" + producto).removeClass("oculto");
            $("#agregar_producto_" + producto).addClass("oculto");
            // add edit
            $("#resumen_producto_" + producto).addClass("oculto2");
        }

        function eliminarProducto(producto, elem) {
            $("#resumen_producto_" + producto).addClass("oculto");
            // add edit
            $("#resumen_producto_" + producto).removeClass("oculto2");

            $("#agregar_producto_" + producto).removeClass("oculto");
            $("#cantidad_" + producto + " option[value='0']").attr("selected", true);

            $("#totalProducto_" + producto).fadeOut("fast", function() {
                $("#totalProducto_" + producto + " span").empty();
                $("#totalProducto_" + producto + " small").empty();
                cuentaProductos();
            });
        }

        function cuentaProductos() {
            let totalProducto = 0;
            $(".totalProducto").each(function() {
                if ($(this).is(":visible")) {
                    totalProducto += parseFloat($(this).children(".total").html());
                }
            });

            $("#totalProductos").html(totalProducto.toFixed(2));
            granTotal();
        }

        function granTotal() {
            var totalProducto = parseFloat($("#totalProductos").html());
            var totalServicio = parseFloat($("#totalTraslado").html());
            var granTotal = totalProducto + totalServicio;
            granTotal = granTotal.toFixed(2);
            $("#totalCuenta").html(granTotal);
            $("#total").val(granTotal);
            $("#totalTransportacionFinal").val(granTotal);
        }

        function subtotalProducto(producto, elem, precio, iso) {
            var cantidad = $(elem).val();
            var total = cantidad * precio;
            $("#totalProducto_" + producto + " span").html(total);
            $("#totalProducto_" + producto + " small").html(iso);

            $("#totalProducto_" + producto).fadeIn("fast", function() {

            });

            cuentaProductos();
        }

        function cuentraTransportacion() {
            var cantAdultos = $("#adultos").val();
            var cantMenores = $("#menores").val();
            var cantInfantes = $("#infantes").val();

            var precioAdultos = $("#precioAdulto").val();
            var precioMenor = $("#precioMenor").val();
            var precioInfante = $("#precioInfante").val();

            if (parseInt(cantAdultos) > 0) {
                totalAdultos = cantAdultos * precioAdultos;
            } else {
                totalAdultos = 0;
            }

            if (parseInt(cantMenores) > 0) {
                totalMenores = cantMenores * precioMenor;
            } else {
                totalMenores = 0;
            }

            if (parseInt(cantInfantes) > 0) {
                totalInfantes = cantInfantes * precioInfante;
            } else {
                totalInfantes = 0;
            }

            var granTotal = totalAdultos + totalMenores + totalInfantes;

            $("#totalAdultos").val(totalAdultos);
            $("#totalMenores").val(totalMenores);
            $("#totalInfantes").val(totalInfantes);
            $("#gtotal").val(granTotal);

            var moneda = $("#currency").val();
            $("#total").val("$ " + granTotal + " " + moneda);
        }

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
            let phpTotal = "@php echo $total . ' ' . $monedaSeleccionada @endphp";
            let phpMonedaSelect = "<?php echo $monedaSeleccionada; ?>";
            $('#total').val(total);
            if (validStatus) {
                nuestroMensaje = 'Cupón aplicado';
                if (hasDescuent) {
                    mensajeConCuponAplicado = `Obtienes un ${bonos}% de descuento al finalizar tu compra`;
                    let tableHtmlRow = `<tr class="total_row" id="totalPriceNew">
                                    <td><strong>Nuevo Total</strong></td>
                                    <td colspan="2" class="text-right">
                                            <input name="total" class="text-end" id="total" value="$ ${total} ${phpMonedaSelect}" disabled="">
                                            <input type="hidden" name="totalConCuponTable" id="totalTourFinalTable" value="${total}">
                                    </td>
                                </tr>`;
                    $("#tfooterTable").append(tableHtmlRow);
                    // $("#total").css("text-decoration", "Line-through");
                    $("#totalCuenta").css("text-decoration", "Line-through");


                    $("#iconMenssageSub").addClass("fa-solid fa-gift");
                } else {
                    // $("#total").css("text-decoration", "none");
                    $("#totalCuenta").css("text-decoration", "none");
                }
                mensajeConResumen = `${nuestroMensaje} : ${mensajeCupon}`;
            } else {
                nuestroMensaje = 'Cupón no aplicado';
                mensajeConCuponAplicado = '';
                mensajeConResumen = `${nuestroMensaje} : ${mensajeCupon}`;
                // $("#total").css("text-decoration", "none");
                $("#totalCuenta").css("text-decoration", "none");
            }
            text.innerText = mensajeConResumen;
            mensajeInformacionCupon.innerText = `${mensajeConCuponAplicado}`;
        }
    </script>
    <script>
        $(document).ready(function() {
            inputPrefijoHidden();
            $('#telefono').attr('type', 'text');
            var input = document.querySelector("#telefono");
    
            var pluginPrefijos = intlTelInput(input, {
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/js/utils.js",
                separateDialCode: true,
    
                hiddenInput: function(telInputName) {
                    return {
                    country: "isoNumber"
                    };
                }
            });
    
            input.addEventListener("countrychange", function() {
                editType();
            });
        });
    
        function editType() {
            let codigoNumber = document.getElementsByClassName('iti__selected-dial-code')[0].textContent;
            codigoNumber = String(codigoNumber).slice(1);
            return $('#codigoNumber').val(codigoNumber);
        }
    
        function inputPrefijoHidden() {
            let input           = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.id            = "codigoNumber";
            input.name          = "codigoNumber";
            return $('input[name=_token]')[0].after(input);
        }

        classNameFontAwesomeClose   = "fas fa-times";
    </script>
@stop
