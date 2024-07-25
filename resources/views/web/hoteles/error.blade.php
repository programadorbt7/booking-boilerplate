@extends('layouts.master')

@section('metaSEO')
    <title>Error de búsqueda - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">      
@endsection

@section('contenido-principal')
<section class="page-header" style="padding: 150px 0; background-position: bottom center; background-size: cover; background-image: linear-gradient(rgba(0, 0, 0, 0.40), rgba(0, 0, 0, 0.40)), url({{ asset('assets/images/tour/tour-4.jpg') }});">
    <div class="container">
        <h2>Lo sentimos hay un error en tu búsqueda</h2>
        <p>{{$error}}</p>
    </div>
</section>

<section class="cta-two">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
            </div>
        </div>
    </div>
</section>
@endsection