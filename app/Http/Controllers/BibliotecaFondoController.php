<?php

namespace App\Http\Controllers;

use App\Models\BibliotecaFondo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BibliotecaFondoController extends Controller
{
    public function create()
    {
        return view('biblioteca_fondos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = null;
        $usu = 1;

        if ($request->hasFile('imagen')) {
            $name_legible = $request->file('imagen')->getClientOriginalName();
            $name = sanear_string($name_legible);
            $type = $request->file('imagen')->getMimeType();
            $size = $request->file('imagen')->getSize();
            [$width, $height] = getimagesize($request->file('imagen'));
            $format = $request->file('imagen')->getClientOriginalExtension();
            $path = $request->file('imagen')->store('biblioteca_imagenes', 'public');
        }

        BibliotecaFondo::create([
            'pf_nombre' => $request->nombre,
            'pf_img_nombre_legible' => $name_legible,
            'pf_img_name' => $name,
            'pf_img_path' => $path,
            'pf_img_format' => $format,
            'pf_img_size' => $size,
            'pf_img_ancho' => $width,
            'pf_img_alto' => $height,
            'pf_estado' => 1,
            'pf_fecha_alta' => now(),
            'pf_usu_alta' => $usu,
        ]);

        return redirect()
            ->route('biblioteca_fondos.create')
            ->with('success', 'Imagen registrada correctamente.');
    }
}
