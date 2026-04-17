<?php

namespace App\Services;

use App\Models\Voucher;
use Carbon\Carbon;

class VoucherTemplateDataResolver
{
    public function resolve(Voucher $voucher): array
    {
        $fechaInicio = $this->formatDate($voucher->vou_fecha_ini ?? null);
        $fechaFin = $this->formatDate($voucher->vou_fecha_fin ?? null);

        return [
            'voucher_nombre'       => $voucher->vou_nombre ?? '',
            'voucher_descripcion'  => $voucher->vou_descripcion ?? '',
            'voucher_condiciones'  => $voucher->vou_condiciones ?? '',
            'voucher_codigo'       => $voucher->vou_codigo ?? '',
            'voucher_fecha_inicio' => $fechaInicio,
            'voucher_fecha_fin'    => $fechaFin,
            'vigencia_texto'       => $this->buildVigenciaTexto($fechaInicio, $fechaFin),
            'entidad_nombre'       => optional($voucher->entidad)->ent_nombre_fantasia ?? '',
            'entidad_logo'         => optional($voucher->entidad)->ent_logo
                ? asset('storage/' . optional($voucher->entidad)->ent_logo)
                : '',
            'modalidad_nombre'     => optional($voucher->modalidad)->mod_nombre ?? '',
            'beneficio_texto'      => $voucher->vou_beneficio_texto ?? '',
        ];
    }

    protected function formatDate($date): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            return Carbon::parse($date)->format('d/m/Y');
        } catch (\Throwable $e) {
            return '';
        }
    }

    protected function buildVigenciaTexto(string $inicio, string $fin): string
    {
        if ($inicio && $fin) {
            return "Válido desde {$inicio} hasta {$fin}";
        }

        if ($fin) {
            return "Válido hasta {$fin}";
        }

        if ($inicio) {
            return "Válido desde {$inicio}";
        }

        return '';
    }
}