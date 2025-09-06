<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NamDuLieu;
use App\Models\VuonQuocGia;
use App\Models\KieuHeSinhThai;
use App\Models\DienTichRungDatLamNghiep;
use App\Models\DienTichKieuHeSinhThai;
use App\Models\DacTrungKieuHeSinhThai;
use App\Models\TruLuongSinhKhoiCarbon;
use App\Models\CauTrucRung;
use App\Models\TangTruongRung;
use App\Models\TaiSinhRung;
use App\Models\RanSanHoCoBien;
use App\Models\ThanhPhanLoaiDongVat;
use App\Models\LoaiDongVatNguyCap;
use App\Models\PhanBoLoaiDongVat;
use App\Models\SoLuongQuanTheDongVat;
use App\Models\TanSuatBatGapDongVat;
use App\Models\LoaiMoiPhatHien;
use App\Models\DongVat;
use App\Models\ThanhPhanLoaiThucVat;
use App\Models\LoaiThucVatNguyCap;
use App\Models\PhanBoLoaiThucVat;
use App\Models\SoLuongQuanTheThucVat;
use App\Models\ThucVat;
use App\Models\ApLucTacDong;
use App\Models\MucDoNghiemTrongApLuc;
use App\Models\PhamViAnhHuongApLuc;
use App\Models\LoaiApLuc;

class CreateYearlyRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:yearly-records {--year= : Năm cụ thể để tạo bản ghi (nếu không có sẽ tạo cho tất cả năm)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo bản ghi mới cho các bảng theo năm từ bảng NamDuLieu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Bắt đầu tạo bản ghi theo năm...');

        // Lấy năm từ option hoặc tất cả năm
        $specificYear = $this->option('year');

        if ($specificYear) {
            $namDuLieus = NamDuLieu::where('nam', $specificYear)->get();
            if ($namDuLieus->isEmpty()) {
                $this->error("Không tìm thấy năm {$specificYear} trong bảng NamDuLieu");
                return 1;
            }
        } else {
            $namDuLieus = NamDuLieu::all();
        }

        if ($namDuLieus->isEmpty()) {
            $this->error('Không có dữ liệu năm nào trong bảng NamDuLieu');
            return 1;
        }

        // Lấy danh sách vườn quốc gia
        $vuonQuocGias = VuonQuocGia::all();
        if ($vuonQuocGias->isEmpty()) {
            $this->error('Không có dữ liệu vườn quốc gia nào');
            return 1;
        }

        // Lấy danh sách kiểu hệ sinh thái
        $kieuHeSinhThais = KieuHeSinhThai::all();

        // Lấy danh sách động vật
        $dongVats = DongVat::all();

        // Lấy danh sách thực vật
        $thucVats = ThucVat::all();

        // Lấy danh sách loại áp lực
        $loaiApLucs = LoaiApLuc::all();

        $totalCreated = 0;

        foreach ($namDuLieus as $namDuLieu) {
            $this->info("Đang xử lý năm: {$namDuLieu->nam}");

            foreach ($vuonQuocGias as $vuonQuocGia) {
                $created = $this->createRecordsForYearAndPark($namDuLieu, $vuonQuocGia, $kieuHeSinhThais, $dongVats, $thucVats, $loaiApLucs);
                $totalCreated += $created;
            }
        }

        $this->info("Hoàn thành! Đã tạo {$totalCreated} bản ghi mới.");
        return 0;
    }

    /**
     * Tạo bản ghi cho một năm và vườn quốc gia cụ thể
     */
    private function createRecordsForYearAndPark($namDuLieu, $vuonQuocGia, $kieuHeSinhThais, $dongVats, $thucVats, $loaiApLucs)
    {
        $created = 0;

        // 1. DienTichRungDatLamNghiep
        if (!$this->recordExists(DienTichRungDatLamNghiep::class, $vuonQuocGia->id, $namDuLieu->id)) {
            DienTichRungDatLamNghiep::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'bvnn_rung_tu_nhien' => 0,
                'bvnn_rung_trong' => 0,
                'bvnn_chua_co_rung' => 0,
                'phst_rung_tu_nhien' => 0,
                'phst_rung_trong' => 0,
                'phst_chua_co_rung' => 0,
                'dvhc_rung_tu_nhien' => 0,
                'dvhc_rung_trong' => 0,
                'dvhc_chua_co_rung' => 0,
            ]);
            $created++;
        }

        // 2. DacTrungKieuHeSinhThai
        if (!$this->recordExists(DacTrungKieuHeSinhThai::class, $vuonQuocGia->id, $namDuLieu->id)) {
            DacTrungKieuHeSinhThai::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'thong_tin_mo_ta' => '',
                'tep_dinh_kem' => '',
            ]);
            $created++;
        }

        // 3. CauTrucRung
        if (!$this->recordExists(CauTrucRung::class, $vuonQuocGia->id, $namDuLieu->id)) {
            CauTrucRung::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'thong_tin_mo_ta' => '',
                'tep_dinh_kem' => '',
            ]);
            $created++;
        }

        // 4. TangTruongRung
        if (!$this->recordExists(TangTruongRung::class, $vuonQuocGia->id, $namDuLieu->id)) {
            TangTruongRung::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'thong_tin_mo_ta' => '',
                'tep_dinh_kem' => '',
            ]);
            $created++;
        }

        // 5. TaiSinhRung
        if (!$this->recordExists(TaiSinhRung::class, $vuonQuocGia->id, $namDuLieu->id)) {
            TaiSinhRung::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'thong_tin_mo_ta' => '',
                'tep_dinh_kem' => '',
            ]);
            $created++;
        }

        // 6. RanSanHoCoBien
        if (!$this->recordExists(RanSanHoCoBien::class, $vuonQuocGia->id, $namDuLieu->id)) {
            RanSanHoCoBien::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'dien_tich_ran_san_ho' => 0,
                'dien_tich_co_bien' => 0,
            ]);
            $created++;
        }

        // 7. DienTichKieuHeSinhThai (cần tạo cho từng kiểu hệ sinh thái)
        foreach ($kieuHeSinhThais as $kieuHeSinhThai) {
            if (!$this->recordExistsWithEcosystem(DienTichKieuHeSinhThai::class, $vuonQuocGia->id, $namDuLieu->id, $kieuHeSinhThai->id)) {
                DienTichKieuHeSinhThai::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'kieu_he_sinh_thai_id' => $kieuHeSinhThai->id,
                    'dien_tich' => 0,
                ]);
                $created++;
            }
        }

        // 8. TruLuongSinhKhoiCarbon (cần tạo cho từng kiểu hệ sinh thái)
        foreach ($kieuHeSinhThais as $kieuHeSinhThai) {
            if (!$this->recordExistsWithEcosystem(TruLuongSinhKhoiCarbon::class, $vuonQuocGia->id, $namDuLieu->id, $kieuHeSinhThai->id)) {
                TruLuongSinhKhoiCarbon::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'kieu_he_sinh_thai_id' => $kieuHeSinhThai->id,
                    'tru_luong' => 0,
                    'sinh_khoi' => 0,
                    'tru_luong_carbon' => 0,
                ]);
                $created++;
            }
        }

        // 9. ThanhPhanLoaiDongVat
        if (!$this->recordExists(ThanhPhanLoaiDongVat::class, $vuonQuocGia->id, $namDuLieu->id)) {
            ThanhPhanLoaiDongVat::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'so_nganh' => 0,
                'so_lop' => 0,
                'so_bo' => 0,
                'so_ho' => 0,
                'so_giong' => 0,
                'so_loai' => 0,
            ]);
            $created++;
        }

        // 10. LoaiMoiPhatHien
        if (!$this->recordExists(LoaiMoiPhatHien::class, $vuonQuocGia->id, $namDuLieu->id)) {
            LoaiMoiPhatHien::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'so_luong_loai_moi' => 0,
            ]);
            $created++;
        }

        // 11. LoaiDongVatNguyCap (cần tạo cho từng động vật)
        foreach ($dongVats as $dongVat) {
            if (!$this->recordExistsWithAnimal(LoaiDongVatNguyCap::class, $vuonQuocGia->id, $namDuLieu->id, $dongVat->id)) {
                LoaiDongVatNguyCap::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'dong_vat_id' => $dongVat->id,
                ]);
                $created++;
            }
        }

        // 12. PhanBoLoaiDongVat (cần tạo cho từng động vật)
        foreach ($dongVats as $dongVat) {
            if (!$this->recordExistsWithAnimal(PhanBoLoaiDongVat::class, $vuonQuocGia->id, $namDuLieu->id, $dongVat->id)) {
                PhanBoLoaiDongVat::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'dong_vat_id' => $dongVat->id,
                    'tieu_khu' => '',
                    'khoanh' => '',
                    'phan_khu_chuc_nang' => '',
                ]);
                $created++;
            }
        }

        // 13. SoLuongQuanTheDongVat (cần tạo cho từng động vật)
        foreach ($dongVats as $dongVat) {
            if (!$this->recordExistsWithAnimal(SoLuongQuanTheDongVat::class, $vuonQuocGia->id, $namDuLieu->id, $dongVat->id)) {
                SoLuongQuanTheDongVat::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'dong_vat_id' => $dongVat->id,
                    'so_quan_the' => 0,
                    'so_ca_the' => 0,
                ]);
                $created++;
            }
        }

        // 14. TanSuatBatGapDongVat (cần tạo cho từng động vật)
        foreach ($dongVats as $dongVat) {
            if (!$this->recordExistsWithAnimal(TanSuatBatGapDongVat::class, $vuonQuocGia->id, $namDuLieu->id, $dongVat->id)) {
                TanSuatBatGapDongVat::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'dong_vat_id' => $dongVat->id,
                    'kha_nang_bat_gap' => 0,
                ]);
                $created++;
            }
        }

        // 15. ThanhPhanLoaiThucVat
        if (!$this->recordExists(ThanhPhanLoaiThucVat::class, $vuonQuocGia->id, $namDuLieu->id)) {
            ThanhPhanLoaiThucVat::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'so_nganh' => 0,
                'so_lop' => 0,
                'so_bo' => 0,
                'so_ho' => 0,
                'so_chi' => 0,
                'so_loai' => 0,
            ]);
            $created++;
        }

        // 16. LoaiThucVatNguyCap (cần tạo cho từng thực vật)
        foreach ($thucVats as $thucVat) {
            if (!$this->recordExistsWithPlant(LoaiThucVatNguyCap::class, $vuonQuocGia->id, $namDuLieu->id, $thucVat->id)) {
                LoaiThucVatNguyCap::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'thuc_vat_id' => $thucVat->id,
                ]);
                $created++;
            }
        }

        // 17. PhanBoLoaiThucVat (cần tạo cho từng thực vật)
        foreach ($thucVats as $thucVat) {
            if (!$this->recordExistsWithPlant(PhanBoLoaiThucVat::class, $vuonQuocGia->id, $namDuLieu->id, $thucVat->id)) {
                PhanBoLoaiThucVat::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'thuc_vat_id' => $thucVat->id,
                    'tieu_khu' => '',
                    'khoanh' => '',
                    'phan_khu_chuc_nang' => '',
                ]);
                $created++;
            }
        }

        // 18. SoLuongQuanTheThucVat (cần tạo cho từng thực vật)
        foreach ($thucVats as $thucVat) {
            if (!$this->recordExistsWithPlant(SoLuongQuanTheThucVat::class, $vuonQuocGia->id, $namDuLieu->id, $thucVat->id)) {
                SoLuongQuanTheThucVat::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'thuc_vat_id' => $thucVat->id,
                    'so_quan_the' => 0,
                    'so_ca_the' => 0,
                ]);
                $created++;
            }
        }

        // 19. MucDoNghiemTrongApLuc
        if (!$this->recordExists(MucDoNghiemTrongApLuc::class, $vuonQuocGia->id, $namDuLieu->id)) {
            MucDoNghiemTrongApLuc::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'thong_tin_mo_ta' => '',
                'tep_dinh_kem' => '',
            ]);
            $created++;
        }

        // 20. PhamViAnhHuongApLuc
        if (!$this->recordExists(PhamViAnhHuongApLuc::class, $vuonQuocGia->id, $namDuLieu->id)) {
            PhamViAnhHuongApLuc::create([
                'vuon_quoc_gia_id' => $vuonQuocGia->id,
                'nam_du_lieu_id' => $namDuLieu->id,
                'thong_tin_mo_ta' => '',
                'tep_dinh_kem' => '',
            ]);
            $created++;
        }

        // 21. ApLucTacDong (cần tạo cho từng loại áp lực)
        foreach ($loaiApLucs as $loaiApLuc) {
            if (!$this->recordExistsWithPressure(ApLucTacDong::class, $vuonQuocGia->id, $namDuLieu->id, $loaiApLuc->id)) {
                ApLucTacDong::create([
                    'vuon_quoc_gia_id' => $vuonQuocGia->id,
                    'nam_du_lieu_id' => $namDuLieu->id,
                    'loai_ap_luc_id' => $loaiApLuc->id,
                    'tieu_khu' => '',
                    'khoanh' => '',
                    'phan_khu_chuc_nang' => '',
                    'dien_tich_anh_huong' => 0,
                    'thoi_gian_xay_ra' => '',
                ]);
                $created++;
            }
        }

        return $created;
    }

    /**
     * Kiểm tra bản ghi đã tồn tại chưa (cho các bảng không có kieu_he_sinh_thai_id)
     */
    private function recordExists($modelClass, $vuonQuocGiaId, $namDuLieuId)
    {
        return $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
            ->where('nam_du_lieu_id', $namDuLieuId)
            ->exists();
    }

    /**
     * Kiểm tra bản ghi đã tồn tại chưa (cho các bảng có kieu_he_sinh_thai_id)
     */
    private function recordExistsWithEcosystem($modelClass, $vuonQuocGiaId, $namDuLieuId, $kieuHeSinhThaiId)
    {
        return $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
            ->where('nam_du_lieu_id', $namDuLieuId)
            ->where('kieu_he_sinh_thai_id', $kieuHeSinhThaiId)
            ->exists();
    }

    /**
     * Kiểm tra bản ghi đã tồn tại chưa (cho các bảng có dong_vat_id)
     */
    private function recordExistsWithAnimal($modelClass, $vuonQuocGiaId, $namDuLieuId, $dongVatId)
    {
        return $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                         ->where('nam_du_lieu_id', $namDuLieuId)
                         ->where('dong_vat_id', $dongVatId)
                         ->exists();
    }

    /**
     * Kiểm tra bản ghi đã tồn tại chưa (cho các bảng có thuc_vat_id)
     */
    private function recordExistsWithPlant($modelClass, $vuonQuocGiaId, $namDuLieuId, $thucVatId)
    {
        return $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                         ->where('nam_du_lieu_id', $namDuLieuId)
                         ->where('thuc_vat_id', $thucVatId)
                         ->exists();
    }

    /**
     * Kiểm tra bản ghi đã tồn tại chưa (cho các bảng có loai_ap_luc_id)
     */
    private function recordExistsWithPressure($modelClass, $vuonQuocGiaId, $namDuLieuId, $loaiApLucId)
    {
        return $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                         ->where('nam_du_lieu_id', $namDuLieuId)
                         ->where('loai_ap_luc_id', $loaiApLucId)
                         ->exists();
    }
}
