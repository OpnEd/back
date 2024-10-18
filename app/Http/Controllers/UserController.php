<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    protected $userService;

    // Inyectamos el servicio en el constructor
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public static function middleware()
    {
        return [
            // new Middleware('auth:sanctum', except: ['index', 'show']), // si se han de excluir algunos métodos
            new Middleware('auth:sanctum'),
        ];
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
    public function store(StoreUserRequest $request) {
        $validatedData = $request->validated();
        return $this->userService->createNewUser($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $userId) {
        $validatedData = $request->validated();
        return $this->userService->updateUserProfile($userId, $validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Método que llama al servicio para obtener los datos del usuario autenticado
    public function getUser(Request $request)
    {
        // Llamamos al servicio para obtener la información del usuario autenticado
        $response = $this->userService->getAuthenticatedUser();

        // Si es exitoso, devolvemos una respuesta JSON con los datos del usuario
        if ($response['success']) {
            return response()->json($response, 200);
        }

        // Si no está autenticado, devolvemos una respuesta de error 401
        return response()->json($response, 401);
    }
}
