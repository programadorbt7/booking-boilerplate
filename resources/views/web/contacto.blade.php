@extends('layouts.master')

@section('metaSEO')
    <title>Contacto - {{ $nameEnterprise }}</title>
    <meta name="description"
        content="Contacta con nosotros mediante nuestro formulario de contacto para cualquier duda o pregunta a cerca de nuestros tours. Nos pondremos en contacto contigo lo más antes posible {{ $nameEnterprise }}.">
    <meta name="keywords"
        content="Contacto, Comunicarte, Atención, Comunicate, Envia un Correo, Mensaje, Clientes, Usuarios, Agencia, {{ $nameEnterprise }}">
@endsection

@section('contenido-principal')
    {{-- BANNER --}}
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('travezo/img/banners/contacto.webp') }})"></div>
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">
                Contáctanos
            </h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a aria-label="Inicio" href="/">Inicio</a></li>
                    <li>Contacto</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- MAIN --}}
    <section class="contact-page section-space-top">
        <div class="container">
            <div class="row">
                {{-- INFO EMPRESA --}}
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar-blog sidebar-blog--left">
                        <aside class="widget-area">
                            <div class="sidebar-blog__single sidebar-blog__single--posts wow animated fadeInUp"
                                data-wow-delay="0.1s" data-wow-duration="1500ms" style="padding: 10px">
                                <h4 class="sidebar-blog__title text-center">
                                    <img style="width: 150px; margin-top: 25px;"
                                        src="{{ asset('travezo/img/logo_travezo.webp') }}" alt="Logo {{ $nameEnterprise }}">
                                </h4>
                                <ul class="sidebar-blog__posts ">
                                    @if ($sitioweb[0]->email_publico != '')
                                        <li class="sidebar-blog__posts-item align-items-center">
                                            <div class="sidebar-blog__posts-image">
                                                <span class="icon icon-envelope"></span>
                                            </div>
                                            <div class="sidebar-blog__posts-content">
                                                <h4 class="sidebar-blog__posts-title" style="text-transform: lowercase;">
                                                    <a aria-label="Correo Electrónico"
                                                        href="mailto:{{ $sitioweb[0]->email_publico }}">
                                                        {{ $sitioweb[0]->email_publico }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($sitioweb[0]->telefono != '')
                                        <li class="sidebar-blog__posts-item align-items-center">
                                            <div class="sidebar-blog__posts-image">
                                                <span class="icon icon-phone-1"></span>
                                            </div>
                                            <div class="sidebar-blog__posts-content">
                                                <h4 class="sidebar-blog__posts-title">
                                                    <a aria-label="Número Telefónico"
                                                        href="tel:{{ $sitioweb[0]->telefono }}">
                                                        {{ $sitioweb[0]->telefono }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($sitioweb[0]->horario_atencion != '')
                                        <li class="sidebar-blog__posts-item align-items-center">
                                            <div class="sidebar-blog__posts-image">
                                                <span class="icon icon-clock-1"></span>
                                            </div>
                                            <div class="sidebar-blog__posts-content">
                                                <h4 class="sidebar-blog__posts-title">
                                                    {{ $sitioweb[0]->horario_atencion }}
                                                </h4>
                                            </div>
                                        </li>
                                    @endif
                                    <li class="sidebar-blog__posts-item align-items-center">
                                        <div class="sidebar-blog__posts-image">
                                            <span class="icon icon-location-1"></span>
                                        </div>
                                        <div class="sidebar-blog__posts-content">

                                            <h4 class="sidebar-blog__posts-title"> Quintana roo, Cancun Q.R.</h4>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
                {{-- FORM --}}
                <div class="col-xl-8 col-lg-7 pb-5">
                    <div class="sec-title text-center">
                        <h2 class="sec-title__title">No dude en escribirnos</h2>
                        <p style="margin: 20px 0">Nuestro equipo está compuesto por expertos en turismo de naturaleza,
                            aventura y cultura,
                            comprometidos en brindarte una experiencia personalizada y de calidad, donde cada detalle está
                            pensado para que tu viaje sea memorable.
                        </p>
                    </div>
                    <form id="registerForm" method="get" action="{{ route('gracias-email') }}"
                        class="contact-page__form form-one row gutter-20">
                        @csrf
                        {!! $response['data']['formulario'] !!}
                        <input type="hidden" value="{{ Session::get('idAfiliado') }}" class="btn_theme" name="idAfiliado">
                        <div class="col-12 wow animated fadeInUp">
                            <div class="form-one__btn-box">
                                <div id="recaptchaContent" class="g-recaptcha"
                                    data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                <br />
                            </div>

                            <div class="form-one__btn-box">
                                <button type="submit"
                                    class="form-one__btn trevlo-btn trevlo-btn--base"><span>Enviar</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-page" style="padding: 0; margin-bottom:20px;">
        <div class="container">
            
            <h2 class="sec-title__title">
                Preguntas Frecuentes
            </h2>

            <div class="accordion" id="accordionExample" style="margin-top: 20px">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            ¿Cuáles son los itinerarios y fechas disponibles para los tours y expediciones?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the
                            collapse plugin adds the appropriate classes that we use to style each element. These classes
                            control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                            modify any of this with custom CSS or overriding our default variables. It's also worth noting
                            that just about any HTML can go within the <code>.accordion-body</code>, though the transition
                            does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            ¿Puedo personalizar un tour o un circuito turístico según mis intereses?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the
                            collapse plugin adds the appropriate classes that we use to style each element. These classes
                            control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                            modify any of this with custom CSS or overriding our default variables. It's also worth noting
                            that just about any HTML can go within the <code>.accordion-body</code>, though the transition
                            does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            ¿Existen opciones de pago a plazos o financiación para tours y paquetes turísticos?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                            collapse plugin adds the appropriate classes that we use to style each element. These classes
                            control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                            modify any of this with custom CSS or overriding our default variables. It's also worth noting
                            that just about any HTML can go within the <code>.accordion-body</code>, though the transition
                            does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            ¿Puedo pagar en cuotas o con diferentes métodos de pago?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                            collapse plugin adds the appropriate classes that we use to style each element. These classes
                            control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                            modify any of this with custom CSS or overriding our default variables. It's also worth noting
                            that just about any HTML can go within the <code>.accordion-body</code>, though the transition
                            does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            ¿Existen descuentos o promociones disponibles?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                            collapse plugin adds the appropriate classes that we use to style each element. These classes
                            control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                            modify any of this with custom CSS or overriding our default variables. It's also worth noting
                            that just about any HTML can go within the <code>.accordion-body</code>, though the transition
                            does limit overflow.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/intTelInputLocal.css') }}">
    <style>
        .errorReCaptcha {
            border: #B80000 solid 4px;
            border-radius: 5px;
        }

        @media(max-width: 400px) {
            #recaptchaContent {
                transform: scale(0.64);
                transform-origin: 0 0;
                width: 100%;
            }
        }

        #phone_contact {
            border: none;
        }

        @media (max-width: 1199px) {

            .iti--allow-dropdown input.iti__tel-input,
            .iti--allow-dropdown input.iti__tel-input[type=text],
            .iti--allow-dropdown input.iti__tel-input[type=tel] {
                width: 100%;
            }
        }

        #registerForm .row{
            margin: 0;
            padding: 0;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.8/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/js/prefijo_contacto.js') }}"></script>

    <script>
        $("#name_contact").addClass("form-one__input");
        $("#lastname_contact").addClass("form-one__input");
        $("#phone_contact").addClass("form-one__input");
        $("#email_contact").addClass("form-one__input");
        $("#humano").addClass("form-one__input");
        $("textarea").addClass("form-one__message form-one__input");
    </script>

    <script>
        window.onload = function() {
            let recaptcha = document.forms["registerForm"]["g-recaptcha-response"];
            recaptcha.required = true;
            recaptcha.oninvalid = function(e) {
                alert("Porfavor Resuelva el reCAPTCHA");
                $('#recaptchaContent').addClass('errorReCaptcha');
            }
        }
    </script>
@endsection
