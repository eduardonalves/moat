<?php

namespace App\Services;
use App\Interfaces\ArtistRepositoryInterface;

class ArtistService {

    public function __construct(ArtistRepositoryInterface $artistRepositoryInterface)
    {
        $this->artistRepositoryInterface = $artistRepositoryInterface;
    }
    
    public function all(){
        return $this->artistRepositoryInterface->with('albums')->get();
    }

    public function find($id){
       return $this->artistRepositoryInterface->with('albums')->find($id);
    }
    public function getValidationRules($id= null):array {
        return $this->artistRepositoryInterface->getValidationRules($id);
    }
}