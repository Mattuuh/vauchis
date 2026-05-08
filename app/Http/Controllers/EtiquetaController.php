<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::orderBy('eti_id','desc')
            ->get([
                'eti_id', 
                'eti_nombre', 
                'eti_descripcion', 
                'eti_fecha_ini', 
                'eti_fecha_fin', 
                'eti_publico', 
                'eti_estado', 
                'eti_fecha_alta',
            ]);

        return view('etiquetas.index', compact('etiquetas'));
    }

    public function create()
    {
        return view('etiquetas.create', compact([]));
    }

    private function validarEtiqueta(Request $request)
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
            $this->validarEtiqueta($request);

            $logoPath = null;

            if ($request->hasFile('logo')) {
                $name_legible = $request->file('logo')->getClientOriginalName();
                $type = $request->file('logo')->getMimeType();
                $size = $request->file('logo')->getSize();
                $format = $request->file('logo')->getClientOriginalExtension();
                $logoPath = $request->file('logo')->store('org_logos', 'public');
            }

            $etiqueta = Etiqueta::create([
                'eti_nombre' => $request->f_nombre,
                'eti_descripcion' => $request->f_observaciones,
                'eti_fecha_ini' => $request->f_fecha_ini,
                'eti_fecha_fin' => $request->f_fecha_fin,
                'eti_publico' => $request->boolean('f_publico') ? 1 : 0,
                // 'ent_img_nombre_legible' => $name_legible,
                // 'ent_img_name' => $name_legible,
                // 'ent_img_path' => $logoPath,
                // 'ent_img_format' => $format,
                // 'ent_img_size' => $size,
                'eti_estado' => 1,
                'eti_fecha_alta' => now(),
                'eti_usu_alta' => 1,
            ]);

            return redirect()
                ->route('etiquetas.index')
                ->with('success', 'Etiqueta creada correctamente');

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
        $etiqueta = Etiqueta::findOrFail($id);

        return view('etiquetas.edit', compact(
            'etiqueta',
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validarEtiqueta($request);

            $etiqueta = Etiqueta::findOrFail($id);

            $logoPath = null;

            if ($request->hasFile('logo')) {
                $name_legible = $request->file('logo')->getClientOriginalName();
                $type = $request->file('logo')->getMimeType();
                $size = $request->file('logo')->getSize();
                $format = $request->file('logo')->getClientOriginalExtension();
                $logoPath = $request->file('logo')->store('org_logos', 'public');

                $etiqueta->update([
                    'eti_img_nombre_legible' => $name_legible,
                    'eti_img_name' => $name_legible,
                    'eti_img_path' => $logoPath,
                    'eti_img_format' => $format,
                    'eti_img_size' => $size,
                ]);
            }

            $etiqueta->update([
                'eti_nombre' => $request->f_nombre,
                'eti_descripcion' => $request->f_observaciones,
                'eti_fecha_ini' => $request->f_fecha_ini,
                'eti_fecha_fin' => $request->f_fecha_fin,
                'eti_publico' => $request->boolean('f_publico') ? 1 : 0,
                'eti_fecha_mod' => now(),
                'eti_usu_mod' => 1,
            ]);

            return redirect()
                ->route('etiquetas.edit', $id)
                ->with('success', 'Etiqueta actualizada correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $etiqueta = Etiqueta::findOrFail($id);

            $etiqueta->update([
                'eti_estado' => 0,
                'eti_fecha_baja' => now(),
                'eti_usu_baja' => 1,
            ]);

            return redirect()
                ->route('etiqueta.index')
                ->with('success', 'Etiqueta eliminada correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
