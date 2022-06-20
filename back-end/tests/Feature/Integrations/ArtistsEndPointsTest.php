<?php

namespace Tests\Feature\Integrations;

use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ArtistsEndPointsTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
    /**
     * @test
     * @return void
     * **/
    public function shouldListArtists()
    {

        $user = User::factory()->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)
            ->withSession(['role' => '1'])
            ->getJson('/api/artists/list');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'created_at', 'updated_at', 'albums']
            ]);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function shoulViewArtist()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $id = Artist::all()->random()->id;
        $response = $this->actingAs($user)
            ->withSession(['role' => '1'])
            ->getJson('api/artists/' . $id);
        $response->assertStatus(200)
            ->assertJsonStructure(
                ['id', 'name', 'created_at', 'updated_at', 'albums']
            );
    }
}
