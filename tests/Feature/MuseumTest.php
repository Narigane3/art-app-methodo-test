<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MuseumTest extends TestCase
{
    /**
     * Get all museums room data.
     */
    public function test_get_all_musiums_room_data(): void
    {
        $response = $this->get('/museums');

        $response->assertStatus(200);
    }

    /**
     * Get all artworks data in to the museum room.
     */
    public function test_get_all_artworks_data_in_to_the_museum_room(): void{
        $response = $this->get('/museums/1');

        $response->assertStatus(200);
    }

}
