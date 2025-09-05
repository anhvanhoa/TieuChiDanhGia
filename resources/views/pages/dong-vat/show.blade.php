@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chi tiết động vật</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('dong-vat.edit', $dongVat->id) }}" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('dong-vat.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên khoa học:</label>
                                    <p class="form-control-plaintext">{{ $dongVat->ten_khoa_hoc }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên tiếng Việt:</label>
                                    <p class="form-control-plaintext">{{ $dongVat->ten_tieng_viet }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên tác giả:</label>
                                    <p class="form-control-plaintext">{{ $dongVat->ten_tac_gia ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Chi:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $dongVat->bacChi->ten_tieng_viet ?? 'N/A' }}
                                            ({{ $dongVat->bacChi->ten_khoa_hoc ?? 'N/A' }})
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Họ:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-danger-subtle text-danger">
                                            {{ $dongVat->bacChi->bacHo->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bộ:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-success-subtle text-success">
                                            {{ $dongVat->bacChi->bacHo->bacBo->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Lớp:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-warning-subtle text-warning">
                                            {{ $dongVat->bacChi->bacHo->bacBo->bacLop->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ngành:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $dongVat->bacChi->bacHo->bacBo->bacLop->bacNganh->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sách đỏ:</label>
                                    <p class="form-control-plaintext">
                                        @if($dongVat->sach_do)
                                            <span class="badge bg-danger-subtle text-danger">{{ $dongVat->sach_do }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">IUCN:</label>
                                    <p class="form-control-plaintext">
                                        @if($dongVat->iucn)
                                            <span class="badge bg-warning-subtle text-warning">{{ $dongVat->iucn }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Đặc hữu:</label>
                                    <p class="form-control-plaintext">
                                        @if($dongVat->dac_huu)
                                            <span class="badge bg-success-subtle text-success">{{ $dongVat->dac_huu }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">NĐ 84:</label>
                                    <p class="form-control-plaintext">{{ $dongVat->nd_84 ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ngày tạo:</label>
                                    <p class="form-control-plaintext">{{ $dongVat->created_at ? $dongVat->created_at->format('d-m-Y H:i:s') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($dongVat->hinh_thai)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Hình thái:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $dongVat->hinh_thai }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($dongVat->sinh_thai)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sinh thái:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $dongVat->sinh_thai }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($dongVat->gia_tri)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Giá trị:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $dongVat->gia_tri }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($dongVat->nguon)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nguồn:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $dongVat->nguon }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Hình ảnh -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Hình ảnh</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset($image->duong_dan_thumb) }}" class="img-fluid img-thumbnail" alt="Hình ảnh">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
