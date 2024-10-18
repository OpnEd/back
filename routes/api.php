<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', [UserController::class, 'getUser']);


Route::middleware(['auth:sanctum'])->group(function () {
    // Ruta para obtener el perfil del usuario autenticado
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('api.user.profile.show');

    // Ruta para actualizar el perfil del usuario autenticado
    Route::put('/user/profile', [UserProfileController::class, 'update'])->name('api.user.profile.update');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    //->middleware('auth:sanctum')
    ->name('dashboard');

Route::apiResource('/pacientes', PacienteController::class);
