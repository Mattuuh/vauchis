<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoEntidad;

class TipoEntidadController extends Controller
{
    public function index()
    {
        $tipos = TipoEntidad::orderBy('tipo_ent_id','desc')
            ->get([
                'tipo_ent_id', 
                'tipo_ent_nombre', 
                'tipo_ent_observacion', 
                'tipo_ent_estado', 
                'tipo_ent_fecha_alta',
            ]);

        return view('tipos-entidad.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipos-entidad.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'observaciones' => 'nullable|string',
            ]);

            TipoEntidad::create([
                'tipo_ent_nombre' => $request->nombre,
                'tipo_ent_observacion' => $request->observaciones,
                'tipo_ent_fecha_alta' => now(),
                'tipo_ent_usu_alta' => '1',
            ]);

            return redirect()
                ->route('tipos-entidad.index')
                ->with('success', 'Tipo de entidad creado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function edit($id)
    {
        $tipo = TipoEntidad::findOrFail($id);

        return view('tipos-entidad.edit', compact('tipo'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'observaciones' => 'nullable|string',
            ]);

            $tipo = TipoEntidad::findOrFail($id);

            $tipo->update([
                'tipo_ent_nombre' => $request->nombre,
                'tipo_ent_observacion' => $request->observaciones,
            ]);

            return redirect()
                ->route('tipos-entidad.edit', $id)
                ->with('success', 'Tipo de entidad actualizado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $tipo_entidad = TipoEntidad::findOrFail($id);

            $tipo_entidad->update([
                'tipo_ent_estado' => 0,
                'tipo_ent_fecha_baja' => now(),
                'tipo_ent_usu_baja' => 1,
            ]);

            return redirect()
                ->route('tipos-entidad.index')
                ->with('success', 'Tipo entidad eliminado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}