<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonaController extends Controller
{
    public function index(): View
    {
        $personas = Persona::query()
            ->orderBy('id')
            ->get();

        return view('personas.index', ['personas' => $personas]);
    }

    public function create(): View
    {
        return view('personas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'dni' => ['required', 'regex:/^[0-9]{13}$/', 'unique:personas,dni'],
            'nombre' => ['required', 'string', 'max:100'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $persona = new Persona;
        $persona->dni = $datos['dni'];
        $persona->nombre = $datos['nombre'];
        $persona->fecha_nacimiento = $datos['fecha_nacimiento'];
        $persona->save();

        return redirect()->route('personas.index')
            ->with('exito', 'Persona creada correctamente.');
    }

    public function edit(int $id)
    {
        $persona = Persona::findOrFail($id);

        return view('personas.edit', ['persona' => $persona]);
    }

    public function update(Request $request, int $id)
    {
        $persona = Persona::findOrFail($id);
        $datos = $request->validate([
            'dni' => ['required', 'regex:/^[0-9]{13}$/',
                Rule::unique('personas', 'dni')->ignore($persona)],
            'nombre' => ['required', 'string', 'max:100'],
            'fecha_nacimiento' => ['required', 'date',
                'before_or_equal:today'],
        ]);
        $persona->dni = $datos['dni'];
        $persona->nombre = $datos['nombre'];
        $persona->fecha_nacimiento = $datos['fecha_nacimiento'];
        $persona->save();

        return redirect()->route('personas.index')
            ->with('exito', 'Persona actualizada correctamente.');
    }

    public function destroy(int $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();
        return redirect()->route('personas.index')
            ->with('exito', 'Persona eliminada correctamente.');
    }
}
