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
                            <h4 class="header-title">Danh sách động vật</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('dong-vat.create') }}" class="btn btn-sm btn-primary rounded-pill">
                                <i class="ri-add-line me-1"></i>Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover dt-responsive nowrap w-100 fixed-header-datatable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Tên tác giả</th>
                                    <th>Cấp bậc</th>
                                    <th>Cấp độ bảo tồn</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="body_data">
                                @forelse($dongVats as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div>
                                                <p class="fs-14 mt-1 mb-0">
                                                    Vn: {{ $item->ten_khoa_hoc }}
                                                </p>
                                                <p class="fs-14 mt-1 mb-0">
                                                    Latin: {{ $item->ten_tieng_viet }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>{{ $item->ten_tac_gia ?? 'N/A' }}</td>
                                        <td style="max-width: 300px;">
                                            <div  class="d-flex flex-wrap gap-2">
                                                <span class="badge bg-info-subtle text-info">
                                                    Chi: {{ $item->bacChi->ten_tieng_viet ?? 'N/A' }}
                                                </span>
                                                <span class="badge bg-danger-subtle text-danger">
                                                    Họ: {{ $item->bacChi->bacHo->ten_tieng_viet ?? 'N/A' }}
                                                </span>
                                                <span class="badge bg-success-subtle text-success">
                                                    Bộ: {{ $item->bacChi->bacHo->bacBo->ten_tieng_viet ?? 'N/A' }}
                                                </span>
                                                <span class="badge bg-warning-subtle text-warning">
                                                    Lớp: {{ $item->bacChi->bacHo->bacBo->bacLop->ten_tieng_viet ?? 'N/A' }}
                                                </span>
                                                <span class="badge bg-primary-subtle text-primary">
                                                    Ngành: {{ $item->bacChi->bacHo->bacBo->bacLop->bacNganh->ten_tieng_viet ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td style="max-width: 300px;">
                                            <div class="d-flex flex-wrap gap-2">
                                                @if($item->sach_do)
                                                    <span class="badge bg-danger-subtle text-danger">
                                                        Sách đỏ: {{ $item->sach_do }}
                                                    </span>
                                                @endif
                                                @if($item->iucn)
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        IUCN: {{ $item->iucn }}
                                                    </span>
                                                @endif
                                                @if($item->dac_huu)
                                                    <span class="badge bg-success-subtle text-success">
                                                        Đặc hữu: {{ $item->dac_huu }}
                                                    </span>
                                                @endif
                                                @if($item->nd_84)
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        ND 84: {{ $item->nd_84 }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                        <td>
                                            <div class="hstack gap-2 fs-15 justify-content-center">
                                                <a href="{{ route('dong-vat.show', $item->id) }}"
                                                    data-toggle="tooltip" data-bs-custom-class="tooltip-info"
                                                    data-bs-placement="bottom" data-bs-original-title="Xem chi tiết"
                                                    class="btn btn-icon btn-sm btn-outline-info rounded-pill"
                                                    aria-label="Xem chi tiết">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('dong-vat.edit', $item->id) }}"
                                                    data-toggle="tooltip" data-bs-custom-class="tooltip-warning"
                                                    data-bs-placement="bottom" data-bs-original-title="Cập nhật"
                                                    class="btn btn-icon btn-sm btn-outline-warning rounded-pill"
                                                    aria-label="Cập nhật">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a href="#" data-toggle="tooltip" data-bs-custom-class="tooltip-danger"
                                                    data-bs-placement="bottom" data-bs-original-title="Xóa"
                                                    data-bs-href="{{ route('dong-vat.destroy', $item->id) }}"
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
                                        <td colspan="14" class="text-center">
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
