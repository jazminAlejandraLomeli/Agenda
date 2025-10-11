import { regexText, regexLetters, regexCorreo, regexNumero } from '../helpers/regex.js';

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

    if(data.get('dependency_program') === ''){
        errors['dependency_program'] = 'El programa académico es obligatorio, selecciona uno';
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

    if(data.get('semester') === ''){
        errors['semester'] = 'El semestre es obligatorio, selecciona uno';
        validated = false;
    }


    if(data.get('description') != '' && !regexText.test(data.get('description'))){
        errors['description'] = 'La descripción del evento tiene caracteres no válidos';
        validated = false;
    }

    if(data.getAll('place').length === 0){
        errors['place'] = 'Debe seleccionar al menos un lugar';
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

    console.log(validated)

    return validated;

}

const showErrors = (fields, errors)=>{
     // Clear previuos styles 
     Object.values(fields).forEach(field => {

        let parent = field.parentElement;
        let span = parent.nextElementSibling;

        if(span?.tagName !== 'SPAN') return;

        // Remove border error
        parent.classList.remove('border-red-600' ,'dark:border-red-500');
        parent.classList.add('border-gay-300' , 'dark:border-gay-600');
        span.classList.add('hidden')

    });

    // If have errros show in the form
    Object.keys(errors).forEach(fieldName => {
        const field = fields[fieldName];
        if (field) {
            let parent = field.parentElement;
            let span = parent.nextElementSibling;

            if(span?.tagName !== 'SPAN') return;

            parent.classList.remove('border-gray-300', 'dark:border-gray-600');
            parent.classList.add('border-red-600', 'dark:border-red-500');
            span.textContent = errors[fieldName];
            span.classList.remove('hidden');
        }
    });


   
}