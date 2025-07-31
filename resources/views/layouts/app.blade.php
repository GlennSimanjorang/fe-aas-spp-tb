<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - SISFO SPP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') {{-- make sure Tailwind jalan --}}
</head>
<body class="bg-gray-100">

    
    @include('app.sidebar')

    
    <div class="ml-64 p-6 min-h-screen">
        @yield('content')
    </div>

</body>
</html>
