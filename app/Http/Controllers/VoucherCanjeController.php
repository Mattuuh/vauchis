<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherCanjeController extends Controller
{
    public function show($token)
    {
        if (session('auth.tu_id')!=3) {
            return redirect()->intended(route('login'))->with('warning', 'Necesita iniciar sesion para canjear el voucher.');
        }

        $voucher = DB::table('vouchers_detalles as vd')
            ->join('vouchers as v', 'v.vou_id', '=', 'vd.vou_id')
            ->join('entidades as e', 'e.ent_id', '=', 'v.ent_id')
            // ->where('vd.vd_token', $token)
            ->where('vd.vd_id', $token)
            ->select([
                'vd.*',
                'v.vou_nombre',
                'v.vou_descripcion',
                'e.ent_nombre_fantasia'
            ])
            ->first();

        if (!$voucher) {
            abort(404);
        }

        return view('vouchers.canjear', compact('voucher'));
    }

    public function canjear(Request $request, $token)
    {
        if (session('auth.tu_id')!=3) {
            return redirect()->intended(route('login'))->with('warning', 'Necesita iniciar sesion para canjear el voucher.');
        }

        $voucher = DB::table('vouchers_detalles')
            // ->where('vd_token', $token)
            ->where('vd_id', $token)
            ->first();

        if (!$voucher) {
            abort(404);
        }

        if ($voucher->vd_estado3 === 'CA') {
            return redirect()
                ->route('voucher.canjear', $token)
                ->with('warning', 'Este voucher ya fue canjeado.');
        }

        DB::table('vouchers_detalles')
            ->where('vd_id', $voucher->vd_id)
            ->update([
                'vd_estado3' => 'CA',
                // 'vd_fecha_canje' => now(),
                'vd_fecha_mod' => now(),
                'vd_usu_mod' => session('auth.usuario_id') ?? 0,
            ]);

        return redirect()
            ->route('voucher.canjear', $token)
            ->with('success', 'Voucher canjeado correctamente.');
    }
}
