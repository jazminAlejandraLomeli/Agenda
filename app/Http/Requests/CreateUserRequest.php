<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'user_name' => 'required|unique:users,user_name|string|max:255',
            'name' => 'required|string|max:255',
            'group' => 'required|integer|exists:groups,id',
            'role' => 'required|integer|exists:roles,id',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'integer|exists:permissions,id'
        ];
    }

    public function messages() : array
    {
        return[
            'user_name.required' => 'El campo nombre de usuario es requerido',
            'user_name.unique' => 'El nombre de usuario ya está en uso',
            'name.required' => 'El campo nombre es requerido',
            'group.required' => 'El campo grupo es requerido',
            'group.exists' => 'El grupo seleccionado no existe',
            'group.integer' => 'El grupo seleccionado no es válido',
            'user_name.string' => 'El campo nombre de usuario no es válido',
            'name.string' => 'El campo nombre no es válido',
            'user_name.max' => 'El campo nombre de usuario no puede tener más de 255 caracteres',
            'name.max' => 'El campo nombre no puede tener más de 255 caracteres',
            'group.integer' => 'El campo grupo no es válido',
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
