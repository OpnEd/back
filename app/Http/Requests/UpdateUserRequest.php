<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user');

        return [
            'name' => 'required|string|max:255',
            'card_id' => [
                'required',
                'string',
                'max:15',
                // Validación de unicidad combinada para 'card_id' y 'card_id_type'
                Rule::unique('users')->where(function ($query) {
                    return $query->where('card_id_type', $this->input('card_id_type'));
                })->ignore($userId)
            ],
            'card_id_type' => 'required|in:Cédula de Ciudadanía,Cédula de Extranjería,Pasaporte,Permiso Especial de Permanencia',
            'email' => 'required|email|unique:users,email,' . $userId . '|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'team_id' => 'nullable|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'card_id.required' => 'La identificación es obligatoria.',
            'card_id.unique' => 'La combinación de identificación y tipo de identificación ya está registrada.',
            'card_id_type.required' => 'El tipo de identificación es obligatorio.',
            'card_id_type.in' => 'El tipo de identificación seleccionado no es válido.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe proporcionar un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'team_id.exists' => 'El equipo seleccionado no es válido.',
        ];
    }
}
