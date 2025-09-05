<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DongVat extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'dong_vat';
    protected $fillable = [
        'bac_chi_id',
        'ten_khoa_hoc',
        'ten_tieng_viet',
        'ten_tac_gia',
        'hinh_thai',
        'sinh_thai',
        'dac_huu',
        'gia_tri',
        'sach_do',
        'iucn',
        'nd_84',
        'nguon'
    ];

    // Relationships
    public function bacChi()
    {
        return $this->belongsTo(BacChi::class, 'bac_chi_id');
    }

    public function dongVatAnh()
    {
        return $this->hasMany(DongVatAnh::class, 'dong_vat_id');
    }

    public function loaiDongVatNguyCap()
    {
        return $this->hasMany(LoaiDongVatNguyCap::class, 'dong_vat_id');
    }

    public function phanBoLoaiDongVat()
    {
        return $this->hasMany(PhanBoLoaiDongVat::class, 'dong_vat_id');
    }

    public function soLuongQuanTheDongVat()
    {
        return $this->hasMany(SoLuongQuanTheDongVat::class, 'dong_vat_id');
    }

    public function tanSuatBatGapDongVat()
    {
        return $this->hasMany(TanSuatBatGapDongVat::class, 'dong_vat_id');
    }
}
