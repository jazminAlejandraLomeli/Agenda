<?php

namespace App\Http\Requests;

use App\Models\Responsible;
use App\Models\TitleEvent;
use Illuminate\Foundation\Http\FormRequest;

class EditEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('create event');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required',
                function($attribute,$value, $fail){
                    if(is_numeric($value)){
                        // Validate if exists in db
                        $exist = TitleEvent::find($value)->exists();

                        if(!$exist){
                            $fail('El título no existe, se ha modificado');
                        }else{
                            if(!is_string($value)){
                                $fail('El título del evento no es válido');
                            }
                        }
                    }
                }
            ],
            'event_type' => 'required|integer|exists:event_types,id',
            'dependency_program' => 'required|integer|exists:dependency_programs,id',
            'places' => 'required|array',
            'places.*' => 'integer|exists:places,id',
            'responsible' => ['required',
                function($attribute,$value, $fail){
                    if(is_numeric($value)){
                        // Validate if exists in db
                        $exist = Responsible::find($value)->exists();

                        if(!$exist){
                            $fail('El responsable seleccionado no existe, se ha modificado');
                        }else{
                            if(!is_string($value)){
                                $fail('El nombre del responsable no es válido');
                            }
                        }
                    }
                }
            ],
            'phone' => 'required',
            'notes_cta' => 'nullable|string|max:400',
            'notes_general_services' => 'nullable|string|max:400',
            'notes_protocolo' => 'nullable|string|max:400',
            'date_start' => 'required|date',
            'hour_start' => 'required',
            'hour_end' => 'required',

        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'El nombre del evento es requerido',
            'title.string' => 'El nombre del evento no es válido',
            'title.max' => 'El nombre del evento no puede tener más de 255 caracteres',
            'event_type.required' => 'El tipo del evento es requerido',
            'event_type.exists' => 'El tipo del evento seleccionado no existe',
            'event_type.integer' => 'El tipo del evento seleccionado no es válido',
            'dependency_program.required' => 'El programa de dependencia es requerido',
            'dependency_program.exists' => 'El programa de dependencia seleccionado no existe',
            'dependency_program.integer' => 'El programa de dependencia seleccionado no es válido',
            'place.required' => 'El campo lugar es requerido',
            'place.exists' => 'El lugar seleccionado no existe',
            'place.integer' => 'El lugar seleccionado no es válido',
            'responsible.required' => 'El campo responsable es requerido',
            'responsible.string' => 'El campo responsable no es válido',
            'responsible.max' => 'El campo responsable no puede tener más de 255 caracteres',
            'phone.required' => 'El campo teléfono es requerido',
            'phone.integer' => 'El campo teléfono no es válido',
            'phone.digits_between' => 'El campo teléfono no es válido',
            'notes_cta.required' => 'El campo notas CTA es requerido',
            'notes_cta.string' => 'El campo notas CTA no es válido',
            'notes_cta.max' => 'El campo notas CTA no puede tener más de 400 caracteres',
            'notes_general_services.required' => 'El campo notas de servicios generales es requerido',
            'notes_general_services.string' => 'El campo notas de servicios generales no es válido',
            'notes_general_services.max' => 'El campo notas de servicios generales no puede tener más de 400 caracteres',
            'notes_protocolo.required' => 'El campo notas de protocolo es requerido',
            'notes_protocolo.string' => 'El campo notas de protocolo no es válido',
            'notes_protocolo.max' => 'El campo notas de protocolo no puede tener más de 400 caracteres',
        ];
    }
}
