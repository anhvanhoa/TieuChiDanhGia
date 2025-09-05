@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chi tiết vườn quốc gia</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('vuon-quoc-gia.edit', $vuonQuocGia->id) }}" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('vuon-quoc-gia.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-semibold" style="width: 200px;">ID:</td>
                                                <td>{{ $vuonQuocGia->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên vườn quốc gia:</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-medium">{{ $vuonQuocGia->ten_vuon }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Loại vườn quốc gia:</td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $vuonQuocGia->loaiVuonQuocGia->ten_loai ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Địa chỉ:</td>
                                                <td>{{ $vuonQuocGia->dia_chi }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày thành lập:</td>
                                                <td>{{ $vuonQuocGia->ngay_thanh_lap ? $vuonQuocGia->ngay_thanh_lap->format('d-m-Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày tạo:</td>
                                                <td>{{ $vuonQuocGia->created_at ? $vuonQuocGia->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày cập nhật:</td>
                                                <td>{{ $vuonQuocGia->updated_at ? $vuonQuocGia->updated_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin thống kê -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-bar-chart-line me-2"></i>Thống kê dữ liệu
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm flex-shrink-0 me-3">
                                                        <span class="avatar-title bg-success-subtle rounded-circle">
                                                            <i class="ri-user-line text-success"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Người dùng</h6>
                                                        <p class="text-muted mb-0">{{ $vuonQuocGia->users->count() }} người</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm flex-shrink-0 me-3">
                                                        <span class="avatar-title bg-warning-subtle rounded-circle">
                                                            <i class="ri-alert-line text-warning"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Áp lực tác động</h6>
                                                        <p class="text-muted mb-0">{{ $vuonQuocGia->apLucTacDong->count() }} bản ghi</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm flex-shrink-0 me-3">
                                                        <span class="avatar-title bg-info-subtle rounded-circle">
                                                            <i class="ri-plant-line text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Thực vật</h6>
                                                        <p class="text-muted mb-0">{{ $vuonQuocGia->phanBoLoaiThucVat->count() }} loài</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm flex-shrink-0 me-3">
                                                        <span class="avatar-title bg-danger-subtle rounded-circle">
                                                            <i class="ri-bear-smile-line text-danger"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Động vật</h6>
                                                        <p class="text-muted mb-0">{{ $vuonQuocGia->phanBoLoaiDongVat->count() }} loài</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Danh sách người dùng -->
                        @if($vuonQuocGia->users->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-user-line me-2"></i>Danh sách người dùng
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Tên người dùng</th>
                                                            <th>Email</th>
                                                            <th>Ngày tạo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($vuonQuocGia->users as $index => $user)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $user->name ?? 'N/A' }}</td>
                                                                <td>{{ $user->email ?? 'N/A' }}</td>
                                                                <td>{{ $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Auto refresh page every 30 seconds to show updated data
            // setInterval(function() {
            //     location.reload();
            // }, 30000);
        });
    </script>
@endsection
