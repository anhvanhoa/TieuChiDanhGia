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
                            <h4 class="header-title">Danh sách bộ</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('bac-bo.create') }}" class="btn btn-sm btn-primary rounded-pill">
                                <i class="ri-add-line me-1"></i>Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover dt-responsive nowrap w-100 fixed-header-datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khoa học</th>
                                    <th>Tên tiếng Việt</th>
                                    <th>Lớp</th>
                                    <th>Ngành</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="body_data">
                                @forelse($bacBos as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h5 class="fs-14 mt-1 mb-0">{{ $item->ten_khoa_hoc }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->ten_tieng_viet }}</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning">
                                                {{ $item->bacLop->ten_tieng_viet ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary">
                                                {{ $item->bacLop->bacNganh->ten_tieng_viet ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                        <td>
                                            <div class="hstack gap-2 fs-15 justify-content-center">
                                                <a href="{{ route('bac-bo.show', $item->id) }}"
                                                    data-toggle="tooltip" data-bs-custom-class="tooltip-info"
                                                    data-bs-placement="bottom" data-bs-original-title="Xem chi tiết"
                                                    class="btn btn-icon btn-sm btn-outline-info rounded-pill"
                                                    aria-label="Xem chi tiết">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('bac-bo.edit', $item->id) }}"
                                                    data-toggle="tooltip" data-bs-custom-class="tooltip-warning"
                                                    data-bs-placement="bottom" data-bs-original-title="Cập nhật"
                                                    class="btn btn-icon btn-sm btn-outline-warning rounded-pill"
                                                    aria-label="Cập nhật">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a href="#" data-toggle="tooltip" data-bs-custom-class="tooltip-danger"
                                                    data-bs-placement="bottom" data-bs-original-title="Xóa"
                                                    data-bs-href="{{ route('bac-bo.destroy', $item->id) }}"
                                                    data-bs-toggle="modal" data-bs-target="#confirm_delete"
                                                    class="btn btn-icon btn-sm btn-outline-danger rounded-pill"
                                                    aria-label="Xóa">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="py-4">
                                                <i class="ri-plant-line fs-48 text-muted"></i>
                                                <p class="text-muted mt-2">Không có dữ liệu</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
        var a = $('.fixed-header-datatable');
        $(document).ready(function () {
            createDataTable(a);
        });
    </script>
@endsection
