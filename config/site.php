<?php

return [
    'description' => env('SITE_DESC', 'Descrição padrão do site para SEO.'),
    'keywords' => env('SITE_KEYWORDS', 'empresa, serviço, cidade'),
    'email' => env('SITE_EMAIL', 'contato@empresa.com.br'),
    'phone' => env('SITE_PHONE', '+55-11-0000-0000'),
    'address' => [
        'street' => 'Rua Exemplo, 123',
        'city' => 'Cidade',
        'state' => 'UF',
        'zip' => '00000-000',
    ],
    'from_email' => env('MAIL_FROM_ADDRESS', 'contato@empresa.com.br'),
];
