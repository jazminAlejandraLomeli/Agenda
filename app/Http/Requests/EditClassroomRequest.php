<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        //return (!auth()->check() || (auth()->check() && $user->can('update reserve classroom')));
        return auth()->check() && auth()->user()->hasAnyPermission(permissions: ['update reserve classroom', 'update reserve laboratory']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'event_type' => 'required|integer|exists:event_types,id',
            'dependency_program' => 'required|integer|exists:dependency_programs,id',
            'place' => 'required|integer|exists:places,id',
            'responsible' => 'required|string|max:255',
            'email' => 'required|email',
            'days' => 'nullable|array',
            'semester' => 'required|integer|exists:semesters,id',          
            'num_participants' => 'required|integer|min:1|max:100',
            'date_start' => 'required|date',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'group_id' => 'nullable|integer|exists:groups,id',
        ];
    }

    public function messages() : array
    {
        return [
            'title.required' => 'El nombre del evento es requerido',
            'title.string' => 'El nombre del evento no es válido',
            'title.max' => 'El nombre del evento no puede tener más de 255 caracteres',
            'event_type.required' => 'El tipo del evento es requerido',
            'event_type.exists' => 'El tipo del evento seleccionado no existe',
            'event_type.integer' => 'El tipo del evento seleccionado no es válido',
            'academic_program.required' => 'El programa de dependencia es requerido',
            'academic_program.exists' => 'El programa de dependencia seleccionado no existe',
            'academic_program.integer' => 'El programa de dependencia seleccionado no es válido',
            'place.required' => 'El campo lugar es requerido',
            'place.exists' => 'El lugar seleccionado no existe',
            'place.integer' => 'El lugar seleccionado no es válido',
            'responsible.required' => 'El campo responsable es requerido',
            'responsible.string' => 'El campo responsable no es válido',    
            'email.required' => 'El campo correo es requerido',
            'email.email' => 'El campo correo no es válido',
            'days.array' => 'Los días seleccionados no son válidos',
            'semester.required' => 'El semestre es requerido',
            'semester.exists' => 'El semestre seleccionado no existe',
            'semester.integer' => 'El semestre seleccionado no es válido',
            'num_participants.required' => 'El número de participantes es requerido',
            'num_participants.integer' => 'El número de participantes no es válido',    
            'num_participants.min' => 'El número de participantes no puede ser menor a 1',
            'num_participants.max' => 'El número de participantes no puede ser mayor a 100',
            'date_start.required' => 'La fecha de inicio es requerida',
            'date_end.required' => 'La fecha de fin es requerida',
            'date_start.date' => 'La fecha de inicio no es válida',
            'date_end.date' => 'La fecha de fin no es válida',
            'hour_start.required' => 'La hora de inicio es requerida',
            'hour_end.required' => 'La hora de fin es requerida',
            'group_id.required' => 'El campo grupo es requerido',
            'group_id.exists' => 'El grupo seleccionado no existe',
            'group_id.integer' => 'El grupo seleccionado no es válido',
        ];
    }
}
