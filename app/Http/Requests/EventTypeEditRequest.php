<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventTypeEditRequest extends FormRequest
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
            'Id' => 'required|integer|exists:event_types,id',
            'Grupo' => 'required|integer|exists:groups,id',
            'Nombre' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'Id.required' => 'El Id debe del tipo de evento es requerido.',
            'Id.integer' => 'El Id debe del tipo de evento debe ser numérico.',
            'Id.exists' => 'El Id del tipo de evento no existe.',
            'Grupo.exists' => 'El Id del grupo de usuarios no existe.',
            'Grupo.required' => 'El Id del grupo de usuarios es requerido.',
            'Grupo.integer' => 'El Id del grupo de usuarios debe ser numérico.',
            'Nombre.required' => 'El nombre del tipo de vento es requerido.',
            'Nombre.max' => 'El nombre del tipo de vento no debe exceder los 255 caracteres.',
        ];
    }
}
