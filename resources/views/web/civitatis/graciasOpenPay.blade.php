@extends('layouts.master')

@section('metaSEO')
    <title>Confirmación de Pago - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')
    @include('web.partials.graciasCompra', ['estatus' => $estatus, 'mensaje' => $mensaje]);
@endsection
