<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite('resources/css/app.css') {{-- jika pakai Vite --}}
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 flex">
    @include('layouts.sidebar')

    <div class="ml-64 p-6 w-full">
        @yield('content')
    </div>
</body>
</html>
