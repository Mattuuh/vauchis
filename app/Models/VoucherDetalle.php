<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherDetalle extends Model
{
    protected $table = 'vouchers_detalles';
    protected $primaryKey = 'vd_id';

    public $timestamps = false;

    protected $fillable = [
        'vou_id',
        'ent_id',
        'cli_id',
        'vd_cliente_nombre',
        'vd_cliente_apellido',
        'vd_cliente_tipo_doc_id',
        'vd_cliente_documento',
        'vd_cliente_email',
        'vd_cliente_telefono',
        'vd_codigo_interno',
        'vd_codigo',
        'vd_secuencia',
        'vd_variante_nombre_de',
        'vd_variante_nombre_para',
        'vd_variante_mensaje',
        'vd_monto_total',
        'vd_fecha_compra',
        'vd_fecha_vencimiento',
        'vd_datos_json',
        'vd_estado',
        'vd_estado2',
        'vd_estado3',
        'vd_pdf_desktop',
        'vd_pdf_mobile',
        'vd_fecha_alta',
        'vd_usu_alta',
        'vd_fecha_mod',
        'vd_usu_mod',
        'vd_fecha_baja',
        'vd_usu_baja',
    ];

    protected $casts = [
        'vd_fecha_compra' => 'datetime',
        'vd_fecha_vencimiento' => 'datetime',
        'vd_fecha_alta' => 'datetime',
        'vd_fecha_mod' => 'datetime',
        'vd_fecha_baja' => 'datetime',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'vou_id', 'vou_id');
    }
}
