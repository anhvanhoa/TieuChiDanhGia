@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chi tiết loại vườn quốc gia</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('loai-vuon-quoc-gia.edit', $loaiVuonQuocGia->id) }}" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('loai-vuon-quoc-gia.index') }}" class="btn btn-sm btn-secondary">
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
                                                <td>{{ $loaiVuonQuocGia->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Tên loại vườn quốc gia:</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-medium">{{ $loaiVuonQuocGia->ten_loai }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày tạo:</td>
                                                <td>{{ $loaiVuonQuocGia->created_at ? $loaiVuonQuocGia->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Ngày cập nhật:</td>
                                                <td>{{ $loaiVuonQuocGia->updated_at ? $loaiVuonQuocGia->updated_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Số lượng vườn quốc gia:</td>
                                                <td>{{ $loaiVuonQuocGia->vuonQuocGia->count() }} vườn</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Trạng thái:</td>
                                                <td>
                                                    @if($loaiVuonQuocGia->vuonQuocGia->count() > 0)
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
                        <!-- Danh sách vườn quốc gia thuộc loại này -->
                        @if($loaiVuonQuocGia->vuonQuocGia->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-list-check me-2"></i>Danh sách vườn quốc gia thuộc loại này
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Tên vườn quốc gia</th>
                                                            <th>Ngày tạo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($loaiVuonQuocGia->vuonQuocGia as $index => $vuon)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $vuon->ten_vuon ?? 'N/A' }}</td>
                                                                <td>{{ $vuon->created_at ? $vuon->created_at->format('d-m-Y') : 'N/A' }}</td>
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
