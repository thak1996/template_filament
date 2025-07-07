<!-- Modal de Sucesso -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center" style="display: none;" data-show="{{ session('success') ? 'true' : 'false' }}">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4 p-6">
        <div class="text-center">
            <!-- Ícone de sucesso -->
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-green-700 mb-2">{{ $title ?? 'Sucesso!' }}</h3>
            <p class="text-gray-600 mb-4">
                {{ $message ?? 'Operação realizada com sucesso!' }}
            </p>

            @if(isset($details))
            <div class="bg-gray-50 rounded-lg p-3 mb-4 text-sm text-gray-600 text-left">
                {!! $details !!}
            </div>
            @endif

            <button onclick="closeModal('successModal')" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                OK
            </button>
        </div>
    </div>
</div>