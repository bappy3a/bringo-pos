<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<title>@yield('title', config('app.name') .' - Modern Point of Sale & Inventory Management')</title>
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo-small.png') }}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo-small.png') }}">
        
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        @yield('css')
    </head>
    <body>
        <!-- Main Wrapper -->
        <div class="main-wrapper">

            <!-- Header -->
            @include('layouts.partials.header')
			<!-- /Header -->
			
			<!-- Sidebar -->
			@include('layouts.partials.sidebar')

            <div class="page-wrapper pagehead">
                <div class="content">
                    <div class="page-header">
						<div class="page-title">
							<h4>Blank Page</h4>
							<h6>Sub Title</h6>
						</div>
						<ul class="table-top-head">
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw" class="feather-rotate-ccw"></i></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i data-feather="chevron-up" class="feather-chevron-up"></i></a>
							</li>
						</ul>
					</div>
				</div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
        <!-- Feather Icon JS -->
        <script src="{{ asset('assets/js/feather.min.js') }}"></script>
        <!-- Slimscroll JS -->
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
		@yield('js')
        <!-- Bootstrap Core JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/js/script.js') }}"></script>
		
    </body>
</html>