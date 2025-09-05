<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiMoiPhatHien extends Model
{
    use HasFactory;

    protected $table = 'loai_moi_phat_hien';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'so_luong_loai_moi'
    ];

    protected $casts = [
        'so_luong_loai_moi' => 'integer',
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
