<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\TipoResponsabilidad;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $ent_id = session('auth.ent_id');

        $entidad = Entidad::with(['domicilios','tipo_responsabilidad'])->findOrFail($ent_id);

        // $tiposResponsabilidad = TipoResponsabilidad::where('tipo_resp_estado', 1)
        //     ->orderBy('tipo_resp_id')
        //     ->pluck('tipo_resp_nombre', 'tipo_resp_id');

        $vouchers = Voucher::with('modalidad')
            ->where('ent_id', $ent_id)
            ->orderBy('vou_id', 'desc')
            ->get();

        return view('clientes.index', compact('entidad', 'vouchers'));
    }
}
