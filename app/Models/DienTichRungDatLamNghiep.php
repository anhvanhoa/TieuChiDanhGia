<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DienTichRungDatLamNghiep extends Model
{
    use HasFactory;

    protected $table = 'dien_tich_rung_dat_lam_nghiep';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'bvnn_rung_tu_nhien',
        'bvnn_rung_trong',
        'bvnn_chua_co_rung',
        'phst_rung_tu_nhien',
        'phst_rung_trong',
        'phst_chua_co_rung',
        'dvhc_rung_tu_nhien',
        'dvhc_rung_trong',
        'dvhc_chua_co_rung'
    ];

    protected $casts = [
        'bvnn_rung_tu_nhien' => 'decimal:2',
        'bvnn_rung_trong' => 'decimal:2',
        'bvnn_chua_co_rung' => 'decimal:2',
        'phst_rung_tu_nhien' => 'decimal:2',
        'phst_rung_trong' => 'decimal:2',
        'phst_chua_co_rung' => 'decimal:2',
        'dvhc_rung_tu_nhien' => 'decimal:2',
        'dvhc_rung_trong' => 'decimal:2',
        'dvhc_chua_co_rung' => 'decimal:2',
    ];

    // Relationships
    public function vuonQuocGia()
    {
        return $this->belongsTo(VuonQuocGia::class, 'vuon_quoc_gia_id');
    }

    public function namDuLieu()
    {
        return $this->belongsTo(NamDuLieu::class, 'nam_du_lieu_id');
    }
}
