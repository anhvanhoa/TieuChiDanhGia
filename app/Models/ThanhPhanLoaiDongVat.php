<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhPhanLoaiDongVat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'thanh_phan_loai_dong_vat';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'so_nganh',
        'so_lop',
        'so_bo',
        'so_ho',
        'so_giong',
        'so_loai'
    ];

    protected $casts = [
        'so_nganh' => 'integer',
        'so_lop' => 'integer',
        'so_bo' => 'integer',
        'so_ho' => 'integer',
        'so_giong' => 'integer',
        'so_loai' => 'integer',
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
