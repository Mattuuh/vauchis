<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherEmision extends Model
{
    protected $table = 'voucher_emisiones';
    protected $primaryKey = 'vem_id';
    public $timestamps = false;

    protected $fillable = [
        'vou_id',
        'vpl_id',
        'vem_codigo',
        'vem_snapshot_json',
        'vem_html',
        'vem_pdf_path',
        'vem_preview_path',
        'vem_fecha_emision',
        'vem_estado',
        'vem_usu_alta',
    ];

    protected $casts = [
        'vem_snapshot_json' => 'array',
    ];

    public function plantilla()
    {
        return $this->belongsTo(VoucherPlantilla::class, 'vpl_id', 'vpl_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'vou_id', 'vou_id');
    }
}