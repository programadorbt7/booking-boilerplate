@extends('layouts.master')

@section('metaSEO')
    <title>Gracias - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
<div>
    <!-- WRAPPER -->
<main class="wrapper"> 
    <!-- CONTENT AREA -->
    <article class="home-three">
        <!--Breadcrumb Section Start-->
        <section class="breadcrumb-bg bg-2 white-color" style="background-image: linear-gradient(rgba(0, 0, 0, 0.40), rgba(0, 0, 0, 0.40)), url({{ asset('assets/images/soport/soporte.jpg') }})">   
            <div class="site-breadcumb ">  
                <div class="container ">     
                    <div class="title-wrap-2">
                        <h2 class="section-title"> Gracias Por Contactarnos </h2>
                        <h3 style="color: white;">En breve una representante de {{ $nameEnterprise }} te contactará</h3>
                    </div>
                </div> 
            </div>
            <hr class="divider-1">
            <div class="container ">    
                <ol class="breadcrumb breadcrumb-menubar">
                    <li> <a href="/"> Inicio </a> Gracias  </li>                             
                </ol>
            </div>
        </section>
        <!--Breadcrumb Section End-->

        <!-- About Us Start -->
        <section class="sec-space-top about-us" style="padding-bottom: 60px;">
            <div class="container">
                <div class="col-md-12">
                    <!--<div class="info">
                        <h2 class="section-title pb-10"> Gracias Por Contactarnos</h2>
                        <p class="fsz-16">En breve una representante de Funtastic te contactará</p>
                    </div>-->                            
                    <!-- <img class="sign" src="assets/images/icons/sign.png" /> -->
                </div>
            </div>
        </section>
        <!-- / About Us Ends -->     
    </article>
    <!-- / CONTENT AREA -->
</main>
<!-- /WRAPPER -->
</div>
@endsection