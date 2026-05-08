<?php

namespace App\Http\Controllers;

use App\Models\Rubro;
use App\Models\Subrubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    public function index()
    {
        $rubros = Rubro::orderBy('rub_id','desc')
            // ->where('rub_estado',1)
            ->get([
                'rub_id', 
                'rub_nombre', 
                'rub_descripcion', 
                'rub_estado', 
                'rub_fecha_alta',
            ]);

        return view('rubros.index', compact('rubros'));
    }

    public function create()
    {
        return view('rubros.create');
    }

    private function validarRubro(Request $request)
    {
        return $request->validate([
            'f_codigo' => 'required|string|max:255',
            'f_nombre' => 'required|string|max:255',
            'f_descripcion' => 'required|string|max:255',
            'f_descripcion_corta' => 'required|string|max:255',
            'subrubros' => 'nullable|array',
            'subrubros.*' => 'integer|exists:subrubros,sub_id',

            'subrubros_nuevos' => 'nullable|array',
            'subrubros_nuevos.*' => 'string|max:255',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'f_codigo' => 'nullable|string|max:255',
                'f_nombre' => 'required|string|max:255',
                'f_descripcion' => 'nullable|string|max:255',
                'f_descripcion_corta' => 'nullable|string|max:255',
            ]);

            $rubro = Rubro::create([
                'rub_codigo' => $request->f_codigo,
                'rub_nombre' => $request->f_nombre,
                'rub_descripcion' => $request->f_descripcion,
                'rub_descripcion_corta' => $request->f_descripcion_corta,
                'rub_estado' => '1',
                'rub_fecha_alta' => now(),
                'rub_usu_alta' => '1',
            ]);

            $subrubrosIds = $request->input('subrubros', []);
            $subrubrosNuevos = $request->input('subrubros_nuevos', []);

            // EXISTENTES
            if (!empty($subrubrosIds)) {
                Subrubro::whereIn('sub_id', $subrubrosIds)
                    ->update(['rub_id' => $rubro->rub_id]);
            }

            // NUEVOS
            foreach ($subrubrosNuevos as $nombre) {
                $nombre = trim($nombre);

                if ($nombre === '') continue;

                Subrubro::create([
                    'rub_id' => $rubro->rub_id,
                    'sub_nombre' => $nombre,
                    'sub_estado' => 1,
                    'sub_fecha_alta' => now(),
                    'sub_usu_alta' => 1,
                ]);
            }

            return redirect()
                ->route('rubros.index')
                ->with('success', 'Rubro creado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $rubro = Rubro::findOrFail($id);

        $subrubrosDisponibles = Subrubro::where('sub_estado', 1)
            ->where(function ($q) use ($id) {
                $q->whereNull('rub_id')
                ->orWhere('rub_id', $id);
            })
            ->orderBy('sub_nombre')
            ->get(['sub_id', 'sub_nombre', 'rub_id']);

        $subrubrosSeleccionados = Subrubro::where('rub_id', $id)
            ->where('sub_estado', 1)
            ->orderBy('sub_nombre')
            ->get(['sub_id', 'sub_nombre'])
            ->map(fn ($item) => [
                'id' => $item->sub_id,
                'name' => $item->sub_nombre,
            ])
            ->values()
            ->toArray();

        return view('rubros.edit', compact(
            'rubro',
            'subrubrosDisponibles',
            'subrubrosSeleccionados'
            ));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validarRubro($request);

            $rubro = Rubro::findOrFail($id);

            $rubro->update([
                'rub_codigo' => $request->f_codigo,
                'rub_nombre' => $request->f_nombre,
                'rub_descripcion' => $request->f_descripcion,
                'rub_descripcion_corta' => $request->f_descripcion_corta,
            ]);

            $subrubrosIds = $request->input('subrubros', []);
            $subrubrosNuevos = $request->input('subrubros_nuevos', []);

            // DESVINCULAR LOS QUE YA NO ESTÁN
            Subrubro::where('rub_id', $id)
                ->whereNotIn('sub_id', $subrubrosIds)
                ->update(['rub_id' => null]);

            // VINCULAR EXISTENTES
            if (!empty($subrubrosIds)) {
                Subrubro::whereIn('sub_id', $subrubrosIds)
                    ->update(['rub_id' => $id]);
            }

            // CREAR NUEVOS
            foreach ($subrubrosNuevos as $nombre) {
                $nombre = trim($nombre);

                if ($nombre === '') continue;

                Subrubro::create([
                    'rub_id' => $id,
                    'sub_nombre' => $nombre,
                    'sub_estado' => 1,
                    'sub_fecha_alta' => now(),
                    'sub_usu_alta' => 1,
                ]);
            }

            return redirect()
                ->route('rubros.edit', $id)
                ->with('success', 'Rubro actualizado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $rubro = Rubro::findOrFail($id);

            $rubro->update([
                'rub_estado' => 0,
                'rub_fecha_baja' => now(),
                'rub_usu_baja' => 1,
            ]);

            return redirect()
                ->route('rubros.index')
                ->with('success', 'Rubro eliminado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
