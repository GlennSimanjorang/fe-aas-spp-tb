<div class="h-screen bg-white shadow-xl flex flex-col w-64">

    <!-- Branding -->
    <div class="px-6 py-5 border-b border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white p-2 rounded-xl shadow-sm">
                <i class="fas fa-graduation-cap text-lg"></i>
            </div>
            <div>
                <span class="text-xl font-bold text-gray-800">Admin</span>
                <p class="text-xs text-gray-500 mt-0.5">SMK Taruna Bhakti</p>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">

        @php
            $menu = [
                ['label' => 'Dashboard', 'icon' => 'fas fa-home', 'url' => '/dashboard', 'active' => request()->is('dashboard')],
                ['label' => 'Data Siswa', 'icon' => 'fas fa-users', 'url' => '/siswa', 'active' => request()->is('siswa*')],
                ['label' => 'Daftar User', 'icon' => 'fas fa-user-cog', 'url' => '/users', 'active' => request()->is('users*')],
                ['label' => 'Academic Years', 'icon' => 'fas fa-calendar-alt', 'url' => '/academic-years', 'active' => request()->is('academic-years*')],
                ['label' => 'Pembayaran', 'icon' => 'fas fa-money-bill-wave', 'url' => '/pembayaran', 'active' => request()->is('pembayaran*')],
                ['label' => 'Tunggakan', 'icon' => 'fas fa-clock', 'url' => '/tunggakan', 'active' => request()->is('tunggakan*')],
                ['label' => 'Laporan', 'icon' => 'fas fa-chart-bar', 'url' => '/laporan', 'active' => request()->is('laporan*')],
                ['label' => 'Notifikasi', 'icon' => 'fas fa-bell', 'url' => '/notifikasi', 'active' => request()->is('notifikasi*')],
            ];
        @endphp

        @foreach ($menu as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center px-4 py-3 text-sm rounded-xl border transition-all duration-200
                      {{ $item['active']
                          ? 'bg-blue-50 text-blue-600 border-blue-100 font-semibold'
                          : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-transparent'
                      }}">
                
                <i class="{{ $item['icon'] }} w-5 text-center
                    {{ $item['active'] ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}">
                </i>

                <span class="ml-3 font-medium">{{ $item['label'] }}</span>

                @if ($item['active'])
                    <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
            </a>
        @endforeach

    </nav>

    <!-- Logout -->
    <div class="px-6 py-4 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 w-full px-3 py-2 rounded-lg hover:bg-red-50 transition">
                
                <i class="fas fa-sign-out-alt text-gray-400 group-hover:text-red-500"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>

</div>
