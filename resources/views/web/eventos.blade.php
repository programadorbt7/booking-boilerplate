@extends('layouts.master')

@section('metaSEO')
    <title>Eventos - {{ $nameEnterprise }}</title>
    {{-- <meta name="description"  content="¿Quienes somos? aqui te cuento todo acerca de nosotros {{$nameEnterprise}} tu agencia de viajes para conocer diversos lugares del mundo.">
    <meta name="keywords" content="Nosotros, Agencia de Viajes, A Cerca De, {{$nameEnterprise}}, Somos, Desde, Experiencias, Tours"> --}}
@endsection

@section('contenido-principal')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ asset('travezo/img/banners/nosotros.webp') }})"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title wow animated fadeInLeft" data-wow-delay="0s" data-wow-duration="1500ms">Eventos</h2>
            <div class="page-header__breadcrumb-box">
                <ul class="trevlo-breadcrumb">
                    <li><a href="index.html">Inicio</a></li>
                    <li>Eventos</li>
                </ul><!-- /.trevlo-breadcrumb -->
            </div><!-- /.page-header__breadcrumb-box -->
        </div>
    </section><!-- /.page-header -->

    <!-- About Four Start -->
    <section class="about-four section-space-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span>Nos descubriste, aún estamos trabajando en esta pestaña...</span>
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
