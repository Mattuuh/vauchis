<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Pais;
use App\Models\Provincia;
use App\Models\Rubro;
use App\Models\Subrubro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TipoDocumento;
use App\Models\TipoResponsabilidad;

class ComercioController extends Controller
{
    public function create()
    {
        // Datos mock (luego salen de DB)
        $tiposEntidad = [
            1 => 'Comercio',
            2 => 'Cine',
            3 => 'Restaurant',
            4 => 'Emprendedor',
            5 => 'Fundacion',
        ];

        $tiposResponsabilidad = TipoResponsabilidad::where('tipo_resp_estado', 1)
            ->orderBy('tipo_resp_id')
            ->pluck('tipo_resp_nombre', 'tipo_resp_id');

        $tiposDocumento = TipoDocumento::where('tipo_doc_estado', 1)
            ->orderBy('tipo_doc_id')
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
            ->pluck('eti_nombre', 'eti_id');

        // $etiquetas = [
        //     ['id' => 1, 'nombre' => 'Shopping'],
        //     ['id' => 2, 'nombre' => 'Premium'],
        //     ['id' => 3, 'nombre' => 'Centro'],
        //     ['id' => 4, 'nombre' => 'Outlet'],
        // ];

        return view('comercios.create', compact(
            'tiposEntidad',
            'tiposResponsabilidad',
            'tiposDocumento',
            'paises',
            'provincias',
            'rubros',
            'subrubros',
            'etiquetas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
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
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'integer|exists:etiquetas,id',
        ]);

        DB::beginTransaction();

        try {
            $logoPath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            $comId = DB::table('entidades')->insertGetId([
                'tipo_resp_id' => $request->tipo_resp_id,
                'tipo_doc_id' => $request->tipo_doc_id,
                'com_documento' => $request->com_documento,
                'com_nombre_fantasia' => $request->com_nombre_fantasia,
                'com_razon_social' => $request->com_razon_social,
                'com_logo_url' => $logoPath,
                'com_fecha_alta' => now(),
            ]);

            foreach ($request->sucursales as $sucursal) {
                DB::table('entidades_domicilios')->insert([
                    'com_id' => $comId,
                    'pais_id' => $sucursal['pais_id'],
                    'provincia_id' => $sucursal['provincia_id'],
                    'cd_ciudad' => $sucursal['cd_ciudad'],
                    'cd_direccion' => $sucursal['cd_direccion'],
                    'cd_telefono1' => $sucursal['cd_telefono1'],
                    'cd_email1' => $sucursal['cd_email1'] ?? null,
                    'cd_fecha_alta' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('comercios.create')->with('success', 'Comercio creado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al guardar');
        }
    }
}