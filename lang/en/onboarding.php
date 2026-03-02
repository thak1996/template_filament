<?php

return [
    'navigation' => [
        'company_settings' => 'Company data',
        'settings_group' => 'Settings',
    ],

    'company' => [
        'register_label' => 'Register company',
        'profile_label' => 'Company data',
        'name' => 'Company name',
        'cnpj' => 'CNPJ',
        'editable_section_title' => 'Company data',
        'editable_section_description' => 'Information you can update.',
        'readonly_section_title' => 'Access and identification',
        'readonly_section_description' => 'Read-only data to share company access.',
        'company_url' => 'Company link',
        'company_url_helper' => 'This link is generated automatically and cannot be changed here.',
        'slug' => 'Slug',
    ],

    'client_register' => [
        'cpf' => 'CPF',
        'is_accountant' => 'Are you an accountant?',
        'crc' => 'CRC',
        'accounting_cnpj' => 'Accounting firm CNPJ',
        'has_cnpj' => 'Do you have a CNPJ?',
        'company_cnpj' => 'Company CNPJ',
        'company_identifier' => 'Company identifier (CODE)',
        'default_company_name' => 'Company :cnpj',

        'messages' => [
            'cpf_required' => 'Please provide your CPF to continue.',
            'cpf_unique' => 'This CPF is already registered.',
            'crc_regex' => 'Invalid format. Use: CRC-UF NNNNNN/Type-DV (e.g. CRC-SP 123456/O-1).',
            'accounting_cnpj_required' => 'Please provide the accounting firm CNPJ.',
            'company_cnpj_required' => 'Please provide the company CNPJ.',
            'invalid_accounting_cnpj' => 'Please provide a valid accounting firm CNPJ.',
            'invalid_company_cnpj' => 'Please provide a valid company CNPJ.',
            'company_identifier_required' => 'Please provide the company identifier.',
            'company_not_found' => 'No company was found for this identifier.',
        ],
    ],

    'validation' => [
        'cpf_format' => 'Invalid CPF. Use the format 000.000.000-00.',
        'cpf_digits' => 'Invalid CPF. Check the digits you entered.',
        'cnpj_format' => 'Invalid CNPJ. Use the format 00.000.000/0000-00.',
        'cnpj_digits' => 'Invalid CNPJ. Check the digits you entered.',
    ],
];
