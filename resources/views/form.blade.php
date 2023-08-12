
@extends('master')

@section('content')
<div class="container">
    <h1>Información del Comprador</h1>
    <form class="form" method="POST" action="{{ route('realizar-pago') }}">
        @csrf <!-- Agrega el token CSRF para protección -->
        <div class="form-group">
            <div class="element_description">
            <label for="fullName">Nombre Completo:</label>
            </div>
            <div class="value_element">
            <input type="text" name="buyer[fullName]" id="fullName" required><br>
            </div>
        </div class="form-group">
        <div class="form-group">
            <label for="emailAddress">Correo Electrónico:</label>
            <input type="email" name="buyer[emailAddress]" id="emailAddress" required><br>
        </div>
        <div class="form-group">
            <label for="contactPhone">Teléfono de Contacto:</label>
            <input type="text" name="buyer[contactPhone]" id="contactPhone" required><br>
        </div>
        <div class="form-group">
            <label for="dniNumber">Número de Identificación:</label>
            <input type="text" name="buyer[dniNumber]" id="dniNumber" required><br>
        </div>
        <div class="form-group">
            <button type="submit" class="button">Revisar estado</button>
        </div>
    </form>
</div>
@stop