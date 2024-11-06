@extends('layouts.master')

@section('metaSEO')
    <title>Nosotros - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="¿Quienes somos? aqui te cuento todo acerca de nosotros {{ $nameEnterprise }} tu agencia de viajes para conocer diversos lugares del mundo.">
    <meta name="keywords"
        content="Nosotros, Agencia de Viajes, A Cerca De, {{ $nameEnterprise }}, Somos, Desde, Experiencias, Tours">
@endsection

@section('contenido-principal')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('travezo/img/banners/nosotros.webp') }})"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Nosotros
            </h2>
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
                            <img src="{{ asset('assets/images/nosotros/imagen_nosotros2.webp') }}" alt="about image"
                                class="about-four__img-two">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 about-four__content-column">
                    <div class="about-four__content">
                        <div class="sec-title text-left">
                            <p class="sec-title__tagline">Conócenos</p>
                            <h2 class="sec-title__title">Quiénes Somos </h2>
                        </div>
                        <p class="about-four__text">En Viajes Travezo, creemos que viajar es mucho más que un destino,
                            viajar es una forma única de
                            conectar y descubrir el mundo al estilo propio de exploración de cada viajero sin limitaciones,
                            que
                            deja una huella en el corazón y la mente. Somos una agencia de viajes online con un enfoque
                            diverso
                            y flexible, especializada en ofrecerte experiencias auténticas que te conecten con la naturaleza
                            y
                            aventura, cultura y gastronomía tanto en México como en cualquier rincón del planeta, sin dejar
                            de
                            lado los clásicos viajes de sol y playa que tanto nos enamoran. Para nosotros…que cada viajero
                            es
                            único y su aventura debe serlo también.</p>

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

    <!-- RIGHT IMAGES -->
    <section class="why-choose-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="why-choose-two__content">
                        <p class="why-choose-two__text">
                            Nos especializamos en turismo de naturaleza, aventura, ecoturismo, cultura y gastronomía. Desde
                            caminatas en paisajes naturales asombrosos, hasta inmersiones en las tradiciones locales,
                            ofrecemos una amplia gama de experiencias diseñadas para aquellos que buscan más que un simple
                            viaje. Queremos que cada paso que des en tu viaje sea una oportunidad para aprender, explorar y
                            disfrutar de lo auténtico y lo original.
                        </p>
                        <br>
                        <p class="why-choose-two__text">
                            Sin embargo, entendemos que no todos los viajes buscan aventura extrema o experiencias en
                            rincones remotos. Por eso, también ofrecemos los destinos más populares de sol y playa,
                            garantizando que nuestros servicios cubran todos los gustos y preferencias. Desde el descanso en
                            una playa paradisíaca hasta la emoción de una expedición en lo más profundo de la naturaleza, en
                            Viajes Travezo adaptamos cada viaje a tus necesidades.
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

    <!-- LEFT IMAGES -->
    <section class="why-choose-two">
        <div class="container">
            <div class="row">
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
                <div class="col-lg-6 col-xl-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="why-choose-two__content">
                        <p class="why-choose-two__text">
                            Lo que nos diferencia es nuestra capacidad para combinar la autenticidad con la comodidad y la
                            flexibilidad. Utilizando nuestra plataforma online, puedes acceder a una gran variedad de
                            itinerarios
                            y paquetes diseñados con cuidado y detalle, siempre alineados con tus intereses. Ya sea que
                            estés
                            buscando un recorrido por las comunidades locales de México, explorar destinos ecológicos, o
                            simplemente disfrutar de una escapada relajante en la costa, tenemos la opción perfecta para ti.

                        </p>
                        <br>
                        <p class="why-choose-two__text">
                            En Viajes Travezo, trabajamos en cada detalle para que tu viaje sea una vivencia enriquecedora,
                            transformadora y única. Desde tu primer clic hasta el último paso de tu viaje, estamos aquí para
                            ayudarte a explorar el mundo con la confianza de que cada destino será una nueva aventura., ya
                            sea
                            que busques aventura, descanso, cultura o una mezcla de todo, estamos aquí para hacer realidad
                            esos viajes que siempre has soñado, asegurándonos de que cada viaje sea una vivencia memorable
                            para que disfrutes del mundo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POR QUÉ TRAVEZO ES DIFERENTE? -->

    <section class="why-choose-two">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sec-title text-center">
                        <h2 class="sec-title__title">¿Por qué {{ $nameEnterprise }} es diferente? </h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img style="width: 100%; height:400px; object-fit:cover; border-radius:20px" src="{{ asset('assets/images/nosotros/imagen_nosotros3.webp') }}">
                </div>
                <div class="col-lg-6" style="display: flex; align-items:center">
                    <p class="why-choose-two__text">
                        En Viajes Travezo, creemos que viajar es mucho más que un destino, viajar es una forma única de
                        conectar y descubrir el mundo al estilo propio de exploración de cada viajero sin limitaciones, que
                        deja una huella en el corazón y la mente. Somos una agencia de viajes online con un enfoque diverso
                        y flexible, especializada en ofrecerte experiencias auténticas que te conecten con la naturaleza y
                        aventura, cultura y gastronomía tanto en México como en cualquier rincón del planeta, sin dejar de
                        lado los clásicos viajes de sol y playa que tanto nos enamoran. Para nosotros…que cada viajero es
                        único y su aventura debe serlo también.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        .about-four__img-two {
            position: relative;
            right: -140px;
        }

        .about-four__shape-one {
            left: 0px;
        }


        @media(max-width:991px) {
            .about-four__img-box {
                justify-content: center;
            }
        }

        @media(max-width:767px) {
            .about-four__shape-one {
                display: none
            }

            .about-four__img-two {
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
