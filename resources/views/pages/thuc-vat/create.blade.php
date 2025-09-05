@extends('layouts.index')

@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/custom_upload_images/css/image-management.css') }}">
@endpush

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
                        <form action="{{ route('thuc-vat.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bac_chi_id" class="form-label">
                                            Chi <span class="text-danger">*</span>
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
                                            Tên khoa học <span class="text-danger">*</span>
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
                                            Tên tiếng Việt <span class="text-danger">*</span>
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
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="dac_huu" class="form-label">
                                            Đặc hữu
                                        </label>
                                        <input type="text" class="form-control" id="dac_huu" name="dac_huu"
                                            value="{{ old('dac_huu') }}" placeholder="Nhập đặc hữu">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sach_do" class="form-label">
                                            Sách đỏ
                                        </label>
                                        <input type="text" class="form-control" id="sach_do" name="sach_do"
                                            value="{{ old('sach_do') }}" placeholder="Nhập sách đỏ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="iucn" class="form-label">
                                            IUCN
                                        </label>
                                        <input type="text" class="form-control" id="iucn" name="iucn"
                                            value="{{ old('iucn') }}" placeholder="Nhập IUCN">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nd_84" class="form-label">
                                            NĐ 84
                                        </label>
                                        <input type="text" class="form-control" id="nd_84" name="nd_84"
                                            value="{{ old('nd_84') }}" placeholder="Nhập NĐ 84">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gia_tri" class="form-label">
                                            Giá trị
                                        </label>
                                        <textarea class="form-control" id="gia_tri" name="gia_tri" rows="2"
                                            placeholder="Mô tả giá trị">{{ old('gia_tri') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
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
                                                <h6 class="new-images-title">Thêm ảnh mới</h6>
                                                <div class="upload-container">
                                                    <div class="upload-area" id="uploadArea">
                                                        <input type="file" id="fileInput" class="file-input" accept="image/*" multiple>
                                                        <div class="upload-content" id="uploadContent">
                                                            <div class="image-icon">
                                                                <i class="ri-image-line upload-icon"></i>
                                                            </div>
                                                            <div class="upload-text">
                                                                <span class="browse-text">Kéo thả hình ảnh vào đây</span> hoặc
                                                                <span class="browse-text">chọn file</span>
                                                            </div>
                                                            <div class="upload-hint">
                                                                Hỗ trợ: JPG, PNG, GIF, WEBP (tối đa 5MB)
                                                            </div>
                                                        </div>
                                                        <div class="preview-container" id="previewContainer" style="display: none;">
                                                            <img class="preview-image" id="previewImage" alt="Preview">
                                                            <button type="button" class="remove-button" id="removeButton">×</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="imagesPreview" class="existing-images-grid mt-3">
                                                    <!-- Ảnh đã chọn sẽ hiển thị ở đây -->
                                                </div>
                                            </div>
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

@section('style')
    <link href="{{ asset('plugins/custom_upload_images/css/upload.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script')
    <script src="{{ asset('plugins/custom_upload_images/js/image_upload.js') }}"></script>
    <script>
        let selectedFiles = [];

        $(document).ready(function () {
            $('#ten_khoa_hoc').focus();
            initSumoSelect($('#bac_chi_id'));
            initializeImageUpload();
        });

        function initializeImageUpload() {
            const $uploadArea = $('#uploadArea');
            const $fileInput = $('#fileInput');
            const $uploadContent = $('#uploadContent');
            const $previewContainer = $('#previewContainer');
            const $previewImage = $('#previewImage');
            const $removeButton = $('#removeButton');
            const $imagesPreview = $('#imagesPreview');

            // Drag and drop events
            const eventNames = ['dragenter', 'dragover', 'dragleave', 'drop'];
            eventNames.forEach(eventName => {
                $uploadArea.on(eventName, preventDefaults);
                $(document).on(eventName, preventDefaults);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            $uploadArea.on('dragenter dragover', function() {
                $(this).addClass('dragging');
            });

            $uploadArea.on('dragleave drop', function() {
                $(this).removeClass('dragging');
            });

            $uploadArea.on('drop', function(e) {
                const files = e.originalEvent.dataTransfer.files;
                handleFiles(files);
            });

            $fileInput.on('change', function() {
                handleFiles(this.files);
            });

            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    if (file && (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/gif' || file.type === 'image/webp')) {
                        selectedFiles.push(file);
                        displayImagePreview(file);
                    } else {
                        showToast('Vui lòng chọn tệp tin hình ảnh hợp lệ.', "err");
                    }
                });
                $fileInput.val('');
            }

            function displayImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageId = 'preview_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                    const imageHtml = `
                        <div class="image-card fade-in" id="${imageId}">
                            <div class="position-relative">
                                <img src="${e.target.result}" class="image-card-image" alt="Preview">
                                <div class="image-card-overlay"></div>
                                <div class="image-card-actions">
                                    <button type="button" class="image-card-action-btn image-card-delete-btn" onclick="removeImagePreview('${imageId}')" title="Xóa ảnh">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="image-card-info">
                                <div class="image-card-filename">${file.name}</div>
                                <div class="image-card-date">Chờ upload</div>
                            </div>
                        </div>
                    `;
                    $imagesPreview.append(imageHtml);
                };
                reader.readAsDataURL(file);
            }

            $removeButton.on('click', function(e) {
                e.preventDefault();
                $previewContainer.hide();
                $previewImage.attr('src', '');
                $uploadContent.fadeIn();
            });

            $uploadArea.on('click', function() {
                if (!$fileInput.is(':focus')) {
                    $fileInput.trigger('click');
                }
            });
        }

        function removeImagePreview(imageId) {
            $('#' + imageId).remove();
            // Có thể cần cập nhật selectedFiles array nếu cần
        }

        // Cập nhật form submit để gửi kèm ảnh
        $('form').on('submit', function(e) {
            if (selectedFiles.length > 0) {
                // Tạo FormData mới
                const formData = new FormData(this);

                // Thêm các file ảnh
                selectedFiles.forEach((file, index) => {
                    formData.append('images[]', file);
                });

                // Gửi form với AJAX
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            showToast('Thành công', response.message, 'success');
                            window.location.href = response.redirect || '/thuc-vat';
                        } else {
                            showToast('Lỗi', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        if (response && response.errors) {
                            let errorMessage = 'Có lỗi xảy ra:\n';
                            Object.values(response.errors).forEach(errors => {
                                errors.forEach(error => {
                                    errorMessage += '- ' + error + '\n';
                                });
                            });
                            showToast('Lỗi', errorMessage, 'error');
                        } else {
                            showToast('Lỗi', response?.message || 'Có lỗi xảy ra khi tạo thực vật', 'error');
                        }
                    }
                });
            }
        });
    </script>
@endsection
