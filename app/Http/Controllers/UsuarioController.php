<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function vouchers(int $id)
    {
        $vouchers = VoucherDetalle::with('voucher')
            ->where('cli_id', $id)
            // ->where('vou_id', 21)
            ->orderBy('vd_id')
            ->get();

        return view('usuarios.vouchers', compact('vouchers'));
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
                'usuarios.partials.tabla',
                compact('vouchers')
            )->render(),

            'foot' => view(
                'usuarios.partials.paginacion',
                compact('vouchers')
            )->render(),

            'kregtotal' => $vouchers->total()
        ]);
    }
}
