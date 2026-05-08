<?php

namespace App\Http\Controllers;

use App\Models\Modalidad;
use App\Models\ModalidadCampo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModalidadController extends Controller
{
    private function validarModalidad(Request $request, $id = null)
    {
        return $request->validate([
            'f_codigo' => [
                'required',
                'string',
                'max:100',
                Rule::unique('modalidades', 'mod_codigo')->ignore($id, 'mod_id'),
            ],
            'f_nombre' => 'required|string|max:150',
            'f_descripcion' => 'nullable|string',

            'campos' => 'nullable|array',
            'campos.*.id' => 'nullable|integer',
            // 'campos.*.codigo' => 'required|string|max:100',
            'campos.*.nombre' => 'required|string|max:150',
            'campos.*.tipo' => 'required|string|max:50',
            // 'campos.*.label' => 'required|string|max:150',
            'campos.*.placeholder' => 'nullable|string|max:255',
            // 'campos.*.orden' => 'nullable|integer|min:1',
            'campos.*.opciones' => 'nullable|string',
            'campos.*.ayuda' => 'nullable|string|max:255',
        ]);
    }

    public function index()
    {
        $modalidades = Modalidad::orderBy('mod_id', 'desc')
            ->get([
                'mod_id',
                'mod_nombre',
                'mod_codigo',
                'mod_descripcion',
                'mod_estado',
                'mod_fecha_alta',
            ]);

        return view('modalidades.index', compact('modalidades'));
    }

    public function create()
    {
        return view('modalidades.create');
    }

    public function store(Request $request)
    {
        $this->validarModalidad($request);

        $modalidad = Modalidad::create([
            'mod_nombre' => $request->f_nombre,
            'mod_codigo' => $request->f_codigo,
            'mod_descripcion' => $request->f_descripcion,
            'mod_estado' => 1,
            'mod_fecha_alta' => now(),
            'mod_usu_alta' => 1,
        ]);

        $i=1;
        foreach ($request->campos ?? [] as $campo) {
            $codigo=sanear_string($campo['nombre']);

            ModalidadCampo::create([
                'mod_id' => $modalidad->mod_id,
                'mca_nombre' => null,
                'mca_codigo' => $codigo,
                'mca_tipo' => $campo['tipo'],
                'mca_label' => $campo['nombre'],
                'mca_placeholder' => $campo['placeholder'] ?? null,
                'mca_requerido' => !empty($campo['requerido']) ? 1 : 0,
                'mca_orden' => $i,
                'mca_opciones' => $campo['opciones'] ?? null,
                'mca_ayuda' => $campo['ayuda'] ?? null,
                'mca_estado' => !empty($campo['estado']) ? 1 : 0,
                'mca_fecha_alta' => now(),
                'mca_usu_alta' => 1,
            ]);
            $i++;
        }

        return redirect()
            ->route('modalidades.index')
            ->with('success', 'Modalidad creada correctamente');
    }

    public function edit($id)
    {
        $modalidad = Modalidad::with(['campos' => function ($query) {
            $query->orderBy('mca_orden')->orderBy('mca_id');
        }])->findOrFail($id);

        return view('modalidades.edit', compact('modalidad'));
    }

    public function update(Request $request, $id)
    {
        $this->validarModalidad($request, $id);

        $modalidad = Modalidad::with('campos')->findOrFail($id);

        $modalidad->update([
            'mod_nombre' => $request->f_nombre,
            'mod_codigo' => $request->f_codigo,
            'mod_descripcion' => $request->f_descripcion,
        ]);

        $camposRequest = $request->campos ?? [];
        $idsRecibidos = collect($camposRequest)
            ->pluck('id')
            ->filter()
            ->map(fn($value) => (int) $value)
            ->values()
            ->all();

        ModalidadCampo::where('mod_id', $modalidad->mod_id)
            ->when(count($idsRecibidos) > 0, function ($query) use ($idsRecibidos) {
                $query->whereNotIn('mca_id', $idsRecibidos);
            }, function ($query) {
                $query->whereRaw('1 = 1');
            })
            ->delete();

        $i=1;
        foreach ($camposRequest as $campo) {
            $codigo=sanear_string($campo['nombre']);

            $dataCampo = [
                'mod_id' => $modalidad->mod_id,
                'mca_nombre' => null,
                'mca_codigo' => $codigo,
                'mca_tipo' => $campo['tipo'],
                'mca_label' => $campo['nombre'],
                'mca_placeholder' => $campo['placeholder'] ?? null,
                'mca_requerido' => !empty($campo['requerido']) ? 1 : 0,
                'mca_orden' => $i,
                'mca_opciones' => $campo['opciones'] ?? null,
                'mca_ayuda' => $campo['ayuda'] ?? null,
                'mca_estado' => !empty($campo['estado']) ? 1 : 0,
            ];
            $i++;

            if (!empty($campo['id'])) {
                $campoExistente = ModalidadCampo::where('mod_id', $modalidad->mod_id)
                    ->where('mca_id', $campo['id'])
                    ->first();

                if ($campoExistente) {
                    $campoExistente->update($dataCampo);
                }
            } else {
                $dataCampo['mca_fecha_alta'] = now();
                $dataCampo['mca_usu_alta'] = 1;

                ModalidadCampo::create($dataCampo);
            }
        }

        return redirect()
            ->route('modalidades.index')
            ->with('success', 'Modalidad actualizada correctamente');
    }

    public function delete($id)
    {
        $modalidad = Modalidad::findOrFail($id);

        $modalidad->update([
            'mod_estado' => 0,
            'mod_fecha_baja' => now(),
            'mod_usu_baja' => 1,
        ]);

        return redirect()
            ->route('modalidades.index')
            ->with('success', 'Modalidad eliminada correctamente');
    }
}