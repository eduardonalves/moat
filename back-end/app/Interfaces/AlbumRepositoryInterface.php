<?php
namespace App\Interfaces;

interface AlbumRepositoryInterface {
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(array $data,$id);
    public function delete($id);
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    public function findOneBy(array $criteria);
    public function with($condition);
    public function getValidationRules($id= null):array;
}