<?php

namespace App\Http\Controllers;

use App\Models\Rubro;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function entidadesPorRubro($categoriaId, $rubroId)
    {
        $rubro = Rubro::with([
            'entidades' => function ($query) {
                $query->where('ent_estado', 1)
                    ->orderBy('ent_nombre');
            }
        ])
        // ->where('cat_id', $categoriaId)
        ->findOrFail($rubroId);

        // $query = $rubro->entidades()
        //     ->where('ent_estado', 1)
        //     ->orderBy('ent_nombre');
        // dd($query->toRawSql());

        return view('categorias.partials.entidades', [
            'entidades' => $rubro->entidades,
        ]);
    }

    public function entidadesPorSubrubro($categoriaId,$rubroId,$subrubroId) {
        $rubro = Rubro::where('cv_id', $categoriaId)
            ->findOrFail($rubroId);

        $entidades = $rubro->entidades()
            ->where('ent_estado', 1)
            ->whereHas('subrubros', function ($query) use ($subrubroId, $rubroId) {
                $query->where('subrubros.sub_id', $subrubroId)
                    ->where('entidades_subrubros.rub_id', $rubroId);
            })
            ->orderBy('ent_nombre')
            ->get();
        // dd($entidades->toRawSql());

        return view('categorias.partials.entidades', [
            'entidades' => $entidades,
        ]);
    }
}
