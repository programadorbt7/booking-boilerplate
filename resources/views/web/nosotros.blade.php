@extends('layouts.master')

@section('metaSEO')
    <title>Nosotros - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="¿Quienes somos? aqui te cuento todo acerca de nosotros {{$nameEnterprise}} tu agencia de viajes para conocer diversos lugares del mundo.">
    <meta name="keywords" content="Nosotros, Agencia de Viajes, A Cerca De, {{$nameEnterprise}}, Somos, Desde, Experiencias, Tours">
@endsection

@section('contenido-principal')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('travezo/img/banners/nosotros.webp') }})"></div>
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
