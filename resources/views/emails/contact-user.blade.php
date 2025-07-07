<!DOCTYPE html>
<html>

<head>
    <title>Confirmação - Mensagem Recebida</title>
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

        .highlight-box {
            background-color: #e8f5e8;
            border: 1px solid #16a085;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }

        .contact-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Mensagem Recebida com Sucesso!</h1>
    </div>

    <div class="content">
        <div class="section">
            <p>Olá <strong>{{ $data['name'] }}</strong>,</p>

            <div class="highlight-box">
                <h3 style="color: #16a085; margin-top: 0;">Sua mensagem foi recebida!</h3>
                <p>Recebemos sua mensagem sobre "<strong>{{ $data['subject'] }}</strong>" e nossa equipe entrará em contato em breve.</p>
            </div>

            <p>Agradecemos seu interesse em nossos serviços de logística e terceirização. Nossa equipe irá analisar sua mensagem e retornar o contato o mais rápido possível.</p>
        </div>

        <div class="section">
            <h3 style="color: #16a085;">Próximos Passos:</h3>
            <ul>
                <li>Nossa equipe analisará sua mensagem</li>
                <li>Entraremos em contato por telefone ou e-mail</li>
                <li>Forneceremos todas as informações solicitadas</li>
            </ul>
        </div>

        <div class="contact-info">
            <h4 style="color: #16a085; margin-top: 0;">Informações de Contato:</h4>
            <p><strong>Telefone:</strong> (11) 2358-9716<br>
                <strong>E-mail:</strong> francisco@fdslogistica.com.br<br>
                <strong>Endereço:</strong> Rua Palhoça, 398 - Parque Industrial Cumbica - Guarulhos/SP
            </p>
        </div>

        <div class="section">
            <p>Atenciosamente,</p>
            <p><strong>Equipe FDS Logística e Terceirização</strong></p>
        </div>
    </div>
</body>

</html>