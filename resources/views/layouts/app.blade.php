<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<title> {{ get_business('name') }} - @yield('title', config('app.name') .' - Modern Point of Sale & Inventory Management')</title>
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo-small.png') }}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo-small.png') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        @yield('css')
    </head>
    <body>
        @if (Request::is('pos'))
            <div class="main-wrapper">
                @yield('content')
            </div>
        @else
            <div class="main-wrapper">
                <!-- Header -->
                @include('layouts.partials.header')
                
                <!-- Sidebar -->
                @include('layouts.partials.sidebar')

                <div class="page-wrapper">
                    <div class="content">
                        @yield('content')
                    </div>
                </div>
            </div>

            @include('layouts.partials.delete_model')            
        @endif

        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/js/script.js') }}"></script>
		@yield('js')
		<script type="text/javascript">
            var base_url = "{{ url('/') }}",
            csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        </script>

    </body>
</html>