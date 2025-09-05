<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamDuLieu extends Model
{
    use HasFactory;

    protected $table = 'nam_du_lieu';
    protected $fillable = [
        'nam',
        'trang_thai'
    ];

    protected $casts = [
        'nam' => 'integer',
    ];

    // Relationships
    public function apLucTacDong()
    {
        return $this->hasMany(ApLucTacDong::class, 'nam_du_lieu_id');
    }

    public function cauTrucRung()
    {
        return $this->hasMany(CauTrucRung::class, 'nam_du_lieu_id');
    }

    public function dacTrungKieuHeSinhThai()
    {
        return $this->hasMany(DacTrungKieuHeSinhThai::class, 'nam_du_lieu_id');
    }

    public function dienTichKieuHeSinhThai()
    {
        return $this->hasMany(DienTichKieuHeSinhThai::class, 'nam_du_lieu_id');
    }

    public function dienTichRungDatLamNghiep()
    {
        return $this->hasMany(DienTichRungDatLamNghiep::class, 'nam_du_lieu_id');
    }

    public function loaiDongVatNguyCap()
    {
        return $this->hasMany(LoaiDongVatNguyCap::class, 'nam_du_lieu_id');
    }

    public function loaiMoiPhatHien()
    {
        return $this->hasMany(LoaiMoiPhatHien::class, 'nam_du_lieu_id');
    }

    public function loaiThucVatNguyCap()
    {
        return $this->hasMany(LoaiThucVatNguyCap::class, 'nam_du_lieu_id');
    }

    public function mucDoNghiemTrongApLuc()
    {
        return $this->hasMany(MucDoNghiemTrongApLuc::class, 'nam_du_lieu_id');
    }

    public function phamViAnhHuongApLuc()
    {
        return $this->hasMany(PhamViAnhHuongApLuc::class, 'nam_du_lieu_id');
    }

    public function phanBoLoaiDongVat()
    {
        return $this->hasMany(PhanBoLoaiDongVat::class, 'nam_du_lieu_id');
    }

    public function phanBoLoaiThucVat()
    {
        return $this->hasMany(PhanBoLoaiThucVat::class, 'nam_du_lieu_id');
    }

    public function ranSanHoCoBien()
    {
        return $this->hasMany(RanSanHoCoBien::class, 'nam_du_lieu_id');
    }

    public function soLuongQuanTheDongVat()
    {
        return $this->hasMany(SoLuongQuanTheDongVat::class, 'nam_du_lieu_id');
    }

    public function soLuongQuanTheThucVat()
    {
        return $this->hasMany(SoLuongQuanTheThucVat::class, 'nam_du_lieu_id');
    }

    public function taiSinhRung()
    {
        return $this->hasMany(TaiSinhRung::class, 'nam_du_lieu_id');
    }

    public function tanSuatBatGapDongVat()
    {
        return $this->hasMany(TanSuatBatGapDongVat::class, 'nam_du_lieu_id');
    }

    public function tangTruongRung()
    {
        return $this->hasMany(TangTruongRung::class, 'nam_du_lieu_id');
    }

    public function thanhPhanLoaiDongVat()
    {
        return $this->hasMany(ThanhPhanLoaiDongVat::class, 'nam_du_lieu_id');
    }

    public function thanhPhanLoaiThucVat()
    {
        return $this->hasMany(ThanhPhanLoaiThucVat::class, 'nam_du_lieu_id');
    }

    public function truLuongSinhKhoiCarbon()
    {
        return $this->hasMany(TruLuongSinhKhoiCarbon::class, 'nam_du_lieu_id');
    }
}
