<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @foreach($overview_data['cards'] as $card)
    <div class="{{ $loop->first ? 'bg-blue-600 text-white' : 'bg-white' }} p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
            <p class="text-sm {{ $loop->first ? '' : 'text-gray-500' }}">{{ $card->title }}</p>
            <p class="text-3xl font-bold {{ $loop->first ? '' : 'text-gray-800' }}">{{ $card->value }}</p>
        </div>
        <div class="{{ $card->icon_bg }} p-3 rounded-full {{ $loop->first ? 'bg-opacity-20' : '' }}">
            <svg class="w-6 h-6 {{ $card->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card->svg_path }}"></path>
            </svg>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Kirim Pesan Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($overview_data['quick_send'] as $quick)
        <div class="bg-gray-100 p-4 rounded-lg flex flex-col items-center text-center">
            <div class="{{ $quick->icon_bg }} p-3 rounded-full mb-2">
                <svg class="w-6 h-6 {{ $quick->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $quick->svg_path }}"></path>
                </svg>
            </div>
            <p class="font-semibold text-gray-800">{{ $quick->title }}</p>
            <p class="text-sm text-gray-500">{{ $quick->count }}</p>
        </div>
        @endforeach
    </div>
</div>