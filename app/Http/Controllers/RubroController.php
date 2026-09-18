<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Rubro;
use App\Models\Subrubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    public function index()
    {
        $rubros = Rubro::with('categoria')
            ->orderBy('rub_id','desc')
            // ->where('rub_estado',1)
            ->get();

        return view('rubros.index', compact('rubros'));
    }

    public function create()
    {
        $categorias = Categoria::where('cv_estado', 1)
            ->orderBy('cv_nombre')
            ->pluck('cv_nombre', 'cv_id');

        $subrubrosDisponibles = Subrubro::where('sub_estado', 1)
            ->where(function ($q) {
                $q->whereNull('rub_id');
            })
            ->orderBy('sub_nombre')
            ->get(['sub_id', 'sub_nombre', 'rub_id']);

        return view('rubros.create', compact('categorias', 'subrubrosDisponibles'));
    }

    private function validarRubro(Request $request)
    {
        return $request->validate([
            // 'f_codigo' => 'required|string|max:255',
            'f_nombre' => 'required|string|max:255',
            // 'f_descripcion' => 'nullable|string|max:255',
            // 'f_descripcion_corta' => 'nullable|string|max:255',
            'subrubros' => 'nullable|array',
            'subrubros.*' => 'integer|exists:subrubros,sub_id',

            'subrubros_nuevos' => 'nullable|array',
            'subrubros_nuevos.*' => 'string|max:255',
        ]);
    }

    public function store(Request $request)
    {
        try {
            // $request->validate([
            //     'f_codigo' => 'nullable|string|max:255',
            //     'f_nombre' => 'required|string|max:255',
            //     'f_descripcion' => 'nullable|string|max:255',
            //     'f_descripcion_corta' => 'nullable|string|max:255',
            // ]);
            $usuario_id=1;

            $rubro = Rubro::create([
                'cv_id' => $request->f_categoria,
                'rub_codigo' => $request->f_codigo ?? null,
                'rub_nombre' => $request->f_nombre,
                'rub_descripcion' => $request->f_descripcion ?? null,
                'rub_descripcion_corta' => $request->f_descripcion_corta ?? null,
                'rub_publico' => $request->f_publico,
                'rub_estado' => '1',
                'rub_fecha_alta' => now(),
                'rub_usu_alta' => $usuario_id,
            ]);

            $subrubrosOrden = $request->input('subrubros_orden', []);
            $subrubrosIds = [];

            // OBTENER IDs EXISTENTES
            foreach ($subrubrosOrden as $item) {
                [$tipo, $valor] = explode(':', $item, 2);

                if ($tipo === 'existente') {
                    $subrubrosIds[] = (int) $valor;
                }
            }

            // DESVINCULAR LOS QUE YA NO ESTÁN
            $query = Subrubro::where('rub_id', $rubro->rub_id);

            if (!empty($subrubrosIds)) {
                $query->whereNotIn('sub_id', $subrubrosIds);
            }

            $query->update([
                'rub_id' => null,
                'sub_orden' => null,
                'sub_fecha_mod' => now(),
                'sub_usu_mod' => $usuario_id,
            ]);


            // VINCULAR / CREAR RESPETANDO EL ORDEN
            foreach ($subrubrosOrden as $index => $item) {
                [$tipo, $valor] = explode(':', $item, 2);

                $orden = $index + 1;
                if ($tipo === 'existente') {
                    Subrubro::where('sub_id', (int) $valor)
                        ->update([
                            'rub_id' => $rubro->rub_id,
                            'sub_orden' => $orden,
                            'sub_fecha_mod' => now(),
                            'sub_usu_mod' => $usuario_id,
                        ]);

                } elseif ($tipo === 'nuevo') {
                    $nombre = trim($valor);

                    if ($nombre === '') {
                        continue;
                    }

                    Subrubro::create([
                        'rub_id' => $rubro->rub_id,
                        'sub_nombre' => $nombre,
                        'sub_orden' => $orden,
                        'sub_estado' => 1,
                        'sub_fecha_alta' => now(),
                        'sub_usu_alta' => $usuario_id,
                    ]);
                }
            }

            return redirect()
                ->route('admin.rubros.index')
                ->with('success', 'Rubro creado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $rubro = Rubro::findOrFail($id);

        $categorias = Categoria::where('cv_estado', 1)
            ->orderBy('cv_nombre')
            ->pluck('cv_nombre', 'cv_id');

        $subrubrosDisponibles = Subrubro::where('sub_estado', 1)
            ->where(function ($q) use ($id) {
                $q->whereNull('rub_id')
                ->orWhere('rub_id', $id);
            })
            ->orderBy('sub_nombre')
            ->get(['sub_id', 'sub_nombre', 'rub_id']);

        $subrubrosSeleccionados = Subrubro::where('rub_id', $id)
            ->where('sub_estado', 1)
            ->orderBy('sub_orden')
            ->get(['sub_id', 'sub_nombre'])
            ->map(fn ($item) => [
                'id' => $item->sub_id,
                'name' => $item->sub_nombre,
            ])
            ->values()
            ->toArray();

        return view('rubros.edit', compact(
            'rubro',
            'categorias',
            'subrubrosDisponibles',
            'subrubrosSeleccionados'
            ));
    }

    public function update(Request $request, $id)
    {
        try {
            // $this->validarRubro($request);

            $rubro = Rubro::findOrFail($id);
            $usuario_id=1;

            $rubro->update([
                'cv_id' => $request->f_categoria,
                'rub_codigo' => $request->f_codigo,
                'rub_nombre' => $request->f_nombre,
                'rub_descripcion' => $request->f_descripcion,
                'rub_descripcion_corta' => $request->f_descripcion_corta,
                'rub_publico' => $request->f_publico,
                'rub_fecha_mod' => now(),
                'rub_usu_mod' => $usuario_id,
            ]);

            $subrubrosOrden = $request->input('subrubros_orden', []);
            $subrubrosIds = [];

            // OBTENER IDs EXISTENTES
            foreach ($subrubrosOrden as $item) {
                [$tipo, $valor] = explode(':', $item, 2);

                if ($tipo === 'existente') {
                    $subrubrosIds[] = (int) $valor;
                }
            }

            // DESVINCULAR LOS QUE YA NO ESTÁN
            $query = Subrubro::where('rub_id', $id);

            if (!empty($subrubrosIds)) {
                $query->whereNotIn('sub_id', $subrubrosIds);
            }

            $query->update([
                'rub_id' => null,
                'sub_orden' => null,
                'sub_fecha_mod' => now(),
                'sub_usu_mod' => $usuario_id,
            ]);


            // VINCULAR / CREAR RESPETANDO EL ORDEN
            foreach ($subrubrosOrden as $index => $item) {
                [$tipo, $valor] = explode(':', $item, 2);

                $orden = $index + 1;
                if ($tipo === 'existente') {
                    Subrubro::where('sub_id', (int) $valor)
                        ->update([
                            'rub_id' => $id,
                            'sub_orden' => $orden,
                            'sub_fecha_mod' => now(),
                            'sub_usu_mod' => $usuario_id,
                        ]);

                } elseif ($tipo === 'nuevo') {
                    $nombre = trim($valor);

                    if ($nombre === '') {
                        continue;
                    }

                    Subrubro::create([
                        'rub_id' => $id,
                        'sub_nombre' => $nombre,
                        'sub_orden' => $orden,
                        'sub_estado' => 1,
                        'sub_fecha_alta' => now(),
                        'sub_usu_alta' => $usuario_id,
                    ]);
                }
            }

            return redirect()
                ->route('admin.rubros.edit', $id)
                ->with('success', 'Rubro actualizado correctamente');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $rubro = Rubro::findOrFail($id);

            $rubro->update([
                'rub_estado' => 0,
                'rub_fecha_baja' => now(),
                'rub_usu_baja' => 1,
            ]);

            return redirect()
                ->route('admin.rubros.index')
                ->with('success', 'Rubro eliminado correctamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function listado(Request $request)
    {
        $query = Rubro::query();

        if ($request->filled('fecha_desde')) {
            $query->whereDate('rub_fecha_alta', '>=', $request->fecha_desde);
        }

        if ($request->filled('buscar')) {
            $query->where('rub_nombre', 'like', "%".$request->buscar."%");
        }

        $rubros = $query
            ->orderBy('rub_id', 'desc')
            ->paginate(20);

        return response()->json([
            'body' => view(
                'rubros.partials.tabla',
                compact('rubros')
            )->render(),

            'foot' => view(
                'rubros.partials.paginacion',
                compact('rubros')
            )->render(),

            'kregtotal' => $rubros->total()
        ]);
    }

    public function ordenar()
    {
        // $rubros = Rubro::with('categoria')
        //     ->orderBy('rub_id','desc')
        //     // ->where('rub_estado',1)
        //     ->get();

        $rubros = Rubro::with('categoria')
            ->where('rub_publico',1)
            ->where('rub_estado',1)
            ->orderByRaw('CASE WHEN rub_orden IS NULL OR rub_orden = 0 THEN 1 ELSE 0 END')
            ->orderBy('rub_orden')
            ->orderBy('rub_id')
            ->get();

        $categorias = Categoria::where('cv_estado', 1)
            ->orderBy('cv_nombre')
            ->get();

        return view('rubros.orden', compact('rubros','categorias'));
    }

    public function guardar_orden(Request $request)
    {
        // dd($request);
        // foreach ($request->orden as $index => $rub_id) {
        //     Rubro::where('rub_id', $rub_id)
        //         ->update([
        //             'rub_orden' => $index + 1,
        //             'rub_fecha_mod' => now(),
        //             'rub_usu_mod' => $usu ?? 0
        //         ]);
        // }

        $categoria_id = $request->categoria_id;
        $orden = $request->input('orden', []);

        foreach ($orden as $index => $rub_id) {
            Rubro::where('rub_id', $rub_id)
                ->where('cv_id', $categoria_id)
                ->update([
                    'rub_orden' => $index + 1,
                    'rub_fecha_mod' => now(),
                    'rub_usu_mod' => $usu ?? 0
                ]);

        }

        return response()->json([
            'success' => true,
            'message' => 'Orden guardado correctamente'
        ]);
    }

    public function por_categoria(Request $request)
    {
        $categoriaId = $request->categoria_id;

        $rubros = Rubro::with('categoria')
            ->where('cv_id', $categoriaId)
            ->where('rub_publico',1)
            ->where('rub_estado',1)
            ->orderBy('rub_orden')
            ->get()
            ->map(function ($rubro) {
                $estado = estado($rubro->rub_estado);

                return [
                    'rub_id' => $rubro->rub_id,
                    'rub_nombre' => $rubro->rub_nombre,
                    'categoria' => $rubro->categoria->cv_nombre ?? '',
                    'fecha_alta' => optional($rubro->rub_fecha_alta)->format('d/m/Y'),
                    'estado_class' => $estado['class'],
                    'estado_text' => $estado['text'],
                    'estado_icon' => $estado['icon'],
                ];

            });

        return response()->json([
            'rubros' => $rubros
        ]);
    }
}
