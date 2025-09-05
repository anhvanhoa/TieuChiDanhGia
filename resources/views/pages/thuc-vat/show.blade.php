@extends('layouts.index')

@section('content')
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Chi tiết thực vật</h4>
                        </div>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-2">
                            <a href="{{ route('thuc-vat.edit', $thucVat->id) }}" class="btn btn-sm btn-warning">
                                <i class="ri-edit-line me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('thuc-vat.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên khoa học:</label>
                                    <p class="form-control-plaintext">{{ $thucVat->ten_khoa_hoc }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên tiếng Việt:</label>
                                    <p class="form-control-plaintext">{{ $thucVat->ten_tieng_viet }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên tác giả:</label>
                                    <p class="form-control-plaintext">{{ $thucVat->ten_tac_gia ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Chi:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $thucVat->bacChi->ten_tieng_viet ?? 'N/A' }}
                                            ({{ $thucVat->bacChi->ten_khoa_hoc ?? 'N/A' }})
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Họ:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-danger-subtle text-danger">
                                            {{ $thucVat->bacChi->bacHo->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bộ:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-success-subtle text-success">
                                            {{ $thucVat->bacChi->bacHo->bacBo->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Lớp:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-warning-subtle text-warning">
                                            {{ $thucVat->bacChi->bacHo->bacBo->bacLop->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ngành:</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $thucVat->bacChi->bacHo->bacBo->bacLop->bacNganh->ten_tieng_viet ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sách đỏ:</label>
                                    <p class="form-control-plaintext">
                                        @if($thucVat->sach_do)
                                            <span class="badge bg-danger-subtle text-danger">{{ $thucVat->sach_do }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">IUCN:</label>
                                    <p class="form-control-plaintext">
                                        @if($thucVat->iucn)
                                            <span class="badge bg-warning-subtle text-warning">{{ $thucVat->iucn }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Đặc hữu:</label>
                                    <p class="form-control-plaintext">
                                        @if($thucVat->dac_huu)
                                            <span class="badge bg-success-subtle text-success">{{ $thucVat->dac_huu }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">NĐ 84:</label>
                                    <p class="form-control-plaintext">{{ $thucVat->nd_84 ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ngày tạo:</label>
                                    <p class="form-control-plaintext">{{ $thucVat->created_at ? $thucVat->created_at->format('d-m-Y H:i:s') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($thucVat->than_canh)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Thân cành:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->than_canh }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($thucVat->la)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Lá:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->la }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($thucVat->phan_bo_viet_nam)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phân bố Việt Nam:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->phan_bo_viet_nam }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($thucVat->phan_bo_the_gioi)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phân bố thế giới:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->phan_bo_the_gioi }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($thucVat->hoa_qua)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Hoa quả:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->hoa_qua }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($thucVat->sinh_thai)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sinh thái:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->sinh_thai }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($thucVat->gia_tri)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Giá trị:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->gia_tri }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($thucVat->nguon)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nguồn:</label>
                                    <div class="form-control-plaintext bg-light p-3 rounded">
                                        {{ $thucVat->nguon }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Hình ảnh -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex flex-wrap align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h4 class="header-title">Hình ảnh</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="imagesContainer" class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header_first')
    <link href="{{ asset('plugins/custom_upload_images/css/upload.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script')
    <script src="{{ asset('plugins/custom_upload_images/js/image_upload.js') }}"></script>
    <script>
        const thucVatId = {{ $thucVat->id }};
        let selectedFile = null;

        $(document).ready(function() {
            loadImages();
        });

        function loadImages() {
            $.get(`/thuc-vat/${thucVatId}/images`)
                .done(function(response) {
                    if (response.success) {
                        displayImages(response.images);
                    }
                })
                .fail(function() {
                    showToast('Lỗi', 'Không thể tải hình ảnh', 'error');
                });
        }

        function displayImages(images) {
            const container = $('#imagesContainer');
            container.empty();

            if (images.length === 0) {
                container.html(`
                    <div class="col-12 text-center py-4">
                        <i class="ri-image-line fs-48 text-muted"></i>
                        <p class="text-muted mt-2">Chưa có hình ảnh nào</p>
                    </div>
                `);
                return;
            }

            images.forEach(function(image) {
                const imageHtml = `
                    <div class="col-md-3" data-image-id="${image.id}">
                        <div class="card">
                            <div class="position-relative">
                                <img src="${image.duong_dan_thumb ? '/storage/' + image.duong_dan_thumb : '/storage/' + image.duong_dan}"
                                    class="card-img-top" style="height: 200px; object-fit: cover;"
                                    alt="Hình ảnh">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-danger rounded-circle"
                                            onclick="deleteImage(${image.id})" title="Xóa hình ảnh">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.append(imageHtml);
            });
        }
        function deleteImage(imageId) {
            if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
                $.ajax({
                    url: `/thuc-vat/image/${imageId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast('Thành công', response.message, 'success');
                            loadImages();
                        } else {
                            showToast('Lỗi', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showToast('Lỗi', response?.message || 'Có lỗi xảy ra khi xóa', 'error');
                    }
                });
            }
        }
    </script>
@endsection
