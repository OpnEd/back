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
    public function index(){
        return Paciente::all();
    }

    public function getById($id){
       return Paciente::findOrFail($id);
    }

    public function store(array $data){
       return Paciente::create($data);
    }

    public function update(array $data,$id){
       return Paciente::whereId($id)->update($data);
    }

    public function delete($id){
       Paciente::destroy($id);
    }
}
