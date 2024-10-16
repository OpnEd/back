<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserService
{
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
