@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chỉnh sửa vườn quốc gia</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('vuon-quoc-gia.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('vuon-quoc-gia.update', $vuonQuocGia->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ten_vuon" class="form-label">
                                            Tên vườn quốc gia
                                        </label>
                                        <input type="text" class="form-control" id="ten_vuon" name="ten_vuon"
                                            value="{{ old('ten_vuon', $vuonQuocGia->ten_vuon) }}"
                                            placeholder="Nhập tên vườn quốc gia" required>
                                        <div class="form-text">
                                            Ví dụ: Vườn quốc gia Cát Tiên, Vườn quốc gia Ba Vì...
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="loai_vuon_quoc_gia_id" class="form-label">
                                            Loại vườn quốc gia
                                        </label>
                                        <select class="form-select" id="loai_vuon_quoc_gia_id" name="loai_vuon_quoc_gia_id" required>
                                            <option value="">-- Chọn loại vườn quốc gia --</option>
                                            @foreach($loaiVuonQuocGias as $loai)
                                                <option value="{{ $loai->id }}"
                                                    {{ old('loai_vuon_quoc_gia_id', $vuonQuocGia->loai_vuon_quoc_gia_id) == $loai->id ? 'selected' : '' }}>
                                                    {{ $loai->ten_loai }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ngay_thanh_lap" class="form-label">
                                            Ngày thành lập
                                        </label>
                                        <input type="date" class="form-control" id="ngay_thanh_lap" name="ngay_thanh_lap"
                                            value="{{ old('ngay_thanh_lap', $vuonQuocGia->ngay_thanh_lap ? $vuonQuocGia->ngay_thanh_lap->format('Y-m-d') : '') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dia_chi" class="form-label">
                                            Địa chỉ
                                        </label>
                                        <input type="text" class="form-control" id="dia_chi" name="dia_chi"
                                            value="{{ old('dia_chi', $vuonQuocGia->dia_chi) }}"
                                            placeholder="Nhập địa chỉ vườn quốc gia" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="ri-save-line me-1"></i>Xác nhận
                                        </button>
                                        <a href="{{ route('vuon-quoc-gia.index') }}" class="btn btn-sm btn-danger">
                                            <i class="ri-close-line me-1"></i>Hủy
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#ten_vuon').focus().select();
        });
    </script>
@endsection
