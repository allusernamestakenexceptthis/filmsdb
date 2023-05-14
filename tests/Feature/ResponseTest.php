<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    /**
     * Test root returns a response.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

     /**
     * Test favorites route returns unauthenticated response.
     */
    public function test_favorites_returns_unauthorized_response(): void
    {
        $response = $this->get('/favorites', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401);
    }
}
