@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chỉnh sửa họ</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('bac-ho.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bac-ho.update', $bacHo->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bac_bo_id" class="form-label">
                                            Bộ
                                        </label>
                                        <select class="form-control" id="bac_bo_id" name="bac_bo_id" required>
                                            <option value="">-- Chọn bộ --</option>
                                            @foreach($bacBos as $bo)
                                                <option value="{{ $bo->id }}"
                                                    {{ old('bac_bo_id', $bacHo->bac_bo_id) == $bo->id ? 'selected' : '' }}>
                                                    {{ $bo->ten_tieng_viet }} ({{ $bo->ten_khoa_hoc }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ten_khoa_hoc" class="form-label">
                                            Tên khoa học
                                        </label>
                                        <input type="text" class="form-control" id="ten_khoa_hoc" name="ten_khoa_hoc"
                                            value="{{ old('ten_khoa_hoc', $bacHo->ten_khoa_hoc) }}"
                                            placeholder="Nhập tên khoa học" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ten_tieng_viet" class="form-label">
                                            Tên tiếng Việt
                                        </label>
                                        <input type="text" class="form-control" id="ten_tieng_viet" name="ten_tieng_viet"
                                            value="{{ old('ten_tieng_viet', $bacHo->ten_tieng_viet) }}"
                                            placeholder="Nhập tên tiếng Việt" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="ri-save-line me-1"></i>Xác nhận
                                        </button>
                                        <a href="{{ route('bac-ho.index') }}" class="btn btn-sm btn-danger">
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
            $('#ten_khoa_hoc').focus().select();
            initSumoSelect($('#bac_bo_id'));
        });
    </script>
@endsection
