<?php

namespace App\Http\Controllers;

use App\Models\Resaltador;
use Illuminate\Http\Request;

class ResaltadorController extends Controller
{
    public function index()
    {
        $resaltadores = Resaltador::orderBy('resal_id','desc')
            ->get([
                'resal_id', 
                'resal_nombre', 
                'resal_descripcion', 
                'resal_fecha_ini', 
                'resal_fecha_fin', 
                'resal_publico', 
                'resal_estado', 
                'resal_fecha_alta',
            ]);

        return view('resaltadores.index', compact('resaltadores'));
    }

    public function create()
    {
        return view('resaltadores.create', compact([]));
    }

    private function validar_resaltador(Request $request)
    {
        return $request->validate([
            'f_nombre' => ['required', 'max:150'],
            'f_fecha_ini_lab' => 'nullable|date_format:d/m/Y',
            'f_fecha_fin_lab' => 'nullable|date_format:d/m/Y|after_or_equal:f_fecha_ini_lab',

            // 'f_publico' => ['required'],
            'f_observaciones' => ['nullable', 'max:255'],
        ], [
            // 'f_nombre.required' => 'Ingresa el nombre.',
            'f_publico.required' => 'Seleccione la opcion.',
            // 'f_observaciones.required' => 'Ingresa una descripcion breve y precisa.',
        ]);
    }

    public function store(Request $request)
    {
        // dd('Entró al store', $request->all());
        // var_dump($request->all());

        try {
            $this->validar_resaltador($request);

            $path = null;

            if ($request->hasFile('imagen')) {
                $name_legible = $request->file('imagen')->getClientOriginalName();
                $type = $request->file('imagen')->getMimeType();
                $size = $request->file('imagen')->getSize();
                $format = $request->file('imagen')->getClientOriginalExtension();
                $path = $request->file('imagen')->store('resaltadores', 'public');
                
                $resaltador = Resaltador::create([
                    'resal_nombre' => $request->f_nombre,
                    'resal_descripcion' => $request->f_observaciones,
                    'resal_fecha_ini' => $request->f_fecha_ini,
                    'resal_fecha_fin' => $request->f_fecha_fin,
                    'resal_publico' => $request->boolean('f_publico') ? 1 : 0,
                    'resal_img_nombre_legible' => $name_legible,
                    'resal_img_name' => $name_legible,
                    'resal_img_path' => $path,
                    'resal_img_format' => $format,
                    'resal_img_size' => $size,
                    'resal_estado' => 1,
                    'resal_fecha_alta' => now(),
                    'resal_usu_alta' => 1,
                ]);
            }

            return redirect()
                ->route('resaltadores.index')
                ->with('success', 'Resaltador creado correctamente');

        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $resaltador = Resaltador::findOrFail($id);

        return view('resaltadores.edit', compact(
            'resaltador',
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validar_resaltador($request);

            $resaltador = Resaltador::findOrFail($id);

            $logoPath = null;

            if ($request->hasFile('logo')) {
                $name_legible = $request->file('logo')->getClientOriginalName();
                $type = $request->file('logo')->getMimeType();
                $size = $request->file('logo')->getSize();
                $format = $request->file('logo')->getClientOriginalExtension();
                $logoPath = $request->file('logo')->store('org_logos', 'public');

                $resaltador->update([
                    'resal_img_nombre_legible' => $name_legible,
                    'resal_img_name' => $name_legible,
                    'resal_img_path' => $logoPath,
                    'resal_img_format' => $format,
                    'resal_img_size' => $size,
                ]);
            }

            $resaltador->update([
                'resal_nombre' => $request->f_nombre,
                'resal_descripcion' => $request->f_observaciones,
                'resal_fecha_ini' => $request->f_fecha_ini,
                'resal_fecha_fin' => $request->f_fecha_fin,
                'resal_publico' => $request->boolean('f_publico') ? 1 : 0,
                'resal_fecha_mod' => now(),
                'resal_usu_mod' => 1,
            ]);

            return redirect()
                ->route('resaltadores.edit', $id)
                ->with('success', 'Resaltador actualizado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $resaltador = Resaltador::findOrFail($id);

            $resaltador->update([
                'resal_estado' => 0,
                'resal_fecha_baja' => now(),
                'resal_usu_baja' => 1,
            ]);

            return redirect()
                ->route('resaltadores.index')
                ->with('success', 'Resaltador eliminado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function listado(Request $request)
    {
        $query = Resaltador::query();

        if ($request->filled('fecha_desde')) {
            $query->whereDate('resal_fecha_alta', '>=', $request->fecha_desde);
        }

        if ($request->filled('buscar')) {
            $query->where('resal_nombre', 'like', "%".$request->buscar."%");
        }

        $resaltadores = $query
            ->orderBy('resal_id', 'desc')
            ->paginate(20);

        return response()->json([
            'body' => view(
                'resaltadores.partials.tabla',
                compact('resaltadores')
            )->render(),

            'foot' => view(
                'resaltadores.partials.paginacion',
                compact('resaltadores')
            )->render(),

            'kregtotal' => $resaltadores->total()
        ]);
    }
}
