<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Entities\Position;

class ConnectTest extends TestCase
{
    protected Position $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = app(Position::class);
    }

    public function testGetAll()
    {
        $position = $this->position->get();

        echo($position);
        $this->assertTrue($position->count() > 0);
    }
}


