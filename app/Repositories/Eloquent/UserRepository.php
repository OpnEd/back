<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository {

    public function __construct(User $model) {
        parent::__construct($model);
    }

    public function updateProfile($userId, array $data) {
        $user = $this->find($userId);
        $user->update($data);
        return $user;
    }

    public function createUser(array $data) {
        return $this->model->create($data);
    }
}
