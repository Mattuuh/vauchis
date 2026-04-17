<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Etiqueta;
use App\Models\Organizacion;
use App\Models\Pais;
use App\Models\Provincia;
use App\Models\Rubro;
use App\Models\Subrubro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TipoDocumento;
use App\Models\TipoEntidad;
use App\Models\TipoResponsabilidad;

class EntidadController extends Controller
{
    public function index()
    {
        // $entidades = collect([
        //     [
        //         'id' => 1,
        //         'name' => 'Nike',
        //         'category' => 'Ropa y Calzado',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg',
        //         'email' => 'contacto@nike.com',
        //         'created_at' => '12/05/2024',
        //         'vouchers_count' => 24,
        //         'status' => 'activo',
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Adidas',
        //         'category' => 'Ropa y Calzado',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg',
        //         'email' => 'info@adidas.com',
        //         'created_at' => '28/04/2024',
        //         'vouchers_count' => 18,
        //         'status' => 'activo',
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'Starbucks',
        //         'category' => 'Alimentos y Bebidas',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/sco/thumb/d/d3/Starbucks_Corporation_Logo_2011.svg/2048px-Starbucks_Corporation_Logo_2011.svg.png',
        //         'email' => 'hola@starbucks.com',
        //         'created_at' => '15/03/2024',
        //         'vouchers_count' => 32,
        //         'status' => 'activo',
        //     ],
        //     [
        //         'id' => 4,
        //         'name' => 'Apple',
        //         'category' => 'Tecnología',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
        //         'email' => 'soporte@apple.com',
        //         'created_at' => '05/02/2024',
        //         'vouchers_count' => 15,
        //         'status' => 'activo',
        //     ],
        //     [
        //         'id' => 5,
        //         'name' => 'Sephora',
        //         'category' => 'Belleza y Cuidado',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/70/Sephora_logo.svg',
        //         'email' => 'contacto@sephora.com',
        //         'created_at' => '20/01/2024',
        //         'vouchers_count' => 9,
        //         'status' => 'activo',
        //     ],
        //     [
        //         'id' => 6,
        //         'name' => 'McDonald\'s',
        //         'category' => 'Alimentos y Bebidas',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4e/McDonald%27s_Golden_Arches.svg',
        //         'email' => 'info@mcdonalds.com',
        //         'created_at' => '10/12/2023',
        //         'vouchers_count' => 27,
        //         'status' => 'activo',
        //     ],
        //     [
        //         'id' => 7,
        //         'name' => 'Samsung',
        //         'category' => 'Tecnología',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg',
        //         'email' => 'info@samsung.com',
        //         'created_at' => '30/11/2023',
        //         'vouchers_count' => 12,
        //         'status' => 'pendiente',
        //     ],
        //     [
        //         'id' => 8,
        //         'name' => 'Zara',
        //         'category' => 'Moda',
        //         'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fd/Zara_Logo.svg',
        //         'email' => 'online@zara.com',
        //         'created_at' => '18/10/2023',
        //         'vouchers_count' => 8,
        //         'status' => 'inactivo',
        //     ],
        // ]);

        $entidades = Entidad::orderBy('ent_id')
            ->get([
                'ent_id', 
                'ent_nombre_fantasia', 
                'ent_nombre', 
                'ent_razon_social', 
                'ent_estado', 
                'ent_fecha_alta',
            ]);

        return view('entidades.index', compact('entidades'));
    }

    public function create()
    {
        // Datos mock (luego salen de DB)
        $tiposEntidad = TipoEntidad::where('tipo_ent_estado', 1)
            ->orderBy('tipo_ent_id')
            ->pluck('tipo_ent_nombre', 'tipo_ent_id');

        $tiposResponsabilidad = TipoResponsabilidad::where('tipo_resp_estado', 1)
            ->orderBy('tipo_resp_id')
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

        $rubros = Rubro::where('rub_estado', 1)
            ->orderBy('rub_nombre')
            ->pluck('rub_nombre', 'rub_id');

        $subrubros = Subrubro::where('sub_estado', 1)
            ->orderBy('sub_nombre')
            ->get(['rub_id', 'sub_nombre', 'sub_id']);

        $etiquetas = Etiqueta::where('eti_estado', 1)
            ->orderBy('eti_nombre')
            ->get(['eti_nombre', 'eti_id']);

        $organizaciones = Organizacion::where('org_estado', 1)
            ->orderBy('org_nombre')
            ->pluck('org_nombre', 'org_id');

        // $etiquetas = [
        //     ['id' => 1, 'nombre' => 'Shopping'],
        //     ['id' => 2, 'nombre' => 'Premium'],
        //     ['id' => 3, 'nombre' => 'Centro'],
        //     ['id' => 4, 'nombre' => 'Outlet'],
        // ];

        return view('entidades.create', compact(
            'tiposEntidad',
            'tiposResponsabilidad',
            'tiposDocumento',
            'paises',
            'provincias',
            'rubros',
            'subrubros',
            'etiquetas',
            'organizaciones'
        ));
    }

    private function validarEntidad(Request $request)
    {
        return $request->validate([
            'tipo_resp_id' => ['required'],
            'tipo_doc_id' => ['required'],
            'com_documento' => ['required', 'max:150'],
            'com_nombre_fantasia' => ['required', 'max:150'],
            'com_razon_social' => ['required', 'max:150'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'sucursales' => ['required', 'array', 'min:1'],
            'sucursales.*.pais_id' => ['required'],
            'sucursales.*.provincia_id' => ['required'],
            'sucursales.*.cd_ciudad' => ['required', 'max:100'],
            'sucursales.*.cd_direccion' => ['required', 'max:255'],
            'sucursales.*.cd_telefono1' => ['required', 'max:30'],
            'sucursales.*.cd_email1' => ['nullable', 'email', 'max:150'],

            'sucursales.*.rubros' => ['nullable', 'array'],
            'sucursales.*.rubros.*' => ['integer'],

            'sucursales.*.subrubros' => ['nullable', 'array'],
            'sucursales.*.subrubros.*' => ['integer'],
        ], [
            'tipo_resp_id.required' => 'Selecciona el tipo de responsabilidad.',
            'tipo_doc_id.required' => 'Selecciona el tipo de documento.',
            'com_documento.required' => 'Ingresa el número de documento.',
            'com_nombre_fantasia.required' => 'Ingresa el nombre de fantasía.',
            'com_razon_social.required' => 'Ingresa la razón social.',

            'sucursales.*.pais_id.required' => 'Selecciona el país.',
            'sucursales.*.provincia_id.required' => 'Selecciona la provincia.',
            'sucursales.*.cd_ciudad.required' => 'Ingresa la ciudad.',
            'sucursales.*.cd_direccion.required' => 'Ingresa la dirección.',
            'sucursales.*.cd_telefono1.required' => 'Ingresa el teléfono principal.',

            'sucursales.*.rubros.*.integer' => 'El rubro seleccionado no es válido.',
            'sucursales.*.subrubros.*.integer' => 'El subrubro seleccionado no es válido.',
        ]);
    }

    public function store(Request $request)
    {
        // dd('Entró al store', $request->all());

        try {
            $this->validarEntidad($request);

            DB::beginTransaction();

            $logoPath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            $entId = DB::table('entidades')->insertGetId([
                'tipo_resp_id' => $request->tipo_resp_id,
                'tipo_doc_id' => $request->tipo_doc_id,
                'ent_documento' => $request->com_documento,
                'ent_nombre_fantasia' => $request->com_nombre_fantasia,
                'ent_razon_social' => $request->com_razon_social,
                'ent_logo_url' => $logoPath,
                'ent_estado' => 1,
                'ent_fecha_alta' => now(),
            ]);

            foreach ($request->sucursales as $sucursal) {
                $domicilioId = DB::table('entidades_domicilios')->insertGetId([
                    'ent_id' => $entId,
                    'org_id' => $sucursal['org_id'] ?? null,
                    'pais_id' => $sucursal['pais_id'],
                    'provincia_id' => $sucursal['provincia_id'],
                    'ed_ciudad' => $sucursal['cd_ciudad'],
                    'ed_barrio' => $sucursal['cd_barrio'] ?? null,
                    'ed_direccion' => $sucursal['cd_direccion'],
                    'ed_codigo_postal' => $sucursal['cd_codigo_postal'] ?? null,
                    'ed_telefono1' => $sucursal['cd_telefono1'],
                    'ed_telefono2' => $sucursal['cd_telefono2'] ?? null,
                    'ed_email1' => $sucursal['cd_email1'] ?? null,
                    'ed_email2' => $sucursal['cd_email2'] ?? null,
                    'ed_whatsapp' => $sucursal['cd_whatsapp'] ?? null,
                    'ed_descripcion_publica' => $sucursal['cd_descripcion_publica'] ?? null,
                    'ed_descripcion_interna' => $sucursal['cd_descripcion_interna'] ?? null,
                    'ed_estado' => 1,
                    'ed_fecha_alta' => now(),
                ]);

                if (!empty($sucursal['rubros']) && is_array($sucursal['rubros'])) {
                    foreach ($sucursal['rubros'] as $rubId) {
                        DB::table('entidades_rubros')->insert([
                            'ent_id' => $entId,
                            'ed_id' => $domicilioId,
                            'rub_id' => $rubId,
                            'er_estado' => 1,
                            'er_fecha_alta' => now(),
                        ]);
                    }
                }

                if (!empty($sucursal['subrubros']) && is_array($sucursal['subrubros'])) {
                    $subrubros = Subrubro::whereIn('sub_id', $sucursal['subrubros'])
                        ->get(['sub_id', 'rub_id']);

                    foreach ($subrubros as $subrubro) {
                        DB::table('entidades_subrubros')->insert([
                            'ent_id' => $entId,
                            'ed_id' => $domicilioId,
                            'sub_id' => $subrubro->sub_id,
                            'rub_id' => $subrubro->rub_id,
                            'es_estado' => 1,
                            'es_fecha_alta' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('entidades.index')->with('success', 'Comercio creado correctamente');

        } catch (\Exception $e) {
            // DB::rollBack();
            // return back()->withErrors('Error al guardar');
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $entidad = Entidad::findOrFail($id);

        $tiposEntidad = TipoEntidad::where('tipo_ent_estado', 1)
            ->orderBy('tipo_ent_id')
            ->pluck('tipo_ent_nombre', 'tipo_ent_id');

        $tiposResponsabilidad = TipoResponsabilidad::where('tipo_resp_estado', 1)
            ->orderBy('tipo_resp_id')
            ->pluck('tipo_resp_nombre', 'tipo_resp_id');

        $tiposDocumento = TipoDocumento::where('tipo_doc_estado', 1)
            ->orderBy('tipo_doc_id', 'desc')
            ->pluck('tipo_doc_nombre', 'tipo_doc_id');

        $paises = Pais::where('pais_estado', 1)
            ->orderBy('pais_nombre')
            ->pluck('pais_nombre', 'pais_id');

        $provincias = Provincia::where('provincia_estado', 1)
            ->orderBy('provincia_nombre')
            ->get(['provincia_id', 'provincia_nombre', 'pais_id']);

        $rubros = Rubro::where('rub_estado', 1)
            ->orderBy('rub_nombre')
            ->pluck('rub_nombre', 'rub_id');

        $subrubros = Subrubro::where('sub_estado', 1)
            ->orderBy('sub_nombre')
            ->get(['rub_id', 'sub_nombre', 'sub_id']);

        $etiquetas = Etiqueta::where('eti_estado', 1)
            ->orderBy('eti_nombre')
            ->get(['eti_nombre', 'eti_id']);

        $organizaciones = Organizacion::where('org_estado', 1)
            ->orderBy('org_nombre')
            ->pluck('org_nombre', 'org_id');

        $sucursales = DB::table('entidades_domicilios')
            ->where('ent_id', $id)
            ->where('ed_estado', 1)
            ->orderBy('ed_id')
            ->get();

        $rubrosPorDomicilio = DB::table('entidades_rubros as er')
            ->join('rubros as r', 'r.rub_id', '=', 'er.rub_id')
            ->where('er.ent_id', $id)
            ->where('er.er_estado', 1)
            ->select('er.ed_id', 'r.rub_id as id', 'r.rub_nombre as name')
            ->get()
            ->groupBy('ed_id')
            ->map(fn ($items) => $items->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
            ])->values()->toArray())
            ->toArray();

        $subrubrosPorDomicilio = DB::table('entidades_subrubros as es')
            ->join('subrubros as s', 's.sub_id', '=', 'es.sub_id')
            ->where('es.ent_id', $id)
            ->where('es.es_estado', 1)
            ->select('es.ed_id', 's.sub_id as id', 's.sub_nombre as name', 'es.rub_id')
            ->get()
            ->groupBy('ed_id')
            ->map(fn ($items) => $items->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'rub_id' => $item->rub_id,
            ])->values()->toArray())
            ->toArray();

        return view('entidades.edit', compact(
            'entidad',
            'tiposEntidad',
            'tiposResponsabilidad',
            'tiposDocumento',
            'paises',
            'provincias',
            'rubros',
            'subrubros',
            'etiquetas',
            'organizaciones',
            'sucursales',
            'rubrosPorDomicilio',
            'subrubrosPorDomicilio',
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validarEntidad($request);

            DB::beginTransaction();

            $entidad = Entidad::findOrFail($id);

            $logoPath = $entidad->ent_logo_url;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            DB::table('entidades')
                ->where('ent_id', $id)
                ->update([
                    'tipo_resp_id' => $request->tipo_resp_id,
                    'tipo_doc_id' => $request->tipo_doc_id,
                    'ent_documento' => $request->com_documento,
                    'ent_nombre_fantasia' => $request->com_nombre_fantasia,
                    'ent_razon_social' => $request->com_razon_social,
                    'ent_logo_url' => $logoPath,
                ]);

            DB::table('entidades_subrubros')
                ->where('ent_id', $id)
                ->update(['ed_estado' => 0]);

            DB::table('entidades_rubros')
                ->where('ent_id', $id)
                ->update(['ed_estado' => 0]);

            DB::table('entidades_domicilios')
                ->where('ent_id', $id)
                ->update(['ed_estado' => 0]);

            foreach ($request->sucursales as $sucursal) {
                $domicilioId = DB::table('entidades_domicilios')->insertGetId([
                    'ent_id' => $id,
                    'org_id' => $sucursal['org_id'] ?? null,
                    'pais_id' => $sucursal['pais_id'],
                    'provincia_id' => $sucursal['provincia_id'],
                    'ed_ciudad' => $sucursal['cd_ciudad'],
                    'ed_barrio' => $sucursal['cd_barrio'] ?? null,
                    'ed_direccion' => $sucursal['cd_direccion'],
                    'ed_codigo_postal' => $sucursal['cd_codigo_postal'] ?? null,
                    'ed_telefono1' => $sucursal['cd_telefono1'],
                    'ed_telefono2' => $sucursal['cd_telefono2'] ?? null,
                    'ed_whatsapp' => $sucursal['cd_whatsapp'] ?? null,
                    'ed_email1' => $sucursal['cd_email1'] ?? null,
                    'ed_email2' => $sucursal['cd_email2'] ?? null,
                    'ed_descripcion_publica' => $sucursal['cd_descripcion_publica'] ?? null,
                    'ed_descripcion_interna' => $sucursal['cd_descripcion_interna'] ?? null,
                    'ed_estado' => 1,
                    'ed_fecha_alta' => now(),
                ]);

                if (!empty($sucursal['rubros']) && is_array($sucursal['rubros'])) {
                    foreach ($sucursal['rubros'] as $rubId) {
                        DB::table('entidades_rubros')->insert([
                            'ent_id' => $id,
                            'ed_id' => $domicilioId,
                            'rub_id' => $rubId,
                            'er_estado' => 1,
                        ]);
                    }
                }

                if (!empty($sucursal['subrubros']) && is_array($sucursal['subrubros'])) {
                    $rubrosSeleccionados = $sucursal['rubros'] ?? [];

                    $subrubros = Subrubro::whereIn('sub_id', $sucursal['subrubros'])
                        ->whereIn('rub_id', $rubrosSeleccionados)
                        ->get(['sub_id', 'rub_id']);

                    foreach ($subrubros as $subrubro) {
                        DB::table('entidades_subrubros')->insert([
                            'ent_id' => $id,
                            'ed_id' => $domicilioId,
                            'sub_id' => $subrubro->sub_id,
                            'rub_id' => $subrubro->rub_id,
                            'es_estado' => 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('entidades.index')
                ->with('success', 'Comercio actualizado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $entidad = Entidad::findOrFail($id);

            $entidad->update([
                'ent_estado' => 0,
                'ent_fecha_baja' => now(),
                'ent_usu_baja' => 1,
            ]);

            return redirect()
                ->route('entidades.index')
                ->with('success', 'Entidad eliminada correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}