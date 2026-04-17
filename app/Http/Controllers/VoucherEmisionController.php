<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherEmision;
use App\Models\VoucherPlantilla;
use App\Services\VoucherEmissionService;
use Illuminate\Http\Request;

class VoucherEmisionController extends Controller
{
    public function create($voucherId)
    {
        $voucher = Voucher::findOrFail($voucherId);

        $plantillas = VoucherPlantilla::where('vpl_estado', 1)
            ->orderBy('vpl_nombre')
            ->get();

        return view('voucher_emisiones.create', compact('voucher', 'plantillas'));
    }

    public function store(Request $request, $voucherId, VoucherEmissionService $service)
    {
        $request->validate([
            'vpl_id' => 'required|exists:voucher_plantillas,vpl_id',
            'generar_pdf' => 'nullable|in:1',
        ]);

        $voucher = Voucher::findOrFail($voucherId);
        $plantilla = VoucherPlantilla::findOrFail($request->vpl_id);

        // $emision = $service->emitir($voucher, $plantilla, auth()->id());
        $emision = $service->emitir($voucher, $plantilla, 1);

        if ($request->generar_pdf == '1') {
            $service->generarPdf($emision);
        }

        return redirect()
            ->route('voucher_emisiones.show', $emision->vem_id)
            ->with('success', 'Voucher emitido correctamente.');
    }

    public function show($id)
    {
        $emision = VoucherEmision::findOrFail($id);

        return view('voucher_emisiones.show', compact('emision'));
    }
}
