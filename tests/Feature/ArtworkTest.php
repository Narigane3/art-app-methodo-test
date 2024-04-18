<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtworkTest extends TestCase
{
    // Refresh the database before each test.
    use RefreshDatabase;

    /**
     * Check add artwork form data based on the given data.
     */
    public function test_add_artwork_form_data(): void
    {
        $response = $this->post('/artwork', [
            'title' => 'Test Artwork',
            'description' => 'This is a test artwork',
            'artist' => 'Test Artist',
            'year' => 2021,
            'image' => 'test.jpg',
            'status' => 'available',
        ]);

        $response->assertStatus(302);
        $response->assertSee('Artwork added successfully');
        $response->assertRedirectToRoute('artwork.index');
    }

    /**
     * Check edit artwork form data based on the given data.
     */
    public function test_edit_artwork_form_data(): void
    {
        $response = $this->put('/artwork/1', [
            'title' => 'Test Artwork',
            'description' => 'This is a test artwork',
            'artist' => 'Test Artist',
            'year' => 2021,
            'image' => 'test.jpg',
            'status' => 'available',
        ]);

        $response->assertStatus(302);
        $response->assertSee('Artwork updated successfully');
        $response->assertRedirectToRoute('artwork.index');
    }

    /**
     * Check archive artwork form data based on the given data.
     */
    public function test_archive_artwork_form_data(): void
    {
        $response = $this->delete('/artwork/1');

        $response->assertStatus(302);
        $this->assertDatabaseHas('artworks', ['id' => 1, 'deleted_at' => now()]);
        $response->assertSee('Artwork archived successfully');
        $response->assertRedirectToRoute('artwork.index');
    }

    /**
     * Get all artworks archive data.
     */
    public function test_get_all_archived_artworks(): void
    {
        $response = $this->get('/artworks/archive');
        $response->assertStatus(200);
    }

    /**
     * Check restore artwork form data based on the given data.
     */
    public function it_tracks_artwork_history(): void
    {
        $artwork = Artwork::create([
            'name' => 'The Night Watch',
            'artist' => 'Rembrandt',
            'year' => 1642
        ]);

        // Simuler une modification pour générer un historique
        $artwork->update(['year' => 1643]);

        $response = $this->get("/artworks/{$artwork->id}/history");
        $response->assertStatus(200)
            ->assertSee('1643');  // Vérifie que l'historique inclut la dernière mise à jour
    }

    /**
     * Check restore artwork form data based on the given data.
     */
    public function test_restore_artwork_form_data(): void
    {
        $response = $this->post('/artwork/1/restore');

        $response->assertStatus(302);
        $this->assertDatabaseHas('artworks', ['id' => 1, 'deleted_at' => null]);
        $response->assertSee('Artwork restored successfully');
        $response->assertRedirectToRoute('artwork.index');
    }

    /**
     * check if fail to restore artwork if is not archived.
     */
    public function test_fail_to_restore_artwork_if_is_not_archived(): void{
        $response = $this->post('/artwork/1/restore');

        $response->assertStatus(302);
        $response->assertSee('Artwork not found');
        $response->assertRedirectToRoute('artwork.index');
    }

    /**
     * Check fail to add artwork form data based on the given data.
     * @return void
     */
    public function test_fail_to_add_artwork_form_data(): void{
        $response = $this->post('/artwork', [
            'year' => 2021,
            'image' => 'test.jpg',
            'status' => 'available',
        ]);

        $response->assertStatus(302);
        $response->assertSee('Artwork added failed');
        $response->assertRedirectToRoute('artwork.index');
    }

}
