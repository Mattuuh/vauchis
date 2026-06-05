<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherCompraController extends Controller
{
     public function show($id)
    {
        $voucher = Voucher::with('entidad')
            ->with('imagenes')
            ->where('vou_estado', 1)
            ->findOrFail($id);
            // dd($voucher);

        $entidad = $voucher->entidad;

        if (!$voucher) {
            abort(404);
        }

        return view('vouchers.comprar', compact('voucher','entidad'));
    }

    public function pagar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $voucher = DB::table('vouchers')
            ->where('vou_id', $id)
            ->first();

        if (!$voucher) {
            abort(404);
        }

        $cantidad = (int) $request->cantidad;
        $precio = (float) $voucher->vou_precio;
        $total = $cantidad * $precio;

        // Acá después podés integrar Mercado Pago
        // o guardar una orden de compra.

        dd([
            'voucher_id' => $id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'total' => $total,
        ]);
    }
}
