class UploadComponent {
    constructor(options = {}) {
        this.options = {
            uploadArea: '#uploadArea',
            fileInput: '#fileInput',
            uploadContent: '#uploadContent',
            previewContainer: '#previewContainer',
            previewImage: '#previewImage',
            removeButton: '#removeButton',
            imagesPreview: '#imagesPreview',
            maxFileSize: 5 * 1024 * 1024,
            allowedTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            onFileSelect: null,
            onFileRemove: null,
            onError: null,
            ...options
        };
        
        this.selectedFiles = [];
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        const $uploadArea = $(this.options.uploadArea);
        const $fileInput = $(this.options.fileInput);
        const $uploadContent = $(this.options.uploadContent);
        const $previewContainer = $(this.options.previewContainer);
        const $previewImage = $(this.options.previewImage);
        const $removeButton = $(this.options.removeButton);

        const eventNames = ['dragenter', 'dragover', 'dragleave', 'drop'];
        eventNames.forEach(eventName => {
            $uploadArea.on(eventName, this.preventDefaults);
            $(document).on(eventName, this.preventDefaults);
        });

        $uploadArea.on('dragenter dragover', () => {
            $uploadArea.addClass('dragging');
        });

        $uploadArea.on('dragleave drop', () => {
            $uploadArea.removeClass('dragging');
        });

        $uploadArea.on('drop', (e) => {
            const files = e.originalEvent.dataTransfer.files;
            this.handleFiles(files);
        });

        $fileInput.on('change', (e) => {
            this.handleFiles(e.target.files);
        });

        $removeButton.on('click', (e) => {
            e.preventDefault();
            $previewContainer.hide();
            $previewImage.attr('src', '');
            $uploadContent.fadeIn();
        });

        $uploadArea.on('click', () => {
            if (!$fileInput.is(':focus')) {
                $fileInput.trigger('click');
            }
        });
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    handleFiles(files) {
        Array.from(files).forEach(file => {
            if (this.validateFile(file)) {
                this.selectedFiles.push(file);
                this.displayImagePreview(file);
                if (this.options.onFileSelect) {
                    this.options.onFileSelect(file, this.selectedFiles);
                }
            }
        });
        $(this.options.fileInput).val(this.selectedFiles);
    }

    validateFile(file) {
        if (!this.options.allowedTypes.includes(file.type)) {
            this.showError('Vui lòng chọn tệp tin hình ảnh hợp lệ (JPG, PNG, GIF, WEBP).');
            return false;
        }
        
        if (file.size > this.options.maxFileSize) {
            this.showError('Kích thước file không được vượt quá 5MB.');
            return false;
        }
        
        return true;
    }

    displayImagePreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const imageId = 'preview_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            const fileIndex = this.selectedFiles.length - 1;
            const fileSize = this.formatFileSize(file.size);
            const imageHtml = `
                <div class="image-card fade-in" id="${imageId}" data-file-index="${fileIndex}">
                    <div class="position-relative">
                        <img src="${e.target.result}" class="image-card-image" alt="Preview">
                        <div class="image-card-overlay"></div>
                        <div class="image-card-actions">
                            <button type="button" class="image-card-action-btn image-card-delete-btn" onclick="uploadComponent.removeImagePreview('${imageId}')" title="Xóa ảnh">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="image-card-info">
                        <div class="image-card-filename" title="${file.name}">${file.name}</div>
                        <div class="image-card-date">${fileSize}</div>
                    </div>
                </div>
            `;
            $(this.options.imagesPreview).append(imageHtml);
        };
        reader.readAsDataURL(file);
    }

    removeImagePreview(imageId) {
        const $imageCard = $('#' + imageId);
        const fileIndex = parseInt($imageCard.data('file-index') || 0);
        
        if (fileIndex >= 0 && fileIndex < this.selectedFiles.length) {
            const removedFile = this.selectedFiles.splice(fileIndex, 1)[0];
            if (this.options.onFileRemove) {
                this.options.onFileRemove(removedFile, this.selectedFiles);
            }
        }
        
        $imageCard.fadeOut(300, function() {
            $(this).remove();
        });
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    showError(message) {
        if (this.options.onError) {
            this.options.onError(message);
        } else if (typeof showToast === 'function') {
            showToast('Lỗi', message, 'error');
        } else {
            alert(message);
        }
    }

    getSelectedFiles() {
        return this.selectedFiles;
    }

    clearFiles() {
        this.selectedFiles = [];
        $(this.options.imagesPreview).empty();
    }

    setLoading(loading) {
        const $uploadArea = $(this.options.uploadArea);
        if (loading) {
            $uploadArea.addClass('loading');
        } else {
            $uploadArea.removeClass('loading');
        }
    }
}

let uploadComponent
function initializeUploadComponent(options = {}) {
    uploadComponent = new UploadComponent(options);
    return uploadComponent;
}