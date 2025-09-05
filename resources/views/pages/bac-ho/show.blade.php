@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chi tiết họ</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('bac-ho.edit', $bacHo->id) }}" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('bac-ho.index') }}" class="btn btn-sm btn-secondary">
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
                                                <td>{{ $bacHo->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên khoa học:</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-medium">{{ $bacHo->ten_khoa_hoc }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên tiếng Việt:</td>
                                                <td>{{ $bacHo->ten_tieng_viet }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Bộ:</td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success">
                                                        {{ $bacHo->bacBo->ten_tieng_viet ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Lớp:</td>
                                                <td>
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        {{ $bacHo->bacBo->bacLop->ten_tieng_viet ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngành:</td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ $bacHo->bacBo->bacLop->bacNganh->ten_tieng_viet ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Phân loại:</td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info">
                                                        {{ $bacHo->bacBo->bacLop->bacNganh->getPhanLoaiLabel($bacHo->bacBo->bacLop->bacNganh->phan_loai) ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày tạo:</td>
                                                <td>{{ $bacHo->created_at ? $bacHo->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày cập nhật:</td>
                                                <td>{{ $bacHo->updated_at ? $bacHo->updated_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Số lượng chi:</td>
                                                <td>{{ $bacHo->bacChi->count() }} chi</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Trạng thái:</td>
                                                <td>
                                                    @if($bacHo->bacChi->count() > 0)
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

                        <!-- Danh sách chi thuộc họ này -->
                        @if($bacHo->bacChi->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-list-check me-2"></i>Danh sách chi thuộc họ này
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
                                                        @foreach($bacHo->bacChi as $index => $bacChi)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $bacChi->ten_khoa_hoc ?? 'N/A' }}</td>
                                                                <td>{{ $bacChi->ten_tieng_viet ?? 'N/A' }}</td>
                                                                <td>{{ $bacChi->created_at ? $bacChi->created_at->format('d-m-Y') : 'N/A' }}</td>
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
