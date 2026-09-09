<?php

namespace App\Http\Controllers;

use App\Models\Coleccion;
use App\Models\ColeccionFile;
use App\Models\TipoArchivo;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ColeccionController extends Controller
{
    public function index()
    {
        $colecciones = Coleccion::orderBy('colecc_id','desc')
            ->get();

        return view('colecciones.index', compact('colecciones'));
    }

    public function create()
    {
        $tipos_archivos = TipoArchivo::where('tipo_archivo_estado', 1)
            ->orderBy('tipo_archivo_id', 'desc')
            ->get(['tipo_archivo_nombre', 'tipo_archivo_id']);

        return view('colecciones.create', compact('tipos_archivos'));
    }

    public function store(Request $request)
    {
        // dd('Entró al store', $request->all());
        // var_dump($request->all());
        $usuario_id=1;

        try {
            $coleccion = Coleccion::create([
                'colecc_nombre_interno' => $request->f_nombre_interno,
                'colecc_nombre' => $request->f_nombre,
                'colecc_descripcion' => $request->f_descripcion,
                'colecc_fecha_ini' => $request->f_fecha_ini,
                'colecc_fecha_fin' => $request->f_fecha_fin,
                'colecc_color_fondo' => $request->f_color_fondo,
                'colecc_publico' => $request->boolean('f_publico') ? 1 : 0,
                'colecc_estado' => 1,
                'colecc_fecha_alta' => now(),
                'colecc_usu_alta' => $usuario_id,
            ]);

            if ($request->hasFile('imagenes')) {
                $tiposArchivos = $request->input('f_tipo_archivo_id', []);

                foreach ($request->file('imagenes') as $index => $imagen) {
                    $tipo_archivo_id = $tiposArchivos[$index] ?? null;

                    $name = sanear_string($imagen->getClientOriginalName());
                    $name_legible = $imagen->getClientOriginalName();
                    $type = $imagen->getMimeType();
                    $size = $imagen->getSize();
                    $format = $imagen->getClientOriginalExtension();
                    $path = $imagen->store('colecciones', 'public');

                    $imagen = ColeccionFile::create([
                        'colecc_id' => $coleccion->colecc_id,
                        'tipo_archivo_id' => $tipo_archivo_id,
                        'cf_nombre' => $name,
                        'cf_img_nombre_legible' => $name_legible,
                        'cf_img_name' => $name,
                        'cf_img_path' => $path,
                        'cf_img_format' => $format,
                        'cf_img_size' => $size,
                        'cf_principal' => 0,
                        'cf_estado' => 1,
                        'cf_fecha_alta' => now(),
                        'cf_usu_alta' => $usuario_id,
                    ]);
                }
            }

            return redirect()
                ->route('admin.colecciones.index')
                ->with('success', 'Coleccion creado correctamente');

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
        $coleccion = Coleccion::with([
            'imagenes'
        ])->findOrFail($id);

        $tipos_archivos = TipoArchivo::where('tipo_archivo_estado', 1)
            ->orderBy('tipo_archivo_id', 'desc')
            ->get(['tipo_archivo_nombre', 'tipo_archivo_id']);

        return view('colecciones.edit', compact(
            'coleccion',
            'tipos_archivos',
        ));
    }

    public function update(Request $request, $id)
    {
        $usuario_id=1;

        try {
            $coleccion = Coleccion::findOrFail($id);

            $coleccion->update([
                'colecc_nombre_interno' => $request->f_nombre_interno,
                'colecc_nombre' => $request->f_nombre,
                'colecc_descripcion' => $request->f_descripcion,
                'colecc_fecha_ini' => $request->f_fecha_ini,
                'colecc_fecha_fin' => $request->f_fecha_fin,
                'colecc_color_fondo' => $request->f_color_fondo,
                'colecc_publico' => $request->boolean('f_publico') ? 1 : 0,
                'colecc_estado' => 1,
                'colecc_fecha_alta' => now(),
                'colecc_usu_alta' => $usuario_id,
            ]);

            
            // Eliminar logos marcados
            if ($request->filled('delete_imagenes')) {
                $imagenes = ColeccionFile::where('colecc_id', $id)
                    ->whereIn('cf_id', $request->delete_imagenes)
                    ->get();

                foreach ($imagenes as $imagen) {
                    $imagen->update([
                        'cf_principal' => 0,
                        'cf_estado' => 0,
                        'cf_fecha_baja' => now(),
                        'cf_usu_baja' => $usuario_id,
                    ]);
                }
            }

            // LOGO PRINCIPAL
            if ($request->filled('imagen_principal_1')) {
                ColeccionFile::where('colecc_id', $id)
                    ->where('tipo_archivo_id', 1)
                    ->where('cf_estado', 1)
                    ->update([
                        'cf_principal' => 0,
                    ]);

                ColeccionFile::where('colecc_id', $id)
                    ->where('cf_id', $request->imagen_principal_1)
                    ->where('cf_estado', 1)
                    ->update([
                        'cf_principal' => 1,
                        'cf_fecha_mod' => now(),
                        'cf_usu_mod' => $usuario_id,
                    ]);
            }
            // BANNER PRINCIPAL
            if ($request->filled('imagen_principal_2')) {
                ColeccionFile::where('colecc_id', $id)
                    ->where('tipo_archivo_id', 2)
                    ->where('cf_estado', 1)
                    ->update([
                        'cf_principal' => 0,
                    ]);

                ColeccionFile::where('colecc_id', $id)
                    ->where('cf_id', $request->imagen_principal_2)
                    ->where('cf_estado', 1)
                    ->update([
                        'cf_principal' => 1,
                        'cf_fecha_mod' => now(),
                        'cf_usu_mod' => $usuario_id,
                    ]);
            }

            if ($request->hasFile('imagenes')) {
                $tiposArchivos = $request->input('f_tipo_archivo_id', []);

                foreach ($request->file('imagenes') as $index => $imagen) {
                    $tipo_archivo_id = $tiposArchivos[$index] ?? null;

                    $name = sanear_string($imagen->getClientOriginalName());
                    $name_legible = $imagen->getClientOriginalName();
                    $type = $imagen->getMimeType();
                    $size = $imagen->getSize();
                    $format = $imagen->getClientOriginalExtension();
                    $path = $imagen->store('colecciones', 'public');

                    $imagen = ColeccionFile::create([
                        'colecc_id' => $id,
                        'tipo_archivo_id' => $tipo_archivo_id,
                        'cf_nombre' => $name,
                        'cf_img_nombre_legible' => $name_legible,
                        'cf_img_name' => $name,
                        'cf_img_path' => $path,
                        'cf_img_format' => $format,
                        'cf_img_size' => $size,
                        'cf_principal' => 0,
                        'cf_estado' => 1,
                        'cf_fecha_alta' => now(),
                        'cf_usu_alta' => $usuario_id,
                    ]);
                }
            }

            return redirect()
                ->route('admin.colecciones.edit', $id)
                ->with('success', 'Coleccion actualizada correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $coleccion = Coleccion::findOrFail($id);

            $coleccion->update([
                'colecc_estado' => 0,
                'colecc_fecha_baja' => now(),
                'colecc_usu_baja' => 1,
            ]);

            return redirect()
                ->route('admin.colecciones.index')
                ->with('success', 'Coleccion eliminada correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function listado(Request $request)
    {
        $query = Coleccion::query();

        if ($request->filled('fecha_desde')) {
            $query->whereDate('colecc_fecha_alta', '>=', $request->fecha_desde);
        }

        if ($request->filled('buscar')) {
            $query->where('colecc_nombre', 'like', "%".$request->buscar."%");
        }

        $colecciones = $query
            ->orderBy('colecc_id', 'desc')
            ->paginate(20);

        return response()->json([
            'body' => view(
                'colecciones.partials.tabla',
                compact('colecciones')
            )->render(),

            'foot' => view(
                'colecciones.partials.paginacion',
                compact('colecciones')
            )->render(),

            'kregtotal' => $colecciones->total()
        ]);
    }

    public function vouchers_por_coleccion($id)
    {
        // $coleccion = Coleccion::with('imagenPrincipal', 'logoPrincipal', 'resaltador_coleccion')
        $coleccion = Coleccion::with('imagenPrincipal', 'logoPrincipal')
        // $coleccion = Coleccion::
            ->where('colecc_publico',1)
            ->where('colecc_estado',1)
            ->findOrFail($id);

        if (!$coleccion) {
            abort(404);
        }

        $vouchers = Voucher::with('imagenes')
            ->with([
                'modalidad.campos',
                'modalidadValores',
                'modalidadValores.campo',
            ])
            ->withWhereHas('modalidad', function ($query) {
                $query->where('tipo_mod_id', 3);
            })
            // ->whereIn('ent_id', $entidades)
            ->where('vou_estado', 1)
            ->get();

        // $vouchers_fijos = Voucher::with('imagenes')
        //     ->with([
        //         'modalidad.campos',
        //         'modalidadValores',
        //         'modalidadValores.campo',
        //     ])
        //     ->withWhereHas('modalidad', function ($query) {
        //         $query->where('tipo_mod_id', 1);
        //     })
        //     ->where('ent_id', $id)
        //     ->where('vou_estado', 1)
        //     ->get();

        // $vouchers_eleccion = Voucher::with('imagenes')
        //     ->with([
        //         'modalidad.campos',
        //         'modalidadValores',
        //         'modalidadValores.campo',
        //     ])
        //     ->withWhereHas('modalidad', function ($query) {
        //         $query->where('tipo_mod_id', 2);
        //     })
        //     ->where('ent_id', $id)
        //     ->where('vou_estado', 1)
        //     ->get();

            // dd($vouchers_fijos);
            // dd($voucher->toArray());

        // return view('entidad', compact('entidad', 'domicilios', 'vouchers', 'vouchers_fijos', 'vouchers_eleccion'));
        return view('coleccion', compact('coleccion', 'vouchers'));
    }
}
