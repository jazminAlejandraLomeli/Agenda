<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DenyReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasAnyPermission(permissions: ['approve reserve', 'approve laboratory']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:events,id',
            'reason' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'El campo ID del evento es obligatorio.',
            'id.numeric' => 'El campo ID del evento debe ser un número.',
            'id.exists' => 'El ID del evento no existe en la base de datos.',
            'reason.required' => 'El motivo de la eliminación es requerido.',
            'reason.max' => 'El motivo no debe exceder los 255 caracteres.',
        ];
    }
}
