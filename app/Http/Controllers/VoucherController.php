<?php

// use App\Http\Controllers\Controller;

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Entidad_domicilio;
use App\Models\Etiqueta;
use App\Models\Influencer;
use App\Models\Modalidad;
use App\Models\Voucher;
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
        return $request->validate([
            'f_nombre' => 'required|string|max:255',

            'f_ent_id' => 'required|integer',
            'f_inf_id' => 'required|integer',
            'f_mod_id' => 'required|integer',
            'f_cv_id' => 'required|integer',

            'f_monto_total' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',

            'f_fecha_ini_lab' => 'required|date_format:d/m/Y',
            'f_fecha_fin_lab' => 'required|date_format:d/m/Y|after_or_equal:f_fecha_ini',

            'f_permite_personalizacion' => 'required|in:0,1',

            'description' => 'required|string|max:5000',
            'terms' => 'nullable|string|max:5000',
            'observaciones' => 'nullable|string|max:2000',

            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'integer|exists:etiquetas,eti_id',
            
            'etiquetas_nuevas' => 'nullable|array',
            'etiquetas_nuevas.*' => 'string|max:100',

            'banners' => 'required|array|min:1',
            'banners.0' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120',
            'banners.*' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'f_nombre.required' => 'Debes ingresar el nombre del voucher.',
            'banners.required' => 'Debes subir al menos un banner.',
            'banners.array' => 'El formato de banners no es válido.',
            'banners.min' => 'Debes subir al menos un banner.',
            'banners.0.required' => 'El primer banner es obligatorio.',
            'banners.*.mimes' => 'Los banners deben ser archivos jpg, jpeg, png o webp.',
            'banners.*.max' => 'Cada banner puede pesar hasta 5MB.',
        ]);
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
        $entidades = DB::table('entidades_domicilios as ed')
            ->join('entidades as e', 'e.ent_id', '=', 'ed.ent_id')
            ->where('ed.ed_estado', 1)
            ->where('e.ent_estado', 1)
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

        $influencers = Influencer::where('inf_estado', 1)
            ->orderBy('inf_id','desc')
            ->pluck('inf_nombre_fantasia', 'inf_id');

        // $modalidades = Modalidad::where('inf_estado', 1)
        //     ->orderBy('inf_id','desc')
        //     ->pluck('inf_nombre_fantasia', 'inf_id');

        $modalidades = Modalidad::where('mod_estado', 1)
            ->orderBy('mod_id','desc')
            ->get(['mod_nombre', 'mod_codigo', 'mod_id']);

        $categorias = Categoria::where('cv_estado', 1)
            ->orderBy('cv_id','desc')
            ->pluck('cv_nombre', 'cv_id');

        $etiquetasDisponibles = Etiqueta::where('eti_estado', 1)
            ->orderBy('eti_nombre')
            ->get(['eti_nombre', 'eti_id']);

        // Idealmente traer datos reales de DB
        return view('vouchers.create', compact(
            'entidades',
            'influencers',
            'modalidades',
            'categorias',
            'etiquetasDisponibles',
        ));
    }

    public function store(Request $request)
    {
        $this->validarVoucher($request);

        DB::beginTransaction();

        try {

            $usuarioId = Auth::id() ?? 1;

            $vouId = DB::table('vouchers')->insertGetId([
                'ent_id' => $request->f_ent_id,
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

            $etiquetasIds = collect($request->etiquetas ?? [])
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            /*
            |--------------------------------------------------------------------------
            | Crear etiquetas nuevas
            |--------------------------------------------------------------------------
            */
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

            /*
            |--------------------------------------------------------------------------
            | Vincular etiquetas al voucher
            |--------------------------------------------------------------------------
            */
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

            /*
            |--------------------------------------------------------------------------
            | Guardar banners
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

                    // guarda en storage/app/public/vouchers/banners
                    $path = $archivo->storeAs('vouchers/banners', $nombreArchivo, 'public');

                    DB::table('vouchers_files')->insert([
                        'vou_id' => $vouId,
                        'vf_img_nombre_legible' => $nombreOriginal,
                        'vf_img_name' => $nombreArchivo,
                        'vf_img_path' => $path,
                        'vf_img_format' => $extension,
                        'vf_img_size' => $size,
                        'vf_estado' => 1,
                        'vf_estado2' => 1,
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

            // return redirect()
            //     ->back()
            //     ->withInput()
            //     ->with('error', 'Ocurrió un error al guardar el voucher: ' . $e->getMessage());
            dd($e->getMessage());
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

        $entidades = DB::table('entidades as e')
            ->leftJoin('entidades_domicilios as ed', 'ed.ent_id', '=', 'e.ent_id')
            ->select(
                'e.ent_id as id',
                'e.ent_nombre_fantasia as nombre',
                'ed.ed_direccion as direccion'
            )
            ->where('e.ent_estado', 1)
            ->get();

        $influencers = DB::table('influencers')
            ->where('inf_estado', 1)
            ->orderBy('inf_nombre_fantasia')
            ->pluck('inf_nombre_fantasia', 'inf_id');

        $modalidades = DB::table('modalidades')
            ->where('mod_estado', 1)
            ->orderBy('mod_nombre')
            ->get(['mod_nombre', 'mod_codigo', 'mod_id']);

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

        return view('vouchers.edit', compact(
            'voucher',
            'banners',
            'entidades',
            'influencers',
            'modalidades',
            'categorias',
            'etiquetasDisponibles',
            'etiquetasSeleccionadas',
            'voucherDetalles'
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
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->f_fecha_ini)->format('Y-m-d');
            $fechaFin = Carbon::createFromFormat('d/m/Y', $request->f_fecha_fin)->format('Y-m-d');
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
                    ->delete();
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
                ->delete();

            if ($request->filled('etiquetas')) {
                $rowsEtiquetas = [];

                foreach ($request->etiquetas as $etiId) {
                    $rowsEtiquetas[] = [
                        'vou_id' => $id,
                        'eti_id' => $etiId,
                        've_estado' => 1,
                        've_fecha_alta' => now(),
                        've_usu_alta' => $usuarioId,
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

                foreach ($bannersEliminar as $banner) {
                    if (!empty($banner->vf_img_path) && Storage::disk('public')->exists($banner->vf_img_path)) {
                        Storage::disk('public')->delete($banner->vf_img_path);
                    }
                }

                DB::table('vouchers_files')
                    ->where('vou_id', $id)
                    ->whereIn('vf_id', $request->delete_banners)
                    ->delete();
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

            /*
            |--------------------------------------------------------------------------
            | Garantizar al menos 1 banner
            |--------------------------------------------------------------------------
            */
            $totalBanners = DB::table('vouchers_files')
                ->where('vou_id', $id)
                ->count();

            if ($totalBanners < 1) {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'El voucher debe tener al menos un banner.');
            }

            DB::commit();

            return redirect()
                ->route('vouchers.index')
                ->with('success', 'Voucher actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

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

        if (!empty($banner->vf_img_path) && Storage::disk('public')->exists($banner->vf_img_path)) {
            Storage::disk('public')->delete($banner->vf_img_path);
        }

        DB::table('vouchers_files')
            ->where('vf_id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Banner eliminado correctamente.');
    }
}