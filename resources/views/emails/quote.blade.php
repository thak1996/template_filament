<!DOCTYPE html>
<html>

<head>
    <title>Nova Solicitação de Orçamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #16a085;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h3 {
            color: #16a085;
            border-bottom: 2px solid #16a085;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .field {
            margin-bottom: 10px;
        }

        .field strong {
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Nova Solicitação de Orçamento</h1>
    </div>

    <div class="content">
        <div class="section">
            <h3>Dados do Cliente</h3>
            <div class="field"><strong>Nome:</strong> {{ $data['name'] }}</div>
            <div class="field"><strong>E-mail:</strong> {{ $data['email'] }}</div>
            <div class="field"><strong>Tipo de Mudança:</strong> {{ $data['type'] == 'residential' ? 'Residencial' : 'Comercial' }}</div>
            @if(isset($data['residential_phone']) && $data['residential_phone'])
            <div class="field"><strong>Telefone Residencial:</strong> {{ $data['residential_phone'] }}</div>
            @endif
            @if(isset($data['commercial_phone']) && $data['commercial_phone'])
            <div class="field"><strong>Telefone Comercial:</strong> {{ $data['commercial_phone'] }}</div>
            @endif
            @if(isset($data['mobile_phone']) && $data['mobile_phone'])
            <div class="field"><strong>Telefone Celular:</strong> {{ $data['mobile_phone'] }}</div>
            @endif
        </div>

        <div class="section">
            <h3>Local de Origem</h3>
            <div class="field"><strong>CEP:</strong> {{ $data['origin_zipcode'] }}</div>
            <div class="field"><strong>Endereço:</strong> {{ $data['origin_street'] }}</div>
            @if(isset($data['origin_number']) && $data['origin_number'])
            <div class="field"><strong>Número:</strong> {{ $data['origin_number'] }}</div>
            @endif
            <div class="field"><strong>Bairro:</strong> {{ $data['origin_district'] }}</div>
            <div class="field"><strong>Cidade:</strong> {{ $data['origin_city'] }}</div>
            <div class="field"><strong>Estado:</strong> {{ $data['origin_state'] }}</div>
            <div class="field"><strong>Tipo:</strong> {{ $data['origin_type'] == 'house' ? 'Casa' : 'Apartamento' }}</div>
            @if(isset($data['origin_elevator']))
            <div class="field"><strong>Elevador:</strong> {{ $data['origin_elevator'] == 'yes' ? 'Sim' : 'Não' }}</div>
            @endif
            @if(isset($data['origin_floor']) && $data['origin_floor'])
            <div class="field"><strong>Andar:</strong> {{ $data['origin_floor'] }}</div>
            @endif
        </div>

        <div class="section">
            <h3>Local de Destino</h3>
            <div class="field"><strong>CEP:</strong> {{ $data['destination_zipcode'] }}</div>
            <div class="field"><strong>Endereço:</strong> {{ $data['destination_street'] }}</div>
            @if(isset($data['destination_number']) && $data['destination_number'])
            <div class="field"><strong>Número:</strong> {{ $data['destination_number'] }}</div>
            @endif
            <div class="field"><strong>Bairro:</strong> {{ $data['destination_district'] }}</div>
            <div class="field"><strong>Cidade:</strong> {{ $data['destination_city'] }}</div>
            <div class="field"><strong>Estado:</strong> {{ $data['destination_state'] }}</div>
            <div class="field"><strong>Tipo:</strong> {{ $data['destination_type'] == 'house' ? 'Casa' : 'Apartamento' }}</div>
            @if(isset($data['destination_elevator']))
            <div class="field"><strong>Elevador:</strong> {{ $data['destination_elevator'] == 'yes' ? 'Sim' : 'Não' }}</div>
            @endif
            @if(isset($data['destination_floor']) && $data['destination_floor'])
            <div class="field"><strong>Andar:</strong> {{ $data['destination_floor'] }}</div>
            @endif
        </div>

        @if(isset($data['observations']) && $data['observations'])
        <div class="section">
            <h3>Observações</h3>
            <p>{{ $data['observations'] }}</p>
        </div>
        @endif

        <div class="section">
            <p><strong>Data da solicitação:</strong> {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>