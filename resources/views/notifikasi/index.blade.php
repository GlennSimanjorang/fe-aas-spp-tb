@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Notifikasi</h1>
                    <p class="text-gray-500 mt-2">Kelola semua pemberitahuan Anda di satu tempat</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ count($notifikasi) }} Notifikasi
                    </span>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                    <p class="text-red-700 mt-1 text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Notifications List -->
        <div class="space-y-4">
            @forelse ($notifikasi as $notif)
                <div class="notification-item bg-white rounded-2xl shadow-sm border border-gray-100 p-6 
                    {{ $notif['is_read'] ? '' : 'unread-indicator border-l-4 border-l-blue-500' }} 
                    transition-all duration-300 hover:shadow-md">
                    
                    <!-- Notification Header -->
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0 mt-1">
                                @if ($notif['type'] === 'payment_success')
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-bell text-blue-600"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $notif['title'] }}</h3>
                                    @if (!$notif['is_read'])
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Baru
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 mt-2 leading-relaxed">{{ $notif['message'] }}</p>
                                
                                <!-- Bill Details -->
                                @if (isset($notif['bill']))
                                    <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <h4 class="text-sm font-medium text-gray-900 mb-3">Detail Pembayaran</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                            <div>
                                                <p class="text-gray-500">Bulan</p>
                                                <p class="font-medium text-gray-900">{{ $notif['bill']['month_year'] }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Jumlah</p>
                                                <p class="font-medium text-green-600">Rp {{ number_format($notif['bill']['amount']) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Status</p>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $notif['bill']['status'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($notif['bill']['status']) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Timestamp -->
                                <div class="flex items-center mt-4 text-sm text-gray-500">
                                    <i class="far fa-clock mr-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Menu -->
                        <div class="flex-shrink-0">
                            <button class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                                <i class="fas fa-ellipsis-v text-gray-400"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada notifikasi</h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        Semua notifikasi Anda akan muncul di sini. Kembali lagi nanti untuk melihat pembaruan.
                    </p>
                </div>
            @endforelse
        </div>
        
        <!-- Load More Button (Optional) -->
        @if(count($notifikasi) > 0)
            <div class="mt-8 text-center">
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Muat Lebih Banyak
                </button>
            </div>
        @endif
    </div>
</div>

<style>
    .notification-item {
        transition: all 0.3s ease;
    }
    
    .notification-item:hover {
        transform: translateY(-2px);
    }
    
    .unread-indicator {
        position: relative;
    }
</style>
@endsection