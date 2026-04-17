<?php

namespace App\Support;

class VoucherTemplateFields
{
    public static function all(): array
    {
        return [
            'voucher_nombre'       => 'Nombre del voucher',
            'voucher_descripcion'  => 'Descripción',
            'voucher_condiciones'  => 'Condiciones',
            'voucher_codigo'       => 'Código',
            'voucher_fecha_inicio' => 'Fecha inicio',
            'voucher_fecha_fin'    => 'Fecha fin',
            'vigencia_texto'       => 'Texto de vigencia',
            'entidad_nombre'       => 'Nombre del comercio',
            'entidad_logo'         => 'Logo del comercio',
            'modalidad_nombre'     => 'Modalidad',
            'beneficio_texto'      => 'Beneficio',
        ];
    }

    public static function textFields(): array
    {
        return [
            'voucher_nombre'       => 'Nombre del voucher',
            'voucher_descripcion'  => 'Descripción',
            'voucher_condiciones'  => 'Condiciones',
            'voucher_codigo'       => 'Código',
            'voucher_fecha_inicio' => 'Fecha inicio',
            'voucher_fecha_fin'    => 'Fecha fin',
            'vigencia_texto'       => 'Texto de vigencia',
            'entidad_nombre'       => 'Nombre del comercio',
            'modalidad_nombre'     => 'Modalidad',
            'beneficio_texto'      => 'Beneficio',
        ];
    }

    public static function imageFields(): array
    {
        return [
            'entidad_logo' => 'Logo del comercio',
        ];
    }
}