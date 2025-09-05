<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThucVat extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'thuc_vat';
    protected $fillable = [
        'bac_chi_id',
        'ten_khoa_hoc',
        'ten_tieng_viet',
        'ten_tac_gia',
        'than_canh',
        'la',
        'phan_bo_viet_nam',
        'phan_bo_the_gioi',
        'hoa_qua',
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

    public function thucVatAnh()
    {
        return $this->hasMany(ThucVatAnh::class, 'thuc_vat_id');
    }

    public function loaiThucVatNguyCap()
    {
        return $this->hasMany(LoaiThucVatNguyCap::class, 'thuc_vat_id');
    }

    public function phanBoLoaiThucVat()
    {
        return $this->hasMany(PhanBoLoaiThucVat::class, 'thuc_vat_id');
    }

    public function soLuongQuanTheThucVat()
    {
        return $this->hasMany(SoLuongQuanTheThucVat::class, 'thuc_vat_id');
    }
}
