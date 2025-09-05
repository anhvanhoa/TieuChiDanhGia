var xhrAjax = null;
const unloadHandler = () => {
    if (xhrAjax !== null) xhrAjax.abort();
};
window.addEventListener("unload", unloadHandler);

$("#confirm_delete").on("show.bs.modal", function (e) {
    $("#btn_delete").attr("href", $(e.relatedTarget).data("bs-href"));
});

$("#btn_delete").on("click", function (e) {
    e.preventDefault();
    $(this).addClass("disabled");
    $(".btn-close").addClass("disabled");
    $(".close_btn").addClass("disabled");
    $(this).html(
        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang thực hiện'
    );
    var url = $(this).attr("href");
    window.location.href = url;
});

$("form").on("submit", function (e) {
    e.preventDefault();
    $('button[type="submit"]').attr("disabled", true);
    $('button[data-bs-dismiss="modal"]').addClass("disabled");
    $(".btn-close").addClass("disabled");
    if ($('button[type="submit"]').hasClass("icon")) {
        $('button[type="submit"]').html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
        );
    } else {
        $('button[type="submit"]').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang thực hiện'
        );
    }
    this.submit();
});

// thêm * cho các trường require
$("form")
    .find("input[required], select[required], textarea[required]")
    .each(function () {
        var label = $(this).siblings("label");
        var labelText = label.text() + '<span style="color:red"> *</span>';
        label.html(labelText);
    });

const updateStatusNotification = (elm) => {
    const url = $(elm).data("bs-href");
    const _token = $('meta[name="csrf-token"]').attr("content");

    if (!url) return;

    const issetAciveClass = $(elm).parent("div").hasClass("active");
    if (!issetAciveClass) return;

    $.ajax({
        type: "post",
        url: url,
        data: {
            _token: _token,
        },
        success: (res, status, xhr) => {
            if (xhr.status === 200) $(elm).parent("div").removeClass("active");

            if ($("#containerNoti").find("div.active").length == 0) {
                $("#noiceNoti")
                    .find(
                        "span.position-absolute.translate-middle.bg-danger.border.border-light.rounded-circle"
                    )
                    .remove();
                $("#noiceNoti")
                    .find("svg.animate-ring")
                    .removeClass("animate-ring");
            }

            let countNoti = $("#linkNotiIndex").find("span.badge").text();
            if (typeof countNoti == "string") countNoti = parseInt(countNoti);
            if (countNoti > 0) {
                countNoti -= 1;
                $("#linkNotiIndex").find("span.badge").text(countNoti);
            }
            if (countNoti == 0) $("#linkNotiIndex").find("span.badge").remove();
        },
        error: (res, status, xhr) => {
            showToast(res.responseText, "err");
        },
    });
};

const showToast = (title, message, status) => {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-center",
        preventDuplicates: true,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "2000",
        extendedTimeOut: "500",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    toastr[status](message, title);
};

const formatNumber = (value) => {
    if (typeof value === "string") {
        return value;
    }
    if (typeof value === "number") {
        if (Number.isInteger(value)) {
            return value.toLocaleString("en-US", {
                minimumFractionDigits: 0,
            });
        } else {
            return value.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        }
    }
    return "";
};

const destroySumoSelect = (selector) => {
    selector.each(function () {
        if ($(this)[0].sumo) {
            $(this)[0].sumo.unload();
        }
    });
};

const initSumoSelect = (selector, placeholder = "Chọn thông tin") => {
    selector.SumoSelect({
        okCancelInMulti: false,
        csvDispCount: 1,
        selectAll: true,
        search: true,
        searchText: "Nhập tìm kiếm...",
        placeholder: placeholder,
        captionFormat: "Đã chọn {0} lựa chọn",
        captionFormatAllSelected: "Đã chọn tất cả {0} lựa chọn",
        captionFormatAllSelected: "Tất cả",
        locale: ["Xác nhận", "Hủy", "Chọn tất cả"],
    });
};

const destroyDataTable = (element) => {
    if ($.fn.DataTable.isDataTable(element)) {
        element.DataTable().destroy();
    }
};

const createDataTable = (element) => {
    element.DataTable({
        responsive: !0,
        pageLength: 10,
        order: [],
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "Tất cả"],
        ],
        language: {
            sLengthMenu: "Hiển thị _MENU_ bản ghi",
            searchPlaceholder: "Nhập từ khóa...",
            info: "Từ _START_ đến _END_ | Tổng số _TOTAL_",
            sInfoEmpty: "Không có dữ liệu",
            sEmptyTable: "Không có dữ liệu",
            sSearch: "Tìm kiếm",
            sZeroRecords: "Không tìm thấy dữ liệu phù hợp",
            sInfoFiltered: "",
            paginate: {
                previous: "<i class='ri-arrow-left-line'>",
                next: "<i class='ri-arrow-right-line'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    new $.fn.dataTable.FixedHeader(element);
};

const show_loading_Filter = () => {
    const filter = $("#filter");
    const download = $("#export");
    filter.addClass("disabled");
    download.addClass("disabled");
    filter.html(
        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang tải dữ liệu'
    );
};

const hide_loading_Filter = () => {
    const filter = $("#filter");
    const download = $("#export");
    filter.removeClass("disabled");
    download.removeClass("disabled");
    filter.html('<i class="ri-filter-line me-2"></i>Lọc dữ liệu');
};

const getData = (method = "GET", url, params, token) => {
    return new Promise((resolve, reject) => {
        if (method == "POST") {
            params = { ...params, _token: token };
        }

        xhrAjax = $.ajax({
            type: method,
            url: url,
            data: params,
            success: function (response, status, xhr) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(xhr.responseJSON || error);
            },
        });
    });
};

const downloadFile = (path) => {
    if (path == "") {
        showToast("Không tìm thấy tệp tin", "err");
    } else {
        window.open(path, "_blank");
    }
};

const initializeTooltips = () => {
    var tooltipTriggerList = Array.from(
        document.querySelectorAll('[data-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
};

const showPass = (el, el_icon) => {
    var icon = el_icon.find("i");
    var type = el.attr("type") === "password" ? "text" : "password";
    el.attr("type", type);
    if (type === "password") {
        icon.removeClass("ri-eye-line").addClass("ri-eye-close-line");
    } else {
        icon.removeClass("ri-eye-close-line").addClass("ri-eye-line");
    }
};

const dmY_To_Ymd = (dateStr) => {
    const [day, month, year] = dateStr.split("-");
    const formattedDate = `${year}-${month}-${day}`;
    return formattedDate;
};

const createEditor = (element, height = 300) => {
    CKEDITOR.replace(element, {
        height: height,
        toolbar: [
            [
                "Source",
                "Print",
                "NewPage",
                "Preview",
                "Templates",
                "Cut",
                "Copy",
                "Paste",
                "PasteText",
                "PasteFromWord",
                "Find",
                "Replace",
                "SelectAll",
            ],
            [
                "Bold",
                "Italic",
                "Underline",
                "Strike",
                "Subscript",
                "Superscript",
                "NumberedList",
                "BulletedList",
                "Outdent",
                "Indent",
                "Blockquote",
            ],
            [
                "Image",
                "Table",
                "HorizontalRule",
                "Smiley",
                "SpecialChar",
                "Iframe",
            ],
            ["Styles", "Format", "Font", "FontSize", "TextColor", "BGColor"],
            ["Link", "Unlink"],
        ],
    });
};

const refreshSumoSelect = (selector) => {
    selector.each(function (i, el) {
        destroySumoSelect($(el));
        initSumoSelect($(el));
    });
};
