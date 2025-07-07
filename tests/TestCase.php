<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Force basic testing environment
        config([
            'app.env' => 'testing',
            'mail.driver' => 'array',
            'session.driver' => 'array',
            'cache.default' => 'array',
        ]);
    }

    /**
     * Helper method to create valid contact data
     */
    protected function validContactData(): array
    {
        return [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'phone' => '(11) 99999-9999',
            'subject' => 'Teste de contato',
            'message' => 'Esta é uma mensagem de teste.',
        ];
    }

    /**
     * Helper method to create valid quote data
     */
    protected function validQuoteData(): array
    {
        return [
            'type' => 'residential',
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'residential_phone' => '(11) 1234-5678',
            'commercial_phone' => '',
            'mobile_phone' => '(11) 99999-9999',
            'origin_zipcode' => '01234-567',
            'origin_street' => 'Rua das Flores',
            'origin_number' => '123',
            'origin_district' => 'Centro',
            'origin_city' => 'São Paulo',
            'origin_state' => 'SP',
            'origin_type' => 'house',
            'destination_zipcode' => '09876-543',
            'destination_street' => 'Avenida Brasil',
            'destination_number' => '456',
            'destination_district' => 'Jardins',
            'destination_city' => 'Rio de Janeiro',
            'destination_state' => 'RJ',
            'destination_type' => 'house',
            'observations' => 'Mudança com móveis especiais.',
        ];
    }
}
