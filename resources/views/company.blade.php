@extends('components.layouts.app')

@section('title', 'A Empresa | FDS Logística e Terceirização')

@section('content')
<div class="min-h-screen flex flex-col">
    @include('components.header')
    <section style="background: linear-gradient(to right, #ebf8ff, #d1fae5); padding: 10px;" class="flex-1 py-6 md:py-10 pb-16 md:pb-20 flex items-center justify-center">
        <div class="container mx-auto px-6 sm:px-8 max-w-4xl bg-gray-50 rounded-lg shadow p-6 md:p-8">
            <h1 class="text-2xl md:text-4xl font-bold text-green-700 mb-4 md:mb-6 text-center">A Empresa</h1>
            <p class="mb-4 text-gray-800">Iniciando suas operações em 2005 a FDS Logística nasceu tendo como principais atividades mudanças residenciais e comerciais. Empresa que tem como meta a QUALIDADE TOTAL, com enorme dedicação no atendimento, informações e negociações.</p>
            <p class="mb-4 text-gray-800">FDS Logística é uma empresa especializada na prestação de serviços de logística e terceirização de mão de obra, tendo como principais atividades a administração e operacionalização da armazenagem, gerenciamento do transporte e/ou distribuição de qualquer tipo de bens ou produtos, terceirização de mão de obra especializada nas áreas de conservação e limpeza, portaria, jardinagem, entre outras que possam auxiliar a operacionalização de nossos clientes.</p>
            <p class="mb-4 text-gray-800">Os serviços são dimensionados e adaptados às necessidades dos nossos clientes, considerando custos, prazos, recursos, qualidade e questões estratégicas. A empresa atua em todo território nacional.</p>
            <p class="mb-4 text-gray-800">Para isso tem o conhecimento e a experiência necessária para a execução e implementação de projetos de logística integrada. Reúne pessoas com experiência para prestar o melhor serviço aos nossos clientes.</p>
            <p class="mb-0 text-gray-800">A FDS Logística busca interpretar as necessidades e vontades de seus clientes, dando a forma de atendimento mais apropriada às suas exigências. Com a parceria dos profissionais da FDS nossos clientes terão acesso ao que há de mais moderno, eficiente e econômico na hora em que necessitar dos serviços de uma transportadora para mudanças residenciais ou mudanças comerciais.</p>
        </div>
    </section>
    @include('components.footer')
</div>
@endsection