<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetEventsRequest extends FormRequest
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
          'filter' => 'nullable|integer|exists:groups,id',
          'start' => 'required|date',
          'end' => 'required|date',
        ];
    }

    public function messages() : array
    {
        return[
            'filter.required' => 'El campo filtro es requerido',
            'filter.exists' => 'El campo filtro no es válido',
            'filter.integer' => 'El campo filtro no es válido',
            'start.required' => 'El campo fecha de inicio es requerido',
            'start.date' => 'El campo fecha de inicio no es válido',
            'end.required' => 'El campo fecha de fin es requerido',
            'end.date' => 'El campo fecha de fin no es válido',
        ];
    }
}
