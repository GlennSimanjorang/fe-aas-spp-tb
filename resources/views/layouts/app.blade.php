<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind (Vite) -->
    @vite('resources/css/app.css')

    @stack('scripts')

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 font-poppins">

    <!-- Sidebar -->
    <div
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-30 transform transition-transform duration-300 ease-in-out lg:translate-x-0"
    >
        @include('layouts.sidebar')
    </div>

    <!-- Overlay (mobile) -->
    <div
        x-show="sidebarOpen"
        x-transition
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black opacity-40 z-20 lg:hidden"
    ></div>

    <!-- Main content -->
    <div class="flex flex-col flex-1 min-h-screen lg:ml-64 transition-all duration-300 ease-in-out">
        <!-- Header or Toggle Button -->
        <header class="bg-white shadow p-4 lg:hidden">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </header>

        <!-- Page content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
