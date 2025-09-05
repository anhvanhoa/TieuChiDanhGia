<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DienTichKieuHeSinhThai extends Model
{
    use HasFactory;

    protected $table = 'dien_tich_kieu_he_sinh_thai';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'kieu_he_sinh_thai_id',
        'dien_tich'
    ];

    protected $casts = [
        'dien_tich' => 'decimal:2',
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

    public function kieuHeSinhThai()
    {
        return $this->belongsTo(KieuHeSinhThai::class, 'kieu_he_sinh_thai_id');
    }
}
