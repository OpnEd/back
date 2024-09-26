<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id, // ID del usuario que creó el paciente (admin o médico)
            'responsable_id' => $this->responsable_id, // ID del responsable del paciente (cliente)
            'name' => $this->name, // Nombre del paciente
            'species' => $this->species, // Especie del paciente
            'race' => $this->race, // Raza del paciente (si es aplicable)
            'sex' => $this->sex, // Sexo del paciente
            'birth_date' => $this->birth_date ? $this->birth_date->format('Y-m-d') : null, // Fecha de nacimiento en formato 'Y-m-d'
            'weight' => $this->weight, // Peso del paciente
            'hair' => $this->hair, // Tipo de pelaje
            'chip_number' => $this->chip_number, // Número de chip del paciente
            'other_features' => $this->other_features, // Otras características del paciente
            'zootechnical_purpose' => $this->zootechnical_purpose, // Propósito zootécnico del paciente
            'provenance' => $this->provenance, // Procedencia del paciente
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Fecha de creación del registro
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'), // Fecha de última actualización
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('Y-m-d H:i:s') : null, // Fecha de eliminación si aplica
            ];
    }
}
