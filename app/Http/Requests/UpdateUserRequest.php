<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'group' => 'required|integer|exists:groups,id',
            'role' => 'required|integer|exists:roles,id',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'integer|exists:permissions,id'
        ];
    }

    public function messages() : array
    {
        return[
            'group.required' => 'El campo grupo es requerido',
            'group.exists' => 'El grupo seleccionado no existe',
            'group.integer' => 'El grupo seleccionado no es válido',
            'role.required' => 'El campo rol es requerido',
            'role.exists' => 'El rol seleccionado no es válido',
            'role.integer' => 'El rol seleccionado no es válido',
            'permissions.required' => 'La lista de permisos es requerida',
            'permissions.array' => 'La lista de permisos debe ser un grupo',
            'permissions.min' => 'Debe al menos enviar 1 permiso',
            'permissions.*.integer' => 'Existe permisos que no cumplen con la condición',
            'permissions.*.exists' => 'Hay permisos que no existen'
        ];
    }
}
