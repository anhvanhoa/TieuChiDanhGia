<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VuonQuocGia extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'vuon_quoc_gia';
    protected $fillable = [
        'ten_vuon',
        'dia_chi',
        'ngay_thanh_lap',
        'loai_vuon_quoc_gia_id'
    ];

    protected $casts = [
        'ngay_thanh_lap' => 'date',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function loaiVuonQuocGia()
    {
        return $this->belongsTo(LoaiVuonQuocGia::class, 'loai_vuon_quoc_gia_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'vuon_quoc_gia_id');
    }

    public function apLucTacDong()
    {
        return $this->hasMany(ApLucTacDong::class, 'vuon_quoc_gia_id');
    }

    public function cauTrucRung()
    {
        return $this->hasMany(CauTrucRung::class, 'vuon_quoc_gia_id');
    }

    public function dacTrungKieuHeSinhThai()
    {
        return $this->hasMany(DacTrungKieuHeSinhThai::class, 'vuon_quoc_gia_id');
    }

    public function dienTichKieuHeSinhThai()
    {
        return $this->hasMany(DienTichKieuHeSinhThai::class, 'vuon_quoc_gia_id');
    }

    public function dienTichRungDatLamNghiep()
    {
        return $this->hasMany(DienTichRungDatLamNghiep::class, 'vuon_quoc_gia_id');
    }

    public function loaiDongVatNguyCap()
    {
        return $this->hasMany(LoaiDongVatNguyCap::class, 'vuon_quoc_gia_id');
    }

    public function loaiMoiPhatHien()
    {
        return $this->hasMany(LoaiMoiPhatHien::class, 'vuon_quoc_gia_id');
    }

    public function loaiThucVatNguyCap()
    {
        return $this->hasMany(LoaiThucVatNguyCap::class, 'vuon_quoc_gia_id');
    }

    public function mucDoNghiemTrongApLuc()
    {
        return $this->hasMany(MucDoNghiemTrongApLuc::class, 'vuon_quoc_gia_id');
    }

    public function phamViAnhHuongApLuc()
    {
        return $this->hasMany(PhamViAnhHuongApLuc::class, 'vuon_quoc_gia_id');
    }

    public function phanBoLoaiDongVat()
    {
        return $this->hasMany(PhanBoLoaiDongVat::class, 'vuon_quoc_gia_id');
    }

    public function phanBoLoaiThucVat()
    {
        return $this->hasMany(PhanBoLoaiThucVat::class, 'vuon_quoc_gia_id');
    }

    public function ranSanHoCoBien()
    {
        return $this->hasMany(RanSanHoCoBien::class, 'vuon_quoc_gia_id');
    }

    public function soLuongQuanTheDongVat()
    {
        return $this->hasMany(SoLuongQuanTheDongVat::class, 'vuon_quoc_gia_id');
    }

    public function soLuongQuanTheThucVat()
    {
        return $this->hasMany(SoLuongQuanTheThucVat::class, 'vuon_quoc_gia_id');
    }

    public function taiSinhRung()
    {
        return $this->hasMany(TaiSinhRung::class, 'vuon_quoc_gia_id');
    }

    public function tanSuatBatGapDongVat()
    {
        return $this->hasMany(TanSuatBatGapDongVat::class, 'vuon_quoc_gia_id');
    }

    public function tangTruongRung()
    {
        return $this->hasMany(TangTruongRung::class, 'vuon_quoc_gia_id');
    }

    public function thanhPhanLoaiDongVat()
    {
        return $this->hasMany(ThanhPhanLoaiDongVat::class, 'vuon_quoc_gia_id');
    }

    public function thanhPhanLoaiThucVat()
    {
        return $this->hasMany(ThanhPhanLoaiThucVat::class, 'vuon_quoc_gia_id');
    }

    public function truLuongSinhKhoiCarbon()
    {
        return $this->hasMany(TruLuongSinhKhoiCarbon::class, 'vuon_quoc_gia_id');
    }
}
