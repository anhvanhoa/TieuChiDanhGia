<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoLuongQuanTheDongVat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'so_luong_quan_the_dong_vat';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'dong_vat_id',
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

    public function dongVat()
    {
        return $this->belongsTo(DongVat::class, 'dong_vat_id');
    }
}
