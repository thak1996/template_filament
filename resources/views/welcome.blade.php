@extends('components.layouts.app')

@section('title', 'Captura de Leads | ' . config('site.name'))

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-6 antialiased text-gray-950">

    <div class="w-full max-w-xl">
        <div class="flex flex-col items-center mb-8">
            <div class="mb-4 p-3 bg-white shadow-sm ring-1 ring-gray-950/5 rounded-xl">
                <img src="{{ asset('images/fds-logo.png') }}" class="h-12 w-auto" alt="Logo">
            </div>
            <h1 class="text-2xl font-bold tracking-tight">Solicitar Orçamento</h1>
            <p class="text-sm text-gray-500 mt-1">Preencha os dados para entrar no nosso painel de leads.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-success-50 border border-success-200 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-sm text-success-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('leads.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-6 text-gray-950">Nome Completo</label>
                    <input type="text" name="nome" required
                        class="block w-full rounded-lg border-none bg-white px-3 py-1.5 text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus:ring-2 focus:ring-amber-500 sm:text-sm"
                        placeholder="Seu nome">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="grid gap-2">
                        <label class="text-sm font-medium leading-6 text-gray-950">E-mail</label>
                        <input type="email" name="email" required
                            class="block w-full rounded-lg border-none bg-white px-3 py-1.5 text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus:ring-2 focus:ring-amber-500 sm:text-sm"
                            placeholder="exemplo@email.com">
                    </div>

                    <div class="grid gap-2">
                        <label class="text-sm font-medium leading-6 text-gray-950">WhatsApp</label>
                        <input type="text" name="telefone" required
                            class="block w-full rounded-lg border-none bg-white px-3 py-1.5 text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus:ring-2 focus:ring-amber-500 sm:text-sm"
                            placeholder="(11) 99999-9999">
                    </div>
                </div>

                <div class="grid gap-2">
                    <label class="text-sm font-medium leading-6 text-gray-950">Como podemos ajudar?</label>
                    <textarea name="mensagem" rows="3"
                        class="block w-full rounded-lg border-none bg-white px-3 py-1.5 text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus:ring-2 focus:ring-amber-500 sm:text-sm"></textarea>
                </div>

                <button type="submit"
                    class="relative inline-grid grid-flow-col items-center justify-center gap-1.5 rounded-lg border-none bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-400 focus:ring-2 focus:ring-amber-500/50 w-full">
                    <span>Enviar Lead</span>
                </button>
            </form>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} {{ config('site.name') }} | Painel de Gestão Técnica
        </div>
    </div>
</div>