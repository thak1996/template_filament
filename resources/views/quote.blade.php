@extends('components.layouts.app')

@section('title', 'Orçamento | FDS Logística e Terceirização')

@section('content')
<div class="min-h-screen flex flex-col">
    @include('components.header')
    <section style="background: linear-gradient(to right, #ebf8ff, #d1fae5); padding: 10px;" class="flex-1 py-10 pb-20 flex items-center justify-center">
        <div class="container mx-auto px-4 max-w-4xl bg-gray-50 rounded-lg shadow p-8">
            <h1 class="text-3xl md:text-4xl font-bold text-green-700 mb-8 text-center">Orçamento</h1>

            <form action="{{ route('quote.send') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Dados para contato</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo <span class="text-red-500">*</span></label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="residencial" class="mr-2" required>
                                    <span>Residencial</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="comercial" class="mr-2" required>
                                    <span>Comercial</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('name') }}">
                        </div>

                        <div>
                            <label for="residential_phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone residencial</label>
                            <input type="text" id="residential_phone" name="residential_phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="(11) 1234-5678" maxlength="15" value="{{ old('residential_phone') }}">
                        </div>

                        <div>
                            <label for="commercial_phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone comercial</label>
                            <input type="text" id="commercial_phone" name="commercial_phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="(11) 1234-5678" maxlength="15" value="{{ old('commercial_phone') }}">
                        </div>

                        <div>
                            <label for="mobile_phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone celular <span class="text-red-500">*</span></label>
                            <input type="text" id="mobile_phone" name="mobile_phone" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="(11) 91234-5678" maxlength="15" value="{{ old('mobile_phone') }}">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('email') }}">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Local de origem</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="origin_zipcode" class="block text-sm font-medium text-gray-700 mb-2">CEP <span class="text-red-500">*</span></label>
                            <input type="text" id="origin_zipcode" name="origin_zipcode" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="00000-000" maxlength="9" value="{{ old('origin_zipcode') }}">
                            <div id="origin_zipcode_loading" class="text-sm text-gray-500 mt-1 hidden">Buscando endereço...</div>
                            <div id="origin_zipcode_error" class="text-sm text-red-500 mt-1 hidden">CEP não encontrado</div>
                        </div>

                        <div>
                            <label for="origin_street" class="block text-sm font-medium text-gray-700 mb-2">Rua <span class="text-red-500">*</span></label>
                            <input type="text" id="origin_street" name="origin_street" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('origin_street') }}">
                        </div>

                        <div>
                            <label for="origin_number" class="block text-sm font-medium text-gray-700 mb-2">Número</label>
                            <input type="text" id="origin_number" name="origin_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Ex: 123, 456A" value="{{ old('origin_number') }}">
                        </div>

                        <div>
                            <label for="origin_district" class="block text-sm font-medium text-gray-700 mb-2">Bairro <span class="text-red-500">*</span></label>
                            <input type="text" id="origin_district" name="origin_district" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('origin_district') }}">
                        </div>

                        <div>
                            <label for="origin_city" class="block text-sm font-medium text-gray-700 mb-2">Cidade <span class="text-red-500">*</span></label>
                            <input type="text" id="origin_city" name="origin_city" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('origin_city') }}">
                        </div>

                        <div>
                            <label for="origin_state" class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-500">*</span></label>
                            <input type="text" id="origin_state" name="origin_state" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('origin_state') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de imóvel <span class="text-red-500">*</span></label>
                            <div class="flex space-x-4 mb-4">
                                <label class="flex items-center">
                                    <input type="radio" name="origin_type" value="house" class="mr-2" required onchange="toggleElevadorAndar('origin')">
                                    <span>Casa</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="origin_type" value="apartment" class="mr-2" required onchange="toggleElevadorAndar('origin')">
                                    <span>Apartamento</span>
                                </label>
                            </div>

                            <div id="origin_elevator_floor" class="grid-cols-1 md:grid-cols-2 gap-4 hidden">
                                <div>
                                    <div class="flex space-x-4 items-center">
                                        <span class="text-sm font-medium text-gray-700">Elevador <span class="text-red-500">*</span>:</span>
                                        <label class="flex items-center">
                                            <input type="radio" name="origin_elevator" value="sim" class="mr-2">
                                            <span>Sim</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="origin_elevator" value="nao" class="mr-2">
                                            <span>Não</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label for="origin_floor" class="block text-sm font-medium text-gray-700 mb-2">Andar</label>
                                    <input type="text" id="origin_floor" name="origin_floor" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Ex: 1º, 2º, Térreo" value="{{ old('origin_floor') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Local de entrega</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="destination_zipcode" class="block text-sm font-medium text-gray-700 mb-2">CEP <span class="text-red-500">*</span></label>
                            <input type="text" id="destination_zipcode" name="destination_zipcode" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="00000-000" maxlength="9" value="{{ old('destination_zipcode') }}">
                            <div id="destination_zipcode_loading" class="text-sm text-gray-500 mt-1 hidden">Buscando endereço...</div>
                            <div id="destination_zipcode_error" class="text-sm text-red-500 mt-1 hidden">CEP não encontrado</div>
                        </div>

                        <div>
                            <label for="destination_street" class="block text-sm font-medium text-gray-700 mb-2">Rua <span class="text-red-500">*</span></label>
                            <input type="text" id="destination_street" name="destination_street" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('destination_street') }}">
                        </div>

                        <div>
                            <label for="destination_number" class="block text-sm font-medium text-gray-700 mb-2">Número</label>
                            <input type="text" id="destination_number" name="destination_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Ex: 123, 456A" value="{{ old('destination_number') }}">
                        </div>

                        <div>
                            <label for="destination_district" class="block text-sm font-medium text-gray-700 mb-2">Bairro <span class="text-red-500">*</span></label>
                            <input type="text" id="destination_district" name="destination_district" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('destination_district') }}">
                        </div>

                        <div>
                            <label for="destination_city" class="block text-sm font-medium text-gray-700 mb-2">Cidade <span class="text-red-500">*</span></label>
                            <input type="text" id="destination_city" name="destination_city" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('destination_city') }}">
                        </div>

                        <div>
                            <label for="destination_state" class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-500">*</span></label>
                            <input type="text" id="destination_state" name="destination_state" required readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed" placeholder="Será preenchido automaticamente com o CEP" value="{{ old('destination_state') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de imóvel <span class="text-red-500">*</span></label>
                            <div class="flex space-x-4 mb-4">
                                <label class="flex items-center">
                                    <input type="radio" name="destination_type" value="house" class="mr-2" required onchange="toggleElevadorAndar('destination')">
                                    <span>Casa</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="destination_type" value="apartment" class="mr-2" required onchange="toggleElevadorAndar('destination')">
                                    <span>Apartamento</span>
                                </label>
                            </div>

                            <div id="destination_elevator_floor" class="grid-cols-1 md:grid-cols-2 gap-4 hidden">
                                <div>
                                    <div class="flex space-x-4 items-center">
                                        <span class="text-sm font-medium text-gray-700">Elevador <span class="text-red-500">*</span>:</span>
                                        <label class="flex items-center">
                                            <input type="radio" name="destination_elevator" value="sim" class="mr-2">
                                            <span>Sim</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="destination_elevator" value="nao" class="mr-2">
                                            <span>Não</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label for="destination_floor" class="block text-sm font-medium text-gray-700 mb-2">Andar</label>
                                    <input type="text" id="destination_floor" name="destination_floor" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Ex: 1º, 2º, Térreo" value="{{ old('destination_floor') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <label for="observations" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea id="observations" name="observations" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Descreva detalhes sobre a mudança, móveis especiais, etc.">{{ old('observations') }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold shadow hover:bg-green-700 transition">
                        Enviar Orçamento
                    </button>
                </div>
            </form>
        </div>
    </section>

    @include('components.modal-success', [
    'title' => 'Orçamento Enviado com Sucesso!',
    'message' => 'Sua solicitação foi recebida. Nossa equipe entrará em contato em breve para fornecer todas as informações sobre sua mudança.',
    'details' => '<strong>Próximos passos:</strong><br>
    • Nossa equipe analisará sua solicitação<br>
    • Entraremos em contato por telefone ou e-mail<br>
    • Enviaremos uma proposta personalizada'
    ])

    @include('components.modal-error', [
    'title' => 'Erro no Envio do Orçamento',
    'message' => 'Ocorreu um erro ao enviar sua solicitação. Por favor, tente novamente ou entre em contato conosco diretamente.',
    'details' => '<strong>O que você pode fazer:</strong><br>
    • Tente enviar o orçamento novamente<br>
    • Verifique se todos os campos estão preenchidos<br>
    • Entre em contato: contato@fdslogistica.com.br'
    ])

    @include('components.footer')
</div>
@endsection