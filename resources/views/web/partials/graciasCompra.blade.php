@extends('layouts.master')

@section('metaSEO')
    <title>Confirmación de Pago - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    {{-- GRACIAS --}}
    <section class="offer-one">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="offer-one__content sec-title">
                        <p class="offer-one__top-title">Confirmación de pago</p>
                        <h2 class="offer-one__heading sec-title__heading">
                            {{ $estatus === 'completed' ? 'SU PAGO SE HA REALIZADO CON ÉXITO' : 'SU PAGO NO PUDO SER PROCESADO' }}
                        </h2>
                        <p class="offer-one__text">
                            {{ $estatus === 'completed' ? 'Muchas Felicidades! Ahora prepárate para una experiencia inolvidable' : 'Comunícate con nosotros para encontrar una solución' }}
                        </p>

                        @if ($estatus === 'completed')
                            <h4>"Felicidades!, revisa tu correo"</h4>
                            <p class="offer-one__text">Te hemos enviado por correo todos los detalles de tu reservación,
                                revisa tu
                                <strong>SPAM</strong>.
                            </p>
                        @else
                            <h4>"Su pago fue rechazado"</h4>
                            <p class="offer-one__text">Motivo: {{ $mensaje }}</p>
                        @endif

                        <div class="offer-one__btn-box wow animated fadeInUp" data-wow-delay="0.1s"
                            data-wow-duration="1500ms">
                            <a aria-label="Inicio" href="/"
                                class="offer-one__btn trevlo-btn trevlo-btn--primary"><span>Ir al
                                    Inicio</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offer-one__shape-one trevlo-splax"
            data-para-options='{ "orientation": "left", "scale": 1.5, "overflow": true }'
            style="background-image: url('assets/images/shapes/offer-shape-1.png');"></div><!-- /.bg -->
        <div class="offer-one__shape-two trevlo-splax"
            data-para-options='{ "orientation": "right", "scale": 1.5, "overflow": true }'
            style="background-image: url('assets/images/shapes/offer-shape-2.png');"></div><!-- /.bg -->
        <div class="offer-one__bottom-bg" style="background-image: url('assets/images/offer/offer-1-4.png');"></div>
    </section>
@endsection
