<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Internpark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon.ico') }}">
    <link href="{{ asset('frontend/assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
    <link href="{{ asset('frontend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('frontend/assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <script src="{{ asset('frontend/assets/js/config.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    @yield('stylesheets')

</head>

<body>
@if(session('success'))
    <div id="toast-success"
         class="alert alert-secondary alert-dismissible d-flex align-items-center border-2 border border-secondary"
         style="position: absolute; top: 50%; left: 40%; z-index: 9999; ">
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
        <iconify-icon icon="solar:bicycling-round-bold-duotone"
                      class="fs-20 me-1"></iconify-icon>
        <div class="lh-1"><strong>{{ session('success') }} </strong></div>

    </div>
    <script>
        // Auto-hide after 3 seconds
        setTimeout(function () {
            var toast = document.getElementById('toast-success');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);

        // Allow click to close
        document.getElementById('toast-success').onclick = function () {
            this.remove();
        };
    </script>

@endif
<!-- Begin page -->
@yield('pageContent')
<!-- END page -->

<!-- Theme Settings -->
@include('frontend.includes.theme-setting')

<!-- Vendor js -->
<script src="{{ asset('frontend/assets/js/vendor.min.js') }}"></script>
<!-- App js -->
<script src="{{ asset('frontend/assets/js/app.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/pages/dashboard.js') }}"></script>

<!-- datatables -->
<script src="{{ asset('frontend/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script
    src="{{ asset('frontend/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script
    src="{{ asset('frontend/assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
<script
    src="{{ asset('frontend/assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('frontend/assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/components/table-datatable.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!-- Fullcalendar js -->
<script src="{{ asset('frontend/assets/vendor/fullcalendar/index.global.min.js') }}"></script>
<!-- Calendar App Demo js -->
<script src="{{ asset('frontend/assets/js/pages/apps-calendar.js') }}"></script>

<!-- Bootstrap Wizard Form js -->
<script src="{{ asset('frontend/assets/vendor/vanilla-wizard/js/wizard.min.js') }}"></script>

<!-- Wizard Form Demo js -->
<script src="{{ asset('frontend/assets/js/components/form-wizard.js') }}"></script>

@yield('javascripts')
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

</body>
</html>
