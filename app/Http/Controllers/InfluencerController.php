<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use App\Models\Pais;
use App\Models\Provincia;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    public function index()
    {
        // $influencers = collect([
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

        $influencers = Influencer::where('inf_estado', 1)
            ->orderBy('inf_id')
            ->get([
                'inf_id', 
                'inf_nombre_fantasia', 
                'inf_nombre', 
                'inf_apellido', 
                'inf_estado', 
                'inf_fecha_alta',
            ]);

        return view('influencers.index', compact('influencers'));
    }

    public function create()
    {
        $tiposDocumento = TipoDocumento::where('tipo_doc_estado', 1)
            ->orderBy('tipo_doc_id')
            ->pluck('tipo_doc_nombre', 'tipo_doc_id');

        $paises = Pais::where('pais_estado', 1)
            ->orderBy('pais_nombre')
            ->pluck('pais_nombre', 'pais_id');

        $provincias = Provincia::where('provincia_estado', 1)
            ->orderBy('provincia_nombre')
            ->get(['provincia_id', 'provincia_nombre', 'pais_id']);

        return view('influencers.create', compact(
            'tiposDocumento',
            'paises',
            'provincias',
        ));
    }

    public function store(Request $request)
    {
        // dd('Entró al store', $request->all());
        // var_dump($request->all());

        try {
            $request->validate([
                // 'tipo_resp_id' => ['required'],
                'tipo_doc_id' => ['required'],
                'f_documento' => ['required', 'max:150'],
                'f_nombre_fantasia' => ['required', 'max:150'],
                'f_apellido' => ['required', 'max:150'],
                'f_nombre' => ['required', 'max:150'],
                // 'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                'f_pais_id' => ['required'],
                'f_provincia_id' => ['required'],
                'f_ciudad' => ['required', 'max:100'],
                'f_instagram' => ['nullable', 'max:150'],
                'f_facebook' => ['nullable', 'max:150'],
                'f_tiktok' => ['nullable', 'max:150'],
                'f_x' => ['nullable', 'max:150'],
                'f_whatsapp' => ['nullable', 'max:150'],
                'f_email1' => ['required', 'email', 'max:150'],
                'f_email2' => ['nullable', 'email', 'max:150'],
                // 'f_telefono1' => ['required', 'max:30'],
                // 'f_telefono2' => ['nullable', 'max:30'],
                'f_descripcion_publica' => ['required', 'max:255'],
                'f_descripcion_interna' => ['required', 'max:255'],
            ], [
                // 'tipo_resp_id.required' => 'Selecciona el tipo de responsabilidad.',
                'tipo_doc_id.required' => 'Selecciona el tipo de documento.',
                'f_documento.required' => 'Ingresa el número de documento.',
                'f_nombre_fantasia.required' => 'Ingresa el nombre de fantasía.',
                'f_apellido.required' => 'Ingresa el apellido.',
                'f_nombre.required' => 'Ingresa el nombre.',
                'f_instagram.required' => 'Ingresa la instagram.',
                'f_facebook.required' => 'Ingresa el facebook.',
                'f_tiktok.required' => 'Ingresa el tiktok.',
                'f_x.required' => 'Ingresa el X.',
                'f_whatsapp.required' => 'Ingresa el whatsapp.',
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

            Influencer::create([
                'tipo_doc_id' => $request->tipo_doc_id,
                'inf_documento' => $request->f_documento,
                'inf_nombre_fantasia' => $request->f_nombre_fantasia,
                'inf_apellido' => $request->f_apellido,
                'inf_nombre' => $request->f_nombre,
                'pais_id' => $request->f_pais_id,
                'provincia_id' => $request->f_provincia_id,
                'inf_ciudad' => $request->f_ciudad,
                'inf_instagram' => $request->f_instagram,
                'inf_facebook' => $request->f_facebook,
                'inf_tiktok' => $request->f_tiktok,
                'inf_x' => $request->f_x,
                'inf_whatsapp' => $request->f_whatsapp,
                'inf_email1' => $request->f_email1,
                'inf_email2' => $request->f_email2,
                // 'inf_telefono1' => $request->f_telefono1,
                // 'inf_telefono2' => $request->f_telefono2,
                'inf_descripcion_publica' => $request->f_descripcion_publica,
                'inf_descripcion_interna' => $request->f_descripcion_interna,
                'inf_estado' => '1',
                'inf_estado2' => null,
                'inf_fecha_alta' => now(),
                'inf_usu_alta' => '1',
            ]);

            return redirect()
                ->route('influencers.index')
                ->with('success', 'Influencer creado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $influencer = Influencer::findOrFail($id);

        $tiposDocumento = TipoDocumento::where('tipo_doc_estado', 1)
            ->orderBy('tipo_doc_id')
            ->pluck('tipo_doc_nombre', 'tipo_doc_id');

        $paises = Pais::where('pais_estado', 1)
            ->orderBy('pais_nombre')
            ->pluck('pais_nombre', 'pais_id');

        $provincias = Provincia::where('provincia_estado', 1)
            ->orderBy('provincia_nombre')
            ->get(['provincia_id', 'provincia_nombre', 'pais_id']);

        return view('influencers.edit', compact(
            'influencer',
            'tiposDocumento',
            'paises',
            'provincias'
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tipo_doc_id' => ['required'],
                'f_documento' => ['required', 'max:150'],
                'f_nombre_fantasia' => ['required', 'max:150'],
                'f_apellido' => ['required', 'max:150'],
                'f_nombre' => ['required', 'max:150'],
                'f_pais_id' => ['required'],
                'f_provincia_id' => ['required'],
                'f_ciudad' => ['required', 'max:100'],
                'f_instagram' => ['nullable', 'max:150'],
                'f_facebook' => ['nullable', 'max:150'],
                'f_tiktok' => ['nullable', 'max:150'],
                'f_x' => ['nullable', 'max:150'],
                'f_whatsapp' => ['nullable', 'max:150'],
                'f_email1' => ['required', 'email', 'max:150'],
                'f_email2' => ['nullable', 'email', 'max:150'],
                'f_descripcion_publica' => ['required', 'max:255'],
                'f_descripcion_interna' => ['required', 'max:255'],
            ], [
                'tipo_doc_id.required' => 'Selecciona el tipo de documento.',
                'f_documento.required' => 'Ingresa el número de documento.',
                'f_nombre_fantasia.required' => 'Ingresa el nombre de fantasía.',
                'f_apellido.required' => 'Ingresa el apellido.',
                'f_nombre.required' => 'Ingresa el nombre.',
                'f_pais_id.required' => 'Selecciona el país.',
                'f_provincia_id.required' => 'Selecciona la provincia.',
                'f_ciudad.required' => 'Ingresa la ciudad.',
                'f_email1.required' => 'Ingresa el email principal.',
                'f_descripcion_publica.required' => 'Ingresa una descripcion breve y precisa.',
                'f_descripcion_interna.required' => 'Ingresa una descripcion mas amplia y detallada.',
            ]);

            $influencer = Influencer::findOrFail($id);

            $influencer->update([
                'tipo_doc_id' => $request->tipo_doc_id,
                'inf_documento' => $request->f_documento,
                'inf_nombre_fantasia' => $request->f_nombre_fantasia,
                'inf_apellido' => $request->f_apellido,
                'inf_nombre' => $request->f_nombre,
                'pais_id' => $request->f_pais_id,
                'provincia_id' => $request->f_provincia_id,
                'inf_ciudad' => $request->f_ciudad,
                'inf_instagram' => $request->f_instagram,
                'inf_facebook' => $request->f_facebook,
                'inf_tiktok' => $request->f_tiktok,
                'inf_x' => $request->f_x,
                'inf_whatsapp' => $request->f_whatsapp,
                'inf_email1' => $request->f_email1,
                'inf_email2' => $request->f_email2,
                'inf_descripcion_publica' => $request->f_descripcion_publica,
                'inf_descripcion_interna' => $request->f_descripcion_interna,
            ]);

            return redirect()
                ->route('influencers.index')
                ->with('success', 'Influencer actualizado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $influencer = Influencer::findOrFail($id);

            $influencer->update([
                'inf_estado' => 0,
                'inf_fecha_baja' => now(),
                'inf_usu_baja' => 1,
            ]);

            return redirect()
                ->route('influencers.index')
                ->with('success', 'Influencer eliminado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
