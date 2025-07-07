<!DOCTYPE html>
<html>

<head>
    <title>Nova Mensagem de Contato</title>
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

        .message-box {
            background-color: #f8f9fa;
            border-left: 4px solid #16a085;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Nova Mensagem de Contato</h1>
    </div>

    <div class="content">
        <div class="section">
            <h3>Dados do Contato</h3>
            <div class="field"><strong>Nome:</strong> {{ $data['name'] }}</div>
            <div class="field"><strong>E-mail:</strong> {{ $data['email'] }}</div>
            <div class="field"><strong>Telefone:</strong> {{ $data['phone'] }}</div>
            <div class="field"><strong>Assunto:</strong> {{ $data['subject'] }}</div>
        </div>

        <div class="section">
            <h3>Mensagem</h3>
            <div class="message-box">
                {{ $data['message'] }}
            </div>
        </div>

        <div class="section">
            <p><strong>Data da mensagem:</strong> {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>