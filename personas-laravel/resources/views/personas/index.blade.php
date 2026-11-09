@extends('layouts.app')

@section('contenido')
    <h1>Personas registradas</h1>

    <table>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">DNI</th>
                <th scope="col">Nombre</th>
                <th scope="col">Nacimiento</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($personas as $persona)
                <tr>
                    <td>{{ $persona->id }}</td>
                    <td>{{ $persona->dni }}</td>
                    <td>{{ $persona->nombre }}</td>
                    <td>{{ $persona->fecha_nacimiento->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay personas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection