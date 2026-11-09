
@extends('layouts.app')

@section('contenido')
    <h1>Iniciar sesión</h1>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <label for="email">Correo electrónico:</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autocomplete="username"
        >

        <label for="password">Contraseña:</label>
        <input
            id="password"
            type="password"
            name="password"
            required
            autocomplete="current-password"
        >

        <button type="submit">Ingresar</button>
    </form>
@endsection
