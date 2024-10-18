<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Classes\ApiResponseClass;
use App\Http\Resources\UserResource;

class UserService extends BaseService
{
    public function __construct(UserRepository $userRepository) {
        parent::__construct($userRepository);
    }

    public function updateUserProfile($userId, array $data) {
        try {
            $updatedUser = $this->repository->updateProfile($userId, $data);
            return ApiResponseClass::sendResponse(new UserResource($updatedUser), "Profile updated successfully");
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, "Failed to update user's profile");
        }
    }

    public function createNewUser(array $data) {
        try {
            $data['password'] = Hash::make($data['password']);
            $user = $this->repository->createUser($data);
            return ApiResponseClass::sendResponse(new UserResource($user), "User created successfully");
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, "Failed to create user");
        }
    }
    /**
     * Obtener el usuario autenticado si el token es válido.
     *
     * @return array
     */
    public function getAuthenticatedUser()
    {
        $user = Auth::user();  // Obtiene el usuario autenticado

        if ($user) {
            // Si el usuario está autenticado, retornamos su información en un arreglo estructurado
            return [
                'success' => true,
                'data' => $user
            ];
        } else {
            // Si no hay un usuario autenticado, retornamos un mensaje de error
            return [
                'success' => false,
                'message' => 'No autorizado'
            ];
        }
    }
}
