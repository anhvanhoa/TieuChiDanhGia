<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanSuatBatGapDongVat extends Model
{
    use HasFactory;

    protected $table = 'tan_suat_bat_gap_dong_vat';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'dong_vat_id',
        'kha_nang_bat_gap'
    ];

    protected $casts = [
        'kha_nang_bat_gap' => 'integer',
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

    public function dongVat()
    {
        return $this->belongsTo(DongVat::class, 'dong_vat_id');
    }
}
