<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiVuonQuocGia extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'loai_vuon_quoc_gia';
    protected $fillable = [
        'ten_loai'
    ];

    // Relationships
    public function vuonQuocGia()
    {
        return $this->hasMany(VuonQuocGia::class, 'loai_vuon_quoc_gia_id');
    }
}
