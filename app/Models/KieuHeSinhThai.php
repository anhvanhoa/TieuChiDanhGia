<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KieuHeSinhThai extends Model
{
    use HasFactory;

    protected $table = 'kieu_he_sinh_thai';
    protected $fillable = [
        'ten_kieu'
    ];

    // Relationships
    public function dienTichKieuHeSinhThai()
    {
        return $this->hasMany(DienTichKieuHeSinhThai::class, 'kieu_he_sinh_thai_id');
    }

    public function truLuongSinhKhoiCarbon()
    {
        return $this->hasMany(TruLuongSinhKhoiCarbon::class, 'kieu_he_sinh_thai_id');
    }
}
