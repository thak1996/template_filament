<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Recuperação de Senha</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #16a085;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .content {
            padding: 40px 30px;
            max-width: 600px;
            margin: -20px auto 0;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 30px;
        }

        .section h3 {
            color: #16a085;
            border-bottom: 2px solid #16a085;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .message-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            color: #856404;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            font-size: 0.95em;
        }

        .btn-login {
            display: inline-block;
            background-color: #16a085;
            color: #ffffff !important;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #138a72;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 style="margin:0; font-size: 24px;">Recuperação de Senha</h1>
    </div>

    <div class="content">
        <div class="section">
            <p>Olá, <strong>{{ $user->name }}</strong>!</p>
            <p>Recebemos uma solicitação para redefinir a senha da sua conta associada ao e-mail <strong>{{ $user->email }}</strong>.</p>
        </div>

        <div class="section">
            <h3>Ação Necessária</h3>
            <p>Para criar uma nova senha, clique no botão abaixo. Este link é seguro e único para você.</p>

            <div style="text-align: center;">
                <a href="{{ $url }}" class="btn-login">REDEFINIR MINHA SENHA</a>
            </div>
        </div>

        <div class="section">
            <div class="message-box">
                <strong>Atenção:</strong> Este link expira em 60 minutos. <br>
                Se você não solicitou essa alteração, por favor, ignore este e-mail.
            </div>

            <p style="font-size: 0.9em; color: #7f8c8d;">
                Se o botão não funcionar, copie e cole o link abaixo no seu navegador:<br>
                <a href="{{ $url }}" style="color: #16a085; word-break: break-all;">{{ $url }}</a>
            </p>
        </div>

        <div class="footer">
            <p>Enviado automaticamente pelo sistema {{ config('app.name') }}</p>
            <p>{{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>