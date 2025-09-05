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
        if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $previewImage.attr('src', e.target.result);
                // $('#base64').attr('value', file);
                $uploadContent.hide();
                $previewContainer.fadeIn();
            };
            reader.readAsDataURL(file);
        } else {
            showToast('Vui lòng chọn tệp tin hình ảnh hợp lệ.', "err");
        }
    }

    $removeButton.off('click').on('click', function(e) {
        e.preventDefault();
        $previewContainer.hide();
        $previewImage.attr('src', '');
        $('#base64').attr('value', '');
        $uploadContent.fadeIn();
    });

    $uploadArea.on('click', function() {
        if (!$fileInput.is(':focus')) {
            $fileInput.trigger('click');
        }
    });
};
