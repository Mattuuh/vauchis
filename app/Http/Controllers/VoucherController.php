<?php

// use App\Http\Controllers\Controller;

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Entidad;
use App\Models\EntidadDomicilio;
use App\Models\Etiqueta;
use App\Models\Influencer;
use App\Models\Modalidad;
use App\Models\ModalidadCampo;
use App\Models\Rubro;
use App\Models\TipoArchivo;
use App\Models\Voucher;
use App\Models\VoucherDetalle;
use App\Models\VoucherFile;
use App\Models\VoucherPlantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{

    private function validarVoucher(Request $request)
    {
        $rules = [
            'f_nombre' => 'required|string|max:255',

            'f_ent_id' => 'required|integer',
            'f_inf_id' => 'nullable|integer',
            'f_mod_id' => 'required|integer|exists:modalidades,mod_id',
            'f_cv_id' => 'required|integer',

            // 'f_monto_total' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'f_comision' => 'required|numeric|min:1',

            'f_fecha_ini_lab' => 'required|date_format:d/m/Y',
            'f_fecha_fin_lab' => 'required|date_format:d/m/Y|after_or_equal:f_fecha_ini_lab',

            // 'f_permite_personalizacion' => 'required|in:0,1',

            'description' => 'required|string|max:5000',
            'terms' => 'nullable|string|max:5000',
            'observaciones' => 'nullable|string|max:2000',

            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'integer|exists:etiquetas,eti_id',

            'etiquetas_nuevas' => 'nullable|array',
            'etiquetas_nuevas.*' => 'string|max:100',

            'banners' => 'nullable|array|min:1',
            'banners.0' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'banners.*' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',

            'modalidad_valores' => 'nullable|array',
        ];

        $messages = [
            'f_nombre.required' => 'Debes ingresar el nombre del voucher.',
            'banners.required' => 'Debes subir al menos un banner.',
            'banners.array' => 'El formato de banners no es válido.',
            'banners.min' => 'Debes subir al menos un banner.',
            'banners.0.required' => 'El primer banner es obligatorio.',
            'banners.*.mimes' => 'Los banners deben ser archivos jpg, jpeg, png o webp.',
            'banners.*.max' => 'Cada banner puede pesar hasta 5MB.',
        ];

        if ($request->filled('f_mod_id')) {
            $camposModalidad = ModalidadCampo::where('mod_id', $request->f_mod_id)
                ->where('mca_estado', 1)
                ->orderBy('mca_orden')
                ->get();

            foreach ($camposModalidad as $campo) {
                $field = 'modalidad_valores.' . $campo->mca_codigo;
                $fieldRules = [];

                if ((int) $campo->mca_requerido === 1) {
                    $fieldRules[] = 'required';
                } else {
                    $fieldRules[] = 'nullable';
                }

                switch ($campo->mca_tipo) {
                    case 'number':
                        $fieldRules[] = 'integer';
                        break;

                    case 'decimal':
                    case 'money':
                        $fieldRules[] = 'numeric';
                        break;

                    case 'boolean':
                        $fieldRules[] = 'in:0,1';
                        break;

                    default:
                        $fieldRules[] = 'string';
                        $fieldRules[] = 'max:5000';
                        break;
                }

                $rules[$field] = implode('|', $fieldRules);
                $messages[$field . '.required'] = 'Debes completar el campo "' . $campo->mca_label . '".';
            }
        }

        return $request->validate($rules, $messages);
    }

    public function index()
    {
        $vouchers = Voucher::with('categoria')
            ->with('modalidad')
            ->orderBy('vou_id','desc')
            ->get([
                'vou_id', 
                'ent_id', 
                'cv_id', 
                'inf_id', 
                'mod_id', 
                'vou_nombre', 
                'vou_stock', 
                'vou_estado', 
                'vou_fecha_alta',
            ]);

        return view('vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $entidades = Entidad::where('ent_estado', 1)
            ->orderBy('ent_id', 'desc')
            ->get(['ent_nombre_fantasia', 'ent_id']);

        $sucursales = EntidadDomicilio::where('ed_estado',1)
            ->orderBy('ent_id', 'desc')
            ->get(['ed_canje', 'ed_direccion', 'ent_id', 'ed_id']);

        $influencers = Influencer::where('inf_estado', 1)
            ->orderBy('inf_id', 'desc')
            ->pluck('inf_nombre_fantasia', 'inf_id');

        $modalidades = Modalidad::with(['campos' => function ($query) {
                $query->where('mca_estado', 1)
                    ->orderBy('mca_orden')
                    ->orderBy('mca_id');
            }])
            ->where('mod_estado', 1)
            ->orderBy('mod_id', 'desc')
            ->get(['mod_id', 'mod_nombre', 'mod_codigo']);

        $categorias = Categoria::where('cv_estado', 1)
            ->orderBy('cv_id', 'desc')
            ->pluck('cv_nombre', 'cv_id');

        $etiquetasDisponibles = Etiqueta::where('eti_estado', 1)
            ->orderBy('eti_nombre')
            ->get(['eti_nombre', 'eti_id']);

        $modalidadesCamposJson = $modalidades
            ->mapWithKeys(function ($modalidad) {
                return [
                    $modalidad->mod_id => $modalidad->campos->map(function ($campo) {
                        return [
                            'mca_id' => $campo->mca_id,
                            'mca_codigo' => $campo->mca_codigo,
                            'mca_nombre' => $campo->mca_nombre,
                            'mca_tipo' => $campo->mca_tipo,
                            'mca_label' => $campo->mca_label,
                            'mca_placeholder' => $campo->mca_placeholder,
                            'mca_requerido' => $campo->mca_requerido,
                            'mca_orden' => $campo->mca_orden,
                            'mca_opciones' => $campo->mca_opciones,
                            'mca_ayuda' => $campo->mca_ayuda,
                        ];
                    })->values(),
                ];
            })
            ->toJson();

        $plantillas = VoucherPlantilla::where('vpl_estado', 1)
            ->orderBy('vpl_id', 'desc')
            ->get(['vpl_fondo_path','vpl_nombre', 'vpl_id']);

        $tipos_archivos = TipoArchivo::where('tipo_archivo_estado', 1)
            ->orderBy('tipo_archivo_id', 'desc')
            ->get(['tipo_archivo_nombre', 'tipo_archivo_id']);

        return view('vouchers.create', compact(
            'entidades',
            'sucursales',
            'influencers',
            'modalidades',
            'categorias',
            'etiquetasDisponibles',
            'modalidadesCamposJson',
            'plantillas',
            'tipos_archivos'
        ));
    }

    public function store(Request $request)
    {
        $this->validarVoucher($request);

        DB::beginTransaction();

        try {
            $usuarioId = Auth::id() ?? 1;

            // $entidad = DB::table('entidades_domicilios')
            //     ->where('ed_id', $request->f_ent_id)
            //     ->first(['ent_id']);

            $vouId = DB::table('vouchers')->insertGetId([
                'ent_id' => $request->f_ent_id,
                'ed_id' => $request->f_ed_id,
                'tv_id' => null,
                'cv_id' => $request->f_cv_id,
                'inf_id' => $request->f_inf_id,
                'mod_id' => $request->f_mod_id,

                'vou_nombre' => $request->f_nombre,
                'vou_descripcion' => $request->description,

                'vou_monto_fijo' => $request->f_monto_total,
                'vou_monto_minimo' => null,
                'vou_monto_maximo' => null,
                'vou_precio_promocional' => null,
                'vou_moneda_codigo' => 'ARS',

                'vou_permite_personalizacion' => $request->f_permite_personalizacion,
                'vou_mensaje_predeterminado' => $request->observaciones,

                'vou_fecha_inicio' => $request->f_fecha_ini,
                'vou_fecha_fin' => $request->f_fecha_fin,
                'vou_stock' => $request->stock,
                'vou_destacado' => 0,
                'vou_porcentaje_comision' => $request->f_comision,

                'vou_terminos_condiciones' => $request->terms,

                'vou_estado' => 1,
                'vou_estado2' => null,
                'vou_estado3' => null,

                'vou_fecha_alta' => now(),
                'vou_usu_alta' => $usuarioId,
            ]);

            $detalles = [];

            for ($i = 1; $i <= (int) $request->stock; $i++) {
                $codigoInterno = 'VOU-' . $vouId . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);
                $codigoPublico = strtoupper(Str::random(10));

                $detalles[] = [
                    'vou_id' => $vouId,
                    'ent_id' => $request->f_ent_id,
                    'cli_id' => null,
                    'vd_codigo_interno' => $codigoInterno,
                    'vd_codigo' => $codigoPublico,
                    'vd_secuencia' => $i,
                    'vd_variante_nombre' => null,
                    'vd_variante_descripcion' => null,
                    'vd_monto_total' => $request->f_monto_total,
                    'vd_estado' => 1,
                    'vd_estado2' => 'PE',
                    'vd_estado3' => 'PE',
                    'vd_fecha_alta' => now(),
                    'vd_usu_alta' => $usuarioId,
                ];
            }

            DB::table('vouchers_detalles')->insert($detalles);

            $camposModalidad = ModalidadCampo::where('mod_id', $request->f_mod_id)
                ->where('mca_estado', 1)
                ->orderBy('mca_orden')
                ->get();

            foreach ($camposModalidad as $campo) {
                $valor = $request->input('modalidad_valores.' . $campo->mca_codigo);

                if ($campo->mca_tipo === 'boolean') {
                    $valor = $request->has('modalidad_valores.' . $campo->mca_codigo) ? 1 : 0;
                }

                DB::table('vouchers_modalidad_valores')->insert([
                    'vou_id' => $vouId,
                    'mca_id' => $campo->mca_id,
                    'vmv_valor' => is_array($valor) ? json_encode($valor) : $valor,
                    'vmv_estado' => 1,
                    'vmv_fecha_alta' => now(),
                    'vmv_usu_alta' => $usuarioId,
                ]);
            }

            $etiquetasIds = collect($request->etiquetas ?? [])
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            if ($request->filled('etiquetas_nuevas')) {
                foreach ($request->etiquetas_nuevas as $nombreNueva) {
                    $nombreNueva = trim($nombreNueva);

                    if ($nombreNueva === '') {
                        continue;
                    }

                    $existente = DB::table('etiquetas')
                        ->whereRaw('LOWER(eti_nombre) = ?', [mb_strtolower($nombreNueva)])
                        ->first();

                    if ($existente) {
                        $etiquetasIds->push((int) $existente->eti_id);
                        continue;
                    }

                    $etiId = DB::table('etiquetas')->insertGetId([
                        'eti_nombre' => $nombreNueva,
                        'eti_descripcion' => null,
                        'eti_fecha_ini' => now(),
                        'eti_fecha_fin' => null,
                        'eti_publico' => 1,
                        'eti_estado' => 1,
                        'eti_estado2' => 1,
                        'eti_fecha_alta' => now(),
                        'eti_usu_alta' => $usuarioId,
                    ]);

                    $etiquetasIds->push((int) $etiId);
                }
            }

            $etiquetasIds = $etiquetasIds->unique()->values();

            if ($etiquetasIds->isNotEmpty()) {
                $rowsEtiquetas = [];

                foreach ($etiquetasIds as $etiId) {
                    $rowsEtiquetas[] = [
                        'vou_id' => $vouId,
                        'eti_id' => $etiId,
                        'ev_estado' => 1,
                        'ev_fecha_alta' => now(),
                        'ev_usu_alta' => $usuarioId,
                    ];
                }

                DB::table('etiquetas_vouchers')->insert($rowsEtiquetas);
            }

            $plantillas = $request->input('plantillas', []);

            $plantillas = collect($plantillas)
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            if ($plantillas->isNotEmpty()) {
                $rowsPlantillas = [];

                foreach ($plantillas as $vplId) {
                    $rowsPlantillas[] = [
                        'vou_id' => $vouId,
                        'vpl_id' => $vplId,
                        'vp_principal' => 0,
                        'vp_estado' => 1,
                        'vp_fecha_alta' => now(),
                        'vp_usu_alta' => $usuarioId,
                    ];
                }

                DB::table('vouchers_plantillas')->insert($rowsPlantillas);
            }

            if ($request->hasFile('imagenes')) {

                foreach ($request->file('imagenes') as $index => $imagen) {
                    // $filename = Str::uuid() . '.' . $imagen->extension();
                    // $path = $imagen->storeAs('logos', $filename, 'public');

                    $name = sanear_string($imagen->getClientOriginalName());
                    $name_legible = $imagen->getClientOriginalName();
                    $type = $imagen->getMimeType();
                    $size = $imagen->getSize();
                    $format = $imagen->getClientOriginalExtension();
                    $path = $imagen->store('vouchers', 'public');

                    DB::table('vouchers_files')->insert([
                        'vou_id' => $vouId,
                        'tipo_archivo_id' => 1,
                        'vf_img_nombre_legible' => $name_legible,
                        'vf_img_name' => $name,
                        'vf_img_path' => $path,
                        'vf_img_format' => $format,
                        'vf_img_size' => $size,
                        'vf_estado' => 1,
                        'vf_estado2' => null,
                        'vf_fecha_alta' => now(),
                        'vf_usu_alta' => $usuarioId,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('vouchers.index')
                ->with('success', 'Voucher creado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // dd($e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar el voucher: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $voucher = DB::table('vouchers')
            ->where('vou_id', $id)
            ->first();

        if (!$voucher) {
            return redirect()
                ->route('vouchers.index')
                ->with('error', 'El voucher no existe.');
        }

        $banners = DB::table('vouchers_files')
            ->where('vou_id', $id)
            ->where('vf_estado', 1)
            ->orderBy('vf_id')
            ->get();

        $entidades = Entidad::where('ent_estado', 1)
            ->orderBy('ent_id', 'desc')
            ->get(['ent_nombre_fantasia', 'ent_id']);

        $sucursales = EntidadDomicilio::where('ed_estado',1)
            ->orderBy('ent_id', 'desc')
            ->get(['ed_canje', 'ed_direccion', 'ent_id', 'ed_id']);

        $influencers = DB::table('influencers')
            ->where('inf_estado', 1)
            ->orderBy('inf_nombre_fantasia')
            ->pluck('inf_nombre_fantasia', 'inf_id');

        $modalidades = Modalidad::with(['campos' => function ($query) {
                $query->where('mca_estado', 1)
                    ->orderBy('mca_orden')
                    ->orderBy('mca_id');
            }])
            ->where('mod_estado', 1)
            ->orderBy('mod_nombre')
            ->get(['mod_id', 'mod_nombre', 'mod_codigo']);

        $categorias = DB::table('categorias_vouchers')
            ->where('cv_estado', 1)
            ->orderBy('cv_nombre')
            ->pluck('cv_nombre', 'cv_id');

        $etiquetasDisponibles = DB::table('etiquetas')
            ->where('eti_estado', 1)
            ->orderBy('eti_nombre')
            ->get([
                'eti_id',
                'eti_nombre',
                'eti_descripcion',
            ]);

        $etiquetasSeleccionadas = DB::table('etiquetas_vouchers as ev')
            ->join('etiquetas as e', 'e.eti_id', '=', 'ev.eti_id')
            ->where('ev.vou_id', $id)
            ->where('ev.ev_estado', 1)
            ->orderBy('e.eti_nombre')
            ->get([
                'e.eti_id as id',
                'e.eti_nombre as name',
            ])
            ->map(fn ($item) => [
                'id' => (int) $item->id,
                'name' => $item->name,
            ])
            ->values()
            ->toArray();

        $voucherDetalles = DB::table('vouchers_detalles')
            ->where('vou_id', $id)
            ->orderBy('vd_id')
            ->get([
                'vd_id',
                'vd_codigo_interno',
                'vd_codigo',
                'cli_id',
                'vd_variante_nombre',
                'vd_variante_descripcion',
                'vd_monto_total',
                'vd_estado',
                'vd_estado2',
                'vd_estado3',
                'vd_fecha_alta',
            ]);

        $voucherModalidadValores = DB::table('vouchers_modalidad_valores as vmv')
            ->join('modalidades_campos as mc', 'mc.mca_id', '=', 'vmv.mca_id')
            ->where('vmv.vou_id', $id)
            ->where('vmv.vmv_estado', 1)
            ->pluck('vmv.vmv_valor', 'mc.mca_codigo')
            ->toArray();

        $modalidadesCamposJson = $modalidades
            ->mapWithKeys(function ($modalidad) {
                return [
                    $modalidad->mod_id => $modalidad->campos->map(function ($campo) {
                        return [
                            'mca_id' => $campo->mca_id,
                            'mca_codigo' => $campo->mca_codigo,
                            'mca_nombre' => $campo->mca_nombre,
                            'mca_tipo' => $campo->mca_tipo,
                            'mca_label' => $campo->mca_label,
                            'mca_placeholder' => $campo->mca_placeholder,
                            'mca_requerido' => $campo->mca_requerido,
                            'mca_orden' => $campo->mca_orden,
                            'mca_opciones' => $campo->mca_opciones,
                            'mca_ayuda' => $campo->mca_ayuda,
                        ];
                    })->values(),
                ];
            })
            ->toJson();

        $plantillas = DB::table('voucher_plantillas')
            ->where('vpl_estado', 1)
            ->orderBy('vpl_nombre')
            ->get();

        $plantillasSeleccionadas = DB::table('vouchers_plantillas')
            ->where('vou_id', $id)
            ->where('vp_estado', 1)
            ->pluck('vpl_id')
            ->toArray();

        // $plantillaPrincipal = DB::table('vouchers_plantillas')
        //     ->where('vou_id', $id)
        //     ->where('vp_estado', 1)
        //     ->where('vp_principal', 1)
        //     ->value('vpl_id');

        $tipos_archivos = TipoArchivo::where('tipo_archivo_estado', 1)
            ->orderBy('tipo_archivo_id', 'desc')
            ->get(['tipo_archivo_nombre', 'tipo_archivo_id']);

        $imagenes = VoucherFile::where('vf_estado', 1)
            ->where('vou_id', $id)
            ->orderBy('vf_id', 'desc')
            ->get();

        return view('vouchers.edit', compact(
            'voucher',
            'banners',
            'entidades',
            'sucursales',
            'influencers',
            'modalidades',
            'categorias',
            'etiquetasDisponibles',
            'etiquetasSeleccionadas',
            'voucherDetalles',
            'voucherModalidadValores',
            'modalidadesCamposJson',
            'plantillas',
            'plantillasSeleccionadas',
            // 'plantillaPrincipal',
            'tipos_archivos',
            'imagenes'
        ));
    }

    public function update(Request $request, $id)
    {
        $voucher = DB::table('vouchers')
            ->where('vou_id', $id)
            ->first();

        if (!$voucher) {
            return redirect()
                ->route('vouchers.index')
                ->with('error', 'El voucher no existe.');
        }

        $this->validarVoucher($request);

        DB::beginTransaction();

        try {
            $fechaInicio = $request->f_fecha_ini;
            $fechaFin = $request->f_fecha_fin;
            $usuarioId = Auth::id() ?? 1;

            /*
            |--------------------------------------------------------------------------
            | Actualizar voucher
            |--------------------------------------------------------------------------
            */
            DB::table('vouchers')
                ->where('vou_id', $id)
                ->update([
                    'ent_id' => $request->f_ent_id,
                    'tv_id' => null,
                    'cv_id' => $request->f_cv_id,
                    'inf_id' => $request->f_inf_id,
                    'mod_id' => $request->f_mod_id,

                    'vou_nombre' => $request->f_nombre,
                    'vou_descripcion' => $request->description,

                    'vou_monto_fijo' => $request->f_monto_total,
                    'vou_mensaje_predeterminado' => $request->observaciones,

                    'vou_fecha_inicio' => $fechaInicio,
                    'vou_fecha_fin' => $fechaFin,
                    'vou_stock' => $request->stock,
                    'vou_porcentaje_comision' => $request->f_comision,

                    'vou_permite_personalizacion' => $request->f_permite_personalizacion,
                    'vou_terminos_condiciones' => $request->terms,
                ]);

            /*
            |--------------------------------------------------------------------------
            | Sincronizar stock con vouchers_detalles
            |--------------------------------------------------------------------------
            */
            $stockAnterior = (int) $voucher->vou_stock;
            $stockNuevo = (int) $request->stock;

            if ($stockNuevo > $stockAnterior) {
                $detallesNuevos = [];

                for ($i = $stockAnterior + 1; $i <= $stockNuevo; $i++) {
                    $codigoInterno = 'VOU-' . $id . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);
                    $codigoPublico = strtoupper(Str::random(10));

                    $detallesNuevos[] = [
                        'vou_id' => $id,
                        'ent_id' => $request->f_ent_id,
                        'cli_id' => null,
                        'vd_codigo_interno' => $codigoInterno,
                        'vd_codigo' => $codigoPublico,
                        'vd_variante_nombre' => null,
                        'vd_variante_descripcion' => null,
                        'vd_monto_total' => $request->f_monto_total,
                        'vd_estado' => 1,
                        'vd_estado2' => 1,
                        'vd_estado3' => 1,
                        'vd_fecha_alta' => now(),
                        'vd_usu_alta' => $usuarioId,
                    ];
                }

                if (!empty($detallesNuevos)) {
                    DB::table('vouchers_detalles')->insert($detallesNuevos);
                }
            }

            if ($stockNuevo < $stockAnterior) {
                $cantidadAEliminar = $stockAnterior - $stockNuevo;

                $detallesLibres = DB::table('vouchers_detalles')
                    ->where('vou_id', $id)
                    ->whereNull('cli_id')
                    ->orderByDesc('vd_id')
                    ->limit($cantidadAEliminar)
                    ->get();

                if ($detallesLibres->count() < $cantidadAEliminar) {
                    DB::rollBack();

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', 'No se puede reducir el stock porque hay vouchers ya asignados o utilizados.');
                }

                $idsEliminar = $detallesLibres->pluck('vd_id')->toArray();

                DB::table('vouchers_detalles')
                    ->whereIn('vd_id', $idsEliminar)
                    ->update([
                        'vd_estado' => 0,
                        'vd_fecha_baja' => now(),
                        'vd_usu_baja' => 1
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Actualizar monto y entidad en detalles existentes
            |--------------------------------------------------------------------------
            */
            DB::table('vouchers_detalles')
                ->where('vou_id', $id)
                ->update([
                    'ent_id' => $request->f_ent_id,
                    'vd_monto_total' => $request->f_monto_total,
                ]);

            /*
            |--------------------------------------------------------------------------
            | Actualizar etiquetas existentes
            |--------------------------------------------------------------------------
            */
            DB::table('etiquetas_vouchers')
                ->where('vou_id', $id)
                ->update([
                    'ev_estado' => 0,
                    'ev_fecha_baja' => now(),
                    'ev_usu_baja' => 1
                ]);

            if ($request->filled('etiquetas')) {
                $rowsEtiquetas = [];

                foreach ($request->etiquetas as $etiId) {
                    $rowsEtiquetas[] = [
                        'vou_id' => $id,
                        'eti_id' => $etiId,
                        'ev_estado' => 1,
                        'ev_fecha_alta' => now(),
                        'ev_usu_alta' => $usuarioId,
                    ];
                }

                DB::table('etiquetas_vouchers')->insert($rowsEtiquetas);
            }

            /*
            |--------------------------------------------------------------------------
            | Eliminar banners existentes seleccionados
            |--------------------------------------------------------------------------
            */
            if ($request->filled('delete_banners')) {
                $bannersEliminar = DB::table('vouchers_files')
                    ->where('vou_id', $id)
                    ->whereIn('vf_id', $request->delete_banners)
                    ->get();

                // foreach ($bannersEliminar as $banner) {
                //     if (!empty($banner->vf_img_path) && Storage::disk('public')->exists($banner->vf_img_path)) {
                //         Storage::disk('public')->delete($banner->vf_img_path);
                //     }
                // }

                DB::table('vouchers_files')
                    ->where('vou_id', $id)
                    ->whereIn('vf_id', $request->delete_banners)
                    ->update([
                        'vf_estado' => 0,
                        'vf_fecha_baja' => now(),
                        'vf_usu_baja' => 1
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Agregar nuevos banners
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('banners')) {
                foreach ($request->file('banners') as $archivo) {
                    if (!$archivo) {
                        continue;
                    }

                    $nombreOriginal = $archivo->getClientOriginalName();
                    $extension = $archivo->getClientOriginalExtension();
                    $size = $archivo->getSize();
                    $nombreArchivo = uniqid('voucher_') . '.' . $extension;

                    $path = $archivo->storeAs('vouchers/banners', $nombreArchivo, 'public');

                    DB::table('vouchers_files')->insert([
                        'vou_id' => $id,
                        'vf_img_nombre_legible' => $nombreOriginal,
                        'vf_img_name' => $nombreArchivo,
                        'vf_img_path' => $path,
                        'vf_img_format' => $extension,
                        'vf_img_size' => $size,
                        'vf_estado' => 1,
                        'vf_estado2' => null,
                        'vf_fecha_alta' => now(),
                        'vf_usu_alta' => $usuarioId,
                    ]);
                }
            }

            // /*
            // |--------------------------------------------------------------------------
            // | Garantizar al menos 1 banner
            // |--------------------------------------------------------------------------
            // */
            // $totalBanners = DB::table('vouchers_files')
            //     ->where('vou_id', $id)
            //     ->count();

            // if ($totalBanners < 1) {
            //     DB::rollBack();

            //     return redirect()
            //         ->back()
            //         ->withInput()
            //         ->with('error', 'El voucher debe tener al menos un banner.');
            // }

            /*
            |--------------------------------------------------------------------------
            | Actualizar valores dinámicos de modalidad
            |--------------------------------------------------------------------------
            */
            $camposModalidad = DB::table('modalidades_campos')
                ->where('mod_id', $request->f_mod_id)
                ->where('mca_estado', 1)
                ->orderBy('mca_orden')
                ->get();

            DB::table('vouchers_modalidad_valores')
                ->where('vou_id', $id)
                ->update([
                    'vmv_estado' => 0,
                    'vmv_fecha_baja' => now(),
                    'vmv_usu_baja' => 1
                ]);

            foreach ($camposModalidad as $campo) {
                $valor = $request->input('modalidad_valores.' . $campo->mca_codigo);

                if ($campo->mca_tipo === 'boolean') {
                    $valor = $request->has('modalidad_valores.' . $campo->mca_codigo) ? 1 : 0;
                }

                DB::table('vouchers_modalidad_valores')->insert([
                    'vou_id' => $id,
                    'mca_id' => $campo->mca_id,
                    'vmv_valor' => is_array($valor) ? json_encode($valor) : $valor,
                    'vmv_estado' => 1,
                    'vmv_fecha_alta' => now(),
                    'vmv_usu_alta' => $usuarioId,
                ]);
            }

            $plantillas = $request->input('plantillas', []);

            $plantillas = collect($plantillas)
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            DB::table('vouchers_plantillas')
                ->where('vou_id', $id)
                ->delete();

            if ($plantillas->isNotEmpty()) {
                $rowsPlantillas = [];

                foreach ($plantillas as $vplId) {
                    $rowsPlantillas[] = [
                        'vou_id' => $id,
                        'vpl_id' => $vplId,
                        'vp_principal' => 0,
                        'vp_estado' => 1,
                        'vp_fecha_alta' => now(),
                        'vp_usu_alta' => $usuarioId,
                    ];
                }

                DB::table('vouchers_plantillas')->insert($rowsPlantillas);
            }

            if ($request->hasFile('imagenes')) {

                foreach ($request->file('imagenes') as $index => $imagen) {
                    // $filename = Str::uuid() . '.' . $imagen->extension();
                    // $path = $imagen->storeAs('logos', $filename, 'public');

                    $name = sanear_string($imagen->getClientOriginalName());
                    $name_legible = $imagen->getClientOriginalName();
                    $type = $imagen->getMimeType();
                    $size = $imagen->getSize();
                    $format = $imagen->getClientOriginalExtension();
                    $path = $imagen->store('vouchers', 'public');

                    DB::table('vouchers_files')->insert([
                        'vou_id' => $id,
                        'tipo_archivo_id' => 1,
                        'vf_img_nombre_legible' => $name_legible,
                        'vf_img_name' => $name,
                        'vf_img_path' => $path,
                        'vf_img_format' => $format,
                        'vf_img_size' => $size,
                        'vf_estado' => 1,
                        'vf_estado2' => null,
                        'vf_fecha_alta' => now(),
                        'vf_usu_alta' => $usuarioId,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('vouchers.edit', $id)
                ->with('success', 'Voucher actualizado correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();
            
            // dd($e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el voucher: ' . $e->getMessage());
        }
    }

    public function destroyBanner($id)
    {
        $banner = DB::table('vouchers_files')->where('vf_id', $id)->first();

        if (!$banner) {
            return redirect()->back()->with('error', 'El banner no existe.');
        }

        $totalBanners = DB::table('vouchers_files')
            ->where('vou_id', $banner->vou_id)
            ->count();

        if ($totalBanners <= 1) {
            return redirect()->back()->with('error', 'El voucher debe conservar al menos un banner.');
        }

        // if (!empty($banner->vf_img_path) && Storage::disk('public')->exists($banner->vf_img_path)) {
        //     Storage::disk('public')->delete($banner->vf_img_path);
        // }

        DB::table('vouchers_files')
            ->where('vf_id', $id)
            ->update([
                'vf_estado' => 0,
                'vf_fecha_baja' => now(),
                'vf_usu_baja' => 1
            ]);

        return redirect()->back()->with('success', 'Banner eliminado correctamente.');
    }

    public function previewPlantilla($voucherId, $plantillaId)
    {
        $voucher = DB::table('vouchers as v')
            ->leftJoin('entidades as e', 'e.ent_id', '=', 'v.ent_id')
            ->leftJoin('modalidades as m', 'm.mod_id', '=', 'v.mod_id')
            ->where('v.vou_id', $voucherId)
            ->select(
                'v.*',
                'e.ent_nombre_fantasia as entidad_nombre',
                'e.ent_logo_url as entidad_logo',
                'm.mod_nombre as modalidad_nombre'
            )
            ->first();

        if (!$voucher) {
            abort(404, 'Voucher no encontrado.');
        }

        $plantilla = DB::table('voucher_plantillas')
            ->where('vpl_id', $plantillaId)
            ->where('vpl_estado', 1)
            ->first();

        if (!$plantilla) {
            abort(404, 'Plantilla no encontrada.');
        }

        // $vinculada = DB::table('vouchers_plantillas')
        //     ->where('vou_id', $voucherId)
        //     ->where('vpl_id', $plantillaId)
        //     ->where('vp_estado', 1)
        //     ->exists();

        // if (!$vinculada) {
        //     abort(404, 'La plantilla no está vinculada a este voucher.');
        // }

        $config = json_decode($plantilla->vpl_config_json, true);

        if (!is_array($config)) {
            $config = [
                'canvas' => [
                    'width' => 800,
                    'height' => 500,
                    'background' => null,
                ],
                'fields' => [],
            ];
        }

        $data = [
            'voucher_nombre' => $voucher->vou_nombre ?? '',
            'voucher_descripcion' => $voucher->vou_descripcion ?? '',
            'voucher_monto' => $voucher->vou_monto_fijo ?? '',
            'voucher_fecha_inicio' => $voucher->vou_fecha_inicio
                ? Carbon::parse($voucher->vou_fecha_inicio)->format('d/m/Y')
                : '',
            'voucher_fecha_fin' => $voucher->vou_fecha_fin
                ? Carbon::parse($voucher->vou_fecha_fin)->format('d/m/Y')
                : '',

            'entidad_nombre' => $voucher->entidad_nombre ?? '',
            'entidad_logo' => $voucher->entidad_logo
                ? asset($voucher->entidad_logo)
                : '',

            'modalidad_nombre' => $voucher->modalidad_nombre ?? '',
        ];

        return view('vouchers.preview', compact(
            'voucher',
            'plantilla',
            'config',
            'data'
        ));
    }

    public function preview($voucherId)
    {
        $voucher = Voucher::with([
            'entidad',
            'modalidad',
            'modalidadValores',
            'detalles',
            'plantillas',
        ])->findOrFail($voucherId);

        $plantilla = $voucher->plantillaPrincipal()->first()
            ?? $voucher->plantillas()->first();
        // dd($plantilla);die;

        abort_if(!$plantilla, 404, 'El voucher no tiene plantilla vinculada.');

        $config = json_decode($plantilla->vpl_config_json, true);
        // dd($config);

        return view('vouchers.preview', compact('voucher', 'plantilla', 'config'));
    }

    public function delete_voucher_detalle($vou_id, $vd_id) {
        try {
            $detalle = VoucherDetalle::findOrFail($vd_id);

            $detalle->update([
                'vd_estado' => 0,
                'vd_fecha_mod' => now(),
                'vd_usu_mod' => 1
            ]);

            // return redirect()
            //     ->route('vouchers.edit', $vou_id)
            //     ->with('success', 'Detalle eliminado correctamente');
            return response()->json([
                'icon' => 'success',
                'title' => 'Detalle eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());

            // return redirect()
            //     ->back()
            //     ->withInput()
            //     ->with('error', 'Ocurrió un error al actualizar el voucher: ' . $e->getMessage());
        }
    }

    public function agregar_voucher_detalle(Request $request, $vou_id) {
        $request->validate([
            'stock' => 'required|integer|min:1',
        ]);

        try {
            $detalle = VoucherDetalle::where('vou_id',$vou_id)
                ->orderBy('vd_secuencia','desc')
                ->first();

            if (!$detalle) {
                return redirect()
                    ->back()
                    ->with('error', 'No se encontró un detalle base para generar stock.');
            }

            $usuarioId=1;

            $detalles = [];
            $secuencia = $detalle->vd_secuencia+1;
            for ($i = 0; $i <  $request->stock; $i++) {
                $codigoInterno = 'VOU-' . $vou_id . '-' . str_pad($secuencia, 4, '0', STR_PAD_LEFT);
                $codigoPublico = strtoupper(Str::random(10));

                $detalles[] = [
                    'vou_id' => $vou_id,
                    'ent_id' => $detalle->ent_id,
                    'cli_id' => null,
                    'vd_codigo_interno' => $codigoInterno,
                    'vd_codigo' => $codigoPublico,
                    'vd_secuencia' => $secuencia,
                    'vd_variante_nombre' => null,
                    'vd_variante_descripcion' => null,
                    'vd_monto_total' => $detalle->vd_monto_total,
                    'vd_estado' => 1,
                    'vd_estado2' => 'PE',
                    'vd_estado3' => 'PE',
                    'vd_fecha_alta' => now(),
                    'vd_usu_alta' => $usuarioId,
                ];
                $secuencia++;
            }

            DB::table('vouchers_detalles')->insert($detalles);
            

            return redirect()
                ->route('vouchers.edit', $vou_id)
                ->with('success', 'Stock actualizado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());

            // return redirect()
            //     ->back()
            //     ->withInput()
            //     ->with('error', 'Ocurrió un error al actualizar el voucher: ' . $e->getMessage());
        }
    }
    public function vouchersPorEntidad($id)
    {
        $entidad = DB::table('entidades')
            ->where('ent_id', $id)
            ->where('ent_estado', 1)
            ->select(
                'ent_id as id',
                'ent_nombre_fantasia as nombre',
                'ent_logo_url as logo'
            )
            ->first();

        if (!$entidad) {
            abort(404);
        }

        $vouchers = Voucher::with('imagenes')
            ->where('ent_id', $id)
            ->where('vou_estado', 1)
            ->get();
            // dd($vouchers);

        return view('entidad', compact('entidad', 'vouchers'));
    }

    public function vouchersPorCategoria(int $id)
    {
        $categoria = DB::table('categorias_vouchers')
            ->where('cv_id', $id)
            ->where('cv_estado', 1)
            ->select(
                'cv_id as id',
                'cv_nombre as nombre',
                'cv_img_path as logo'
            )
            ->first();

        if (!$categoria) {
            abort(404);
        }

        $rubros = Rubro::with('subrubros')
            ->where('cv_id', $id)
            ->where('rub_estado', 1)
            ->get();

        $vouchers = Voucher::with('imagenes')
            ->where('cv_id', $id)
            ->where('vou_estado', 1)
            ->get();
            // dd($vouchers);

        return view('categoria', compact('categoria', 'rubros', 'vouchers'));
    }

    public function buscar_voucher(Request $request)
    {
         $query = Voucher::query()
            ->with(['entidad', 'categoria', 'imagenes']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('vou_nombre', 'like', "%{$search}%")
                    ->orWhere('vou_descripcion', 'like', "%{$search}%")
                    ->orWhereHas('entidad', function ($entidad) use ($search) {
                        $entidad->where('ent_nombre_fantasia', 'like', "%{$search}%");
                    })
                    ->orWhereHas('categoria', function ($categoria) use ($search) {
                        $categoria->where('cv_nombre', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where('cv_id', $request->category);
        }

        if ($request->filled('min')) {
            $query->where('vou_monto_fijo', '>=', $request->min);
        }

        if ($request->filled('max')) {
            $query->where('vou_monto_fijo', '<=', $request->max);
        }

        if ($request->filled('destacado')) {
            $query->where('destacado', 1);
        }

        $vouchers = $query->paginate(12)->withQueryString();

        $categories = Categoria::all();

        if ($request->ajax()) {
            return view('partials.voucher-grid', compact('vouchers'))->render();
        }

        return view('categoria', compact('vouchers', 'categories'));
    }

    public function listado(Request $request)
    {
        $query = Voucher::query();

        if ($request->filled('fecha_desde')) {
            $query->whereDate('vou_fecha_alta', '>=', $request->fecha_desde);
        }

        if ($request->filled('buscar')) {
            $query->where('vou_nombre', 'like', "%".$request->buscar."%");
        }

        $vouchers = $query
            ->orderBy('vou_id', 'desc')
            ->paginate(20);

        return response()->json([
            'body' => view(
                'vouchers.partials.tabla',
                compact('vouchers')
            )->render(),

            'foot' => view(
                'vouchers.partials.paginacion',
                compact('vouchers')
            )->render(),

            'kregtotal' => $vouchers->total()
        ]);
    }
}