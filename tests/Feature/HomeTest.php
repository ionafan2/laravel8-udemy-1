<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomeIsWorking(): void
    {
        $response = $this->get('/');
        $response->assertSeeText('Hello');
        $response->assertStatus(200);
    }

    public function testContactPageIsWorking(): void
    {
        $response = $this->get('/contact');
        $response->assertSeeText('Contact');
    }
}
