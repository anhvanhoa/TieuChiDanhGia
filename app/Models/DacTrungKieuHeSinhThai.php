<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DacTrungKieuHeSinhThai extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'dac_trung_kieu_he_sinh_thai';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'thong_tin_mo_ta',
        'tep_dinh_kem'
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
