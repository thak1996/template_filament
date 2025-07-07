<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center" style="display: none;" data-show="{{ session('error') ? 'true' : 'false' }}">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4 p-6">
        <div class="text-center">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-red-700 mb-2">{{ $title ?? 'Erro!' }}</h3>
            <p class="text-gray-600 mb-4">
                {{ $message ?? 'Ocorreu um erro inesperado.' }}
            </p>

            @if(isset($details))
            <div class="bg-gray-50 rounded-lg p-3 mb-4 text-sm text-gray-600 text-left">
                {!! $details !!}
            </div>
            @endif

            <button onclick="closeModal('errorModal')" class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition">
                OK
            </button>
        </div>
    </div>
</div>