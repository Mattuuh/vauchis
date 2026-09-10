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

    public function exportar_reporte_vouchers($ent_id)
    {
        $vouchers = Voucher::with('modalidad')
            ->where('ent_id', $ent_id)
            ->orderBy('vou_id', 'desc')
            ->get();

        $nombreArchivo = 'reporte_vouchers_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($vouchers) {

            $archivo = fopen('php://output', 'w');

            // Para que Excel reconozca correctamente UTF-8
            fwrite($archivo, "\xEF\xBB\xBF");

            fputcsv($archivo, [
                'VOUCHER',
                'FECHA DE ALTA',
                'PRECIO INDIVIDUAL',
                'STOCK',
                'VENDIDOS',
                'CANJEADOS',
                'ESTADO',
                'MONTO ACTIVO',
                'MONTO VENDIDO',
                'MONTO CANJEADO',
                'SALDO CANJEADO',
            ], ';');

            foreach ($vouchers as $voucher) {

                fputcsv($archivo, [
                    $voucher->vou_nombre,

                    $voucher->vou_fecha_alta
                        ? date('d/m/Y', strtotime($voucher->vou_fecha_alta))
                        : '',

                    rand(10000,100000),

                    // $voucher->stock,
                    // $voucher->vendidos,
                    // $voucher->canjeados,
                    rand(1,100),
                    rand(1,100),
                    rand(1,100),
                    
                    rand(10000,100000),
                    rand(10000,100000),
                    rand(10000,100000),
                    rand(10000,100000),

                    $voucher->vou_estado == 1
                        ? 'Activo'
                        : 'Inactivo',
                ], ';');
            }

            fclose($archivo);

        }, $nombreArchivo, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
