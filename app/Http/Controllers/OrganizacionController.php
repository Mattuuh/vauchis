<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\EntidadDomicilio;
use App\Models\Organizacion;
use App\Models\OrganizacionImagen;
use App\Models\Pais;
use App\Models\Provincia;
use App\Models\TipoArchivo;
use App\Models\TipoDocumento;
use App\Models\TipoResponsabilidad;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizacionController extends Controller
{
    public function index()
    {
        // $organizaciones = collect([
        //     [
        //         'nombre' => 'Empresa',
        //         'descripcion' => 'Personas jurídicas y empresas registradas.',
        //         'fecha' => '15/01/2024',
        //         'status' => 'Activo',
        //         'icono' => 'bi-building'
        //     ],
        //     [
        //         'nombre' => 'Persona Natural',
        //         'descripcion' => 'Personas naturales con identificación.',
        //         'fecha' => '22/02/2024',
        //         'status' => 'Activo',
        //         'icono' => 'bi-person'
        //     ],
        //     [
        //         'nombre' => 'Comercio',
        //         'descripcion' => 'Negocios y comercios asociados.',
        //         'fecha' => '10/03/2024',
        //         'status' => 'Activo',
        //         'icono' => 'bi-shop'
        //     ],
        //     [
        //         'nombre' => 'Institución Educativa',
        //         'descripcion' => 'Centros educativos y universidades.',
        //         'fecha' => '05/04/2024',
        //         'status' => 'Activo',
        //         'icono' => 'bi-bank'
        //     ],
        //     [
        //         'nombre' => 'Organización Sin Fines de Lucro',
        //         'descripcion' => 'Fundaciones y organizaciones sociales.',
        //         'fecha' => '18/04/2024',
        //         'status' => 'Inactivo',
        //         'icono' => 'bi-heart-pulse'
        //     ],
        //     [
        //         'nombre' => 'Entidad Gubernamental',
        //         'descripcion' => 'Entidades estatales y gubernamentales.',
        //         'fecha' => '30/04/2024',
        //         'status' => 'Activo',
        //         'icono' => 'bi-building-gear'
        //     ],
        // ]);

        $organizaciones = Organizacion::where('org_estado', 1)
            ->orderBy('org_id','desc')
            ->get([
                'org_id', 
                'org_nombre_fantasia', 
                'org_nombre', 
                'org_razon_social', 
                'org_estado', 
                'org_fecha_alta',
            ]);

        return view('organizaciones.index', compact('organizaciones'));
    }

    public function create()
    {
        $tiposResponsabilidad = TipoResponsabilidad::where('tipo_resp_estado', 1)
            ->orderBy('tipo_resp_id','desc')
            ->pluck('tipo_resp_nombre', 'tipo_resp_id');

        $tiposDocumento = TipoDocumento::where('tipo_doc_estado', 1)
            ->orderBy('tipo_doc_id','desc')
            ->pluck('tipo_doc_nombre', 'tipo_doc_id');

        $paises = Pais::where('pais_estado', 1)
            ->orderBy('pais_nombre')
            ->pluck('pais_nombre', 'pais_id');

        $provincias = Provincia::where('provincia_estado', 1)
            ->orderBy('provincia_nombre')
            ->get(['provincia_id', 'provincia_nombre', 'pais_id']);

        $tipos_archivos = TipoArchivo::where('tipo_archivo_estado', 1)
            ->orderBy('tipo_archivo_id', 'desc')
            ->get(['tipo_archivo_nombre', 'tipo_archivo_id']);

        return view('organizaciones.create', compact(
            'tiposResponsabilidad',
            'tiposDocumento',
            'paises',
            'provincias',
            'tipos_archivos'
        ));
    }

    private function validarOrganizacion(Request $request)
    {
        return $request->validate([
            // 'tipo_resp_id' => ['required'],
            'tipo_doc_id' => ['required'],
            'f_documento' => ['required', 'max:150'],
            'f_nombre_fantasia' => ['required', 'max:150'],
            'f_nombre' => ['required', 'max:150'],
            'f_razon_social' => ['required', 'max:150'],
            // 'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'f_pais_id' => ['required'],
            'f_provincia_id' => ['required'],
            'f_ciudad' => ['required', 'max:100'],
            'f_direccion' => ['required', 'max:255'],
            'f_email1' => ['required', 'email', 'max:150'],
            'f_email2' => ['nullable', 'email', 'max:150'],
            'f_telefono1' => ['required', 'max:30'],
            'f_telefono2' => ['nullable', 'max:30'],
            'f_longitud' => ['nullable', 'max:30'],
            'f_latitud' => ['nullable', 'max:30'],
            'f_descripcion_publica' => ['required', 'max:255'],
            'f_descripcion_interna' => ['required', 'max:255'],
            'domicilios' => ['nullable', 'array'],
            'domicilios.*' => ['integer'],
        ], [
            // 'tipo_resp_id.required' => 'Selecciona el tipo de responsabilidad.',
            'tipo_doc_id.required' => 'Selecciona el tipo de documento.',
            'f_documento.required' => 'Ingresa el número de documento.',
            'f_nombre_fantasia.required' => 'Ingresa el nombre de fantasía.',
            'f_razon_social.required' => 'Ingresa la razón social.',
            'f_pais_id.required' => 'Selecciona el país.',
            'f_provincia_id.required' => 'Selecciona la provincia.',
            'f_ciudad.required' => 'Ingresa la ciudad.',
            'f_direccion.required' => 'Ingresa la dirección.',
            'f_telefono1.required' => 'Ingresa el teléfono principal.',
            // 'f_longitud.required' => 'Ingresa la ciudad.',
            // 'f_latitud.required' => 'Ingresa la ciudad.',
            'f_descripcion_publica.required' => 'Ingresa una descripcion breve y precisa.',
            'f_descripcion_interna.required' => 'Ingresa una descripcion mas amplia y detallada.',
        ]);
    }

    public function store(Request $request)
    {
        // dd('Entró al store', $request->all());
        // var_dump($request->all());

        try {
            // $this->validarOrganizacion($request);

            $logoPath = null;

            // if ($request->hasFile('logo')) {
            //     $name_legible = $request->file('logo')->getClientOriginalName();
            //     $type = $request->file('logo')->getMimeType();
            //     $size = $request->file('logo')->getSize();
            //     $format = $request->file('logo')->getClientOriginalExtension();
            //     $logoPath = $request->file('logo')->store('org_logos', 'public');
            // }

            $organizacion = Organizacion::create([
                'tipo_doc_id' => $request->tipo_doc_id,
                'org_documento' => $request->f_documento,
                'org_nombre_fantasia' => $request->f_nombre_fantasia,
                'org_nombre' => $request->f_nombre,
                'org_razon_social' => $request->f_razon_social,
                'pais_id' => $request->f_pais_id,
                'provincia_id' => $request->f_provincia_id,
                'org_ciudad' => $request->f_ciudad,
                'org_codigo_postal' => $request->f_codigo_postal,
                'org_barrio' => $request->f_barrio,
                'org_direccion' => $request->f_direccion,
                'org_email1' => $request->f_email1,
                'org_email2' => $request->f_email2,
                'org_telefono1' => $request->f_telefono1,
                'org_telefono2' => $request->f_telefono2,
                'org_latitud' => $request->f_latitud,
                'org_longitud' => $request->f_longitud,
                'org_descripcion_publica' => $request->f_descripcion_publica,
                'org_descripcion_interna' => $request->f_descripcion_interna,
                // 'org_img_nombre_legible' => $name_legible,
                // 'org_img_name' => $name_legible,
                // 'org_img_path' => $logoPath,
                // 'org_img_format' => $format,
                // 'org_img_size' => $size,
                'org_color_fondo' => $request->f_color_fondo,
                'org_publico' => $request->f_publico,
                'org_estado' => '1',
                'org_estado2' => null,
                'org_fecha_alta' => now(),
                'org_usu_alta' => '1',
            ]);

            $path = null;
            $usu = 1;

            if ($request->hasFile('imagenes')) {
                $tiposArchivos = $request->input('f_tipo_archivo_id', []);

                foreach ($request->file('imagenes') as $index => $imagen) {
                    // $filename = Str::uuid() . '.' . $imagen->extension();
                    // $path = $imagen->storeAs('logos', $filename, 'public');
                    $tipo_archivo_id = $tiposArchivos[$index] ?? null;

                    $name = sanear_string($imagen->getClientOriginalName());
                    $name_legible = $imagen->getClientOriginalName();
                    $type = $imagen->getMimeType();
                    $size = $imagen->getSize();
                    $format = $imagen->getClientOriginalExtension();
                    $path = $imagen->store('organizaciones', 'public');

                    $imagen = OrganizacionImagen::create([
                        'org_id' => $organizacion->org_id,
                        'tipo_archivo_id' => $tipo_archivo_id,
                        'of_nombre' => $name,
                        'of_img_nombre_legible' => $name_legible,
                        'of_img_name' => $name,
                        'of_img_path' => $path,
                        'of_img_format' => $format,
                        'of_img_size' => $size,
                        'of_principal' => 1,
                        'of_estado' => 1,
                        'of_fecha_alta' => now(),
                        'of_usu_alta' => $usu,
                    ]);
                }
            }

            // dd('Se guardó correctamente', $organizacion);

            return redirect()
                ->route('admin.organizacion.index')
                ->with('success', 'Organizacion creada correctamente');

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
        $organizacion = Organizacion::with([
            'imagenes'
        ])->findOrFail($id);

        $tiposDocumento = TipoDocumento::where('tipo_doc_estado', 1)
            ->orderBy('tipo_doc_id', 'desc')
            ->pluck('tipo_doc_nombre', 'tipo_doc_id');

        $paises = Pais::where('pais_estado', 1)
            ->orderBy('pais_nombre')
            ->pluck('pais_nombre', 'pais_id');

        $provincias = Provincia::where('provincia_estado', 1)
            ->orderBy('provincia_nombre')
            ->get(['provincia_id', 'provincia_nombre', 'pais_id']);

        $domiciliosDisponibles = DB::table('entidades_domicilios as ed')
            ->join('entidades as e', 'e.ent_id', '=', 'ed.ent_id')
            ->where('ed.ed_estado', 1)
            ->where('e.ent_estado', 1)
            ->where(function ($q) use ($id) {
                $q->whereNull('ed.org_id')
                ->orWhere('ed.org_id', $id);
            })
            ->select(
                'ed.ed_id as id',
                'e.ent_nombre_fantasia as nombre',
                'ed.ed_direccion as direccion'
            )
            ->orderBy('e.ent_nombre_fantasia')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'nombre' => $item->nombre,
                'direccion' => $item->direccion,
            ])
            ->toArray();

        $domiciliosSeleccionados = DB::table('entidades_domicilios as ed')
            ->join('entidades as e', 'e.ent_id', '=', 'ed.ent_id')
            ->where('ed.ed_estado', 1)
            ->where('ed.org_id', $id)
            ->select(
                'ed.ed_id as id',
                'e.ent_nombre_fantasia as nombre',
                'ed.ed_direccion as direccion'
            )
            ->orderBy('e.ent_nombre_fantasia')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'nombre' => $item->nombre,
                'direccion' => $item->direccion,
            ])
            ->toArray();

        $tipos_archivos = TipoArchivo::where('tipo_archivo_estado', 1)
            ->orderBy('tipo_archivo_id', 'desc')
            ->get(['tipo_archivo_nombre', 'tipo_archivo_id']);

        return view('organizaciones.edit', compact(
            'organizacion',
            'tiposDocumento',
            'paises',
            'provincias',
            'domiciliosDisponibles',
            'domiciliosSeleccionados',
            'tipos_archivos'
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            // $this->validarOrganizacion($request);

            $organizacion = Organizacion::findOrFail($id);

            $logoPath = null;
            $usu=1;

            if ($request->hasFile('logo')) {
                $name_legible = $request->file('logo')->getClientOriginalName();
                $type = $request->file('logo')->getMimeType();
                $size = $request->file('logo')->getSize();
                $format = $request->file('logo')->getClientOriginalExtension();
                $logoPath = $request->file('logo')->store('org_logos', 'public');

                $organizacion->update([
                    'org_img_nombre_legible' => $name_legible,
                    'org_img_name' => $name_legible,
                    'org_img_path' => $logoPath,
                    'org_img_format' => $format,
                    'org_img_size' => $size,
                ]);
            }

            $organizacion->update([
                'tipo_doc_id' => $request->tipo_doc_id,
                'org_documento' => $request->f_documento,
                'org_nombre_fantasia' => $request->f_nombre_fantasia,
                'org_nombre' => $request->f_nombre,
                'org_razon_social' => $request->f_razon_social,
                'pais_id' => $request->f_pais_id,
                'provincia_id' => $request->f_provincia_id,
                'org_ciudad' => $request->f_ciudad,
                'org_codigo_postal' => $request->f_codigo_postal,
                'org_barrio' => $request->f_barrio,
                'org_direccion' => $request->f_direccion,
                'org_email1' => $request->f_email1,
                'org_email2' => $request->f_email2,
                'org_telefono1' => $request->f_telefono1,
                'org_telefono2' => $request->f_telefono2,
                'org_latitud' => $request->f_latitud,
                'org_longitud' => $request->f_longitud,
                'org_descripcion_publica' => $request->f_descripcion_publica,
                'org_descripcion_interna' => $request->f_descripcion_interna,
                'org_color_fondo' => $request->f_color_fondo,
                'org_publico' => $request->f_publico,
                'org_fecha_mod' => now(),
                'org_usu_mod' => 1,
            ]);

            $domiciliosIds = $request->input('domicilios', []);

            // Desvincular de esta organización los domicilios que ya no están seleccionados
            DB::table('entidades_domicilios')
                ->where('org_id', $id)
                ->update(['org_id' => null]);

            // Volver a vincular los seleccionados
            if (!empty($domiciliosIds)) {
                DB::table('entidades_domicilios')
                    ->whereIn('ed_id', $domiciliosIds)
                    ->update(['org_id' => $id]);
            }

            
            // Eliminar logos marcados
            if ($request->filled('delete_logos')) {

                $logos = OrganizacionImagen::where('org_id', $id)
                    ->whereIn('of_id', $request->delete_logos)
                    ->get();

                foreach ($logos as $logo) {

                    if ($logo->imagen && $logo->imagen->of_img_path) {
                        // Storage::disk('public')->delete($logo->imagen->of_img_path);
                    }

                    $logo->update([
                        'of_principal' => 0,
                        'of_estado' => 0,
                        'of_fecha_baja' => now(),
                        'of_usu_baja' => $usu,
                    ]);
                }
            }

            // LOGO PRINCIPAL
            if ($request->filled('logo_principal')) {

                OrganizacionImagen::where('ent_id', $id)
                    ->where('of_estado', 1)
                    ->update([
                        'of_principal' => 1,
                    ]);

                OrganizacionImagen::where('ent_id', $id)
                    ->where('of_id', $request->logo_principal)
                    ->where('of_estado', 1)
                    ->update([
                        'of_principal' => 1,
                        'of_fecha_mod' => now(),
                        'of_usu_mod' => $usu,
                    ]);
            }

            if ($request->hasFile('imagenes')) {
                $tiposArchivos = $request->input('f_tipo_archivo_id', []);

                foreach ($request->file('imagenes') as $index => $imagen) {
                    // $filename = Str::uuid() . '.' . $imagen->extension();
                    // $path = $imagen->storeAs('logos', $filename, 'public');
                    $tipo_archivo_id = $tiposArchivos[$index] ?? null;

                    $name = sanear_string($imagen->getClientOriginalName());
                    $name_legible = $imagen->getClientOriginalName();
                    $type = $imagen->getMimeType();
                    $size = $imagen->getSize();
                    $format = $imagen->getClientOriginalExtension();
                    $path = $imagen->store('logos', 'public');

                    $imagen = OrganizacionImagen::create([
                        'org_id' => $id,
                        'tipo_archivo_id' => $tipo_archivo_id,
                        'of_nombre' => $name,
                        'of_img_nombre_legible' => $name_legible,
                        'of_img_name' => $name,
                        'of_img_path' => $path,
                        'of_img_format' => $format,
                        'of_img_size' => $size,
                        'of_principal' => 1,
                        'of_estado' => 1,
                        'of_fecha_alta' => now(),
                        'of_usu_alta' => $usu,
                    ]);
                }
            }

            return redirect()
                ->route('admin.organizacion.edit', $id)
                ->with('success', 'Organización actualizada correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $organizacion = Organizacion::findOrFail($id);

            $organizacion->update([
                'org_estado' => 0,
                'org_fecha_baja' => now(),
                'org_usu_baja' => 1,
            ]);

            return redirect()
                ->route('admin.organizacion.index')
                ->with('success', 'Organizacion eliminada correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function listado(Request $request)
    {
        $query = Organizacion::query();

        if ($request->filled('fecha_desde')) {
            $query->whereDate('org_fecha_alta', '>=', $request->fecha_desde);
        }

        if ($request->filled('buscar')) {
            $query->where('org_nombre', 'like', "%".$request->buscar."%");
        }

        $organizaciones = $query
            ->orderBy('org_id', 'desc')
            ->paginate(20);

        return response()->json([
            'body' => view(
                'organizaciones.partials.tabla',
                compact('organizaciones')
            )->render(),

            'foot' => view(
                'organizaciones.partials.paginacion',
                compact('organizaciones')
            )->render(),

            'kregtotal' => $organizaciones->total()
        ]);
    }

    public function ordenar()
    {
        $organizaciones = Organizacion::where('org_publico',1)
            ->where('org_estado',1)
            ->orderByRaw('CASE WHEN org_orden IS NULL OR org_orden = 0 THEN 1 ELSE 0 END')
            ->orderBy('org_orden')
            ->orderBy('org_id')
            ->get([
                'org_id', 
                'org_nombre_fantasia', 
                'org_nombre', 
                'org_razon_social', 
                'org_estado', 
                'org_fecha_alta',
            ]);

        return view('organizaciones.orden', compact('organizaciones'));
    }

    public function guardar_orden(Request $request)
    {
        foreach ($request->orden as $index => $id) {
            Organizacion::where('org_id', $id)
                ->update([
                    'org_orden' => $index + 1,
                    'org_fecha_mod' => now(),
                    'org_usu_mod' => $usu ?? 0
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden guardado correctamente'
        ]);
    }

    public function vouchers_por_organizacion($id)
    {
        // $organizacion = Organizacion::with('imagenPrincipal', 'logoPrincipal', 'resaltador_organizacion')
        $organizacion = Organizacion::with('imagenPrincipal', 'logoPrincipal')
        // $organizacion = Organizacion::
            ->where('org_publico',1)
            ->where('org_estado',1)
            ->findOrFail($id);

        $entidades = EntidadDomicilio::where('org_id', $id)
            ->where('ed_publico', 1)
            ->where('ed_estado', 1)
            ->pluck('ent_id');
        // dd($entidades);

        if (!$organizacion) {
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
            ->whereIn('ent_id', $entidades)
            ->where('vou_estado', 1)
            ->get();


        $entidades = Entidad::whereIn('ent_id', $entidades)
            ->where('ent_publico', 1)
            ->where('ent_estado', 1)
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
        return view('organizacion', compact('organizacion', 'vouchers', 'entidades'));
    }
}