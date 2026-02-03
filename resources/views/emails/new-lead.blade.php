<!DOCTYPE html>
<html>

<head>
    <title>Novo Lead Recebido</title>
</head>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee;">
        <h2 style="color: #2563eb;">Você recebeu um novo contato!</h2>
        <p>Alguém preencheu o formulário no site <strong>{{ config('site.name') }}</strong>.</p>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

        <p><strong>Nome:</strong> {{ $this->lead->nome }}</p>
        <p><strong>E-mail:</strong> {{ $this->lead->email }}</p>
        <p><strong>Telefone:</strong> {{ $this->lead->telefone }}</p>
        <p><strong>Mensagem:</strong></p>
        <div style="background: #f9fafb; padding: 15px; border-radius: 5px;">
            {{ $this->lead->mensagem ?? 'Nenhuma mensagem enviada.' }}
        </div>

        <footer style="margin-top: 30px; font-size: 12px; color: #666;">
            Este é um e-mail automático enviado pelo sistema do seu site.
        </footer>
    </div>
</body>

</html>