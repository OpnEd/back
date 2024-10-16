<?php

namespace App\Repositories;

use App\Interfaces\PacienteRepositoryInterface;
use App\Models\Care\Paciente;

class PacienteRepository implements PacienteRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function index()
    {
        return Paciente::all();
    }

    public function getById(Paciente $paciente)
    {
       return Paciente::findOrFail($paciente->id);
    }

    public function store(array $data)
    {
       return Paciente::create($data);
    }

    public function update(array $data, Paciente $paciente)
    {
       /* return Paciente::whereId($paciente)->update($data); */

        $pacienteUpdated = Paciente::find($paciente->id);
        $pacienteUpdated->fill($data);

        if($pacienteUpdated->isDirty()) {
            $pacienteUpdated->save();
        }

        return $pacienteUpdated;
    }

    public function delete(Paciente $paciente)
    {
        // Elimina el paciente de la base de datos
        $paciente->delete();

        return true;
    }
}
