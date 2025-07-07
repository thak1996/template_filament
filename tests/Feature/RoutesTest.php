<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * Test that home route works
     */
    public function test_home_route()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test that contact routes work
     */
    public function test_contact_routes()
    {
        // Test GET route
        $response = $this->get('/contact');
        $response->assertStatus(200);

        // Test POST route exists (will fail validation but route should exist)
        $response = $this->post('/contact');
        $response->assertStatus(302); // Redirect due to validation errors
    }

    /**
     * Test that quote routes work
     */
    public function test_quote_routes()
    {
        // Test GET route
        $response = $this->get('/quote');
        $response->assertStatus(200);

        // Test POST route exists (will fail validation but route should exist)
        $response = $this->post('/quote');
        $response->assertStatus(302); // Redirect due to validation errors
    }

    /**
     * Test that service route works
     */
    public function test_service_route()
    {
        $response = $this->get('/service');
        $response->assertStatus(200);
    }

    /**
     * Test that company route works
     */
    public function test_company_route()
    {
        $response = $this->get('/company');
        $response->assertStatus(200);
    }

    /**
     * Test route names are correctly defined
     */
    public function test_route_names()
    {
        $this->assertTrue(route('contact.send') !== null);
        $this->assertTrue(route('quote.send') !== null);
    }

    /**
     * Test 404 for non-existent routes
     */
    public function test_404_for_non_existent_routes()
    {
        $response = $this->get('/non-existent-page');
        $response->assertStatus(404);
    }

    /**
     * Test that all main pages return valid HTML
     */
    public function test_pages_return_valid_html()
    {
        $pages = ['/', '/contact', '/quote', '/service', '/company'];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);

            // Check for basic HTML structure
            $response->assertSee('<html', false);
            $response->assertSee('</html>', false);
            $response->assertSee('<head>', false);
            $response->assertSee('<body>', false);
        }
    }
}
