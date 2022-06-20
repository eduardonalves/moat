<?php

namespace Tests\Feature\Integrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UsersEndPointsTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function shouldRegisterUser()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)
            ->withSession(['role' => 1])
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type'  => 'application/json'
            ])
            ->postJson('api/register', [
                'full_name' => $this->faker->unique()->name,
                'username' => $this->faker->unique()->email(),
                'password' => $this->faker->password,
                'role' => $this->faker->numberBetween(1, 2)
            ]);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *@test
     *@dataProvider shouldNotRegisterUserProvider
     * @return void
     */
    public function shouldNotRegisterUser($args)
    {

        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)
            ->withSession(['role' => 1])
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type'  => 'application/json'
            ])
            ->postJson('api/register', $args);

        $response->assertStatus(400);
    }

    /**
     *@test
     *@return void
     * **/
    public function shouldLogin()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        User::create(
            [
                'full_name' => 'test',
                'username' => 'mytest@example.com.tk',
                'password' => bcrypt('12345678'),
                'role' => 1
            ],
        );

        $response = $this->actingAs($user)
            ->withHeaders(
                [
                    'Accept' => 'application/json',
                    'Content-Type'  => 'application/json'
                ]
            )->postJson('api/login', [
                'username' => 'mytest@example.com.tk',
                'password' => '12345678',
            ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     * @return void
     * **/

    public function shouldNotLoginWithInvalidCredentials()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */

        $response = $this->actingAs($user)
            ->withHeaders(
                [
                    'Accept' => 'application/json',
                    'Content-Type'  => 'application/json'
                ]
            )->postJson('api/login', [
                'username' => 'mytest@example.com.tk',
                'password' => '123456789',
            ]);

        $response->assertStatus(401);
    }

    public function shouldNotRegisterUserProvider(): array
    {
        return [
            [
                [
                    'full_name' => '',
                    'username' => '',
                    'password' => '',
                    'role' => '',
                ]
            ],
            [
                [
                    'full_name' => 'Jhon',
                    'username' => '',
                    'password' => '',
                    'role' => '',
                ]
            ],
            [
                [
                    'full_name' => 'Jhon',
                    'username' => 'email@email.com',
                    'password' => '',
                    'role' => '',
                ]
            ],
            [
                [
                    'full_name' => 'Jhon',
                    'username' => 'email@email.com',
                    'password' => 'fdsfsdfsa',
                    'role' => '',
                ]
            ]
        ];
    }
}
