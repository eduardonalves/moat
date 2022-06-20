<?php

namespace Tests\Feature\Integrations;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\Album;
use App\Models\Artist;
use App\Models\User;


class AlbumsEndPointsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
    /**
     * 
     * @test
     * @return void
     */

    use WithFaker;
    use DatabaseMigrations;

    public function shouldListAlbums()
    {


        $user = User::factory()->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)
            ->withSession(['role' => '1'])
            ->getJson('/api/albums/list');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'album_name', 'year', 'artist_id', 'created_at', 'updated_at']
            ]);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function shouldViewAlbum()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $id = Album::all()->random()->id;
        $response = $this->actingAs($user)
            ->withSession(['role' => '1'])
            ->getJson('api/albums/' . $id);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'album_name', 'year', 'artist_id', 'created_at', 'updated_at']
            ]);
    }

    /**
     * @test
     * @return void
     * **/
    public function shouldCreateAlbum()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */

        $response = $this->actingAs($user)
            ->withSession(['role' => 1])
            ->postJson('api/albums/add', [
                'album_name' => $this->faker->unique()->name,
                'year' =>  (string) $this->faker->numberBetween(1980, 2022),
                'artist_id' => Artist::all()->random()->id
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'album_name',
                    'year',
                    'artist_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }
    /**
     * @test
     * @return void
     * @dataProvider shouldNotCreateAlbumIfItsDataIsInvalidProvider
     * **/
    public function shouldNotCreateAlbumIfItsDataIsInvalid($data)
    {
        $user = User::factory()->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)
            ->withSession(['role' => 1])
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type'  => 'application/json'
            ])
            ->postJson('api/albums/add', $data);
        $response->assertStatus(422);
    }

    /**
     * @test
     * @return void
     * **/

    public function shouldUpdateAlbum()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */

        $user = User::factory()->create();
        $id = Album::all()->random()->id;

        $response = $this->actingAs($user)
            ->withSession(['role' => 1])
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type'  => 'application/json'
            ])
            ->putJson('api/albums/edit/' . $id, [
                'id' => $id,
                'album_name' => $this->faker->unique()->title(),
                'year' => (string) $this->faker->numberBetween(1980, 2022),
                'artist_id' => Artist::all()->random()->id
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['data' => true]);
    }

    /**
     * @test 
     * @return void 
     * @dataProvider shouldNotUpdateAlbumIfItsDataIsInvalidProvider
     * **/
    public function shouldNotUpdateAlbumIfItsDataIsInvalid($data)
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $id = Album::all()->random()->id;

        $data['id'] = $id;

        $response = $this->actingAs($user)
            ->withSession(['role' => 1])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->putJson('api/albums/edit/' . $id, $data);
        $response->assertStatus(422);
    }


    /**
     * @test
     * @return void
     * **/
    public function shouldDeleteAlbum()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */

        $user = User::where('role', 1)->first();

        $id = Album::all()->random()->id;
        $response = $this->actingAs($user)
            ->withSession(['role' => 1])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->deleteJson('api/albums/delete/' . $id);
        $response->assertStatus(200);
    }

    /**
     * @test
     * @return void
     * **/
    public function shouldNotDeleteAlbum()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::where('role', 2)->first();
        $id = Album::all()->random()->id;

        $response = $this->actingAs($user)
            ->withSession(['role' => 2, 'token_type' => 'user'])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->deleteJson('api/albums/delete/' . $id);
        $response->assertStatus(401);
    }


    public function shouldNotCreateAlbumIfItsDataIsInvalidProvider(): array
    {
        return [
            [
                [
                    'album_name' => '',
                    'year' => '',
                    'artist_id' => ''
                ]
            ],
            [
                [
                    'album_name' => 'Psycho Circus',
                    'year' => '',
                    'artist_id' => ''
                ]
            ],
            [
                [
                    'album_name' => 'Psycho Circus',
                    'year' =>  '1998',
                    'artist_id' => ''
                ]
            ],
            [
                [
                    'album_name' => 'Psycho Circus',
                    'year' =>  '1998',
                    'artist_id' => ''
                ]
            ],
        ];
    }
    public function shouldNotUpdateAlbumIfItsDataIsInvalidProvider()
    {
        return [
            [
                [
                    'id' => 1,
                    'album_name' => '',
                    'year' => '',
                    'artist_id' => ''
                ]
            ],
            [
                [
                    'id' => 1,
                    'album_name' => 'Psycho Circus',
                    'year' => '',
                    'artist_id' => ''
                ]
            ],
            [
                [
                    'id' => 1,
                    'album_name' => 'Psycho Circus',
                    'year' =>  '1998',
                    'artist_id' => ''
                ]
            ],
            [
                [
                    'id' => 1,
                    'album_name' => 'Psycho Circus',
                    'year' =>  '1998',
                    'artist_id' => ''
                ]
            ],
        ];
    }
}
