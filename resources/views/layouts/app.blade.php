<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Mentorpark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    <!-- Vendor css -->
    <link href="{{ asset('admin/assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- App css -->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>

    <!-- Icons css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Datatables css -->
    <link href="{{ asset('admin/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Theme Config Js -->
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>


</head>

<body>
<!-- Begin page -->
<div class="wrapper">

    @include('admin.includes.sidebar')

    @include('admin.includes.top-bar')





    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="page-content">
        @isset($header)
            {{ $header }}
        @endisset

        <div class="page-container">
            {{ $slot }}
        </div>
        <!-- container -->

        <!-- Footer Start -->
        @include('admin.partials._goal')
        @include('admin.includes.footer')
        <!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Theme Settings -->
@include('admin.includes.theme-setting')

<!-- Vendor js -->
<script src="{{ asset('admin/assets/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/dashboard.js') }}"></script>

<!-- datatables -->
<script src="{{ asset('admin/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/table-datatable.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

@stack('scripts')
<script src="{{ asset('admin/assets/js/main.js') }}"></script>
</body>
</html>
