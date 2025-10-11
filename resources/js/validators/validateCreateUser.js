import { regexLetters } from "../helpers/regex";
import { showErrors } from "../helpers/showErrors";

const errorPermissions = document.querySelector('#error-permissions');
const accordionPermission = document.querySelector('.accordionPermission');

let validate = true;

export const validateDataUser = (data, fields) => {
    validate = true;

    const errors = [];

    // Clear errors
    errorPermissions.textContent = '';
    errorPermissions.classList.add('hidden');
    accordionPermission.classList.add('border-neutral-300','dark:border-neutral-700');
    accordionPermission.classList.remove('border-red-500','dark:border-red-700');

    if(data.get('name') == ''){
        errors['name'] = 'El nombre es obligatorio';
        validate = false;
    }

    if(data.get('name') != '' && !regexLetters.test(data.get('name'))){
        errors['name'] = 'El nombre tiene carácteres inválidos';
        validate = false;
    }

    if(data.get('user_name') == ''){
        errors['user_name'] = 'El nombre es obligatorio';        
        validate = false;
    }

    if(data.get('user_name') != '' && !regexLetters.test(data.get('user_name'))){
        errors['name'] = 'El nombre de usuario no cumple con el formato, tiene cáracteres inválidos';
        validate = false;
    }

    if(data.get('group') == '' || data.get('group') == null){
        errors['group'] = 'El grupo es obligatorio, debe seleccionar uno';
        validate = false;
    }


    if(data.get('role') == '' || data.get('role') == null){
        errors['role'] = 'El role es obligatorio, debe seleccionar uno';
        validate = false;
    }


    console.log(data.get('role'),data.get('group'));

    if(((data.get('role') != null) && (data.get('group') != null)) && data.getAll('permissions[]').length === 0){
        errorPermissions.textContent = 'Debe seleccionar al menos un permiso para agregar el usuario'
        errorPermissions.classList.remove('hidden');
        accordionPermission.classList.remove('border-neutral-300','border-neutral-700');
        accordionPermission.classList.add('border-red-500','border-red-700');

        validate = false;
    }

    showErrors(fields, errors);

    return validate;
}