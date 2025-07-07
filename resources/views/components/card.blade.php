<div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center">
    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $title }}</h3>
    <p class="text-gray-600 mb-6 text-center">{{ $text }}</p>
    <a href="{{ $link }}" @if(isset($external) && $external) target="_blank" rel="noopener" @endif
        class="bg-green-700 text-white px-5 py-2 rounded font-semibold hover:bg-green-900 transition">
        {{ $button }}
    </a>
</div>