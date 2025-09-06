<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiDongVatNguyCap extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'loai_dong_vat_nguy_cap';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'dong_vat_id'
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
