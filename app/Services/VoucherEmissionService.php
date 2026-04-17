<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\VoucherEmision;
use App\Models\VoucherPlantilla;
use Illuminate\Support\Facades\File;

class VoucherEmissionService
{
    public function emitir(Voucher $voucher, VoucherPlantilla $plantilla, ?int $userId = null): VoucherEmision
    {
        $resolver = app(VoucherTemplateDataResolver::class);
        $renderer = app(VoucherTemplateRenderer::class);

        $data = $resolver->resolve($voucher);
        $config = $plantilla->vpl_config_json ?? [];

        $snapshot = [
            'voucher_id'     => $voucher->vou_id,
            'plantilla_id'   => $plantilla->vpl_id,
            'template_name'  => $plantilla->vpl_nombre,
            'template_config'=> $config,
            'data'           => $data,
            'generated_at'   => now()->toDateTimeString(),
        ];

        $html = $renderer->render($config, $data);

        $emision = VoucherEmision::create([
            'vou_id'            => $voucher->vou_id,
            'vpl_id'            => $plantilla->vpl_id,
            'vem_codigo'        => 'VEM-' . now()->format('YmdHis') . '-' . $voucher->vou_id,
            'vem_snapshot_json' => $snapshot,
            'vem_html'          => $html,
            'vem_pdf_path'      => null,
            'vem_preview_path'  => null,
            'vem_fecha_emision' => now(),
            'vem_estado'        => 1,
            'vem_usu_alta'      => $userId,
        ]);

        return $emision;
    }

    public function generarPdf(VoucherEmision $emision): ?string
    {
        if (!class_exists(\Spatie\Browsershot\Browsershot::class)) {
            return null;
        }

        $relativePath = 'storage/vouchers/emisiones/' . $emision->vem_id . '.pdf';
        $absoluteDir = public_path('storage/vouchers/emisiones');
        $absolutePath = public_path('storage/vouchers/emisiones/' . $emision->vem_id . '.pdf');

        if (!File::exists($absoluteDir)) {
            File::makeDirectory($absoluteDir, 0775, true);
        }

        \Spatie\Browsershot\Browsershot::html($this->wrapHtml($emision->vem_html))
            ->showBackground()
            ->savePdf($absolutePath);

        $emision->vem_pdf_path = $relativePath;
        $emision->save();

        return $relativePath;
    }

    protected function wrapHtml(string $html): string
    {
        return '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <title>Voucher</title>
                <style>
                    body {
                        margin: 0;
                        padding: 20px;
                        background: #ffffff;
                        font-family: Arial, sans-serif;
                    }
                </style>
            </head>
            <body>' . $html . '</body>
            </html>
        ';
    }
}