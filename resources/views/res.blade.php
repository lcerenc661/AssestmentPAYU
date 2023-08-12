@extends('master')

@section('content')
    <title>Resultado de Pago</title>
    <P>User = {{$username}} </P>
    <P>DNI = {{$dni}} </P>
    <h1>Resultado de Pago</h1>

    <p>{{ $response }}</p>
@stop