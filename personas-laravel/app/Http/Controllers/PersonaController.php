<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Contracts\View\View;

class PersonaController extends Controller
{
    public function index(): View
    {
        $personas = Persona::query()
            ->orderBy('id')
            ->get();

        return view('personas.index', ['personas' => $personas]);
    }
}
