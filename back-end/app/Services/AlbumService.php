<?php

namespace App\Services;

use App\Interfaces\AlbumRepositoryInterface;


class AlbumService
{
    public function __construct(AlbumRepositoryInterface $albumRepositoryInterface)
    {
        $this->albumRepositoryInterface = $albumRepositoryInterface;
    }

    public function all()
    {
        return $this->albumRepositoryInterface->all();
    }

    public function find($id)
    {
        return $this->albumRepositoryInterface->find($id);
    }

    public function create(array $data)
    {
        return $this->albumRepositoryInterface->create($data);
    }

    public function update($id, $data)
    {
        $album = $this->albumRepositoryInterface->find($id);
        $album->album_name = $data['album_name'];
        $album->artist_id = $data['artist_id'];
        $album->year = $data['year'];
        return $album->save();
    }

    public function delete($id)
    {
        return $this->albumRepositoryInterface->delete($id);
    }

    public function getValidationRules($id= null):array {
        return $this->albumRepositoryInterface->getValidationRules($id);
    }
}
