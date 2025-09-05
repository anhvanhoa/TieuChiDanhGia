@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chi tiết ngành</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('bac-nganh.edit', $bacNganh->id) }}" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('bac-nganh.index') }}" class="btn btn-sm btn-secondary">
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
                                                <td>{{ $bacNganh->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên khoa học:</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-medium">{{ $bacNganh->ten_khoa_hoc }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên tiếng Việt:</td>
                                                <td>{{ $bacNganh->ten_tieng_viet }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Phân loại:</td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info">
                                                        {{ $bacNganh->getPhanLoaiLabel($bacNganh->phan_loai) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày tạo:</td>
                                                <td>{{ $bacNganh->created_at ? $bacNganh->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày cập nhật:</td>
                                                <td>{{ $bacNganh->updated_at ? $bacNganh->updated_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Số lượng lớp:</td>
                                                <td>{{ $bacNganh->bacLop->count() }} lớp</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Trạng thái:</td>
                                                <td>
                                                    @if($bacNganh->bacLop->count() > 0)
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

                        <!-- Danh sách lớp thuộc ngành này -->
                        @if($bacNganh->bacLop->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-list-check me-2"></i>Danh sách lớp thuộc ngành này
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
                                                        @foreach($bacNganh->bacLop as $index => $bacLop)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $bacLop->ten_khoa_hoc ?? 'N/A' }}</td>
                                                                <td>{{ $bacLop->ten_tieng_viet ?? 'N/A' }}</td>
                                                                <td>{{ $bacLop->created_at ? $bacLop->created_at->format('d-m-Y') : 'N/A' }}</td>
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
