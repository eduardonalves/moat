<?php

namespace App\Repositories;
use App\Interfaces\ArtistRepositoryInterface;
use App\Repositories\AbstractRepository;
use App\Models\Artist;

class ArtistRepository extends AbstractRepository implements ArtistRepositoryInterface{
    public function __construct(Artist $artist) {
        $this->model = $artist;
    }

}