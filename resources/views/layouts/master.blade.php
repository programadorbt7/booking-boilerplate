@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-control" content="public">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="BookingTech">
    @yield('metaSEO')
    {{-- FAVICON --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('cucapah/img/logo-cucapah.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('cucapah/img/logo-cucapah.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/images/favicons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    {{-- FONT FUNTASTIC --}}
    <link href="https://fonts.cdnfonts.com/css/metropolis-2" rel="stylesheet">
    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-select/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/jarallax/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/nouislider/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/nouislider/nouislider.pips.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/tiny-slider/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/trevlo-icons/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/daterangepicker-master/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/trevlo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/stylesTransportacionListDaniel.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('cucapah/css/main.css') }}">
    <style>
        #whatsapp-float {
            display: block;
            box-shadow: 2px 3px 5px black;
            border-radius: 50%;
            border: none;
            position: fixed;
            z-index: 99;
            background-color: #00f942;
            opacity: 80%;
            bottom: 160px;
            right: 15px;
            width: 86px;
            height: 86px;
        }

        #whatsapp-float i {
            font-size: 3.1rem;
            color: white;
            background: none;
        }
        @media(max-width: 768px){
            #whatsapp-float {
                width: 45px;
                height: 45px;
            }
            #whatsapp-float i {
                font-size: x-large;
            }
        }
    </style>
    @yield('css')
    {!! $sitioweb[0]->snippet_header !!}
</head>

<body>
    @php
        $monedaMaster = json_decode($monedas);
    @endphp
    {{-- WHATS --}}
    <button id="whatsapp-float" type="button" class="btn btn-primary">
        <a target="_blank" href="https://wa.me/{{ $sitioweb[0]->whatsapp }}?text=Estoy interesada(o) en un tour"><i
                class="fa-brands fa-whatsapp"></i></a>
    </button>
    {{-- PRELOADER --}}
    <div class="preloader">
        <div class="loader-svg-img">
            <img alt="favicon" loading="lazy" class="img-preloader"
                src="{{ asset('cucapah/img/logo-cucapah.png') }}" style="width: 120px">
            <div class="flight-icon"><i aria-hidden="true" class="fa fa-plane"
                    style="transform: rotate(-70deg)"></i></div>
        </div>
    </div>

    @if ($statusSandbox == true)
        <span class="statusSandBox">
            <img src="{{ asset('assets/images/warning.svg') }}" alt="">
            <span>SandBox Activo</span>
        </span>
    @endif

    {{-- MAIN --}}
    <div class="page-wrapper">
        {{-- NAV TOP --}}
        <div class="topbar-one">
            <div class="topbar-one__contaner container-fluid">
                <div class="topbar-one__inner">
                    {{-- INFO EMPRESA --}}
                    <div class="topbar-one__left">
                        <ul class="topbar-one__info">
                            <li class="topbar-one__info-item">
                                <span class="topbar-one__info-icon icon-location-1"></span>
                                <span class="topbar-one__info-text">Quintana Roo, Cancun Q.R.</span>
                            </li>
                            @if ($sitioweb[0]->email_publico != '')
                                <li class="topbar-one__info-item">
                                    <span class="topbar-one__info-icon icon-envelope"></span>
                                    <a href="mailto:{{ $sitioweb[0]->email_publico }}"
                                        class="topbar-one__info-text">{{ $sitioweb[0]->email_publico }}</a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->horario_atencion != '')
                                <li class="topbar-one__info-item">
                                    <span class="topbar-one__info-icon icon-clock-1"></span>
                                    <span class="topbar-one__info-text"> {{ $sitioweb[0]->horario_atencion }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{-- SOCIAL MEDIA --}}
                    <div class="topbar-one__right">
                        <ul class="topbar-one__social">
                            @if ($sitioweb[0]->whatsapp != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="Whatsapp" target="_blank"
                                        href="https://wa.me/{{ $sitioweb[0]->whatsapp }}?text=Estoy interesada(o) en un tour"><i
                                            class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->facebook != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="Facebook"
                                        href="{{ $sitioweb[0]->facebook }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-facebook-f" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->twitter != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="twitter"
                                        href="{{ $sitioweb[0]->twitter }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->instagram != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="instagram"
                                        href="{{ $sitioweb[0]->instagram }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-instagram" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->tiktok != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="tiktok"
                                        href="{{ $sitioweb[0]->tiktok }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-tiktok" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->pinterest != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="pinterest"
                                        href="{{ $sitioweb[0]->pinterest }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-pinterest-p" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->youtube != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="youtube"
                                        href="{{ $sitioweb[0]->youtube }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-youtube" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->linkedin != '')
                                <li class="topbar-one__social-item">
                                    <a class="topbar-one__social-link" aria-label="linkedin"
                                        href="{{ $sitioweb[0]->linkedin }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-linkedin" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- HEADER --}}
        <header class="main-header sticky-header sticky-header--normal">
            <div class="container">
                <div class="main-header__inner">
                    {{-- NAV GENERAL --}}
                    <div class="main-header__left">
                        {{-- LOGO --}}
                        <div class="main-header__logo">
                            <a href="/">
                                <img src="{{ asset('cucapah/img/logo-cucapah.png') }}"
                                    alt="Logo Funtastic" width="146" class="imgHeaderHome">
                            </a>
                        </div>
                        {{-- NAV MENU --}}
                        <nav class="main-header__nav main-menu">
                            <ul class="main-menu__list">
                                <li>
                                    <a aria-label="Inicio" href="/">Inicio</a>
                                </li>
                                <li class="dropdown">
                                    <a>Experiencias</a>
                                    <ul class="sub-menu">
                                        <li><a aria-label="Todas las experiencias" href="/experiencias">Todas las
                                                experiencias</a></li>
                                        @foreach ($categoriasExperiencias as $categoriaExperiencia)
                                            <li><a aria-label="Experiencias en {{ $categoriaExperiencia['nombre'] }}"
                                                    href="{{ route('categoriasExperiencias.categoria.id', ['categoria' => $fn->stringToUrl($categoriaExperiencia['nombre']), 'id' => $categoriaExperiencia['id']]) }}">
                                                    {{ $categoriaExperiencia['nombre'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @if ($megaTravel != null)
                                    <li class="dropdown">
                                        <a>Circuitos</a>
                                        <ul class="sub-menu">
                                                <li>
                                                    <a aria-label="Ver todas las ofertas"
                                                        href="/ofertas-megatravel">
                                                        Ver todas las ofertas
                                                    </a>
                                                </li>
                                            @foreach ($megaTravel as $mgTravel)
                                                <li>
                                                    <a aria-label="Circuitos en {{ $mgTravel['nombre'] }}"
                                                        href="{{ route('circuitosTuristicos.entidad.entidad2.id', ['entidad' => $fn->reemplaza_espacios($mgTravel['nombre']), 'entidad2' => urlencode($mgTravel['nombre']), 'id' => $mgTravel['id_destino']]) }}">
                                                        {{ $mgTravel['nombre'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                                @if ($countArticulosRecientes > 0)
                                    <li>
                                        <a aria-label="Blog" href="/blog">Blog</a>
                                    </li>
                                @endif
                                <li>
                                    <a aria-label="Galería" href="/galeria">Galería</a>
                                </li>
                                <li>
                                    <a aria-label="Nosotros" href="/nosotros">Nosotros</a>
                                </li>
                                <li>
                                    <a aria-label="Contacto" href="/contacto">Contacto</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    {{-- MOBILE NAV --}}
                    <div class="main-header__right">
                        <div class="mobile-nav__btn mobile-nav__toggler">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        {{-- TELEFONO & CURRENCY --}}
                        <div class="main-header__right-right">
                            @if ($sitioweb[0]->telefono != '')
                                <div class="main-header__phone">
                                    <div class="main-header__phone-icon">
                                        <span class="icon-phone-1"></span>
                                    </div>
                                    <div class="main-header__phone-text">
                                        <p class="main-header__phone-title">Llámanos</p>
                                        <h4 class="main-header__phone-number"><a
                                                href="tel:{{ $sitioweb[0]->telefono }}">{{ $sitioweb[0]->telefono }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @endif
                            <div class="main-header__divider"></div>
                            <ul class="main-header__search-user">
                                <li class="main-header__search-user-item">
                                    <select class="form-control" id="currency" onchange="changeCurrency(value)">
                                        @foreach ($monedaMaster->data as $moneda)
                                            <option value="{{ $moneda->iso }}"
                                                {{ $monedaSeleccionada == $moneda->iso ? 'selected' : '' }}>
                                                {{ $moneda->iso }}</option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN --}}
        @yield('contenido-principal')

        {{-- FOOTER --}}
        <footer class="main-footer @@extraClassName">
            <div class="main-footer__bg"
                style="background-image: url({{ asset('assets/images/backgrounds/footer-bg.png') }});">
            </div>
            <div class="container">
                {{-- FOOTER TOP --}}
                <div class="main-footer__top row">
                    {{-- LOGO --}}
                    <div class="col-lg-4 col-sm-12">
                        <div class="main-footer__logo-box d-flex justify-content-center">
                            <a href="/" aria-label="Inicio" class="hrefImgLogoFooter">
                                <img src="{{ asset('cucapah/img/logo-cucapah.png') }}"
                                    alt="logo funtastic" class="main-footer__logo">
                            </a>
                        </div>
                    </div>
                    {{-- SOCIAL MEDIA --}}
                    <div class="col-lg-8 col-sm-12 d-flex justify-content-center align-items-center">
                        <ul class="main-footer__social">
                            @if ($sitioweb[0]->whatsapp != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="Whatsapp" target="_blank"
                                        href="https://wa.me/{{ $sitioweb[0]->whatsapp }}?text=Estoy interesada(o) en un tour"><i
                                            class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->facebook != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="Facebook"
                                        href="{{ $sitioweb[0]->facebook }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-facebook-f" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->twitter != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="twitter"
                                        href="{{ $sitioweb[0]->twitter }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->instagram != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="instagram"
                                        href="{{ $sitioweb[0]->instagram }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-instagram" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->tiktok != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="tiktok"
                                        href="{{ $sitioweb[0]->tiktok }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-tiktok" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->pinterest != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="pinterest"
                                        href="{{ $sitioweb[0]->pinterest }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-pinterest-p" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->youtube != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="youtube"
                                        href="{{ $sitioweb[0]->youtube }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-youtube" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->google != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="google"
                                        href="{{ $sitioweb[0]->google }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-google-plus-g" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($sitioweb[0]->linkedin != '')
                                <li class="main-footer__social-item">
                                    <a class="main-footer__social-link" aria-label="linkedin"
                                        href="{{ $sitioweb[0]->linkedin }}" target="_blank">
                                        <i aria-hidden="true" class="fab fa-linkedin" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{-- LINE --}}
                    <div class="col-12 m-0">
                        <div class="main-footer__line"></div>
                    </div>
                </div>
                {{-- FOOTER GENERAL --}}
                <div class="row">
                    {{-- MENU --}}
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4" data-wow-duration="1500ms">
                        <div class="footer-widget footer-widget--links">
                            <h2 class="footer-widget__title">Menú</h2>
                            <ul class="footer-widget__links">
                                <li><a aria-label="Inicio" href="/">Inicio</a></li>
                                <li><a aria-label="Blog" href="/blog">Blog</a></li>
                                <li><a aria-label="Experiencias" href="/experiencias">Experiencias</a></li>
                                <li><a aria-label="Nosotros" href="/nosotros">Nosotros</a></li>
                                <li><a aria-label="Galería" href="/galeria">Galería</a></li>
                                <li><a aria-label="Galería" href="{{ route('preguntas') }}">Preguntas Frecuentes</a></li>
                            </ul>
                        </div>
                    </div>
                    {{-- AYUDA --}}
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4" data-wow-duration="1500ms">
                        <div class="footer-widget footer-widget--links">
                            <h2 class="footer-widget__title">Ayuda</h2>
                            <ul class="footer-widget__links">
                                <li><a aria-label="Contacto" href="/contacto">Contacto</a></li>
                                <li><a aria-label="Aviso de privacidad" href="/aviso-privacidad">Aviso de
                                        privacidad</a></li>
                                <li><a aria-label="Términos y Condiciones" href="/terminos-condiciones">Términos y
                                        Condiciones</a></li>
                            </ul>
                        </div>
                    </div>
                    {{-- INFO EMPRESA --}}
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4" data-wow-duration="1500ms">
                        <div class="footer-widget footer-widget--contact">
                            <h2 class="footer-widget__title">Contacto</h2>
                            <p class="footer-widget__address">
                                <span class="topbar-one__info-icon icon-location-1"></span>
                                Catania Residencial CP 77536, Cancun Q.R.
                            </p>
                            <ul class="footer-widget__info">
                                @if ($sitioweb[0]->telefono != '')
                                    <li> <span class="icon-phone-1"></span>
                                        <a aria-label="Número Telefónico" href="tel:{{ $sitioweb[0]->telefono }}">
                                            {{ $sitioweb[0]->telefono }}</a>
                                    </li>
                                @endif
                                @if ($sitioweb[0]->email_publico != '')
                                    <li> <span class="icon-envelope"></span>
                                        <a aria-label="Correo Electrónico"
                                            href="mailto:{{ $sitioweb[0]->email_publico }}">{{ $sitioweb[0]->email_publico }}</a>
                                    </li>
                                @endif
                                @if ($sitioweb[0]->horario_atencion != '')
                                    <li>
                                        <span class="icon-clock-1"></span>
                                        {{ $sitioweb[0]->horario_atencion }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- COPYRIGHT & BOOKINGTECH --}}
            <div class="main-footer__bottom">
                <div class="container">
                    <div class="main-footer__bottom-inner">
                        <p class="main-footer__copyright">
                            {!! $sitioweb[0]->footer_copyright !!}
                        </p>
                        <p class="main-footer__copyright">
                            Powered by
                            <a aria-label="BookingTech" target="_blank" href="https://bookingtech.mx/"
                                style="color: white">Booking<span style="color: #2671ff">Tech</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- MOBILE NAV --}}
    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i aria-hidden="true" class="fa fa-times"></i></span>

            <div class="logo-box">
                <a href="/" aria-label="logo image"><img
                        src="{{ asset('assets/images/logos/logo4-funtastic.webp') }}" width="155"
                        alt="Logo Funtastic" /></a>
            </div>
            <div class="mobile-nav__container"></div>
            {{-- Correo & Numero --}}
            <ul class="mobile-nav__contact list-unstyled">
                @if ($sitioweb[0]->email_publico != '')
                    <li>
                        <i aria-hidden="true" class="fa fa-envelope"></i>
                        <a href="mailto:{{ $sitioweb[0]->email_publico }}">{{ $sitioweb[0]->email_publico }}</a>
                    </li>
                @endif
                @if ($sitioweb[0]->telefono != '')
                    <li>
                        <i aria-hidden="true" class="fa fa-phone-alt"></i>
                        <a href="tel:{{ $sitioweb[0]->telefono }}">{{ $sitioweb[0]->telefono }}</a>
                    </li>
                @endif
            </ul>
            {{-- Social media --}}
            <div class="mobile-nav__social">
                @if ($sitioweb[0]->whatsapp != '')
                    <a aria-label="Whatsapp" target="_blank"
                        href="https://wa.me/{{ $sitioweb[0]->whatsapp }}?text=Estoy interesada(o) en un tour"><i
                            class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                @endif
                @if ($sitioweb[0]->facebook != '')
                    <a aria-label="Facebook" href="{{ $sitioweb[0]->facebook }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                @endif
                @if ($sitioweb[0]->twitter != '')
                    <a aria-label="twitter" href="{{ $sitioweb[0]->twitter }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-twitter" aria-hidden="true"></i>
                    </a>
                @endif
                @if ($sitioweb[0]->instagram != '')
                    <a aria-label="instagram" href="{{ $sitioweb[0]->instagram }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                @endif
                @if ($sitioweb[0]->tiktok != '')
                    <a aria-label="tiktok" href="{{ $sitioweb[0]->tiktok }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-tiktok" aria-hidden="true"></i>
                    </a>
                @endif
                @if ($sitioweb[0]->pinterest != '')
                    <a aria-label="pinterest" href="{{ $sitioweb[0]->pinterest }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-pinterest-p" aria-hidden="true"></i>
                    </a>
                @endif
                @if ($sitioweb[0]->youtube != '')
                    <a aria-label="youtube" href="{{ $sitioweb[0]->youtube }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-youtube" aria-hidden="true"></i>
                    </a>
                @endif
                @if ($sitioweb[0]->google != '')
                    <a aria-label="google" href="{{ $sitioweb[0]->google }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-google-plus-g" aria-hidden="true"></i>
                    </a>
                @endif
                @if ($sitioweb[0]->linkedin != '')
                    <a aria-label="linkedin" href="{{ $sitioweb[0]->linkedin }}" target="_blank">
                        <i aria-hidden="true" class="fab fa-linkedin" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- SCROLL TOP --}}
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__text">back top</span>
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
    </a>

    {{-- SCRIPTS --}}
    <script src="{{ asset('assets/vendors/jquery/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jarallax/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-appear/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/tiny-slider/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/vendors/wnumb/wNumb.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/wow.js') }}"></script>
    <script src="{{ asset('assets/vendors/tilt/tilt.jquery.js') }}"></script>
    <script src="{{ asset('assets/vendors/simpleParallax/simpleParallax.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/imagesloaded/imagesloaded.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/isotope/isotope.js') }}"></script>
    <script src="{{ asset('assets/vendors/countdown/countdown.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/daterangepicker-master/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/daterangepicker-master/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-circleType/jquery.circleType.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-lettering/jquery.lettering.min.js') }}"></script>
    <script src="{{ asset('assets/js/customFunctions.js') }}"></script>
    <script src="{{ asset('assets/js/trevlo.js') }}"></script>
    <script src="{{ asset('assets/js/owlCarrousel.js') }}"></script>
    @yield('scripts')
    {!! $sitioweb[0]->snippet_footer !!}
</body>

</html>
