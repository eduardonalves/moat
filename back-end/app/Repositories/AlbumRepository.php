<?php

namespace App\Repositories;
use App\Interfaces\AlbumRepositoryInterface;
use App\Repositories\AbstractRepository;
use App\Models\Album;

class AlbumRepository extends AbstractRepository implements AlbumRepositoryInterface{
    public function __construct(Album $album) {
        $this->model = $album;
    }
}