<div 
    x-data="{ open: true }" 
    class="h-screen fixed bg-white shadow-xl flex flex-col transition-all duration-300 ease-in-out z-50"
    :class="open ? 'w-64' : 'w-20'"
>
    <!-- Toggle Button -->
    <div class="flex justify-end p-3">
        <button 
            @click="open = !open"
            class="p-1 text-gray-500 hover:bg-gray-100 rounded-full focus:outline-none transition-colors duration-200"
            :title="open ? 'Collapse sidebar' : 'Expand sidebar'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-300" 
                :class="open ? '' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <!-- Branding -->
    <div class="px-4 py-3 border-b border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white p-2 rounded-lg shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                </svg>
            </div>
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <span class="text-xl font-bold text-gray-800">Admin</span>
                <p class="text-xs text-gray-500 mt-0.5">SMK Taruna Bhakti</p>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
        @php
            $menu = [
                [
                    'label' => 'Dashboard', 
                    'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 
                    'url' => '/dashboard',
                    'active' => request()->is('dashboard')
                ],
                [
                    'label' => 'Data Siswa', 
                    'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 
                    'url' => '/siswa',
                    'active' => request()->is('siswa*')
                ],
                [
                    'label' => 'Pembayaran', 
                    'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 
                    'url' => '/pembayaran',
                    'active' => request()->is('pembayaran*')
                ],
                [
                    'label' => 'Tunggakan', 
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 
                    'url' => '/tunggakan',
                    'active' => request()->is('tunggakan*')
                ],
                [
                    'label' => 'Laporan', 
                    'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 
                    'url' => '/laporan',
                    'active' => request()->is('laporan*')
                ],
                [
                    'label' => 'Notifikasi', 
                    'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 
                    'url' => '/notifikasi',
                    'active' => request()->is('notifikasi*')
                ],
            ];
        @endphp

        @foreach($menu as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-all duration-200"
               :class="{{ $item['active'] ? "'bg-blue-50 text-blue-600 font-semibold'" : "'text-gray-600 hover:bg-gray-50 hover:text-gray-900'" }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="{{ $item['icon'] }}" />
                </svg>
                <span class="ml-3 whitespace-nowrap" 
                      x-show="open" 
                      x-transition:enter="transition ease-out duration-300"
                      x-transition:enter-start="opacity-0 translate-x-2"
                      x-transition:enter-end="opacity-100 translate-x-0"
                      x-transition:leave="transition ease-in duration-200"
                      x-transition:leave-start="opacity-100 translate-x-0"
                      x-transition:leave-end="opacity-0 translate-x-2">
                    {{ $item['label'] }}
                </span>
            </a>
        @endforeach
    </nav>

    <!-- Footer / Logout -->
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center">
            <div class="h-9 w-9 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="ml-3" 
                 x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-2">
                <p class="text-sm font-medium text-gray-900">Admin</p>
                <button class="text-xs text-gray-500 hover:text-gray-700 flex items-center mt-1 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </div>
        </div>
    </div>
</div>