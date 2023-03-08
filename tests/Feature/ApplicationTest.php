<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {

        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('api/position');
        $response->assertStatus(200);
    }
}


