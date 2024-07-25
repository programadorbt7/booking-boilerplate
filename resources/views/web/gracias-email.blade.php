@extends('layouts.master')

@section('metaSEO')
    <title>Gracias - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    <section class="offer-one" style="background-image: url('{{ asset('assets/images/backgrounds/offer-1-bg.png') }}');">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="offer-one__content sec-title">
                        <p class="offer-one__top-title">Correo envíado con éxito</p>
                        <h2 class="offer-one__heading sec-title__heading">Gracias por tu mensaje</h2>
                        <p class="offer-one__text">Tu comentario es importante para nosotros, gracias por contáctarnos en
                            breve nos comunicaremos contigo!</p>
                        <div class="offer-one__btn-box wow animated fadeInUp" data-wow-delay="0.1s"
                            data-wow-duration="1500ms">
                            <a aria-label="Home" href="/"
                                class="offer-one__btn trevlo-btn trevlo-btn--primary"><span>Ir al Home</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 wow animated fadeInRight" data-wow-delay="0.1s" data-wow-duration="1500ms">
                    <div class="offer-one__img-box">
                        <div class="offer-one__inner-img-box">
                            {{-- <img src="{{ asset('assets/images/offer/offer-1-1.jpg') }}" alt="offer"
                                class="offer-one__img-one"> --}}
                            <img src="{{ asset('assets/images/offer/offer-1-2.jpg') }}" alt="offer"
                                class="offer-one__img-two">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offer-one__shape-one trevlo-splax"
            data-para-options='{ "orientation": "left", "scale": 1.5, "overflow": true }'
            style="background-image: url({{ asset('assets/images/shapes/offer-shape-1.png') }});"></div><!-- /.bg -->
        <div class="offer-one__shape-two trevlo-splax"
            data-para-options='{ "orientation": "right", "scale": 1.5, "overflow": true }'
            style="background-image: url('{{ asset('assets/images/shapes/offer-shape-2.png') }}');"></div><!-- /.bg -->
        <div class="offer-one__bottom-bg"
            style="background-image: url('{{ asset('assets/images/offer/offer-1-4.png') }}');"></div><!-- /.bg -->
    </section>
@endsection
