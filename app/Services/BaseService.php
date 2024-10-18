<?php
namespace App\Services;

abstract class BaseService

{

    protected $repository;

    public function __construct($repository) {
        $this->repository = $repository;
    }

    public function getAll() {
        return $this->repository->all();
    }

    public function findById($id) {
        return $this->repository->find($id);
    }

    public function create(array $data) {
        return $this->repository->create($data);
    }

    public function update($id, array $data) {
        return $this->repository->update($id, $data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }
}
