<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowLoginPage extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testShowLoginPage(): void
    {
        $response = $this->withoutMiddleware()->get('/login');

        $response->assertStatus(200);
    }
}
