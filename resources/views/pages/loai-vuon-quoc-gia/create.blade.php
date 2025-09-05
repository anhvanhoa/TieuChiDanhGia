@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Thêm loại vườn quốc gia mới</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('loai-vuon-quoc-gia.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('loai-vuon-quoc-gia.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="ten_loai" class="form-label">
                                            Tên loại vườn quốc gia
                                        </label>
                                        <input type="text" class="form-control" id="ten_loai" name="ten_loai"
                                            value="{{ old('ten_loai') }}" placeholder="Nhập tên loại vườn quốc gia"
                                            required>
                                        <div class="form-text">
                                            Ví dụ: Vườn quốc gia, Khu bảo tồn thiên nhiên, Khu dự trữ sinh quyển...
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="ri-save-line me-1"></i>Xác nhận
                                        </button>
                                        <a href="{{ route('loai-vuon-quoc-gia.index') }}" class="btn btn-sm btn-danger">
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
            $('#ten_loai').focus();
        });
    </script>
@endsection
