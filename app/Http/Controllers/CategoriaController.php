<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Entidad;
use App\Models\Rubro;
use App\Models\Voucher;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function entidadesPorRubro($categoriaId, $rubroId)
    {
        $rubro = Rubro::with([
            'entidades' => function ($query) {
                $query->where('ent_estado', 1)
                    ->where('ent_publico', 1)
                    ->orderBy('ent_orden');
            }
        ])
        // ->where('cat_id', $categoriaId)
        // ->orderBy('rub_orden', 'asc')
        ->findOrFail($rubroId);

        $entidades = Entidad::query()
            ->with('resaltador_entidad')
            ->where('ent_estado', 1)
            ->where('ent_publico', 1)

            // Primer filtro: la entidad debe tener vouchers de la categoría.
            ->whereHas('vouchers', function ($query) use ($categoriaId) {
                $query->where('cv_id', $categoriaId)
                    ->where('vou_estado', 1);
            })

            // Segundo filtro: la entidad debe pertenecer al rubro.
            ->whereHas('rubros', function ($query) use ($rubroId) {
                $query->where('rubros.rub_id', $rubroId);
            })

            // ->with([
            //     'imagenPrincipal',
            //     'logoPrincipal',
            // ])
            ->orderBy('ent_orden')
            ->get();

            // dd($entidades->toRawSql());

        return view('categorias.partials.entidades', ['entidades' => $entidades,]);
    }

    public function entidadesPorSubrubro($categoriaId,$rubroId,$subrubroId) {
        $rubro = Rubro::where('cv_id', $categoriaId)
            ->findOrFail($rubroId);

        $entidades = $rubro->entidades()
            ->where('ent_estado', 1)
            ->where('ent_publico', 1)
            ->whereHas('subrubros', function ($query) use ($subrubroId, $rubroId) {
                $query->where('subrubros.sub_id', $subrubroId)
                    ->where('entidades_subrubros.rub_id', $rubroId);
            })
            ->orderBy('ent_orden')
            ->get();
        // dd($entidades->toRawSql());


        // $entidades = Entidad::query()
        //     ->where('ent_estado', 1)

        //     ->whereHas('vouchers', function ($query) use ($categoriaId) {
        //         $query->where('cat_id', $categoriaId)
        //             ->where('vou_estado', 1);
        //     })

        //     ->whereHas('rubros', function ($query) use ($rubroId) {
        //         $query->where('rubros.rub_id', $rubroId);
        //     })

        //     ->whereHas('subrubros', function ($query) use ($rubroId, $subrubroId) {
        //         $query
        //             ->where('subrubros.rub_id', $rubroId)
        //             ->where('subrubros.sub_id', $subrubroId);
        //     })

        //     ->with([
        //         'imagenPrincipal',
        //         'logoPrincipal',
        //     ])
        //     ->orderBy('ent_nombre')
        //     ->get();

        return view('categorias.partials.entidades', [
            'entidades' => $entidades,
        ]);
    }

    public function mostrarCategoria($id)
    {
        session()->forget('voucher');

        $categoria = Categoria::where('cv_id', $id)
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
            ->where('rub_publico', 1)
            // ->orderBy('rub_nombre')
            ->orderBy('rub_orden', 'asc')
            ->get();

        $entidades = Entidad::query()
            ->where('ent_estado', 1)
            ->where('ent_publico', 1)
            ->whereHas('vouchers', function ($query) use ($id) {
                $query->where('cv_id', $id)
                    ->where('vou_estado', 1);
            })
            ->with([
                'imagenPrincipal',
                'logoPrincipal',
            ])
            ->orderBy('ent_orden')
            ->get();

        $montos_vouchers=[];
        foreach ($entidades as $entidad) {
            $vouchers_montos = Voucher::with('modalidadValores')
                ->where('ent_id', $entidad->ent_id)
                ->where('vou_estado', 1)
                ->get();

            $montosMinimos = [];
            $montosMaximos = [];
            foreach ($vouchers_montos as $voucher) {
                foreach ($voucher->modalidadValores as $valor) {
                    // MONTO A ELECCIÓN
                    if (($valor->vmv_monto_minimo>0) && ($valor->vmv_monto_maximo>0)) {
                        $montosMinimos[] = $valor->vmv_monto_minimo;
                        $montosMaximos[] = $valor->vmv_monto_maximo;
                    }
                    // MONTO FIJO / BOTÓN
                    elseif ($valor->vmv_monto_fijo>0) {
                        $montosMinimos[] = $valor->vmv_monto_fijo;
                        $montosMaximos[] = $valor->vmv_monto_fijo;
                    }
                }
            }

            $monto_minimo = !empty($montosMinimos) ? min($montosMinimos) : 0;
            $monto_maximo = !empty($montosMaximos) ? max($montosMaximos) : 0;
            $montos_vouchers[$entidad->ent_id]['monto_minimo']=$monto_minimo;
            $montos_vouchers[$entidad->ent_id]['monto_maximo']=$monto_maximo;
        }

        return view('categoria', compact('categoria', 'rubros','entidades','montos_vouchers'));
    }
}
