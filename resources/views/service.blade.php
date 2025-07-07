@extends('components.layouts.app')

@section('title', 'Serviços | FDS Logística e Terceirização')

@section('content')
<div class="min-h-screen flex flex-col">
    @include('components.header')
    <section style="background: linear-gradient(to right, #ebf8ff, #d1fae5); padding: 10px;" class="flex-1 py-10 pb-20 flex items-center justify-center">
        <div class="container mx-auto px-4 max-w-5xl bg-gray-50 rounded-lg shadow p-8">
            <h1 class="text-3xl md:text-4xl font-bold text-green-700 mb-8 text-center">Serviços</h1>

            <div class="space-y-6">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Mudanças Comerciais:</h3>
                    <p class="text-gray-700">Todos os processos de mudanças corporativas são gerenciados em todas as suas fases por coordenadores especializados. Os processos de codificação e de identificação dos layouts e das embalagens para o transporte são totalmente inventariados e monitorados. Desta forma garantimos uma transição suave e sem transtornos às áreas e departamentos em movimento.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Mudanças Residenciais:</h3>
                    <p class="text-gray-700">Realizamos mudanças locais, intermunicipais e interestaduais porta a porta para todo o território nacional. Utilizamos os melhores materiais descartáveis para acondicionar seus pertences (caixas de papelão triplex, papéis de seda, papel Kraft, papelão ondulado para as embalagens do mobiliário e mantas especiais para roupas de papelão entre outros). Desmontamos e montamos todo tipo de mobiliário. Inventariamos todos os itens da mudança dando mais segurança aos nossos clientes.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Transportes de sensíveis:</h3>
                    <p class="text-gray-700">Utilizamos profissionais qualificados e treinados para o manuseio de equipamentos sensíveis embalando, removendo e transportando dentro das normativas dos nossos clientes assegurando a qualidade dos equipamentos.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Transportes de Obras de Artes:</h3>
                    <p class="text-gray-700">Realizamos serviços de embalagens especiais seguindo as normas exigidas por nossos clientes e utilizamos laudos técnicos para assegurar a qualidade de nossas embalagens. Os transportes são realizados em veículos climatizados e equipados com suspensão à ar.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Desmontagem e Montagem de Mobiliários:</h3>
                    <p class="text-gray-700">Mão de obra treinada e especializada que seguem as recomendações dos fabricantes.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Remanejamentos Internos:</h3>
                    <p class="text-gray-700">Equipe especializada em emplastação de layout coordenadas por profissional especializado, atendendo as exigências e expectativas dos arquitetos e gerenciadores envolvidos no processo agilizando com segurança, pontualidade e organização na implantação.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Armazenagem:</h3>
                    <p class="text-gray-700">Oferecemos uma nova filosofia de armazenagem, agregada às mudanças físicas ou estruturais de uma empresa. Fazemos uma análise comparativa do mobiliário existente, armazenando seu excedente em nossos depósitos, com total classificação e controle on-line pelo cliente. Possuímos sistema WMS (Warehouse Management System), para o gerenciamento de todo e qualquer item a ser armazenado emitindo relatórios gerenciais de fácil acesso ao cliente.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Logística e Distribuição:</h3>
                    <p class="text-gray-700">Colocamos a disposição frotas de veículos de pequeno, médio e grande porte dotados de rastreadores via satélite, gerenciadores de risco e aplices de seguro ACF (Art. Seguro), em grandes centros e pontos de apoio para operação de aplicação e preservação.</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Terceirização de Mão de Obra:</h3>
                    <p class="text-gray-700">Somos uma empresa especializada no fornecimento de mão de obra em diversos segmentos, tais como limpeza, portaria, jardinagem, copa, recepção, entre outros. Nossos funcionários são especializados, sendo treinados com frequência para melhor atender nossos clientes. Uma das principais vantagens na terceirização de mão de obra é que nossos clientes conseguem focar seus esforços nas atividades fim da empresa, deixando a nosso cargo, toda mão de obra necessária para dar suporte.</p>
                </div>
            </div>
        </div>
    </section>
    @include('components.footer')
</div>
@endsection