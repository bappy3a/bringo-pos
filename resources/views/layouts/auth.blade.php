<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', config('app.name') . ' - Modern Point of Sale & Inventory Management')</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo-small.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/logo-small.png">

    @vite('resources/css/app.css')
    @yield('css')
</head>

<body class="account-page bg-white">

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">
            @yield('content')
        </div>
    </div>
    <!-- /Main Wrapper -->

    @vite('resources/js/app.js')
    <script src="assets/js/rocket-loader.min.js"></script>
    <script defer src="assets/js/beacon.min.js"></script>
    @yield('js')
</body>

</html>