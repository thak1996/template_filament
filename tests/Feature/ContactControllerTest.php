<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Fake Mail to prevent actual emails being sent during tests
        Mail::fake();
    }

    /**
     * Test that the contact page is displayed correctly
     */
    public function test_contact_page_displays_correctly()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertViewIs('contact');
        $response->assertSee('Contato');
        $response->assertSee('Nome'); // Mudou para o texto correto da página
        $response->assertSee('E-mail');
        $response->assertSee('Telefone');
    }

    /**
     * Test successful contact form submission
     */
    public function test_contact_form_submission_success()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '(11) 99999-9999',
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
        ];

        $response = $this->post(route('contact.send'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
        $response->assertSessionMissing('error');
    }

    /**
     * Test contact form validation - required fields
     */
    public function test_contact_form_validation_required_fields()
    {
        $response = $this->post(route('contact.send'), []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'phone',
            'subject',
            'message'
        ]);
    }

    /**
     * Test contact form validation - invalid email format
     */
    public function test_contact_form_validation_invalid_email()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => 'invalid-email',
            'phone' => '(11) 99999-9999',
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
        ];

        $response = $this->post(route('contact.send'), $contactData);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test contact form validation - field max lengths
     */
    public function test_contact_form_validation_max_lengths()
    {
        $contactData = [
            'name' => str_repeat('a', 256), // Max 255
            'email' => $this->faker->email,
            'phone' => str_repeat('1', 21), // Max 20
            'subject' => str_repeat('a', 256), // Max 255
            'message' => str_repeat('a', 2001), // Max 2000
        ];

        $response = $this->post(route('contact.send'), $contactData);

        $response->assertSessionHasErrors([
            'name',
            'phone',
            'subject',
            'message'
        ]);
    }

    /**
     * Test contact form handles mail sending exceptions
     */
    public function test_contact_form_handles_mail_exceptions()
    {
        // Mock Mail to throw an exception
        Mail::shouldReceive('send')->andThrow(new \Exception('Mail server error'));

        // Mock Log to verify error logging
        Log::shouldReceive('error')->once()->with(
            'Error sending contact emails',
            ['error' => 'Mail server error']
        );

        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '(11) 99999-9999',
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
        ];

        $response = $this->post(route('contact.send'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHas('error', true);
    }

    /**
     * Test contact form with minimum valid data
     */
    public function test_contact_form_minimum_valid_data()
    {
        $contactData = [
            'name' => 'A',
            'email' => 'test@example.com',
            'phone' => '1',
            'subject' => 'A',
            'message' => 'A',
        ];

        $response = $this->post(route('contact.send'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
    }

    /**
     * Test contact form with special characters
     */
    public function test_contact_form_with_special_characters()
    {
        $contactData = [
            'name' => 'José da Silva',
            'email' => 'jose@teste.com.br',
            'phone' => '(11) 99999-9999',
            'subject' => 'Orçamento para mudança',
            'message' => 'Preciso de um orçamento para mudança. Tenho móveis especiais: sofá, geladeira, etc.',
        ];

        $response = $this->post(route('contact.send'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHas('success', true);
    }
}
