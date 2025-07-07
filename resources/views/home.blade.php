@extends('components.layouts.app')

@section('title', 'FDS Logística e Terceirização')

@section('content')
<div class="min-h-screen flex flex-col">
    {{-- Header Component --}}
    @include('components.header')
    <section style="background: linear-gradient(to right, #ebf8ff, #d1fae5);" class="bg-hero-gradient py-10 md:py-16 flex-1">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-8 max-w-6xl h-full">
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold text-blue-800 mb-4">A sua melhor opção em mudanças e transportes</h1>
                <p class="text-lg md:text-xl text-gray-700 mb-6">Mudanças residenciais, comerciais, transporte de equipamentos sensíveis e armazenagem com qualidade e segurança.</p>
                <a href="/quote" class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg font-semibold shadow hover:bg-green-700 transition">Solicite um orçamento</a>
            </div>
            <div class="flex-1 flex justify-center">
                <img src="https://i.imgur.com/Yeuto4V.jpeg" alt="Caminhão FDS" class="rounded-lg shadow-lg w-full max-w-md">
            </div>
        </div>
    </section>
    <section style="background-color: #ffffff;" class="bg-white py-6">
        <div class="container mx-auto px-4 text-center max-w-4xl">
            <h2 class="text-lg md:text-xl font-bold text-gray-800">A sua melhor opção em mudança residencial, comercial e transporte especializado.</h2>
        </div>
    </section>
    <section style="background: linear-gradient(to right, #bfdbfe, #bbf7d0);" class="bg-cards-gradient py-12" id="empresa">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl">
            @include('components.card', [
            'title' => 'EMPRESA',
            'text' => 'A FDS trabalha no ramo de transportes especializados de mudanças comerciais, residenciais, transportes de sensíveis e de obras de artes, armazenagem e logística.',
            'link' => '/company',
            'button' => 'Conheça'
            ])
            @include('components.card', [
            'title' => 'SERVIÇOS',
            'text' => 'Mudanças comerciais e residenciais, transportes de sensíveis e obras de artes, desmontagem e montagem de mobiliários, remanejamentos internos, armazenagem, logística e distribuição.',
            'link' => '/quote',
            'button' => 'Veja mais'
            ])
            @include('components.card', [
            'title' => 'CONTATO',
            'text' => 'Caso tenha alguma dúvida ou queira solicitar mais informações sobre nossos serviços, entre em contato conosco.',
            'link' => '/contact',
            'button' => 'Entre em contato',
            'external' => true
            ])
        </div>
    </section>
    {{-- Footer Component --}}
    @include('components.footer')
</div>
@endsection