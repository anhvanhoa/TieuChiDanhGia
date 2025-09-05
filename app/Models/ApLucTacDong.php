<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApLucTacDong extends Model
{
    use HasFactory;

    protected $table = 'ap_luc_tac_dong';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'loai_ap_luc_id',
        'tieu_khu',
        'khoanh',
        'phan_khu_chuc_nang',
        'dien_tich_anh_huong',
        'thoi_gian_xay_ra'
    ];

    protected $casts = [
        'dien_tich_anh_huong' => 'decimal:2',
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

    public function loaiApLuc()
    {
        return $this->belongsTo(LoaiApLuc::class, 'loai_ap_luc_id');
    }
}
