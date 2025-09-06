@extends('layouts.index')

@section('header_first')
    <link href="{{ asset('plugins/custom_upload_images/css/upload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom_upload_images/css/upload-component.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Thêm thực vật mới</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('thuc-vat.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('thuc-vat.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bac_chi_id" class="form-label">
                                            Chi
                                        </label>
                                        <select class="form-control" id="bac_chi_id" name="bac_chi_id" required>
                                            <option value="">-- Chọn chi --</option>
                                            @foreach($bacChis as $chi)
                                                <option value="{{ $chi->id }}" {{ old('bac_chi_id') == $chi->id ? 'selected' : '' }}>
                                                    {{ $chi->ten_tieng_viet }} ({{ $chi->ten_khoa_hoc }})
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
                                            value="{{ old('ten_khoa_hoc') }}" placeholder="Nhập tên khoa học"
                                            required>
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
                                            value="{{ old('ten_tieng_viet') }}" placeholder="Nhập tên tiếng Việt"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ten_tac_gia" class="form-label">
                                            Tên tác giả
                                        </label>
                                        <input type="text" class="form-control" id="ten_tac_gia" name="ten_tac_gia"
                                            value="{{ old('ten_tac_gia') }}" placeholder="Nhập tên tác giả">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="than_canh" class="form-label">
                                            Thân cành
                                        </label>
                                        <textarea class="form-control" id="than_canh" name="than_canh" rows="3"
                                            placeholder="Mô tả thân cành">{{ old('than_canh') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="la" class="form-label">
                                            Lá
                                        </label>
                                        <textarea class="form-control" id="la" name="la" rows="3"
                                            placeholder="Mô tả lá">{{ old('la') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phan_bo_viet_nam" class="form-label">
                                            Phân bố Việt Nam
                                        </label>
                                        <textarea class="form-control" id="phan_bo_viet_nam" name="phan_bo_viet_nam" rows="2"
                                            placeholder="Mô tả phân bố tại Việt Nam">{{ old('phan_bo_viet_nam') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phan_bo_the_gioi" class="form-label">
                                            Phân bố thế giới
                                        </label>
                                        <textarea class="form-control" id="phan_bo_the_gioi" name="phan_bo_the_gioi" rows="2"
                                            placeholder="Mô tả phân bố trên thế giới">{{ old('phan_bo_the_gioi') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="hoa_qua" class="form-label">
                                            Hoa quả
                                        </label>
                                        <textarea class="form-control" id="hoa_qua" name="hoa_qua" rows="3"
                                            placeholder="Mô tả hoa quả">{{ old('hoa_qua') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sinh_thai" class="form-label">
                                            Sinh thái
                                        </label>
                                        <textarea class="form-control" id="sinh_thai" name="sinh_thai" rows="3"
                                            placeholder="Mô tả sinh thái">{{ old('sinh_thai') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dac_huu" class="form-label">
                                            Đặc hữu
                                        </label>
                                        <input type="text" class="form-control" id="dac_huu" name="dac_huu"
                                            value="{{ old('dac_huu') }}" placeholder="Nhập đặc hữu">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sach_do" class="form-label">
                                            Sách đỏ
                                        </label>
                                        <input type="text" class="form-control" id="sach_do" name="sach_do"
                                            value="{{ old('sach_do') }}" placeholder="Nhập sách đỏ">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="iucn" class="form-label">
                                            IUCN
                                        </label>
                                        <input type="text" class="form-control" id="iucn" name="iucn"
                                            value="{{ old('iucn') }}" placeholder="Nhập IUCN">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nd_84" class="form-label">
                                            NĐ 84
                                        </label>
                                        <input type="text" class="form-control" id="nd_84" name="nd_84"
                                            value="{{ old('nd_84') }}" placeholder="Nhập NĐ 84">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gia_tri" class="form-label">
                                            Giá trị
                                        </label>
                                        <textarea class="form-control" id="gia_tri" name="gia_tri" rows="2"
                                            placeholder="Mô tả giá trị">{{ old('gia_tri') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nguon" class="form-label">
                                            Nguồn
                                        </label>
                                        <textarea class="form-control" id="nguon" name="nguon" rows="2"
                                            placeholder="Nhập nguồn tham khảo">{{ old('nguon') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Phần upload ảnh -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="image-management-section">
                                        <div class="image-management-header">
                                            <h5 class="header-title">Hình ảnh</h5>
                                            <p class="text-muted">Thêm hình ảnh cho thực vật (tùy chọn)</p>
                                        </div>
                                        <div class="image-management-body">
                                            <div class="new-images-section">
                                                <div class="upload-container">
                                                    <div class="upload-area" id="uploadArea">
                                                        <input name="images[]" type="file" id="fileInput" class="file-input" accept="image/*" multiple>
                                                        <div class="upload-content" id="uploadContent">
                                                            <div class="image-icon">
                                                                <i class="ri-image-line upload-icon text-white"></i>
                                                            </div>
                                                            <div class="upload-text">
                                                                <span class="browse-text">Kéo thả hình ảnh vào đây</span> hoặc
                                                                <span class="browse-text">chọn file</span>
                                                            </div>
                                                            <div class="upload-hint">
                                                                Hỗ trợ: JPG, PNG, GIF, WEBP (tối đa 5MB)
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="imagesPreview" class="existing-images-grid mt-3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="ri-save-line me-1"></i>Xác nhận
                                        </button>
                                        <a href="{{ route('thuc-vat.index') }}" class="btn btn-sm btn-danger">
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
    <script src="{{ asset('plugins/custom_upload_images/js/image_upload.js') }}"></script>
    <script src="{{ asset('plugins/custom_upload_images/js/upload-component.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#ten_khoa_hoc').focus();
            initSumoSelect($('#bac_chi_id'));
            
            const uploadComponent = initializeUploadComponent({
                uploadArea: '#uploadArea',
                fileInput: '#fileInput',
                uploadContent: '#uploadContent',
                previewContainer: '#previewContainer',
                previewImage: '#previewImage',
                removeButton: '#removeButton',
                imagesPreview: '#imagesPreview',
                maxFileSize: 5 * 1024 * 1024, // 5MB
                allowedTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                onError: function(message) {
                    if (typeof showToast === 'function') {
                        showToast('Lỗi', message, 'error');
                    } else {
                        alert(message);
                    }
                }
            });
            
        });
    </script>
@endsection

