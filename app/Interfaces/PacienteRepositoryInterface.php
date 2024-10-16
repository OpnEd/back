<?php

namespace App\Interfaces;

use App\Models\Care\Paciente;

interface PacienteRepositoryInterface
{
    public function index();
    public function getById(Paciente $paciente);
    public function store(array $data);
    public function update(array $data, Paciente $paciente);
    public function delete(Paciente $paciente);
}
