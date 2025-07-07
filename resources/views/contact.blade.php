@extends('components.layouts.app')

@section('title', 'Contato | FDS Logística e Terceirização')

@section('content')
<div class="min-h-screen flex flex-col">
    @include('components.header')
    <section style="background: linear-gradient(to right, #ebf8ff, #d1fae5);" class="flex-1 py-10 pb-20 flex items-center justify-center">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow p-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-green-700 mb-8 text-center">Contato</h1>
                    <p class="text-gray-600 mb-6 text-center">Para entrar em contato, preencha o formulário abaixo ou envie sua mensagem para o email: <strong class="text-red-600">contato@fdslogistica.com.br</strong></p>

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf

                        <h3 class="text-xl font-bold text-gray-800 mb-4">Dados para contato</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('name') }}">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ old('email') }}">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone <span class="text-red-500">*</span></label>
                                <input type="text" id="phone" name="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="(11) 91234-5678" maxlength="15" value="{{ old('phone') }}">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Assunto <span class="text-red-500">*</span></label>
                                <input type="text" id="subject" name="subject" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Assunto da mensagem" value="{{ old('subject') }}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mensagem <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" required rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Descreva sua dúvida, solicitação ou comentário...">{{ old('message') }}</textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold shadow hover:bg-green-700 transition">
                                Enviar Mensagem
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold text-green-700 mb-6">FDS Logística</h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">📞 Telefone</h3>
                            <p class="text-gray-600">11 2358-9716</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">📧 E-mail</h3>
                            <p class="text-gray-600">contato@fdslogistica.com.br</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">📍 Endereço</h3>
                            <p class="text-gray-600">
                                Rua Palhoça, 398<br>
                                Cumbica - Parque Industrial<br>
                                Guarulhos/SP<br>
                                CEP 07241-010
                            </p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">🕒 Horário de Atendimento</h3>
                            <p class="text-gray-600">
                                Segunda a Sexta: 8h às 18h<br>
                                Sábado: 8h às 12h
                            </p>
                        </div>
                    </div>

                    <!-- Mapa -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">📍 Localização</h3>
                        <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3658.748982091781!2d-46.524928824982!3d-23.43567898473533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5c1f4b8b8a8f%3A0x8e2f9b8f8e2f9b8f!2sRua%20Palho%C3%A7a%2C%20398%20-%20Cumbica%2C%20Guarulhos%20-%20SP%2C%20CEP%2007241-010!5e0!3m2!1spt-BR!2sbr!4v1680000000000!5m2!1spt-BR!2sbr"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.modal-success', [
    'title' => 'Mensagem Enviada com Sucesso!',
    'message' => 'Sua mensagem foi recebida com sucesso. Nossa equipe entrará em contato em breve.',
    'details' => '<strong>Próximos passos:</strong><br>
    • Nossa equipe analisará sua mensagem<br>
    • Entraremos em contato por telefone ou e-mail<br>
    • Forneceremos todas as informações solicitadas'
    ])

    @include('components.modal-error', [
    'title' => 'Erro no Envio da Mensagem',
    'message' => 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente ou entre em contato conosco diretamente.',
    'details' => '<strong>O que você pode fazer:</strong><br>
    • Tente enviar a mensagem novamente<br>
    • Verifique se todos os campos estão preenchidos<br>
    • Entre em contato: francisco@fdslogistica.com.br'
    ])

    @include('components.footer')
</div>
@endsection