<?php

namespace App\Policies;

use App\Models\Care\Paciente;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PacientePolicy
{
/*     public function modify(User $user, Paciente $paciente): Response
    {
        return $user->team_id === $paciente->creador->team_id
            ? Response::allow()
            : Response::deny('You do not own this patient!');
    } */

    // Permitir la creación de 'Paciente' solo a 'admin' y 'medico'
    public function create(User $user): Response
    {
        return $user->hasRole(['admin', 'medico'])
            ? Response::allow()
            : Response::deny('Only admins and doctors can create a patient.');
    }

    // Permitir la actualización solo si el 'User' pertenece al mismo 'Team' que el 'Paciente'
    public function update(User $user, Paciente $paciente): Response
    {
        // Verificar si el usuario tiene el rol 'admin' o 'medico'
        if ($user->hasRole(['admin', 'medico'])) {

            // Verificar si el equipo del usuario tiene acceso al paciente a través del responsable (cliente)
            $team = $user->team;

            // Usar la relación del equipo con los pacientes
            if ($team->pacientes()->where('pacientes.id', $paciente->id)->exists()) {
                return Response::allow();
            }

            return Response::deny('You can only update patients within your team.');
        }

        // Si no tiene el rol requerido, denegar la autorización
        return Response::deny('Only admins and doctors can update a patient.');
    }

    // Permitir la eliminación solo si el 'User' pertenece al mismo 'Team' que el 'Paciente'
    public function delete(User $user, Paciente $paciente): Response
    {
/*         return $user->team_id === $paciente->creador->team_id
            ? Response::allow()
            : Response::deny('You can only delete patients within your team.'); */

        // Verificar si el usuario tiene el rol 'admin' o 'medico'
        if ($user->hasRole(['admin', 'medico'])) {

            // Verificar si el equipo del usuario tiene acceso al paciente a través del responsable (cliente)
            $team = $user->team;

            // Usar la relación del equipo con los pacientes
            if ($team->pacientes()->where('pacientes.id', $paciente->id)->exists()) {
                return Response::allow();
            }

            return Response::deny('You can only delete patients within your team.');
        }

        // Si no tiene el rol requerido, denegar la autorización
        return Response::deny('Only admins and doctors can delete a patient.');
    }
}
