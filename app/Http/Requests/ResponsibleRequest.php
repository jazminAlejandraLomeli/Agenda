<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponsibleRequest extends FormRequest
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
            'responsible_name' => 'required|string|max:255',     
            'group_id' => 'required|integer|exists:groups,id',
        ];
    }

    public function messages() : array 
    {
        return [
            'responsible_name.required' => 'El nombre del responsable es requerido',
            'responsible_name.string' => 'El nombre del responsable no es válido',
            'responsible_name.max' => 'El nombre del responsable no puede tener más de 255 caracteres',
            'group_id.required' => 'El grupo es requerido',
            'group_id.exists' => 'El grupo seleccionado no existe',
            'group_id.integer' => 'El grupo seleccionado no es válido',
        ];
    }
}
