<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoLuongQuanTheThucVat extends Model
{
    use HasFactory;

    protected $table = 'so_luong_quan_the_thuc_vat';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'thuc_vat_id',
        'so_quan_the',
        'so_ca_the'
    ];

    protected $casts = [
        'so_quan_the' => 'integer',
        'so_ca_the' => 'integer',
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
