<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use App\Classes\ApiResponseClass;

class UserProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponseClass::sendResponse(null, 'User not found', 404);
        }

        // Obtener el nombre del rol del usuario autenticado
        $role = $user->getRoleNames()->first() ?? 'guest'; // Esto devuelve el primer rol del usuario logueado si tiene varios roles

        return ApiResponseClass::sendResponse([
            'user' => new UserResource($user),
            'role' => $role, // Devolvemos los roles también
        ], 'User profile retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponseClass::sendResponse(null, 'User not found', 404);
            }

            $data = $request->only(['name', 'email', 'card_id', 'card_id_type']);
            $updatedUser = $this->userService->updateUserProfile($user->id, $data);

            return ApiResponseClass::sendResponse(new UserResource($updatedUser), 'Profile updated successfully.');
        } catch (\Exception $e) {
            return ApiResponseClass::throw($e, 'Failed to update profile.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
