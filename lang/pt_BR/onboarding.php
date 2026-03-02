<?php

return [
    'navigation' => [
        'company_settings' => 'Dados da empresa',
        'settings_group' => 'Configurações',
    ],

    'company' => [
        'register_label' => 'Cadastrar empresa',
        'profile_label' => 'Dados da empresa',
        'name' => 'Nome da empresa',
        'cnpj' => 'CNPJ',
        'editable_section_title' => 'Dados da empresa',
        'editable_section_description' => 'Informações que você pode atualizar.',
        'readonly_section_title' => 'Acesso e identificação',
        'readonly_section_description' => 'Dados somente leitura para compartilhar o acesso da empresa.',
        'company_url' => 'Link da empresa',
        'company_url_helper' => 'Esse link é gerado automaticamente e não pode ser alterado por aqui.',
        'slug' => 'Slug',
    ],

    'client_register' => [
        'cpf' => 'CPF',
        'is_accountant' => 'É contador?',
        'crc' => 'CRC',
        'accounting_cnpj' => 'CNPJ da contabilidade',
        'has_cnpj' => 'Possui CNPJ?',
        'company_cnpj' => 'CNPJ da empresa',
        'company_identifier' => 'Identificador da empresa (CÓDIGO)',
        'default_company_name' => 'Empresa :cnpj',

        'messages' => [
            'cpf_required' => 'Informe o CPF para continuar.',
            'cpf_unique' => 'Este CPF já está cadastrado.',
            'crc_regex' => 'Formato inválido. Use o padrão: CRC-UF NNNNNN/Tipo-DV (ex.: CRC-SP 123456/O-1).',
            'accounting_cnpj_required' => 'Informe o CNPJ da contabilidade.',
            'company_cnpj_required' => 'Informe o CNPJ da empresa.',
            'invalid_accounting_cnpj' => 'Informe um CNPJ válido da contabilidade.',
            'invalid_company_cnpj' => 'Informe um CNPJ válido da empresa.',
            'company_identifier_required' => 'Informe o identificador da empresa.',
            'company_not_found' => 'Empresa não encontrada para este identificador.',
        ],
    ],

    'validation' => [
        'cpf_format' => 'CPF inválido. Use o formato 000.000.000-00.',
        'cpf_digits' => 'CPF inválido. Verifique os dígitos informados.',
        'cnpj_format' => 'CNPJ inválido. Use o formato 00.000.000/0000-00.',
        'cnpj_digits' => 'CNPJ inválido. Verifique os dígitos informados.',
    ],
];
