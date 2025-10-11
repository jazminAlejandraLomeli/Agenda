<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DependencyAddRequest extends FormRequest
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
        // Data = { Id: Id, Group: Group, name: Name };
        return [
            'Grupo' => 'required|integer|exists:groups,id',
            'Nombre' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'Grupo.exists' => 'El Id del grupo de usuarios no existe.',
            'Grupo.required' => 'El Id del grupo de usuarios es requerido.',
            'Grupo.integer' => 'El Id del grupo de usuarios debe ser numérico.',
            'Nombre.required' => 'El nombre del tipo de vento es requerido.',
            'Nombre.max' => 'El nombre del tipo de vento no debe exceder los 255 caracteres.',
        ];
    }
}
