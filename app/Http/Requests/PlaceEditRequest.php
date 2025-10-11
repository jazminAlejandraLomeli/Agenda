<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceEditRequest extends FormRequest
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
            'Id' => 'required|integer|exists:places,id',
            'Grupo' => 'required|integer|exists:groups,id',
            'Nombre' => 'required|string|max:255',
            'Color' => 'required|string|max:8',
            'Color_Texto' => 'required|integer|in:1,2',
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
            'Nombre.required' => 'El nombre del tipo de evento es requerido.',
            'Nombre.max' => 'El nombre del tipo de evento no debe exceder los 255 caracteres.',
            'Color.max' => 'El color del lugar deben ser 7 caracteres (#fef9f9).',
            'Color.required' => 'El valor Hex para el color del lugar es requerido.',
            'Color_Texto.required' => 'El valor para el color del texto requerido.',
            'Color_Texto.integer' => 'El valor para el color del texto debe ser numérico.',
            'Color_Texto.in' => 'El valor para el color del texto debe ser entre 1 y 2.',
        ];
    }
}
