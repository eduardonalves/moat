<?php

namespace Database\Factories;
use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Artist;

class AlbumFactory extends Factory
{
    protected $model = Album::class;

    public function definition()
    {
        return [
            'album_name'=> $this->faker->name(),
            'year'=> $this->faker->randomNumber(4),
            'artist_id'=> Artist::factory()->create()->id
        ];
    }
}
