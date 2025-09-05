<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RanSanHoCoBien extends Model
{
    use HasFactory;

    protected $table = 'ran_san_ho_co_bien';
    protected $fillable = [
        'vuon_quoc_gia_id',
        'nam_du_lieu_id',
        'dien_tich_ran_san_ho',
        'dien_tich_co_bien'
    ];

    protected $casts = [
        'dien_tich_ran_san_ho' => 'decimal:2',
        'dien_tich_co_bien' => 'decimal:2',
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
