@extends('layouts.master')

@section('metaSEO')
<title>Sin permisos de acceso - {{ $nameEnterprise }}</title>
@endsection

@section('contenido-principal')
<!-- Error Starts-->
<section class="sec-space text-center">
    <div class="container"> 
        <img src="{{asset('assets/images/icons/error.png')}}" alt=""/>
        <div class="title-wrap-2 pt-30">
            <h2 class="section-title no-margin">Usted no tiene permisos para accender a este recurso</h2>
        </div>
        <p class=" padding-bottom-30">Parece que no podemos accender a este recurso. Quizás quiera volver a la página de inicio.<a href="/" class="clr-txt-2"> Ir al inicio. </a> </p>
    </div>
</section>
<!-- / Error Ends -->    
@endsection