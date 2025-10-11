<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetEventsGuestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'filter_place' => 'nullable|string',
            'type_event' => 'required|integer|exists:groups,id'
        ];
    }
// 
    public function messages() : array
    {
        return [
            'start_date.required' => 'La fecha de inicio es requerida',
            'end_date.required' => 'La fecha fin es requerida',
            'start_date.date' => 'La fecha de inicio no es válida',
            'end_date.date' => 'La fecha fin no es válida',
            'filter_place.integer' => 'El filtro de aulas debe ser entero',
            'filter_place.exists' => 'El áula no existe',
            'type_event.required' => 'El tipo del evento es requerido',
            'type_event.integer' => 'El tipo del evento debe ser entero',
            'type_event.exists' => 'El tipo del evento no existe'
        ];
    }
}
