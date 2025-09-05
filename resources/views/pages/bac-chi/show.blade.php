@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chi tiết chi</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('bac-chi.edit', $bacChi->id) }}" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('bac-chi.index') }}" class="btn btn-sm btn-secondary">
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
                                                <td>{{ $bacChi->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên khoa học:</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-medium">{{ $bacChi->ten_khoa_hoc }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên tiếng Việt:</td>
                                                <td>{{ $bacChi->ten_tieng_viet }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Họ:</td>
                                                <td>
                                                    <span class="badge bg-danger-subtle text-danger">
                                                        {{ $bacChi->bacHo->ten_tieng_viet ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Bộ:</td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success">
                                                        {{ $bacChi->bacHo->bacBo->ten_tieng_viet ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Lớp:</td>
                                                <td>
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        {{ $bacChi->bacHo->bacBo->bacLop->ten_tieng_viet ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngành:</td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $bacChi->bacHo->bacBo->bacLop->bacNganh->ten_tieng_viet ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Phân loại:</td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info">
                                                        {{ $bacChi->bacHo->bacBo->bacLop->bacNganh->getPhanLoaiLabel($bacChi->bacHo->bacBo->bacLop->bacNganh->phan_loai) ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày tạo:</td>
                                                <td>{{ $bacChi->created_at ? $bacChi->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày cập nhật:</td>
                                                <td>{{ $bacChi->updated_at ? $bacChi->updated_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Số lượng động vật:</td>
                                                <td>{{ $bacChi->dongVat->count() }} loài</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Số lượng thực vật:</td>
                                                <td>{{ $bacChi->thucVat->count() }} loài</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Trạng thái:</td>
                                                <td>
                                                    @if($bacChi->dongVat->count() > 0 || $bacChi->thucVat->count() > 0)
                                                        <span class="badge bg-success">Đang sử dụng</span>
                                                    @else
                                                        <span class="badge bg-secondary">Chưa sử dụng</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Thống kê động vật và thực vật -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-bar-chart-line me-2"></i>Thống kê loài
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm flex-shrink-0 me-3">
                                                        <span class="avatar-title bg-danger-subtle rounded-circle">
                                                            <i class="ri-bear-smile-line text-danger"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Động vật</h6>
                                                        <p class="text-muted mb-0">{{ $bacChi->dongVat->count() }} loài</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm flex-shrink-0 me-3">
                                                        <span class="avatar-title bg-success-subtle rounded-circle">
                                                            <i class="ri-plant-line text-success"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Thực vật</h6>
                                                        <p class="text-muted mb-0">{{ $bacChi->thucVat->count() }} loài</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Danh sách động vật thuộc chi này -->
                        @if($bacChi->dongVat->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-bear-smile-line me-2"></i>Danh sách động vật thuộc chi này
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Tên khoa học</th>
                                                            <th>Tên tiếng Việt</th>
                                                            <th>Ngày tạo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($bacChi->dongVat as $index => $dongVat)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $dongVat->ten_khoa_hoc ?? 'N/A' }}</td>
                                                                <td>{{ $dongVat->ten_tieng_viet ?? 'N/A' }}</td>
                                                                <td>{{ $dongVat->created_at ? $dongVat->created_at->format('d-m-Y') : 'N/A' }}</td>
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

                        <!-- Danh sách thực vật thuộc chi này -->
                        @if($bacChi->thucVat->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-plant-line me-2"></i>Danh sách thực vật thuộc chi này
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Tên khoa học</th>
                                                            <th>Tên tiếng Việt</th>
                                                            <th>Ngày tạo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($bacChi->thucVat as $index => $thucVat)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $thucVat->ten_khoa_hoc ?? 'N/A' }}</td>
                                                                <td>{{ $thucVat->ten_tieng_viet ?? 'N/A' }}</td>
                                                                <td>{{ $thucVat->created_at ? $thucVat->created_at->format('d-m-Y') : 'N/A' }}</td>
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
