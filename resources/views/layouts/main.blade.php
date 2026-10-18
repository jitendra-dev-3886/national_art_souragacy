<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>National ART & Surrogacy Registry</title>
    <!-- Bootstrap 5 CSS -->
    <link href="{{ url('public/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/css/bootstrap5.min.css')}}" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link href="{{ url('public/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/css/font-awesome.min.css') }}">
    <!-- jQuery -->
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
   
    <!-- Navbar -->
    @include('pages.header')

    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
    </div>

    @include('pages.footer')

    <!-- Scripts -->
    <!-- jQuery -->
    
	<script nonce="{{ $cspNonce }}" src="{{ url('public/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
	<script nonce="{{ $cspNonce }}" src="{{ url('public/js/plugins-init/datatables.init.js')}}"></script>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/bootstrap.bundle.min.js')}}"></script>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/bootstrap5.min.js')}}"></script>
</body>
</html>
