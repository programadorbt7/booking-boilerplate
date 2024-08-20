@extends('layouts.master')

@section('metaSEO')
    <title>Contacto - {{ $nameEnterprise }}</title>
    <meta name="description" content="Contacta con nosotros mediante nuestro formulario de contacto para cualquier duda o pregunta a cerca de nuestros tours. Nos pondremos en contacto contigo lo más antes posible {{$nameEnterprise}}.">
    <meta name="keywords" content="Contacto, Comunicarte, Atención, Comunicate, Envia un Correo, Mensaje, Clientes, Usuarios, Agencia, {{$nameEnterprise}}"> 
@endsection

@section('contenido-principal')
<!--Breadcrumb Section Start-->
<section class="breadcrumb-bg bg-4 white-color" style="background-image: linear-gradient(rgba(0, 0, 0, 0.40), rgba(0, 0, 0, 0.40)), url({{ asset('assets/images/tour/tour-2.jpg') }})">   
    <div class="site-breadcumb ">  
        <div class="container ">     
            <div class="title-wrap-2">
                <h2 class="section-title"> CONTACTO Agencia </h2>
            </div>
        </div> 
    </div>
    <hr class="divider-1">
    <div class="container ">    
        <ol class="breadcrumb breadcrumb-menubar">
            <li> <a href="/"> Inicio </a> Contacto Agencia </li>                             
        </ol>
    </div>
</section>
<!--Breadcrumb Section End-->
<h2 class="text-center">Tu formulario personalizado debera de ingresarse aqui</h2>
@endsection