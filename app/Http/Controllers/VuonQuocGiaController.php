<?php

namespace App\Http\Controllers;

use App\Services\VuonQuocGiaService;
use App\Services\LoaiVuonQuocGiaService;
use App\Models\NamDuLieu;
use App\Models\VuonQuocGia;
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
use App\Models\ThanhPhanLoaiThucVat;
use App\Models\LoaiThucVatNguyCap;
use App\Models\PhanBoLoaiThucVat;
use App\Models\SoLuongQuanTheThucVat;
use App\Models\ApLucTacDong;
use App\Models\MucDoNghiemTrongApLuc;
use App\Models\PhamViAnhHuongApLuc;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VuonQuocGiaController extends Controller
{
    protected $vuonQuocGiaService;
    protected $loaiVuonQuocGiaService;

    public function __construct(VuonQuocGiaService $vuonQuocGiaService, LoaiVuonQuocGiaService $loaiVuonQuocGiaService)
    {
        $this->vuonQuocGiaService = $vuonQuocGiaService;
        $this->loaiVuonQuocGiaService = $loaiVuonQuocGiaService;
    }

    public function index(): View
    {
        $vuonQuocGias = $this->vuonQuocGiaService->getAll();
        $statistics = $this->vuonQuocGiaService->getStatistics();

        return view('pages.vuon-quoc-gia.index', compact('vuonQuocGias', 'statistics'));
    }

    public function create(): View
    {
        $loaiVuonQuocGias = $this->loaiVuonQuocGiaService->getAll();

        return view('pages.vuon-quoc-gia.create', compact('loaiVuonQuocGias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ten_vuon' => 'required|string|max:255',
            'dia_chi' => 'required|string|max:500',
            'ngay_thanh_lap' => 'required|date',
            'loai_vuon_quoc_gia_id' => 'required|exists:loai_vuon_quoc_gia,id'
        ], [
            'ten_vuon.required' => 'Tên vườn quốc gia không được để trống',
            'ten_vuon.max' => 'Tên vườn quốc gia không được vượt quá 255 ký tự',
            'dia_chi.required' => 'Địa chỉ không được để trống',
            'dia_chi.max' => 'Địa chỉ không được vượt quá 500 ký tự',
            'ngay_thanh_lap.required' => 'Ngày thành lập không được để trống',
            'ngay_thanh_lap.date' => 'Ngày thành lập phải là định dạng ngày hợp lệ',
            'loai_vuon_quoc_gia_id.required' => 'Loại vườn quốc gia không được để trống',
            'loai_vuon_quoc_gia_id.exists' => 'Loại vườn quốc gia không tồn tại'
        ]);

        try {
            $this->vuonQuocGiaService->create($request->only(['ten_vuon', 'dia_chi', 'ngay_thanh_lap', 'loai_vuon_quoc_gia_id']));
            return redirect()->route('vuon-quoc-gia.index')
                ->with('success', 'Thêm vườn quốc gia thành công!');
        } catch (\Exception $e) {
            // return redirect()->back()->withInput()->with('err', 'Có lỗi xảy ra khi thêm vườn quốc gia!');
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id, Request $request): View
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        return view('pages.vuon-quoc-gia.show', compact('vuonQuocGia'));
    }

    public function edit(int $id): View
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);
        $loaiVuonQuocGias = $this->loaiVuonQuocGiaService->getAll();

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        return view('pages.vuon-quoc-gia.edit', compact('vuonQuocGia', 'loaiVuonQuocGias'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'ten_vuon' => 'required|string|max:255',
            'dia_chi' => 'required|string|max:500',
            'ngay_thanh_lap' => 'required|date',
            'loai_vuon_quoc_gia_id' => 'required|exists:loai_vuon_quoc_gia,id'
        ], [
            'ten_vuon.required' => 'Tên vườn quốc gia không được để trống',
            'ten_vuon.max' => 'Tên vườn quốc gia không được vượt quá 255 ký tự',
            'dia_chi.required' => 'Địa chỉ không được để trống',
            'dia_chi.max' => 'Địa chỉ không được vượt quá 500 ký tự',
            'ngay_thanh_lap.required' => 'Ngày thành lập không được để trống',
            'ngay_thanh_lap.date' => 'Ngày thành lập phải là định dạng ngày hợp lệ',
            'loai_vuon_quoc_gia_id.required' => 'Loại vườn quốc gia không được để trống',
            'loai_vuon_quoc_gia_id.exists' => 'Loại vườn quốc gia không tồn tại'
        ]);

        try {
            $updated = $this->vuonQuocGiaService->update($id, $request->only(['ten_vuon', 'dia_chi', 'ngay_thanh_lap', 'loai_vuon_quoc_gia_id']));

            if ($updated) {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('success', 'Cập nhật vườn quốc gia thành công!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Vườn quốc gia không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('err', 'Có lỗi xảy ra khi cập nhật vườn quốc gia!');
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            if ($this->vuonQuocGiaService->isInUse($id)) {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('err', 'Không thể xóa vườn quốc gia này vì đang được sử dụng!');
            }

            $deleted = $this->vuonQuocGiaService->delete($id);

            if ($deleted) {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('success', 'Xóa vườn quốc gia thành công!');
            } else {
                return redirect()->route('vuon-quoc-gia.index')
                    ->with('err', 'Vườn quốc gia không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('vuon-quoc-gia.index')
                ->with('err', 'Có lỗi xảy ra khi xóa vườn quốc gia!');
        }
    }

    public function inputCriteria(int $id, Request $request): View
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        // Lấy danh sách năm dữ liệu
        $namDuLieus = NamDuLieu::all();

        // Lấy năm được chọn từ request
        $selectedYear = $request->get('year');

        // Nếu không có năm được chọn, lấy năm đầu tiên
        if (!$selectedYear && $namDuLieus->count() > 0) {
            $selectedYear = $namDuLieus->first()->nam;
        }

        // Lấy dữ liệu tiêu chí cho vườn quốc gia này và năm được chọn
        $criteriaData = $this->getCriteriaDataForYear($id, $selectedYear);

        return view('pages.vuon-quoc-gia.input-criteria', compact('vuonQuocGia', 'namDuLieus', 'criteriaData', 'selectedYear'));
    }

    public function storeCriteria(Request $request, int $id): RedirectResponse
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        try {
            $this->updateCriteriaData($id, $request->all());

            return redirect()->route('vuon-quoc-gia.input-criteria', $id)
                ->with('success', 'Cập nhật dữ liệu tiêu chí thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('err', 'Có lỗi xảy ra khi cập nhật dữ liệu: ' . $e->getMessage());
        }
    }

    private function getCriteriaData(int $vuonQuocGiaId): array
    {
        $data = [];

        // Lấy dữ liệu cho từng năm
        $namDuLieus = NamDuLieu::all();

        foreach ($namDuLieus as $namDuLieu) {
            $yearData = [
                'dien_tich_rung_dat_lam_nghiep' => DienTichRungDatLamNghiep::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'dien_tich_kieu_he_sinh_thai' => DienTichKieuHeSinhThai::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'dac_trung_kieu_he_sinh_thai' => DacTrungKieuHeSinhThai::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'tru_luong_sinh_khoi_carbon' => TruLuongSinhKhoiCarbon::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'cau_truc_rung' => CauTrucRung::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'tang_truong_rung' => TangTruongRung::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'tai_sinh_rung' => TaiSinhRung::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'ran_san_ho_co_bien' => RanSanHoCoBien::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'thanh_phan_loai_dong_vat' => ThanhPhanLoaiDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'loai_moi_phat_hien' => LoaiMoiPhatHien::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'loai_dong_vat_nguy_cap' => LoaiDongVatNguyCap::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'phan_bo_loai_dong_vat' => PhanBoLoaiDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'so_luong_quan_the_dong_vat' => SoLuongQuanTheDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'tan_suat_bat_gap_dong_vat' => TanSuatBatGapDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'thanh_phan_loai_thuc_vat' => ThanhPhanLoaiThucVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'loai_thuc_vat_nguy_cap' => LoaiThucVatNguyCap::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'phan_bo_loai_thuc_vat' => PhanBoLoaiThucVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'so_luong_quan_the_thuc_vat' => SoLuongQuanTheThucVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'ap_luc_tac_dong' => ApLucTacDong::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
                'muc_do_nghiem_trong_ap_luc' => MucDoNghiemTrongApLuc::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
                'pham_vi_anh_huong_ap_luc' => PhamViAnhHuongApLuc::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                    ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            ];

            $data[$namDuLieu->nam] = $yearData;
        }

        return $data;
    }

    private function getCriteriaDataForYear(int $vuonQuocGiaId, int $year): array
    {
        $namDuLieu = NamDuLieu::where('nam', $year)->first();

        if (!$namDuLieu) {
            return [];
        }

        return [
            'dien_tich_rung_dat_lam_nghiep' => DienTichRungDatLamNghiep::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'dien_tich_kieu_he_sinh_thai' => DienTichKieuHeSinhThai::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'dac_trung_kieu_he_sinh_thai' => DacTrungKieuHeSinhThai::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'tru_luong_sinh_khoi_carbon' => TruLuongSinhKhoiCarbon::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'cau_truc_rung' => CauTrucRung::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'tang_truong_rung' => TangTruongRung::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'tai_sinh_rung' => TaiSinhRung::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'ran_san_ho_co_bien' => RanSanHoCoBien::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'thanh_phan_loai_dong_vat' => ThanhPhanLoaiDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'loai_moi_phat_hien' => LoaiMoiPhatHien::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'loai_dong_vat_nguy_cap' => LoaiDongVatNguyCap::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'phan_bo_loai_dong_vat' => PhanBoLoaiDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'so_luong_quan_the_dong_vat' => SoLuongQuanTheDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'tan_suat_bat_gap_dong_vat' => TanSuatBatGapDongVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'thanh_phan_loai_thuc_vat' => ThanhPhanLoaiThucVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'loai_thuc_vat_nguy_cap' => LoaiThucVatNguyCap::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'phan_bo_loai_thuc_vat' => PhanBoLoaiThucVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'so_luong_quan_the_thuc_vat' => SoLuongQuanTheThucVat::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'ap_luc_tac_dong' => ApLucTacDong::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->get(),
            'muc_do_nghiem_trong_ap_luc' => MucDoNghiemTrongApLuc::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
            'pham_vi_anh_huong_ap_luc' => PhamViAnhHuongApLuc::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                ->where('nam_du_lieu_id', $namDuLieu->id)->first(),
        ];
    }

    private function updateCriteriaData(int $vuonQuocGiaId, array $requestData): void
    {
        foreach ($requestData as $key => $value) {
            if (strpos($key, '_') !== false) {
                $parts = explode('_', $key);

                // Tìm năm trong các phần - năm thường là số 4 chữ số
                $year = null;
                $yearIndex = -1;
                for ($i = 0; $i < count($parts); $i++) {
                    if (is_numeric($parts[$i]) && strlen($parts[$i]) == 4) {
                        $year = $parts[$i];
                        $yearIndex = $i;
                        break;
                    }
                }

                if ($year && $yearIndex >= 0) {
                    // Xác định table name và foreign key
                    $tableName = null;
                    $foreignId = null;
                    $fieldName = null;

                    // Kiểm tra xem có foreign key không (số ngay sau năm)
                    if ($yearIndex < count($parts) - 1 && is_numeric($parts[$yearIndex + 1])) {
                        $foreignId = $parts[$yearIndex + 1];
                        $tableName = implode('_', array_slice($parts, 0, $yearIndex));
                        $fieldName = implode('_', array_slice($parts, $yearIndex + 2));
                    } else {
                        $tableName = implode('_', array_slice($parts, 0, $yearIndex));
                        $fieldName = implode('_', array_slice($parts, $yearIndex + 1));
                    }

                    $modelClass = $this->getModelClass($tableName);

                    if ($modelClass) {
                        $namDuLieuId = NamDuLieu::where('nam', $year)->first()->id;

                        if ($foreignId) {
                            // Xử lý các bảng có foreign key
                            if (in_array($tableName, ['dien_tich_kieu_he_sinh_thai', 'tru_luong_sinh_khoi_carbon'])) {
                                $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                                    ->where('nam_du_lieu_id', $namDuLieuId)
                                    ->where('kieu_he_sinh_thai_id', $foreignId)
                                    ->first();
                            } elseif (in_array($tableName, ['loai_dong_vat_nguy_cap', 'phan_bo_loai_dong_vat', 'so_luong_quan_the_dong_vat', 'tan_suat_bat_gap_dong_vat'])) {
                                $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                                    ->where('nam_du_lieu_id', $namDuLieuId)
                                    ->where('dong_vat_id', $foreignId)
                                    ->first();
                            } elseif (in_array($tableName, ['loai_thuc_vat_nguy_cap', 'phan_bo_loai_thuc_vat', 'so_luong_quan_the_thuc_vat'])) {
                                $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                                    ->where('nam_du_lieu_id', $namDuLieuId)
                                    ->where('thuc_vat_id', $foreignId)
                                    ->first();
                            } elseif ($tableName === 'ap_luc_tac_dong') {
                                $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                                    ->where('nam_du_lieu_id', $namDuLieuId)
                                    ->where('loai_ap_luc_id', $foreignId)
                                    ->first();
                            }
                        } else {
                            // Xử lý các bảng không có foreign key
                            $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                                ->where('nam_du_lieu_id', $namDuLieuId)
                                ->first();
                        }

                        if ($record) {
                            $record->update([$fieldName => $value]);
                        }
                    }
                }
            }
        }
    }

    private function getModelClass(string $tableName): ?string
    {
        $modelMap = [
            'dien_tich_rung_dat_lam_nghiep' => DienTichRungDatLamNghiep::class,
            'dien_tich_kieu_he_sinh_thai' => DienTichKieuHeSinhThai::class,
            'dac_trung_kieu_he_sinh_thai' => DacTrungKieuHeSinhThai::class,
            'tru_luong_sinh_khoi_carbon' => TruLuongSinhKhoiCarbon::class,
            'cau_truc_rung' => CauTrucRung::class,
            'tang_truong_rung' => TangTruongRung::class,
            'tai_sinh_rung' => TaiSinhRung::class,
            'ran_san_ho_co_bien' => RanSanHoCoBien::class,
            'thanh_phan_loai_dong_vat' => ThanhPhanLoaiDongVat::class,
            'loai_moi_phat_hien' => LoaiMoiPhatHien::class,
            'loai_dong_vat_nguy_cap' => LoaiDongVatNguyCap::class,
            'phan_bo_loai_dong_vat' => PhanBoLoaiDongVat::class,
            'so_luong_quan_the_dong_vat' => SoLuongQuanTheDongVat::class,
            'tan_suat_bat_gap_dong_vat' => TanSuatBatGapDongVat::class,
            'thanh_phan_loai_thuc_vat' => ThanhPhanLoaiThucVat::class,
            'loai_thuc_vat_nguy_cap' => LoaiThucVatNguyCap::class,
            'phan_bo_loai_thuc_vat' => PhanBoLoaiThucVat::class,
            'so_luong_quan_the_thuc_vat' => SoLuongQuanTheThucVat::class,
            'ap_luc_tac_dong' => ApLucTacDong::class,
            'muc_do_nghiem_trong_ap_luc' => MucDoNghiemTrongApLuc::class,
            'pham_vi_anh_huong_ap_luc' => PhamViAnhHuongApLuc::class,
        ];

        return $modelMap[$tableName] ?? null;
    }

    public function exportExcel(int $id, Request $request): Response
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);
        $year = $request->get('year');

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        $criteriaData = $this->getCriteriaDataForYear($id, $year);

        // Tạo file Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Thiết lập header
        $sheet->setCellValue('A1', 'Bảng');
        $sheet->setCellValue('B1', 'Dữ liệu');
        $sheet->setCellValue('C1', 'Năm');
        $sheet->setCellValue('D1', 'Giá trị');
        $sheet->setCellValue('E1', 'Foreign ID');

        // Style cho header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '366092']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        $row = 2;

        // Diện tích rừng đất lâm nghiệp
        if ($criteriaData['dien_tich_rung_dat_lam_nghiep']) {
            $record = $criteriaData['dien_tich_rung_dat_lam_nghiep'];
            $fields = [
                'bvnn_rung_tu_nhien' => 'BVNN - Rừng tự nhiên',
                'bvnn_rung_trong' => 'BVNN - Rừng trồng',
                'bvnn_chua_co_rung' => 'BVNN - Chưa có rừng',
                'phst_rung_tu_nhien' => 'PHST - Rừng tự nhiên',
                'phst_rung_trong' => 'PHST - Rừng trồng',
                'phst_chua_co_rung' => 'PHST - Chưa có rừng',
                'dvhc_rung_tu_nhien' => 'DVHC - Rừng tự nhiên',
                'dvhc_rung_trong' => 'DVHC - Rừng trồng',
                'dvhc_chua_co_rung' => 'DVHC - Chưa có rừng'
            ];

            foreach ($fields as $field => $label) {
                $sheet->setCellValue('A' . $row, 'Diện tích rừng đất lâm nghiệp');
                $sheet->setCellValue('B' . $row, $label);
                $sheet->setCellValue('C' . $row, $year);
                $sheet->setCellValue('D' . $row, $record->$field ?? 0);
                $sheet->setCellValue('E' . $row, '');
                $row++;
            }
        }

        // Diện tích kiểu hệ sinh thái
        foreach ($criteriaData['dien_tich_kieu_he_sinh_thai'] as $record) {
            $sheet->setCellValue('A' . $row, 'Diện tích kiểu hệ sinh thái');
            $sheet->setCellValue('B' . $row, 'Diện tích');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->dien_tich ?? 0);
            $sheet->setCellValue('E' . $row, $record->kieu_he_sinh_thai_id);
            $row++;
        }

        // Trữ lượng sinh khối carbon
        foreach ($criteriaData['tru_luong_sinh_khoi_carbon'] as $record) {
            $sheet->setCellValue('A' . $row, 'Trữ lượng sinh khối carbon');
            $sheet->setCellValue('B' . $row, 'Trữ lượng');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->tru_luong ?? 0);
            $sheet->setCellValue('E' . $row, $record->kieu_he_sinh_thai_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Trữ lượng sinh khối carbon');
            $sheet->setCellValue('B' . $row, 'Sinh khối');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->sinh_khoi ?? 0);
            $sheet->setCellValue('E' . $row, $record->kieu_he_sinh_thai_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Trữ lượng sinh khối carbon');
            $sheet->setCellValue('B' . $row, 'Trữ lượng carbon');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->tru_luong_carbon ?? 0);
            $sheet->setCellValue('E' . $row, $record->kieu_he_sinh_thai_id);
            $row++;
        }

        // Thông tin mô tả
        if ($criteriaData['dac_trung_kieu_he_sinh_thai']) {
            $sheet->setCellValue('A' . $row, 'Đặc trưng kiểu hệ sinh thái');
            $sheet->setCellValue('B' . $row, 'Thông tin mô tả');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['dac_trung_kieu_he_sinh_thai']->thong_tin_mo_ta ?? '');
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        if ($criteriaData['cau_truc_rung']) {
            $sheet->setCellValue('A' . $row, 'Cấu trúc rừng');
            $sheet->setCellValue('B' . $row, 'Thông tin mô tả');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['cau_truc_rung']->thong_tin_mo_ta ?? '');
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        if ($criteriaData['tang_truong_rung']) {
            $sheet->setCellValue('A' . $row, 'Tăng trưởng rừng');
            $sheet->setCellValue('B' . $row, 'Thông tin mô tả');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['tang_truong_rung']->thong_tin_mo_ta ?? '');
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        if ($criteriaData['tai_sinh_rung']) {
            $sheet->setCellValue('A' . $row, 'Tái sinh rừng');
            $sheet->setCellValue('B' . $row, 'Thông tin mô tả');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['tai_sinh_rung']->thong_tin_mo_ta ?? '');
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        // Rạn san hô có biển
        if ($criteriaData['ran_san_ho_co_bien']) {
            $sheet->setCellValue('A' . $row, 'Rạn san hô có biển');
            $sheet->setCellValue('B' . $row, 'Diện tích rạn san hô');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['ran_san_ho_co_bien']->dien_tich_ran_san_ho ?? 0);
            $sheet->setCellValue('E' . $row, '');
            $row++;

            $sheet->setCellValue('A' . $row, 'Rạn san hô có biển');
            $sheet->setCellValue('B' . $row, 'Diện tích cỏ biển');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['ran_san_ho_co_bien']->dien_tich_co_bien ?? 0);
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        // Thành phần loài động vật
        if ($criteriaData['thanh_phan_loai_dong_vat']) {
            $record = $criteriaData['thanh_phan_loai_dong_vat'];
            $fields = [
                'so_nganh' => 'Số ngành',
                'so_lop' => 'Số lớp',
                'so_bo' => 'Số bộ',
                'so_ho' => 'Số họ',
                'so_giong' => 'Số giống',
                'so_loai' => 'Số loài'
            ];

            foreach ($fields as $field => $label) {
                $sheet->setCellValue('A' . $row, 'Thành phần loài động vật');
                $sheet->setCellValue('B' . $row, $label);
                $sheet->setCellValue('C' . $row, $year);
                $sheet->setCellValue('D' . $row, $record->$field ?? 0);
                $sheet->setCellValue('E' . $row, '');
                $row++;
            }
        }

        // Loài mới phát hiện
        if ($criteriaData['loai_moi_phat_hien']) {
            $sheet->setCellValue('A' . $row, 'Loài mới phát hiện');
            $sheet->setCellValue('B' . $row, 'Số lượng loài mới');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['loai_moi_phat_hien']->so_luong_loai_moi ?? 0);
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        // Dữ liệu động vật chi tiết
        foreach ($criteriaData['loai_dong_vat_nguy_cap'] as $record) {
            $sheet->setCellValue('A' . $row, 'Phân bố loài động vật');
            $sheet->setCellValue('B' . $row, 'Tiểu khu');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->phanBoLoaiDongVat->tieu_khu ?? '');
            $sheet->setCellValue('E' . $row, $record->dong_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Phân bố loài động vật');
            $sheet->setCellValue('B' . $row, 'Khoảnh');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->phanBoLoaiDongVat->khoanh ?? '');
            $sheet->setCellValue('E' . $row, $record->dong_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Phân bố loài động vật');
            $sheet->setCellValue('B' . $row, 'Phân khu chức năng');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->phanBoLoaiDongVat->phan_khu_chuc_nang ?? '');
            $sheet->setCellValue('E' . $row, $record->dong_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Số lượng quần thể động vật');
            $sheet->setCellValue('B' . $row, 'Số quần thể');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->soLuongQuanTheDongVat->so_quan_the ?? 0);
            $sheet->setCellValue('E' . $row, $record->dong_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Số lượng quần thể động vật');
            $sheet->setCellValue('B' . $row, 'Số cá thể');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->soLuongQuanTheDongVat->so_ca_the ?? 0);
            $sheet->setCellValue('E' . $row, $record->dong_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Tần suất bắt gặp động vật');
            $sheet->setCellValue('B' . $row, 'Khả năng bắt gặp');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->tanSuatBatGapDongVat->kha_nang_bat_gap ?? 0);
            $sheet->setCellValue('E' . $row, $record->dong_vat_id);
            $row++;
        }

        // Thành phần loài thực vật
        if ($criteriaData['thanh_phan_loai_thuc_vat']) {
            $record = $criteriaData['thanh_phan_loai_thuc_vat'];
            $fields = [
                'so_nganh' => 'Số ngành',
                'so_lop' => 'Số lớp',
                'so_bo' => 'Số bộ',
                'so_ho' => 'Số họ',
                'so_chi' => 'Số chi',
                'so_loai' => 'Số loài'
            ];

            foreach ($fields as $field => $label) {
                $sheet->setCellValue('A' . $row, 'Thành phần loài thực vật');
                $sheet->setCellValue('B' . $row, $label);
                $sheet->setCellValue('C' . $row, $year);
                $sheet->setCellValue('D' . $row, $record->$field ?? 0);
                $sheet->setCellValue('E' . $row, '');
                $row++;
            }
        }

        // Dữ liệu thực vật chi tiết
        foreach ($criteriaData['loai_thuc_vat_nguy_cap'] as $record) {
            $sheet->setCellValue('A' . $row, 'Phân bố loài thực vật');
            $sheet->setCellValue('B' . $row, 'Tiểu khu');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->phanBoLoaiThucVat->tieu_khu ?? '');
            $sheet->setCellValue('E' . $row, $record->thuc_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Phân bố loài thực vật');
            $sheet->setCellValue('B' . $row, 'Khoảnh');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->phanBoLoaiThucVat->khoanh ?? '');
            $sheet->setCellValue('E' . $row, $record->thuc_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Phân bố loài thực vật');
            $sheet->setCellValue('B' . $row, 'Phân khu chức năng');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->phanBoLoaiThucVat->phan_khu_chuc_nang ?? '');
            $sheet->setCellValue('E' . $row, $record->thuc_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Số lượng quần thể thực vật');
            $sheet->setCellValue('B' . $row, 'Số quần thể');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->soLuongQuanTheThucVat->so_quan_the ?? 0);
            $sheet->setCellValue('E' . $row, $record->thuc_vat_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Số lượng quần thể thực vật');
            $sheet->setCellValue('B' . $row, 'Số cá thể');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->soLuongQuanTheThucVat->so_ca_the ?? 0);
            $sheet->setCellValue('E' . $row, $record->thuc_vat_id);
            $row++;
        }

        // Mức độ nghiêm trọng áp lực
        if ($criteriaData['muc_do_nghiem_trong_ap_luc']) {
            $sheet->setCellValue('A' . $row, 'Mức độ nghiêm trọng áp lực');
            $sheet->setCellValue('B' . $row, 'Thông tin mô tả');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['muc_do_nghiem_trong_ap_luc']->thong_tin_mo_ta ?? '');
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        // Phạm vi ảnh hưởng áp lực
        if ($criteriaData['pham_vi_anh_huong_ap_luc']) {
            $sheet->setCellValue('A' . $row, 'Phạm vi ảnh hưởng áp lực');
            $sheet->setCellValue('B' . $row, 'Thông tin mô tả');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $criteriaData['pham_vi_anh_huong_ap_luc']->thong_tin_mo_ta ?? '');
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        // Áp lực tác động chi tiết
        foreach ($criteriaData['ap_luc_tac_dong'] as $record) {
            $sheet->setCellValue('A' . $row, 'Áp lực tác động');
            $sheet->setCellValue('B' . $row, 'Tiểu khu');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->tieu_khu ?? '');
            $sheet->setCellValue('E' . $row, $record->loai_ap_luc_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Áp lực tác động');
            $sheet->setCellValue('B' . $row, 'Khoảnh');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->khoanh ?? '');
            $sheet->setCellValue('E' . $row, $record->loai_ap_luc_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Áp lực tác động');
            $sheet->setCellValue('B' . $row, 'Phân khu chức năng');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->phan_khu_chuc_nang ?? '');
            $sheet->setCellValue('E' . $row, $record->loai_ap_luc_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Áp lực tác động');
            $sheet->setCellValue('B' . $row, 'Diện tích ảnh hưởng');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->dien_tich_anh_huong ?? 0);
            $sheet->setCellValue('E' . $row, $record->loai_ap_luc_id);
            $row++;

            $sheet->setCellValue('A' . $row, 'Áp lực tác động');
            $sheet->setCellValue('B' . $row, 'Thời gian xảy ra');
            $sheet->setCellValue('C' . $row, $year);
            $sheet->setCellValue('D' . $row, $record->thoi_gian_xay_ra ?? '');
            $sheet->setCellValue('E' . $row, $record->loai_ap_luc_id);
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Tạo file Excel
        $writer = new Xlsx($spreadsheet);

        $filename = "du_lieu_tieu_chi_{$vuonQuocGia->ten_vuon}_{$year}_" . date('Y-m-d_H-i-s') . ".xlsx";

        // Lưu vào memory
        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        return response($content)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function importExcel(int $id, Request $request): RedirectResponse
    {
        $vuonQuocGia = $this->vuonQuocGiaService->findById($id);
        $year = $request->get('year');

        if (!$vuonQuocGia) {
            abort(404, 'Vườn quốc gia không tồn tại');
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240',
            'year' => 'required|integer'
        ]);

        try {
            $file = $request->file('excel_file');
            $excelData = $this->parseExcelFile($file);

            $this->importExcelData($id, $year, $excelData);

            return redirect()->route('vuon-quoc-gia.input-criteria', ['id' => $id, 'year' => $year])
                ->with('success', 'Import dữ liệu thành công!');

        } catch (\Exception $e) {
            return redirect()->route('vuon-quoc-gia.input-criteria', ['id' => $id, 'year' => $year])
                ->with('err', 'Có lỗi xảy ra khi import: ' . $e->getMessage());
        }
    }


    private function parseExcelFile($file): array
    {
        $excelData = [];

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            // Skip header row (row 1)
            for ($row = 2; $row <= $highestRow; $row++) {
                $table = $worksheet->getCell('A' . $row)->getValue();
                $field = $worksheet->getCell('B' . $row)->getValue();
                $year = $worksheet->getCell('C' . $row)->getValue();
                $value = $worksheet->getCell('D' . $row)->getValue();
                $foreignId = $worksheet->getCell('E' . $row)->getValue();

                if ($table && $field && $year) {
                    $excelData[] = [
                        'table' => $table,
                        'field' => $field,
                        'year' => $year,
                        'value' => $value,
                        'foreign_id' => $foreignId ?: null
                    ];
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Không thể đọc file Excel: ' . $e->getMessage());
        }

        return $excelData;
    }

    private function importExcelData(int $vuonQuocGiaId, int $year, array $excelData): void
    {
        $namDuLieu = NamDuLieu::where('nam', $year)->first();

        if (!$namDuLieu) {
            throw new \Exception("Không tìm thấy dữ liệu năm {$year}");
        }

        foreach ($excelData as $row) {
            $tableName = $row['table'];
            $fieldName = $row['field'];
            $value = $row['value'];
            $foreignId = $row['foreign_id'];

            $modelClass = $this->getModelClass($tableName);

            if ($modelClass) {
                if ($foreignId) {
                    // Xử lý các bảng có foreign key
                    if (in_array($tableName, ['dien_tich_kieu_he_sinh_thai', 'tru_luong_sinh_khoi_carbon'])) {
                        $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                            ->where('nam_du_lieu_id', $namDuLieu->id)
                            ->where('kieu_he_sinh_thai_id', $foreignId)
                            ->first();
                    } elseif (in_array($tableName, ['loai_dong_vat_nguy_cap', 'phan_bo_loai_dong_vat', 'so_luong_quan_the_dong_vat', 'tan_suat_bat_gap_dong_vat'])) {
                        $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                            ->where('nam_du_lieu_id', $namDuLieu->id)
                            ->where('dong_vat_id', $foreignId)
                            ->first();
                    } elseif (in_array($tableName, ['loai_thuc_vat_nguy_cap', 'phan_bo_loai_thuc_vat', 'so_luong_quan_the_thuc_vat'])) {
                        $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                            ->where('nam_du_lieu_id', $namDuLieu->id)
                            ->where('thuc_vat_id', $foreignId)
                            ->first();
                    } elseif ($tableName === 'ap_luc_tac_dong') {
                        $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                            ->where('nam_du_lieu_id', $namDuLieu->id)
                            ->where('loai_ap_luc_id', $foreignId)
                            ->first();
                    }
                } else {
                    // Xử lý các bảng không có foreign key
                    $record = $modelClass::where('vuon_quoc_gia_id', $vuonQuocGiaId)
                        ->where('nam_du_lieu_id', $namDuLieu->id)
                        ->first();
                }

                if ($record) {
                    $record->update([$fieldName => $value]);
                }
            }
        }
    }
    }
