<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Bem-vindo ao Sistema</title>
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
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
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
            font-size: 1.2em;
            font-family: monospace;
        }

        .btn-login {
            display: inline-block;
            background-color: #16a085;
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Bem-vindo ao Sistema!</h1>
    </div>

    <div class="content">
        <div class="section">
            <p>Olá!</p>
            <p>Sua conta foi criada com sucesso. Abaixo estão as suas credenciais para acessar o painel administrativo.</p>
        </div>

        <div class="section">
            <h3>Dados de Acesso</h3>
            <div class="field"><strong>Link de Acesso:</strong> <a href="{{ $url }}" style="color: #16a085;">Acessar Painel</a></div>
            <div class="field"><strong>E-mail (Login):</strong> {{ $email }}</div>
        </div>

        <div class="section">
            <h3>Sua Senha Provisória</h3>
            <p>Copie a senha abaixo para fazer o seu primeiro login:</p>
            <div class="message-box">
                {{ $password }}
            </div>
            <p style="font-size: 0.9em; color: #e74c3c;">* Recomendamos que você altere sua senha no menu "Perfil" após entrar.</p>
        </div>

        <div style="text-align: center;">
            <a href="{{ $url }}" class="btn-login">CLIQUE AQUI PARA ENTRAR</a>
        </div>

        <div class="footer">
            <p>Gerado automaticamente em: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>