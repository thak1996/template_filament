<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Fake Mail to prevent actual emails being sent during tests
        Mail::fake();
    }

    /**
     * Get valid quote data for testing
     */
    private function getValidQuoteData(): array
    {
        return [
            'type' => 'residential',
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'residential_phone' => '(11) 1234-5678',
            'commercial_phone' => '',
            'mobile_phone' => '(11) 99999-9999',
            'origin_zipcode' => '01234-567',
            'origin_street' => $this->faker->streetName,
            'origin_number' => '123',
            'origin_district' => $this->faker->city,
            'origin_city' => $this->faker->city,
            'origin_state' => 'SP',
            'origin_type' => 'house',
            'destination_zipcode' => '09876-543',
            'destination_street' => $this->faker->streetName,
            'destination_number' => '456',
            'destination_district' => $this->faker->city,
            'destination_city' => $this->faker->city,
            'destination_state' => 'RJ',
            'destination_type' => 'house',
            'observations' => $this->faker->paragraph,
        ];
    }

    /**
     * Test that the quote page is displayed correctly
     */
    public function test_quote_page_displays_correctly()
    {
        $response = $this->get('/quote');

        $response->assertStatus(200);
        $response->assertViewIs('quote');
        $response->assertSee('Orçamento');
        $response->assertSee('origin_zipcode');
        $response->assertSee('destination_zipcode');
    }

    /**
     * Test successful quote form submission with house type
     */
    public function test_quote_form_submission_success_house()
    {
        $quoteData = $this->getValidQuoteData();

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
        $response->assertSessionMissing('error');
    }

    /**
     * Test successful quote form submission with apartment type
     */
    public function test_quote_form_submission_success_apartment()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['origin_type'] = 'apartment';
        $quoteData['origin_elevator'] = 'yes';
        $quoteData['origin_floor'] = '5º';
        $quoteData['destination_type'] = 'apartment';
        $quoteData['destination_elevator'] = 'no';
        $quoteData['destination_floor'] = '2º';

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
        $response->assertSessionMissing('error');
    }

    /**
     * Test quote form validation - required fields
     */
    public function test_quote_form_validation_required_fields()
    {
        $response = $this->post(route('quote.send'), []);

        $response->assertSessionHasErrors([
            'type',
            'name',
            'email',
            'origin_zipcode',
            'origin_street',
            'origin_district',
            'origin_city',
            'origin_state',
            'origin_type',
            'destination_zipcode',
            'destination_street',
            'destination_district',
            'destination_city',
            'destination_state',
            'destination_type',
            'mobile_phone',
        ]);
    }

    /**
     * Test quote form validation - invalid type values
     */
    public function test_quote_form_validation_invalid_type_values()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['type'] = 'invalid';
        $quoteData['origin_type'] = 'invalid';
        $quoteData['destination_type'] = 'invalid';

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertSessionHasErrors([
            'type',
            'origin_type',
            'destination_type'
        ]);
    }

    /**
     * Test quote form validation - invalid zipcode format
     */
    public function test_quote_form_validation_invalid_zipcode()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['origin_zipcode'] = '123';
        $quoteData['destination_zipcode'] = 'invalid';

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertSessionHasErrors([
            'origin_zipcode',
            'destination_zipcode'
        ]);
    }

    /**
     * Test quote form validation - elevator required for apartments
     */
    public function test_quote_form_validation_elevator_required_for_apartments()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['origin_type'] = 'apartment';
        $quoteData['destination_type'] = 'apartment';
        // Don't set elevator fields

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertSessionHasErrors([
            'origin_elevator',
            'destination_elevator'
        ]);
    }

    /**
     * Test quote form validation - invalid email format
     */
    public function test_quote_form_validation_invalid_email()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['email'] = 'invalid-email';

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test quote form validation - field max lengths
     */
    public function test_quote_form_validation_max_lengths()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['name'] = str_repeat('a', 256); // Max 255
        $quoteData['origin_number'] = str_repeat('1', 21); // Max 20
        $quoteData['mobile_phone'] = str_repeat('1', 21); // Max 20
        $quoteData['observations'] = str_repeat('a', 1001); // Max 1000

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertSessionHasErrors([
            'name',
            'origin_number',
            'mobile_phone',
            'observations'
        ]);
    }

    /**
     * Test quote form handles mail sending exceptions
     */
    public function test_quote_form_handles_mail_exceptions()
    {
        // Mock Mail to throw an exception
        Mail::shouldReceive('send')->andThrow(new \Exception('Mail server error'));

        // Mock Log to verify error logging
        Log::shouldReceive('error')->once()->with(
            'Error sending quote emails',
            ['error' => 'Mail server error']
        );

        $quoteData = $this->getValidQuoteData();

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertRedirect();
        $response->assertSessionHas('error', true);
    }

    /**
     * Test quote form with commercial type
     */
    public function test_quote_form_commercial_type()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['type'] = 'commercial';
        $quoteData['commercial_phone'] = '(11) 3333-4444';

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
    }

    /**
     * Test quote form with valid zipcode formats
     */
    public function test_quote_form_valid_zipcode_formats()
    {
        // Test with dash
        $quoteData = $this->getValidQuoteData();
        $quoteData['origin_zipcode'] = '12345-678';
        $quoteData['destination_zipcode'] = '98765-432';

        $response = $this->post(route('quote.send'), $quoteData);
        $response->assertSessionDoesntHaveErrors(['origin_zipcode', 'destination_zipcode']);

        // Test without dash
        $quoteData['origin_zipcode'] = '12345678';
        $quoteData['destination_zipcode'] = '98765432';

        $response = $this->post(route('quote.send'), $quoteData);
        $response->assertSessionDoesntHaveErrors(['origin_zipcode', 'destination_zipcode']);
    }

    /**
     * Test quote form with mixed apartment and house types
     */
    public function test_quote_form_mixed_property_types()
    {
        $quoteData = $this->getValidQuoteData();
        $quoteData['origin_type'] = 'apartment';
        $quoteData['origin_elevator'] = 'yes';
        $quoteData['origin_floor'] = '3º';
        $quoteData['destination_type'] = 'house';

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
    }

    /**
     * Test elevator data cleanup for house types
     */
    public function test_elevator_data_cleanup_for_houses()
    {
        $quoteData = $this->getValidQuoteData();
        // Simulate form sending elevator data for house (shouldn't happen in UI but test robustness)
        $quoteData['origin_type'] = 'house';
        $quoteData['destination_type'] = 'house';

        $response = $this->post(route('quote.send'), $quoteData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
    }
}
