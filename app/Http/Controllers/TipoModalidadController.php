<?php

namespace App\Http\Controllers;

use App\Models\TipoModalidad;
use Illuminate\Http\Request;

class TipoModalidadController extends Controller
{
    public function index()
    {
        $tipos = TipoModalidad::orderBy('tipo_mod_id','desc')
            ->get([
                'tipo_mod_id', 
                'tipo_mod_nombre', 
                'tipo_mod_descripcion', 
                'tipo_mod_estado', 
                'tipo_mod_fecha_alta',
            ]);

        return view('tipos_modalidades.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipos_modalidades.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'condiciones' => 'nullable|string',
            ]);

            TipoModalidad::create([
                'tipo_mod_nombre' => $request->nombre,
                'tipo_mod_descripcion' => $request->descripcion,
                'tipo_mod_condiciones' => $request->condiciones,
                'tipo_mod_fecha_alta' => now(),
                'tipo_mod_usu_alta' => '1',
            ]);

            return redirect()
                ->route('admin.tipos_modalidades.index')
                ->with('success', 'Tipo de modalidad creado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function edit($id)
    {
        $tipo = TipoModalidad::findOrFail($id);

        return view('tipos_modalidades.edit', compact('tipo'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'condiciones' => 'nullable|string',
            ]);

            $tipo = TipoModalidad::findOrFail($id);

            $tipo->update([
                'tipo_mod_nombre' => $request->nombre,
                'tipo_mod_descripcion' => $request->descripcion,
                'tipo_mod_condiciones' => $request->condiciones,
            ]);

            return redirect()
                ->route('admin.tipos_modalidades.edit', $id)
                ->with('success', 'Tipo de modalidad actualizado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $tipo_modidad = TipoModalidad::findOrFail($id);

            $tipo_modidad->update([
                'tipo_mod_estado' => 0,
                'tipo_mod_fecha_baja' => now(),
                'tipo_mod_usu_baja' => 1,
            ]);

            return redirect()
                ->route('admin.tipos_modalidades.index')
                ->with('success', 'Tipo entidad eliminado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function listado(Request $request)
    {
        $query = TipoModalidad::query();

        if ($request->filled('fecha_desde')) {
            $query->whereDate('tipo_mod_fecha_alta', '>=', $request->fecha_desde);
        }

        if ($request->filled('buscar')) {
            $query->where('tipo_mod_nombre', 'like', "%".$request->buscar."%");
        }

        $tipos = $query
            ->orderBy('tipo_mod_id', 'desc')
            ->paginate(20);

        return response()->json([
            'body' => view(
                'tipos_modalidades.partials.tabla',
                compact('tipos')
            )->render(),

            'foot' => view(
                'tipos_modalidades.partials.paginacion',
                compact('tipos')
            )->render(),

            'kregtotal' => $tipos->total()
        ]);
    }
}
