@extends('layouts.master')

@section('metaSEO')
<title>Pagina no encontrada - {{ $nameEnterprise }}</title>
@endsection

@section('contenido-principal')
<!-- Error Starts-->
<section class="sec-space text-center">
    <div class="container"> 
        <img src="{{asset('assets/images/icons/error.png')}}" alt=""/>
        <div class="title-wrap-2 pt-30">
            <h2 class="section-title no-margin">Error - Recurso No Encontrado</h2>
        </div>
        <p class=" padding-bottom-30">Parece que no podemos encontrar lo que estás buscando. Quizás quiera volver a la página de inicio.<a href="/" class="clr-txt-2"> Ir al inicio. </a> </p>
    </div>
</section>
<!-- / Error Ends -->      

<hr class="divider-1">
@endSection