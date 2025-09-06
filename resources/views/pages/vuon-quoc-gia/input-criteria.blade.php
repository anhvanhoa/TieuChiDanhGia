@extends('layouts.index')

@section('header_first')
    <link href="{{ asset('plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('plugins/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Nhập dữ liệu tiêu chí - {{ $vuonQuocGia->ten_vuon }}</h4>
                            <p class="text-muted mb-0">Cập nhật dữ liệu tiêu chí đánh giá cho vườn quốc gia</p>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('vuon-quoc-gia.index') }}"
                                class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="ri-check-line me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('err'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="ri-error-warning-line me-2"></i>{{ session('err') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                         <!-- Year Selection and Excel Actions -->
                         <div class="row mb-4">
                             <div class="col-md-3">
                                 <label class="form-label">Chọn năm dữ liệu</label>
                                 <select class="form-control" id="yearSelect" onchange="changeYear()">
                                     @foreach($namDuLieus as $namDuLieu)
                                         <option value="{{ $namDuLieu->nam }}" {{ $selectedYear == $namDuLieu->nam ? 'selected' : '' }}>
                                             Năm {{ $namDuLieu->nam }}
                                         </option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-5 d-flex align-items-end">
                                 <div class="alert alert-info mb-0">
                                     <i class="ri-information-line me-2"></i>
                                     Đang nhập dữ liệu cho <strong>năm {{ $selectedYear }}</strong>
                                 </div>
                             </div>
                             <div class="col-md-4 d-flex align-items-end gap-2 justify-content-end">
                                 <a href="{{ route('vuon-quoc-gia.export-excel', ['id' => $vuonQuocGia->id, 'year' => $selectedYear]) }}"
                                    class="btn btn-success btn-sm">
                                     <i class="ri-download-line me-1"></i>Export Excel
                                 </a>
                                 <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                                     <i class="ri-upload-line me-1"></i>Import Excel
                                 </button>
                             </div>
                         </div>

                        <form action="{{ route('vuon-quoc-gia.store-criteria', $vuonQuocGia->id) }}" method="POST"
                            id="criteriaForm">
                            @csrf

                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs nav-justified mb-4" id="criteriaTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="forest-tab" data-bs-toggle="tab"
                                        data-bs-target="#forest" type="button" role="tab">
                                        <i class="ri-tree-line me-1"></i>Rừng & Hệ sinh thái
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="animals-tab" data-bs-toggle="tab" data-bs-target="#animals"
                                        type="button" role="tab">
                                        <i class="ri-bear-smile-line me-1"></i>Động vật
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="plants-tab" data-bs-toggle="tab" data-bs-target="#plants"
                                        type="button" role="tab">
                                        <i class="ri-plant-line me-1"></i>Thực vật
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pressure-tab" data-bs-toggle="tab"
                                        data-bs-target="#pressure" type="button" role="tab">
                                        <i class="ri-alarm-warning-line me-1"></i>Áp lực tác động
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="criteriaTabsContent">
                                <!-- Forest & Ecosystem Tab -->
                                <div class="tab-pane fade show active" id="forest" role="tabpanel">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-calendar-line me-2"></i>Năm {{ $selectedYear }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Diện tích rừng đất lâm nghiệp -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-tree-line me-2"></i>Diện tích rừng đất lâm nghiệp (ha)
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">BVNN - Rừng tự nhiên</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_bvnn_rung_tu_nhien"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->bvnn_rung_tu_nhien ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">BVNN - Rừng trồng</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_bvnn_rung_trong"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->bvnn_rung_trong ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">BVNN - Chưa có rừng</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_bvnn_chua_co_rung"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->bvnn_chua_co_rung ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PHST - Rừng tự nhiên</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_phst_rung_tu_nhien"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->phst_rung_tu_nhien ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PHST - Rừng trồng</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_phst_rung_trong"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->phst_rung_trong ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PHST - Chưa có rừng</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_phst_chua_co_rung"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->phst_chua_co_rung ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">DVHC - Rừng tự nhiên</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_dvhc_rung_tu_nhien"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->dvhc_rung_tu_nhien ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">DVHC - Rừng trồng</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_dvhc_rung_trong"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->dvhc_rung_trong ?? 0 }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">DVHC - Chưa có rừng</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="dien_tich_rung_dat_lam_nghiep_{{ $selectedYear }}_dvhc_chua_co_rung"
                                                        value="{{ $criteriaData['dien_tich_rung_dat_lam_nghiep']->dvhc_chua_co_rung ?? 0 }}">
                                                </div>
                                            </div>

                                            <!-- Diện tích kiểu hệ sinh thái -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-leaf-line me-2"></i>Diện tích kiểu hệ sinh thái (ha)
                                                    </h6>
                                                </div>
                                                @foreach($criteriaData['dien_tich_kieu_he_sinh_thai'] as $dienTichKieuHeSinhThai)
                                                    <div class="col-md-6 mb-3">
                                                        <label
                                                            class="form-label">{{ $dienTichKieuHeSinhThai->kieuHeSinhThai->ten_kieu ?? 'Kiểu hệ sinh thái' }}</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="dien_tich_kieu_he_sinh_thai_{{ $selectedYear }}_{{ $dienTichKieuHeSinhThai->kieu_he_sinh_thai_id }}_dien_tich"
                                                            value="{{ $dienTichKieuHeSinhThai->dien_tich ?? 0 }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Trữ lượng sinh khối carbon -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-plant-line me-2"></i>Trữ lượng sinh khối carbon
                                                    </h6>
                                                </div>
                                                @foreach($criteriaData['tru_luong_sinh_khoi_carbon'] as $truLuongSinhKhoiCarbon)
                                                    <div class="col-md-4 mb-3">
                                                        <label
                                                            class="form-label">{{ $truLuongSinhKhoiCarbon->kieuHeSinhThai->ten_kieu ?? 'Kiểu hệ sinh thái' }}
                                                            - Trữ lượng</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="tru_luong_sinh_khoi_carbon_{{ $selectedYear }}_{{ $truLuongSinhKhoiCarbon->kieu_he_sinh_thai_id }}_tru_luong"
                                                            value="{{ $truLuongSinhKhoiCarbon->tru_luong ?? 0 }}">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label
                                                            class="form-label">{{ $truLuongSinhKhoiCarbon->kieuHeSinhThai->ten_kieu ?? 'Kiểu hệ sinh thái' }}
                                                            - Sinh khối</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="tru_luong_sinh_khoi_carbon_{{ $selectedYear }}_{{ $truLuongSinhKhoiCarbon->kieu_he_sinh_thai_id }}_sinh_khoi"
                                                            value="{{ $truLuongSinhKhoiCarbon->sinh_khoi ?? 0 }}">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label
                                                            class="form-label">{{ $truLuongSinhKhoiCarbon->kieuHeSinhThai->ten_kieu ?? 'Kiểu hệ sinh thái' }}
                                                            - Trữ lượng carbon</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="tru_luong_sinh_khoi_carbon_{{ $selectedYear }}_{{ $truLuongSinhKhoiCarbon->kieu_he_sinh_thai_id }}_tru_luong_carbon"
                                                            value="{{ $truLuongSinhKhoiCarbon->tru_luong_carbon ?? 0 }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Đặc trưng kiểu hệ sinh thái -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-file-text-line me-2"></i>Thông tin mô tả
                                                    </h6>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Đặc trưng kiểu hệ sinh thái</label>
                                                    <textarea class="form-control" rows="3"
                                                        name="dac_trung_kieu_he_sinh_thai_{{ $selectedYear }}_thong_tin_mo_ta">{{ $criteriaData['dac_trung_kieu_he_sinh_thai']->thong_tin_mo_ta ?? '' }}</textarea>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Cấu trúc rừng</label>
                                                    <textarea class="form-control" rows="3"
                                                        name="cau_truc_rung_{{ $selectedYear }}_thong_tin_mo_ta">{{ $criteriaData['cau_truc_rung']->thong_tin_mo_ta ?? '' }}</textarea>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Tăng trưởng rừng</label>
                                                    <textarea class="form-control" rows="3"
                                                        name="tang_truong_rung_{{ $selectedYear }}_thong_tin_mo_ta">{{ $criteriaData['tang_truong_rung']->thong_tin_mo_ta ?? '' }}</textarea>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Tái sinh rừng</label>
                                                    <textarea class="form-control" rows="3"
                                                        name="tai_sinh_rung_{{ $selectedYear }}_thong_tin_mo_ta">{{ $criteriaData['tai_sinh_rung']->thong_tin_mo_ta ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Rạn san hô có biển -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-ocean-line me-2"></i>Rạn san hô có biển (ha)
                                                    </h6>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Diện tích rạn san hô</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="ran_san_ho_co_bien_{{ $selectedYear }}_dien_tich_ran_san_ho"
                                                        value="{{ $criteriaData['ran_san_ho_co_bien']->dien_tich_ran_san_ho ?? 0 }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Diện tích cỏ biển</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="ran_san_ho_co_bien_{{ $selectedYear }}_dien_tich_co_bien"
                                                        value="{{ $criteriaData['ran_san_ho_co_bien']->dien_tich_co_bien ?? 0 }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Animals Tab -->
                                <div class="tab-pane fade" id="animals" role="tabpanel">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-calendar-line me-2"></i>Năm {{ $selectedYear }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Thành phần loài động vật -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-bear-smile-line me-2"></i>Thành phần loài động vật
                                                    </h6>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số ngành</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_dong_vat_{{ $selectedYear }}_so_nganh"
                                                        value="{{ $criteriaData['thanh_phan_loai_dong_vat']->so_nganh ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số lớp</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_dong_vat_{{ $selectedYear }}_so_lop"
                                                        value="{{ $criteriaData['thanh_phan_loai_dong_vat']->so_lop ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số bộ</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_dong_vat_{{ $selectedYear }}_so_bo"
                                                        value="{{ $criteriaData['thanh_phan_loai_dong_vat']->so_bo ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số họ</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_dong_vat_{{ $selectedYear }}_so_ho"
                                                        value="{{ $criteriaData['thanh_phan_loai_dong_vat']->so_ho ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số giống</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_dong_vat_{{ $selectedYear }}_so_giong"
                                                        value="{{ $criteriaData['thanh_phan_loai_dong_vat']->so_giong ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số loài</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_dong_vat_{{ $selectedYear }}_so_loai"
                                                        value="{{ $criteriaData['thanh_phan_loai_dong_vat']->so_loai ?? 0 }}">
                                                </div>
                                            </div>

                                            <!-- Loài mới phát hiện -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-add-circle-line me-2"></i>Loài mới phát hiện
                                                    </h6>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Số lượng loài mới phát hiện</label>
                                                    <input type="number" class="form-control"
                                                        name="loai_moi_phat_hien_{{ $selectedYear }}_so_luong_loai_moi"
                                                        value="{{ $criteriaData['loai_moi_phat_hien']->so_luong_loai_moi ?? 0 }}">
                                                </div>
                                            </div>

                                            <!-- Dữ liệu động vật chi tiết -->
                                            @if($criteriaData['loai_dong_vat_nguy_cap']->count() > 0)
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <h6 class="text-primary mb-3">
                                                            <i class="ri-alarm-warning-line me-2"></i>Loài động vật nguy cấp
                                                        </h6>
                                                    </div>
                                                    @foreach($criteriaData['loai_dong_vat_nguy_cap'] as $loaiDongVatNguyCap)
                                                        <div class="col-12 mb-3">
                                                            <div class="card border-warning">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-warning">
                                                                        {{ $loaiDongVatNguyCap->dongVat->ten_tieng_viet ?? 'Động vật' }}
                                                                        <small
                                                                            class="text-muted">({{ $loaiDongVatNguyCap->dongVat->ten_khoa_hoc ?? 'Tên khoa học' }})</small>
                                                                    </h6>
                                                                    <div class="row">
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Tiểu khu</label>
                                                                            <input type="text" class="form-control"
                                                                                name="phan_bo_loai_dong_vat_{{ $selectedYear }}_{{ $loaiDongVatNguyCap->dong_vat_id }}_tieu_khu"
                                                                                value="{{ $criteriaData['phan_bo_loai_dong_vat']->where('dong_vat_id', $loaiDongVatNguyCap->dong_vat_id)->first()->tieu_khu ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Khoảnh</label>
                                                                            <input type="text" class="form-control"
                                                                                name="phan_bo_loai_dong_vat_{{ $selectedYear }}_{{ $loaiDongVatNguyCap->dong_vat_id }}_khoanh"
                                                                                value="{{ $criteriaData['phan_bo_loai_dong_vat']->where('dong_vat_id', $loaiDongVatNguyCap->dong_vat_id)->first()->khoanh ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Phân khu chức năng</label>
                                                                            <input type="text" class="form-control"
                                                                                name="phan_bo_loai_dong_vat_{{ $selectedYear }}_{{ $loaiDongVatNguyCap->dong_vat_id }}_phan_khu_chuc_nang"
                                                                                value="{{ $criteriaData['phan_bo_loai_dong_vat']->where('dong_vat_id', $loaiDongVatNguyCap->dong_vat_id)->first()->phan_khu_chuc_nang ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-2">
                                                                            <label class="form-label">Số quần thể</label>
                                                                            <input type="number" class="form-control"
                                                                                name="so_luong_quan_the_dong_vat_{{ $selectedYear }}_{{ $loaiDongVatNguyCap->dong_vat_id }}_so_quan_the"
                                                                                value="{{ $criteriaData['so_luong_quan_the_dong_vat']->where('dong_vat_id', $loaiDongVatNguyCap->dong_vat_id)->first()->so_quan_the ?? 0 }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-2">
                                                                            <label class="form-label">Số cá thể</label>
                                                                            <input type="number" class="form-control"
                                                                                name="so_luong_quan_the_dong_vat_{{ $selectedYear }}_{{ $loaiDongVatNguyCap->dong_vat_id }}_so_ca_the"
                                                                                value="{{ $criteriaData['so_luong_quan_the_dong_vat']->where('dong_vat_id', $loaiDongVatNguyCap->dong_vat_id)->first()->so_ca_the ?? 0 }}">
                                                                        </div>
                                                                        <div class="col-md-12 mb-2">
                                                                            <label class="form-label">Khả năng bắt gặp</label>
                                                                            <input type="number" class="form-control"
                                                                                name="tan_suat_bat_gap_dong_vat_{{ $selectedYear }}_{{ $loaiDongVatNguyCap->dong_vat_id }}_kha_nang_bat_gap"
                                                                                value="{{ $criteriaData['tan_suat_bat_gap_dong_vat']->where('dong_vat_id', $loaiDongVatNguyCap->dong_vat_id)->first()->kha_nang_bat_gap ?? 0 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Plants Tab -->
                                <div class="tab-pane fade" id="plants" role="tabpanel">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-calendar-line me-2"></i>Năm {{ $selectedYear }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Thành phần loài thực vật -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-plant-line me-2"></i>Thành phần loài thực vật
                                                    </h6>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số ngành</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_thuc_vat_{{ $selectedYear }}_so_nganh"
                                                        value="{{ $criteriaData['thanh_phan_loai_thuc_vat']->so_nganh ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số lớp</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_thuc_vat_{{ $selectedYear }}_so_lop"
                                                        value="{{ $criteriaData['thanh_phan_loai_thuc_vat']->so_lop ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số bộ</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_thuc_vat_{{ $selectedYear }}_so_bo"
                                                        value="{{ $criteriaData['thanh_phan_loai_thuc_vat']->so_bo ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số họ</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_thuc_vat_{{ $selectedYear }}_so_ho"
                                                        value="{{ $criteriaData['thanh_phan_loai_thuc_vat']->so_ho ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số chi</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_thuc_vat_{{ $selectedYear }}_so_chi"
                                                        value="{{ $criteriaData['thanh_phan_loai_thuc_vat']->so_chi ?? 0 }}">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Số loài</label>
                                                    <input type="number" class="form-control"
                                                        name="thanh_phan_loai_thuc_vat_{{ $selectedYear }}_so_loai"
                                                        value="{{ $criteriaData['thanh_phan_loai_thuc_vat']->so_loai ?? 0 }}">
                                                </div>
                                            </div>

                                            <!-- Dữ liệu thực vật chi tiết -->
                                            @if($criteriaData['loai_thuc_vat_nguy_cap']->count() > 0)
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <h6 class="text-primary mb-3">
                                                            <i class="ri-alarm-warning-line me-2"></i>Loài thực vật nguy cấp
                                                        </h6>
                                                    </div>
                                                    @foreach($criteriaData['loai_thuc_vat_nguy_cap'] as $loaiThucVatNguyCap)
                                                        <div class="col-12 mb-3">
                                                            <div class="card border-warning">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-warning">
                                                                        {{ $loaiThucVatNguyCap->thucVat->ten_tieng_viet ?? 'Thực vật' }}
                                                                        <small
                                                                            class="text-muted">({{ $loaiThucVatNguyCap->thucVat->ten_khoa_hoc ?? 'Tên khoa học' }})</small>
                                                                    </h6>
                                                                    <div class="row">
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Tiểu khu</label>
                                                                            <input type="text" class="form-control"
                                                                                name="phan_bo_loai_thuc_vat_{{ $selectedYear }}_{{ $loaiThucVatNguyCap->thuc_vat_id }}_tieu_khu"
                                                                                value="{{ $criteriaData['phan_bo_loai_thuc_vat']->where('thuc_vat_id', $loaiThucVatNguyCap->thuc_vat_id)->first()->tieu_khu ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Khoảnh</label>
                                                                            <input type="text" class="form-control"
                                                                                name="phan_bo_loai_thuc_vat_{{ $selectedYear }}_{{ $loaiThucVatNguyCap->thuc_vat_id }}_khoanh"
                                                                                value="{{ $criteriaData['phan_bo_loai_thuc_vat']->where('thuc_vat_id', $loaiThucVatNguyCap->thuc_vat_id)->first()->khoanh ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Phân khu chức năng</label>
                                                                            <input type="text" class="form-control"
                                                                                name="phan_bo_loai_thuc_vat_{{ $selectedYear }}_{{ $loaiThucVatNguyCap->thuc_vat_id }}_phan_khu_chuc_nang"
                                                                                value="{{ $criteriaData['phan_bo_loai_thuc_vat']->where('thuc_vat_id', $loaiThucVatNguyCap->thuc_vat_id)->first()->phan_khu_chuc_nang ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-2">
                                                                            <label class="form-label">Số quần thể</label>
                                                                            <input type="number" class="form-control"
                                                                                name="so_luong_quan_the_thuc_vat_{{ $selectedYear }}_{{ $loaiThucVatNguyCap->thuc_vat_id }}_so_quan_the"
                                                                                value="{{ $criteriaData['so_luong_quan_the_thuc_vat']->where('thuc_vat_id', $loaiThucVatNguyCap->thuc_vat_id)->first()->so_quan_the ?? 0 }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-2">
                                                                            <label class="form-label">Số cá thể</label>
                                                                            <input type="number" class="form-control"
                                                                                name="so_luong_quan_the_thuc_vat_{{ $selectedYear }}_{{ $loaiThucVatNguyCap->thuc_vat_id }}_so_ca_the"
                                                                                value="{{ $criteriaData['so_luong_quan_the_thuc_vat']->where('thuc_vat_id', $loaiThucVatNguyCap->thuc_vat_id)->first()->so_ca_the ?? 0 }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Pressure Tab -->
                                <div class="tab-pane fade" id="pressure" role="tabpanel">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-calendar-line me-2"></i>Năm {{ $selectedYear }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Mức độ nghiêm trọng áp lực -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-alarm-warning-line me-2"></i>Mức độ nghiêm trọng áp lực
                                                    </h6>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Thông tin mô tả mức độ nghiêm trọng áp
                                                        lực</label>
                                                    <textarea class="form-control" rows="3"
                                                        name="muc_do_nghiem_trong_ap_luc_{{ $selectedYear }}_thong_tin_mo_ta">{{ $criteriaData['muc_do_nghiem_trong_ap_luc']->thong_tin_mo_ta ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Phạm vi ảnh hưởng áp lực -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="ri-map-pin-line me-2"></i>Phạm vi ảnh hưởng áp lực
                                                    </h6>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Thông tin mô tả phạm vi ảnh hưởng áp
                                                        lực</label>
                                                    <textarea class="form-control" rows="3"
                                                        name="pham_vi_anh_huong_ap_luc_{{ $selectedYear }}_thong_tin_mo_ta">{{ $criteriaData['pham_vi_anh_huong_ap_luc']->thong_tin_mo_ta ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Áp lực tác động chi tiết -->
                                            @if($criteriaData['ap_luc_tac_dong']->count() > 0)
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <h6 class="text-primary mb-3">
                                                            <i class="ri-alarm-warning-line me-2"></i>Áp lực tác động chi tiết
                                                        </h6>
                                                    </div>
                                                    @foreach($criteriaData['ap_luc_tac_dong'] as $apLucTacDong)
                                                        <div class="col-12 mb-3">
                                                            <div class="card border-danger">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-danger">
                                                                        {{ $apLucTacDong->loaiApLuc->ten_ap_luc ?? 'Loại áp lực' }}
                                                                    </h6>
                                                                    <div class="row">
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Tiểu khu</label>
                                                                            <input type="text" class="form-control"
                                                                                name="ap_luc_tac_dong_{{ $selectedYear }}_{{ $apLucTacDong->loai_ap_luc_id }}_tieu_khu"
                                                                                value="{{ $apLucTacDong->tieu_khu ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Khoảnh</label>
                                                                            <input type="text" class="form-control"
                                                                                name="ap_luc_tac_dong_{{ $selectedYear }}_{{ $apLucTacDong->loai_ap_luc_id }}_khoanh"
                                                                                value="{{ $apLucTacDong->khoanh ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-4 mb-2">
                                                                            <label class="form-label">Phân khu chức năng</label>
                                                                            <input type="text" class="form-control"
                                                                                name="ap_luc_tac_dong_{{ $selectedYear }}_{{ $apLucTacDong->loai_ap_luc_id }}_phan_khu_chuc_nang"
                                                                                value="{{ $apLucTacDong->phan_khu_chuc_nang ?? '' }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-2">
                                                                            <label class="form-label">Diện tích ảnh hưởng
                                                                                (ha)</label>
                                                                            <input type="number" step="0.01" class="form-control"
                                                                                name="ap_luc_tac_dong_{{ $selectedYear }}_{{ $apLucTacDong->loai_ap_luc_id }}_dien_tich_anh_huong"
                                                                                value="{{ $apLucTacDong->dien_tich_anh_huong ?? 0 }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-2">
                                                                            <label class="form-label">Thời gian xảy ra</label>
                                                                            <input type="text" class="form-control"
                                                                                name="ap_luc_tac_dong_{{ $selectedYear }}_{{ $apLucTacDong->loai_ap_luc_id }}_thoi_gian_xay_ra"
                                                                                value="{{ $apLucTacDong->thoi_gian_xay_ra ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('vuon-quoc-gia.index') }}" class="btn btn-outline-secondary">
                                    <i class="ri-close-line me-1"></i>Hủy
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i>Lưu dữ liệu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>
     </div>

     <!-- Import Excel Modal -->
     <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="importExcelModalLabel">
                         <i class="ri-upload-line me-2"></i>Import dữ liệu từ Excel
                     </h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <form action="{{ route('vuon-quoc-gia.import-excel', $vuonQuocGia->id) }}" method="POST" enctype="multipart/form-data" id="importExcelForm">
                     @csrf
                     <div class="modal-body">
                         <div class="mb-3">
                             <label class="form-label">Chọn năm dữ liệu</label>
                             <select class="form-control" name="year" required>
                                 @foreach($namDuLieus as $namDuLieu)
                                     <option value="{{ $namDuLieu->nam }}" {{ $selectedYear == $namDuLieu->nam ? 'selected' : '' }}>
                                         Năm {{ $namDuLieu->nam }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="mb-3">
                             <label class="form-label">Chọn file Excel</label>
                             <input type="file" class="form-control" name="excel_file" accept=".xlsx,.xls" required>
                             <div class="form-text">
                                 <i class="ri-information-line me-1"></i>
                                 Chỉ chấp nhận file Excel (.xlsx, .xls).
                                 <a href="{{ route('vuon-quoc-gia.export-excel', ['id' => $vuonQuocGia->id, 'year' => $selectedYear]) }}" class="text-primary">
                                     Tải template mẫu
                                 </a>
                             </div>
                         </div>
                         <div class="alert alert-warning">
                             <i class="ri-alarm-warning-line me-2"></i>
                             <strong>Lưu ý:</strong> Dữ liệu cũ sẽ bị ghi đè hoàn toàn. Hãy backup dữ liệu trước khi import.
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                             <i class="ri-close-line me-1"></i>Hủy
                         </button>
                         <button type="submit" class="btn btn-primary">
                             <i class="ri-upload-line me-1"></i>Import dữ liệu
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            initSumoSelect($('#yearSelect'));
        });

        // Year selection function
        function changeYear() {
            const selectedYear = $('#yearSelect').val();
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('year', selectedYear);
            window.location.href = currentUrl.toString();
        }

         // Form validation
         $('#criteriaForm').on('submit', function (e) {
             e.preventDefault();

             // Show loading
             const submitBtn = $(this).find('button[type="submit"]');
             const originalText = submitBtn.html();
             submitBtn.html('<i class="ri-loader-4-line me-1"></i>Đang lưu...');
             submitBtn.prop('disabled', true);

             // Submit form
             this.submit();
         });

         // Import Excel form validation
         $('#importExcelForm').on('submit', function (e) {
             e.preventDefault();

             // Show loading
             const submitBtn = $(this).find('button[type="submit"]');
             const originalText = submitBtn.html();
             submitBtn.html('<i class="ri-loader-4-line me-1"></i>Đang import...');
             submitBtn.prop('disabled', true);

             // Submit form
             this.submit();
         });
    </script>
@endsection
