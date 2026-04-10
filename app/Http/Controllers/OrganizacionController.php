<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use Illuminate\Http\Request;

class OrganizacionController extends Controller
{
    public function index()
    {
        $organizaciones = collect([
            [
                'nombre' => 'Empresa',
                'descripcion' => 'Personas jurídicas y empresas registradas.',
                'fecha' => '15/01/2024',
                'status' => 'Activo',
                'icono' => 'bi-building'
            ],
            [
                'nombre' => 'Persona Natural',
                'descripcion' => 'Personas naturales con identificación.',
                'fecha' => '22/02/2024',
                'status' => 'Activo',
                'icono' => 'bi-person'
            ],
            [
                'nombre' => 'Comercio',
                'descripcion' => 'Negocios y comercios asociados.',
                'fecha' => '10/03/2024',
                'status' => 'Activo',
                'icono' => 'bi-shop'
            ],
            [
                'nombre' => 'Institución Educativa',
                'descripcion' => 'Centros educativos y universidades.',
                'fecha' => '05/04/2024',
                'status' => 'Activo',
                'icono' => 'bi-bank'
            ],
            [
                'nombre' => 'Organización Sin Fines de Lucro',
                'descripcion' => 'Fundaciones y organizaciones sociales.',
                'fecha' => '18/04/2024',
                'status' => 'Inactivo',
                'icono' => 'bi-heart-pulse'
            ],
            [
                'nombre' => 'Entidad Gubernamental',
                'descripcion' => 'Entidades estatales y gubernamentales.',
                'fecha' => '30/04/2024',
                'status' => 'Activo',
                'icono' => 'bi-building-gear'
            ],
        ]);

        return view('organizaciones.index', compact('organizaciones'));
    }

    public function create()
    {
        return view('organizaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        Organizacion::create([
            'nombre' => $request->nombre,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('organizaciones.index')
            ->with('success', 'Tipo de entidad creado correctamente');
    }
}