import { regexText, regexLetters, regexCorreo, regexNumero } from '../helpers/regex.js';
import { showErrors } from '../helpers/showErrors.js';

let validated = true;

export const validateData = (data, fields)=>{

    validated = true;    
    const errors = {};



    if(data.get('title') === ''){
        errors['title'] = 'El título del evento es obligatorio';
        validated = false;
    }

    if(!regexText.test(data.get('title')) ){
        errors['title'] = 'El título del evento no es válido';
        validated = false;
    }

    if(data.get('responsible') === ''){
        errors['responsible'] = 'El campo responsable es obligatorio';
        validated = false;
    }


    if(data.get('email') === ''){
        errors['email'] = 'El correo es obligatorio';
        validated = false;
    }

    if(data.get('email') != '' && !regexCorreo.test(data.get('email'))){
        errors['email'] = 'El correo no es válido';
        validated = false;
    }

    if(data.get('event_type') === ''){
        errors['event_type'] = 'El tipo de evento es obligatorio, selecciona uno';
        validated = false;
    }

    if(data.get('academic_program') === ''){
        errors['academic_program'] = 'El programa académico es obligatorio, selecciona uno';
        validated = false;
    }

    if(data.get('num_participants') === ''){
        errors['num_participants'] = 'El número de participantes es obligatorio';
        validated = false;
    }

    if(data.get('num_participants') != '' && !regexNumero.test(data.get('num_participants'))){
        errors['num_participants'] = 'El número de participantes no es válido';
        validated = false;
    }

    if(data.get('num_participants') != '' && !regexNumero.test(data.get('num_participants')) && data.get('num_participants') < 1){
        errors['num_participants'] = 'El número de participantes no es válido, el mínimo es 1';
        validated = false;
    }

    if(data.get('num_participants') != '' && !regexNumero.test(data.get('num_participants')) && data.get('num_participants') > 50){
        errors['num_participants'] = 'El número de participantes no es válido, el máximo es 50';
        validated = false;
    }

    if(data.get('semester') === null){
        errors['semester'] = 'El semestre es obligatorio, selecciona uno';
        validated = false;
    }


    if(data.get('description') != '' && !regexText.test(data.get('description'))){
        errors['description'] = 'La descripción del evento tiene caracteres no válidos';
        validated = false;
    }

    if(data.get('place') === ''){
        errors['place'] = 'El lugar es obligatorio';
        validated = false;
    }

    // if(data.get('place') != '' && !regexText.test(data.get('place'))){
    //     errors['place'] = 'El lugar es inválido';
    //     validated = false;
    // }

    if(data.get('date_start') === ''){
        errors['date_start'] = 'La fecha de inicio es obligatoria';
        validated = false;
    }

    if(data.get('hour_start') === ''){
        errors['hour_start'] = 'La hora de inicio es obligatoria';
        validated = false;
    }

    if(data.get('hour_end') === ''){
        errors['hour_end'] = 'La hora de fin es obligatoria';
        validated = false;
    }

    showErrors(fields, errors);

    return validated;

}

