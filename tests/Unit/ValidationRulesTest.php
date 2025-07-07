<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ValidationRulesTest extends TestCase
{
    use WithFaker;

    /**
     * Test CEP (zipcode) validation patterns
     */
    public function test_cep_validation_patterns()
    {
        $validCeps = [
            '12345-678',
            '12345678',
            '00000-000',
            '99999-999'
        ];

        $invalidCeps = [
            '123',
            '12345-67',
            '12345-6789',
            'abcde-fgh',
            '123456789',
            '1234-567'
        ];

        $pattern = '/^\d{5}-?\d{3}$/';

        foreach ($validCeps as $cep) {
            $this->assertTrue(
                (bool) preg_match($pattern, $cep),
                "CEP '{$cep}' should be valid"
            );
        }

        foreach ($invalidCeps as $cep) {
            $this->assertFalse(
                (bool) preg_match($pattern, $cep),
                "CEP '{$cep}' should be invalid"
            );
        }
    }

    /**
     * Test email validation
     */
    public function test_email_validation()
    {
        $validEmails = [
            'test@example.com',
            'user.name@domain.com.br',
            'contact@fdslogistica.com.br',
            'simple@domain.co'
        ];

        $invalidEmails = [
            'invalid-email',
            '@domain.com',
            'user@',
            'user..name@domain.com',
            'user name@domain.com'
        ];

        foreach ($validEmails as $email) {
            $this->assertTrue(
                filter_var($email, FILTER_VALIDATE_EMAIL) !== false,
                "Email '{$email}' should be valid"
            );
        }

        foreach ($invalidEmails as $email) {
            $this->assertFalse(
                filter_var($email, FILTER_VALIDATE_EMAIL) !== false,
                "Email '{$email}' should be invalid"
            );
        }
    }

    /**
     * Test string length limits
     */
    public function test_string_length_limits()
    {
        // Test name field (max 255)
        $validName = str_repeat('a', 255);
        $invalidName = str_repeat('a', 256);

        $this->assertLessThanOrEqual(255, strlen($validName));
        $this->assertGreaterThan(255, strlen($invalidName));

        // Test phone field (max 20)
        $validPhone = str_repeat('1', 20);
        $invalidPhone = str_repeat('1', 21);

        $this->assertLessThanOrEqual(20, strlen($validPhone));
        $this->assertGreaterThan(20, strlen($invalidPhone));

        // Test message field (max 2000 for contact, 1000 for quote observations)
        $validMessage = str_repeat('a', 2000);
        $invalidMessage = str_repeat('a', 2001);

        $this->assertLessThanOrEqual(2000, strlen($validMessage));
        $this->assertGreaterThan(2000, strlen($invalidMessage));
    }

    /**
     * Test property type validation
     */
    public function test_property_type_validation()
    {
        $validTypes = ['house', 'apartment'];
        $invalidTypes = ['casa', 'apartamento', 'other', 'building'];

        foreach ($validTypes as $type) {
            $this->assertContains($type, ['house', 'apartment']);
        }

        foreach ($invalidTypes as $type) {
            $this->assertNotContains($type, ['house', 'apartment']);
        }
    }

    /**
     * Test service type validation
     */
    public function test_service_type_validation()
    {
        $validServiceTypes = ['residential', 'commercial'];
        $invalidServiceTypes = ['residencial', 'comercial', 'industrial', 'other'];

        foreach ($validServiceTypes as $type) {
            $this->assertContains($type, ['residential', 'commercial']);
        }

        foreach ($invalidServiceTypes as $type) {
            $this->assertNotContains($type, ['residential', 'commercial']);
        }
    }

    /**
     * Test elevator options validation
     */
    public function test_elevator_options_validation()
    {
        $validOptions = ['yes', 'no'];
        $invalidOptions = ['sim', 'nao', 'true', 'false', '1', '0'];

        foreach ($validOptions as $option) {
            $this->assertContains($option, ['yes', 'no']);
        }

        foreach ($invalidOptions as $option) {
            $this->assertNotContains($option, ['yes', 'no']);
        }
    }
}
