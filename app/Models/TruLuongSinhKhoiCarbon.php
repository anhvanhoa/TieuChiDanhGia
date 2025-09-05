<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruLuongSinhKhoiCarbon extends Model
{
    use HasFactory;

    protected $table = 'tru_luong_sinh_khoi_carbon';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'kieu_he_sinh_thai_id',
        'tru_luong',
        'sinh_khoi',
        'tru_luong_carbon'
    ];

    protected $casts = [
        'tru_luong' => 'decimal:2',
        'sinh_khoi' => 'decimal:2',
        'tru_luong_carbon' => 'decimal:2',
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
