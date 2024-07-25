@extends('layouts.master')

@section('metaSEO')
    <title>Nosotros - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="¿Quienes somos? aqui te cuento todo acerca de nosotros Funtastic tu agencia de viajes para conocer diversos lugares del mundo.">
    <meta name="keywords" content="Nosotros, Agencia de Viajes, A Cerca De, Funtastic, Somos, Desde, Experiencias, Tours">
@endsection

@section('contenido-principal')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('cucapah/img/nosotros1.webp') }})"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Nosotros</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a href="index.html">Inicio</a></li>
                    <li>Nosotros</li>
                </ul><!-- /.trevlo-breadcrumb -->
            </div><!-- /.page-header__breadcrumb-box -->
        </div>
    </section><!-- /.page-header -->

    <!-- About Four Start -->
    <section class="about-four section-space-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 about-four__img-column wow animated fadeInLeft" data-wow-delay="0.1s"
                    data-wow-duration="1500ms">
                    <div class="about-four__img-box">
                        <div class="about-four__inner-img-box-one">
                            <img src="{{ asset('assets/images/nosotros/imagen_nosotros1.webp') }}" alt="about-shape"
                                class="about-four__shape-one">
                        </div>
                        <div class="about-four__inner-img-box-two">
                            <img src="{{ asset('assets/images/nosotros/imagen_nosotros2.webp') }}" alt="about image" class="about-four__img-two">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 about-four__content-column">
                    <div class="about-four__content">
                        <div class="sec-title text-left">
                            <p class="sec-title__tagline">Conócenos</p>
                            <h2 class="sec-title__title">Asistencia Profesional para Tu Experiencia de Viaje </h2>
                        </div>
                        <p class="about-four__text">Nuestra misión es brindar asistencia profesional a quien requiera una EXPERIENCIA en su viaje. Nuestros esfuerzos se 
                            centran en dar soluciones antes, durante y después del viaje.</p>
                            <p>Nuestros valores: Calidad, Compromiso y Confianza.</p>
                        <div class="about-four__service">
                            <div class="about-four__service-box wow animated fadeInUp" data-wow-delay="0s"
                                data-wow-duration="1500ms">
                                <div class="about-four__service-icon">
                                    <span class="icon-safety"></span>
                                </div>
                                <div class="about-four__service-content">
                                    <h4 class="about-four__service-title">Siempre seguros</h4>
                                </div>
                            </div>
                            <div class="about-four__service-box wow animated fadeInUp" data-wow-delay="0.3s"
                                data-wow-duration="1500ms">
                                <div class="about-four__service-icon">
                                    <span class="icon-friendly-Guide"></span>
                                </div>
                                <div class="about-four__service-content">
                                    <h4 class="about-four__service-title">Guías <br> Amigables</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Two Start -->
    <section class="why-choose-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="why-choose-two__content">
                        <div class="sec-title text-left">

                            <p class="sec-title__tagline">Lo que nos motiva</p>

                            <h2 class="sec-title__title">Promoviendo un Turismo Justo y Equitativo.</h2>
                        </div>
                        <p class="why-choose-two__text">Nuestra empresa surge con la necesidad de reactivar la economía del país y de procurar un turismo justo para todos.</p>
                        <p class="why-choose-two__text">
                            El interés principal es crecer la marca y proporcionar una ganancia justa para nuestros Agentes Basados en Casa, además de la oportunidad de 
                            viajar, ¡obtener experiencias, salud y bienestar!

                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6">
                    <div class="why-choose-two__img">
                        <div class="why-choose-two__img__one wow fadeInUp" data-wow-delay="200ms">
                            <div class="trevlo-tilt"
                                data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 7, "speed": 700, "scale": 1 }'>
                                <img src="{{ asset('assets/images/nosotros/imagen_nosotros3.webp') }}" alt="why-choose">
                            </div>
                        </div><!-- /.why-choose-two__img__one -->
                        <div class="why-choose-two__img__two wow fadeInUp" data-wow-delay="300ms">
                            <div class="trevlo-tilt"
                                data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 7, "speed": 700, "scale": 1 }'>
                                <img src="{{ asset('assets/images/nosotros/imagen_nosotros4.webp') }}" alt="why-choose">
                            </div>
                            <div class="trevlo-tilt"
                                data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 7, "speed": 700, "scale": 1 }'>
                                <img src="{{ asset('assets/images/nosotros/imagen_nosotros5.webp') }}" alt="why-choose">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="offer-one" style="background-image: url('assets/images/backgrounds/offer-1-bg.png');">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="offer-one__content sec-title">
                        <h2 style="font-size: 30px;" class="offer-one__heading sec-title__heading">Empoderando a Mujeres para el Éxito y el Equilibrio</h2>
                        <p style="font-weight: bold;font-size: 15px;" class="offer-one__text">Originalmente nuestra empresa está enfocada para mujeres con las que nos identificamos. Mujeres independientes, ávidas de triunfar, generar 
                            dinero, ¡emprender! Pero también de educar, amar a la familia y consentirles, lo que con horarios de oficina se vuelve imposible. 
                            Hoy en día nos impulsa reactivar la economía y es por esto que ofrecemos una carrera en el Turismo, una red de apoyo integral y una posibilidad 
                            de tener un ingreso extra empezando una carrera de medio tiempo o tiempo completo, tú decides.</p>
                       {{--  <div class="offer-one__btn-box wow animated fadeInUp" data-wow-delay="0.1s"
                            data-wow-duration="1500ms">
                            <a href="tour-listing-side-filter-right.html"
                                class="offer-one__btn trevlo-btn trevlo-btn--primary"><span>Start Booking</span></a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 wow animated fadeInRight" data-wow-delay="0.1s" data-wow-duration="1500ms">
                    <div class="offer-one__img-box">
                        <div class="offer-one__inner-img-box">
                            <img src="{{ asset('assets/images/nosotros/imagen_nosotros7.webp') }}" alt="offer" class="offer-one__img-one">
                            <img src="{{ asset('assets/images/nosotros/imagen_nosotros6.webp') }}" alt="offer" class="offer-one__img-two">
                            <img src="assets/images/offer/offer-1-3.png" alt="offer" class="offer-one__img-three">
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
        <!-- /.bg -->
    </section>
    <!-- Offer End Start -->

    <!-- Counter One Start -->
    <section class="counter-one">
        <div class="counter-one__bg-box"></div><!-- /.counter-one__bg-box -->
        <div class="counter-one__main-content">
            <div class="container">
                <div class="counter-one__container container-fluid">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.1s"
                            data-wow-duration="1500ms">
                            <div class="counter-box @@extraClassName">
                                <div class="counter-box__icon">
                                    <span class="icon-happy-Travel"></span>
                                </div><!-- /.counter-box__icon -->
                                <div class="counter-box__inner sec-title count-box">
                                    <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text"
                                        data-stop="30.3" data-speed="1500">00</h3>
                                    <h3 class="counter-box__count-text sec-title__heading">k</h3>
                                </div><!-- /.counter-box__inner -->
                                <p class="counter-box__title">Viajeros felices</p>
                            </div>
                        </div><!-- /.col-xl-3 col-lg-3 col-6 -->
                        <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.3s"
                            data-wow-duration="1500ms">
                            <div class="counter-box @@extraClassName">
                                <div class="counter-box__icon">
                                    <span class="icon-tent-1"></span>
                                </div><!-- /.counter-box__icon -->
                                <div class="counter-box__inner sec-title count-box">
                                    <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text"
                                        data-stop="40.5" data-speed="1500">00</h3>
                                    <h3 class="counter-box__count-text sec-title__heading">k</h3>
                                </div><!-- /.counter-box__inner -->
                                <p class="counter-box__title">Destinos para Acampar</p>
                            </div>
                        </div><!-- /.col-xl-3 col-lg-3 col-6 -->
                        <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.5s"
                            data-wow-duration="1500ms">
                            <div class="counter-box @@extraClassName">
                                <div class="counter-box__icon">
                                    <span class="icon-satisfied"></span>
                                </div><!-- /.counter-box__icon -->
                                <div class="counter-box__inner sec-title count-box">
                                    <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text"
                                        data-stop="94.9" data-speed="1500">00</h3>
                                    <h3 class="counter-box__count-text sec-title__heading">%</h3>
                                </div><!-- /.counter-box__inner -->
                                <p class="counter-box__title">Tasa de satisfacción</p>
                            </div>
                        </div><!-- /.col-xl-3 col-lg-3 col-6 -->
                        <div class="col-xl-3 col-lg-3 col-6 wow animated fadeInUp" data-wow-delay="0.7s"
                            data-wow-duration="1500ms">
                            <div class="counter-box counter-box--no-border">
                                <div class="counter-box__icon">
                                    <span class="icon-online-chat-1"></span>
                                </div><!-- /.counter-box__icon -->
                                <div class="counter-box__inner sec-title count-box">
                                    <h3 class="counter-box__count-text counter-box__count-text--one sec-title__heading count-text"
                                        data-stop="6.50" data-speed="1500">00</h3>
                                    <h3 class="counter-box__count-text sec-title__heading">+</h3>
                                </div><!-- /.counter-box__inner -->
                                <p class="counter-box__title">Años de experiencia</p>
                            </div>
                        </div><!-- /.col-xl-3 col-lg-3 col-6 -->
                    </div>
                </div><!-- /.counter-one__container container-fluid -->
            </div>
        </div><!-- /.counter-one__main-content -->
    </section>
    <!-- Counter One End -->
@endsection

@section('css')
<style>
    .about-four__img-two{
        position: relative;
        right: -140px;
    }
    .about-four__shape-one{
        left: 0px;
    }
   

    @media(max-width:991px){
        .about-four__img-box{
            justify-content: center;
        }
    }
    @media(max-width:767px){
        .about-four__shape-one{
            display: none
        }
        .about-four__img-two{
            right: 7px;
        }
        .about-four {
            padding: 25px 0;
        }
    }

    @media (max-width: 575px) {
        .counter-one__bg-box {
            height: 100px;
        }
    }
</style>
@endsection
