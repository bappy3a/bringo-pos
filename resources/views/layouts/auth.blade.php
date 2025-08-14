<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <!--
    Theme: 2‑Step Signup Wizard (Business → Owner)
    Framework: Bootstrap v5.3.3
    Author: Your Brand
    License: Standard ThemeForest Item License
    Notes: Accessible (A11y), semantic, scalable, RTL‑friendly ready, no JS validation (step JS only)
  -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light" />
	  <title>@yield('title', config('app.name') .' - Modern Point of Sale & Inventory Management')</title>
    <link rel=" shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo-small.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/logo-small.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>

  <main class="container py-5" id="content">
    <div class="row justify-content-center">
      @yield('content')
    </div>
  </main>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/login.js') }}"></script>
    @yield('js')
</body>

</html>