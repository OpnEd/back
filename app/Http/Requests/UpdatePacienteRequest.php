<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdatePacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id', // Verifica que user_id existe en la tabla users.
            'responsable_id' => 'required|exists:users,id', // Verifica que responsable_id existe en la tabla users.
            'name' => 'required|string|max:255', // Nombre del paciente, requerido y texto.
            'species' => 'required|string|max:255', // Especie del paciente, requerida y texto.
            'race' => 'nullable|string|max:255', // Raza, opcional y texto.
            'sex' => 'nullable|string|in:male,female,unknown', // Sexo, opcional y debe ser male, female o unknown.
            'birth_date' => 'nullable|date|before_or_equal:today', // Fecha de nacimiento, opcional y debe ser fecha válida anterior o igual a hoy.
            'weight' => 'nullable|numeric|min:0', // Peso, opcional, numérico y mayor o igual a 0.
            'hair' => 'nullable|string|max:255', // Tipo de pelaje, opcional y texto.
            'chip_number' => 'nullable|digits_between:1,15|unique:pacientes,chip_number', // Número de chip, opcional, entre 1 y 15 dígitos y único en la tabla de pacientes.
            'other_features' => 'nullable|string|max:65535', // Otras características, opcional y texto largo.
            'zootechnical_purpose' => 'nullable|string|max:65535', // Propósito zootécnico, opcional y texto largo.
            'provenance' => 'nullable|string|max:255', // Procedencia, opcional y texto.
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
