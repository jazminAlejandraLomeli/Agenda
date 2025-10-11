import { regexText, regexLetters, regexCorreo, regexNumero } from '../helpers/regex.js';
import { showErrors } from '../helpers/showErrors.js';

const errorDays = document.getElementById('error-days');
let validated = true;

export const validateData = (data, fields)=>{

    validated = true;    
    const errors = {};

    
    errorDays.classList.add('hidden');


    if(data.get('title') === ''){
        errors['title'] = 'El título del evento es obligatorio';
        validated = false;
    }

    if(!regexText.test(data.get('title')) ){
        errors['title'] = 'El título del evento no es válido';
        validated = false;
    }

    if(data.get('event_type') === ''){
        errors['event_type'] = 'El tipo del evento es obligatorio, selecciona uno';
        validated = false;
    }

    if(data.get('dependency_program') === ''){
        errors['dependency_program'] = 'La dependencia es obligatoria, selecciona una';
        validated = false;
    }

    if(data.get('place') === ''){
        errors['place'] = 'El lugar es obligatorio';
        validated = false;
    }

    if(data.get('responsible') === ''){
        errors['responsible'] = 'El campo responsable es obligatorio';
        validated = false;
    }

    if(data.get('phone') === ''){
        console.log('No hay phone')
        errors['phone'] = 'El teléfono o la extensión es obligatoria';
        validated = false;
    }

    // if(data.get('responsible') != '' && !regexLetters.test(data.get('responsible'))){
    //     errors['responsible'] = 'El campo responsable tiene caracteres no válidos';
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

    if(data.getAll('repetition').length === 2 && data.getAll('repetition')[data.getAll('repetition').length - 1] == 1){
        console.log('Repetición activada');
        if(data.get('date_end') === ''){
            errors['date_end'] = 'La fecha fin es obligatoria';
            validated = false;
        }

        if(data.getAll('days[]').length === 0){
            errorDays.classList.remove('hidden');
            errorDays.textContent = 'Debes seleccionar al menos un día que quiere que se repita'
            validated = false;
        }            
    }

    showErrors(fields, errors);

    return validated;

}

