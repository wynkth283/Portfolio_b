<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(
        [
            'resources/sass/app.scss', 
            'resources/js/app.js', 
            'resources/js/jquery.dataTables.min.js', 
            'resources/css/jquery.dataTables.min.css', 
            'node_modules/sweetalert2/dist/sweetalert2.min.js', 
            'node_modules/sweetalert2/dist/sweetalert2.min.css', 
            'resources/css/toast.css',
        ])
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
</head>
<body>
    @include('layouts.Navbar')
    <div>
        @yield('content')
    </div>
    @include('layouts.Footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="toast-container" id="toastContainer"></div>
</body>
</html>