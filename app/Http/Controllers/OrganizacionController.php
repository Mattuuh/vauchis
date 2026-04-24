<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use App\Models\Pais;
use App\Models\Provincia;
use App\Models\TipoDocumento;
use App\Models\TipoResponsabilidad;
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

        return view('organizaciones.create', compact(
            'tiposResponsabilidad',
            'tiposDocumento',
            'paises',
            'provincias',
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
            $this->validarOrganizacion($request);

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
                'org_estado' => '1',
                'org_estado2' => null,
                'org_fecha_alta' => now(),
                'org_usu_alta' => '1',
            ]);

            // dd('Se guardó correctamente', $organizacion);

            return redirect()
                ->route('organizacion.index')
                ->with('success', 'Organizacion creada correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $organizacion = Organizacion::findOrFail($id);

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

        return view('organizaciones.edit', compact(
            'organizacion',
            'tiposDocumento',
            'paises',
            'provincias',
            'domiciliosDisponibles',
            'domiciliosSeleccionados',
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validarOrganizacion($request);

            $organizacion = Organizacion::findOrFail($id);

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

            return redirect()
                ->route('organizacion.index')
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
                ->route('organizacion.index')
                ->with('success', 'Organizacion eliminada correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}