<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanBoLoaiThucVat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'phan_bo_loai_thuc_vat';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'thuc_vat_id',
        'tieu_khu',
        'khoanh',
        'phan_khu_chuc_nang'
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

    public function thucVat()
    {
        return $this->belongsTo(ThucVat::class, 'thuc_vat_id');
    }
}
