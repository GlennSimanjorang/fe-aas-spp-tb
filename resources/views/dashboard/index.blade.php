<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @extends('layouts.app')

    @section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 font-poppins">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl p-6 mb-8 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold mb-1">Welcome back, Admin!</h2>
                        <p class="opacity-90">Sistem Pembayaran SPP - SMK Taruna Bhakti</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @for($i = 0; $i < 3; $i++)
                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Total Siswa</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">1,248</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 flex items-center">
                            <span class="text-green-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                12% from last month
                            </span>
                        </p>
                    </div>
            </div>
            @endfor
        </div>

        <!-- New Payments Section -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Pembayaran Baru</h3>
                <div class="relative mt-4 sm:mt-0 w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari Data Siswa" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Placeholder for payment data -->
            <div class="bg-gray-100 rounded-lg p-8 flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-500 mb-2">Data pembayaran akan muncul di sini</p>
                <p class="text-sm text-gray-400">Gunakan kolom pencarian untuk menemukan siswa</p>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                <button class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 disabled:opacity-50" disabled>
                    Previous
                </button>
                <div class="flex space-x-1">
                    <button class="px-3 py-1 rounded-md bg-blue-600 text-white text-sm">1</button>
                    <button class="px-3 py-1 rounded-md text-gray-600 hover:bg-gray-100 text-sm">2</button>
                    <button class="px-3 py-1 rounded-md text-gray-600 hover:bg-gray-100 text-sm">3</button>
                    <span class="px-3 py-1 text-gray-600 text-sm">...</span>
                    <button class="px-3 py-1 rounded-md text-gray-600 hover:bg-gray-100 text-sm">5</button>
                </div>
                <button class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">
                    Next
                </button>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>