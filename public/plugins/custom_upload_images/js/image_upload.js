const image_upload = () => {
    const $uploadArea = $('#uploadArea');
    const $fileInput = $('#fileInput');
    const $uploadContent = $('#uploadContent');
    const $previewContainer = $('#previewContainer');
    const $previewImage = $('.preview-image');
    const $removeButton = $('.remove-button');

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
        handleFile(files[0]);
    });

    $fileInput.on('change', function() {
        handleFile(this.files[0]);
    });

    function handleFile(file) {
        if (file && (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/gif' || file.type === 'image/webp')) {
            // Show loading state
            $uploadArea.addClass('loading');

            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove loading state
                $uploadArea.removeClass('loading');

                $previewImage.attr('src', e.target.result);
                $uploadContent.hide();
                $previewContainer.fadeIn(300);
            };

            reader.onerror = function() {
                $uploadArea.removeClass('loading');
                showToast('Lỗi khi đọc file. Vui lòng thử lại.', "err");
            };

            reader.readAsDataURL(file);
        } else {
            showToast('Vui lòng chọn tệp tin hình ảnh hợp lệ (JPG, PNG, GIF, WEBP).', "err");
        }
        $fileInput.val('');
    }

    $removeButton.off('click').on('click', function(e) {
        e.preventDefault();
        $previewContainer.fadeOut(300, function() {
            $previewImage.attr('src', '');
            $uploadContent.fadeIn(300);
        });
    });

    $uploadArea.on('click', function() {
        if (!$fileInput.is(':focus')) {
            $fileInput.trigger('click');
        }
    });
};
