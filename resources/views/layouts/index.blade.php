<!DOCTYPE html>
<html lang="vi">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <base href="{{ asset('') }}">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Xanh - Vì cộng đồng</title>
    {{-- favicon --}}
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{url('favicon.ico')}}" type="image/x-icon">
    @yield('header_first')
	<link href="plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <!-- Main css -->
    <link href="admin/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="admin/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="admin/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- Plugins -->
    <link href="plugins/sumoselect/sumoselect.css" rel="stylesheet">
    <link href="plugins/flatpickr/flatpickr.min.css" rel="stylesheet" >
    <link href="plugins/toastr/toastr.min.css" rel="stylesheet">

    @yield('header_second')
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        @include('layouts.header')
        <div class="page-content">
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.settings')

    <div id="confirm_delete" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="confirm_delete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-bg-danger border-0">
                    <h4 class="modal-title" id="danger-header-modalLabel">Xác nhận xóa dữ liệu</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mt-0">Cảnh báo</h5>
                    <p>Xác nhận xóa dữ liệu sẽ xóa tất cả những dữ liệu liên quan đến dữ liệu bị xóa. Để xóa dữ liệu
                        chọn
                        <span class="text-danger"><b>"Xác nhận"</b></span>
                        , để hủy xóa dữ liệu chọn <span class="text-primary bold"><b>"Hủy"</b></span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light close_btn" data-bs-dismiss="modal">Hủy
                    </button>
                    <a href="#" id="btn_delete" class="btn btn-danger">Xác nhận</a>
                </div>
            </div>
        </div>
    </div>

    @yield('modal')

    <!-- Main JS -->
    <script src="admin/js/config.js"></script>
    <script src="admin/js/vendor.min.js"></script>
    <script src="admin/js/app.js"></script>

    <!-- Plugins JS -->
    <script src="plugins/sumoselect/jquery.sumoselect.js"></script>
    <script src="plugins/flatpickr/flatpickr.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
	<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Global JS -->
    <script src="global/global.js"></script>

    <!-- Other Script -->
    <script>
        $(document).ready(function() {
            @if (session('success'))
            showToast('Thông báo', @json(session('success')), 'success');
            @endif

            @if (session('err'))
            showToast('Thông báo', @json(session('err')), 'error');
            @endif
                @if ($errors->all())
                $errs = @Json($errors->all());
            $.each($errs, (i, v) => {
                showToast('Thông báo', v, 'error');
            })
            @endif
        });
    </script>

    @yield('script')
</body>

</html>
