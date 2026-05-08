<?php

namespace App\Http\Controllers;

use App\Models\BibliotecaFondo;
use App\Models\VoucherPlantilla;
use App\Services\VoucherTemplateRenderer;
use App\Support\VoucherTemplateFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VoucherPlantillaController extends Controller
{
    public function index()
    {
        $plantillas = VoucherPlantilla::orderBy('vpl_id', 'desc')->get();

        return view('voucher_plantillas.index', compact('plantillas'));
    }

    public function create()
    {
        $imagenesBiblioteca = BibliotecaFondo::where('pf_estado',1)->get();

        return view('voucher_plantillas.create', compact('imagenesBiblioteca'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vpl_nombre' => 'required|string|max:150',
            'vpl_descripcion' => 'nullable|string|max:255',
            'vpl_ancho' => 'required|integer|min:100',
            'vpl_alto' => 'required|integer|min:100',
            // 'vpl_fondo' => 'nullable|image|max:5120',
            'biblioteca_imagen_id' => 'required|exists:plantillas_fondos_files,pf_id',
        ]);

        $fondoPath = 'storage/'.$request->img_path;

        // if ($request->hasFile('vpl_fondo')) {
        //     $folder = public_path('storage/vouchers/plantillas/fondos');

        //     if (!File::exists($folder)) {
        //         File::makeDirectory($folder, 0775, true);
        //     }

        //     $filename = uniqid('plantilla_') . '.' . $request->file('vpl_fondo')->getClientOriginalExtension();
        //     $request->file('vpl_fondo')->move($folder, $filename);

        //     $fondoPath = 'storage/vouchers/plantillas/fondos/' . $filename;
        // }

        $config = [
            'canvas' => [
                'width' => (int)$request->vpl_ancho,
                'height' => (int)$request->vpl_alto,
                'background' => $fondoPath,
            ],
            'fields' => [],
        ];

        $plantilla = VoucherPlantilla::create([
            'pf_id' => $request->biblioteca_imagen_id,
            'vpl_nombre' => $request->vpl_nombre,
            'vpl_descripcion' => $request->vpl_descripcion,
            'vpl_ancho' => $request->vpl_ancho,
            'vpl_alto' => $request->vpl_alto,
            'vpl_fondo_path' => $fondoPath,
            'vpl_config_json' => $config,
            'vpl_preview_path' => null,
            'vpl_estado' => 1,
            'vpl_fecha_alta' => now(),
            // 'vpl_usu_alta' => auth()->id(),
            'vpl_usu_alta' => 1,
        ]);

        return redirect()
            ->route('voucher_plantillas.builder', $plantilla->vpl_id)
            ->with('success', 'Plantilla creada correctamente.');
    }

    public function edit($id)
    {
        $plantilla = VoucherPlantilla::findOrFail($id);

        return view('voucher_plantillas.edit', compact('plantilla'));
    }

    public function update(Request $request, $id)
    {
        $plantilla = VoucherPlantilla::findOrFail($id);

        $request->validate([
            'vpl_nombre' => 'required|string|max:150',
            'vpl_descripcion' => 'nullable|string|max:255',
            'vpl_ancho' => 'required|integer|min:100',
            'vpl_alto' => 'required|integer|min:100',
            'vpl_fondo' => 'nullable|image|max:5120',
        ]);

        $config = $plantilla->vpl_config_json ?? [
            'canvas' => [],
            'fields' => [],
        ];

        $fondoPath = $plantilla->vpl_fondo_path;

        if ($request->hasFile('vpl_fondo')) {
            $folder = public_path('storage/vouchers/plantillas/fondos');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0775, true);
            }

            $filename = uniqid('plantilla_') . '.' . $request->file('vpl_fondo')->getClientOriginalExtension();
            $request->file('vpl_fondo')->move($folder, $filename);

            $fondoPath = 'storage/vouchers/plantillas/fondos/' . $filename;
        }

        $config['canvas']['width'] = (int)$request->vpl_ancho;
        $config['canvas']['height'] = (int)$request->vpl_alto;
        $config['canvas']['background'] = $fondoPath;

        $plantilla->update([
            'vpl_nombre' => $request->vpl_nombre,
            'vpl_descripcion' => $request->vpl_descripcion,
            'vpl_ancho' => $request->vpl_ancho,
            'vpl_alto' => $request->vpl_alto,
            'vpl_fondo_path' => $fondoPath,
            'vpl_config_json' => $config,
            'vpl_fecha_mod' => now(),
            // 'vpl_usu_mod' => auth()->id(),
            'vpl_usu_mod' => 1,
        ]);

        return redirect()
            ->route('voucher_plantillas.edit', $plantilla->vpl_id)
            ->with('success', 'Plantilla actualizada correctamente.');
    }

    public function delete($id)
    {
        try {
            $plantilla = VoucherPlantilla::findOrFail($id);

            $plantilla->update([
                'vlp_estado' => 0,
                'vlp_fecha_baja' => now(),
                'vlp_usu_baja' => 1,
            ]);

            return redirect()
                ->route('voucher_plantillas.index')
                ->with('success', 'Plantilla eliminado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function builder($id)
    {
        $plantilla = VoucherPlantilla::findOrFail($id);

        $config = $plantilla->vpl_config_json ?? [
            'canvas' => [],
            'fields' => [],
        ];

        if (!empty($config['canvas']['background'])) {
            $config['canvas']['background'] = asset($config['canvas']['background']);
        }

        $plantilla->vpl_config_json = $config;

        $textFields = VoucherTemplateFields::textFields();
        $imageFields = VoucherTemplateFields::imageFields();

        return view('voucher_plantillas.builder', compact('plantilla', 'textFields', 'imageFields'));
    }

    public function saveBuilder(Request $request, $id)
    {
        $plantilla = VoucherPlantilla::findOrFail($id);

        $request->validate([
            'config_json' => 'required|json',
        ]);

        $config = json_decode($request->config_json, true);

        $plantilla->update([
            'vpl_config_json' => $config,
            'vpl_ancho' => $config['canvas']['width'] ?? $plantilla->vpl_ancho,
            'vpl_alto' => $config['canvas']['height'] ?? $plantilla->vpl_alto,
            'vpl_fondo_path' => $config['canvas']['background'] ?? $plantilla->vpl_fondo_path,
            'vpl_fecha_mod' => now(),
            // 'vpl_usu_mod' => auth()->id(),
            'vpl_usu_mod' => 1,
        ]);

        return redirect()
            ->route('voucher_plantillas.builder', $plantilla->vpl_id)
            ->with('success', 'Diseño guardado correctamente.');
    }

    public function preview($id, VoucherTemplateRenderer $renderer)
    {
        $plantilla = VoucherPlantilla::findOrFail($id);

        $demoData = [
            'voucher_nombre'       => 'Cena para dos personas',
            'voucher_descripcion'  => 'Disfrutá una experiencia gastronómica única con menú completo.',
            'voucher_condiciones'  => 'Válido de lunes a jueves. No acumulable con otras promociones.',
            'voucher_codigo'       => 'VC-2026-001',
            'voucher_fecha_inicio' => '01/05/2026',
            'voucher_fecha_fin'    => '31/12/2026',
            'vigencia_texto'       => 'Válido hasta el 31/12/2026',
            'entidad_nombre'       => 'Restó Demo',
            'entidad_logo'         => asset('images/logo-demo.png'),
            'modalidad_nombre'     => 'Cena',
            'beneficio_texto'      => 'Incluye entrada, plato principal y bebida',
        ];

        $html = $renderer->render($plantilla->vpl_config_json ?? [], $demoData);

        return view('voucher_plantillas.preview', compact('plantilla', 'html'));
    }
}
