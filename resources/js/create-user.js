import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

import { requestGetPerson } from "./helpers/requestGetPerson.js";
import { managePermissionsOfRole } from './components/managePermissions.js';
import { validateDataUser } from "./validators/validateCreateUser.js";
import { hideLoader, showLoader } from "./helpers/loader.js";


import { AlertInfo, AlertListErrorHtml, confirmDeleteAlert, errorAlert } from "./helpers/messagesSwalAlert.js";

showLoader('Cargando vista');

window.onload = () => {
    const form = document.querySelector('#form');
    const instructionsText = document.querySelector('#instructions');
    const fields = {};

    const code = document.querySelector('#code');
    const searchCode = document.querySelector('#search-code');
    const inputName = document.querySelector('#name');

    const listAlert = document.querySelector('#listAlert');
    const storePermissions = document.querySelector('#permissions');


    if(listAlert){
        setTimeout(()=>{listAlert.classList.add('hidden')},5000);
    }


    form.querySelectorAll('input, select').forEach(field => {
        fields[field.name] = field
    });

    // Handle permissions of role of user
    managePermissionsOfRole();

    const manageSuccessSearchCode = (data) => {

        const { type } = data || {};

        if (type === 1 || type === '1') {
            const { dataPerson: { worker } } = data || {};

            instructionsText.classList.add('hidden');
            form.classList.remove('hidden');
            inputName.value = worker.nombre
            inputName.disabled = true;
        }

    }

    const manageErrorSearchCode = (error) => {
        const { status, response: { data } } = error;

        form.classList.add('hidden');
        instructionsText.classList.remove('hidden');

        if (status == 404) {
            AlertInfo('No encontrado', data.msg)
            return;
        }

        const errors = data.error;
        let template = '';

        if (Object.keys(errors).length > 0) {

            for (const [key, messages] of Object.entries(errors)) {
                template += `<li>${messages[0]}</li>`
            }

            AlertListErrorHtml(template);

            return;
        }

        const { title, msg } = data;
        
        Swal.fire(errorAlert(title, msg));

    }

    const manageSearchCode = () => {

        let codeValue = code.value?.trim();
        let type = 1;

        requestGetPerson(codeValue, type)
            .then(manageSuccessSearchCode)
            .catch(manageErrorSearchCode)

    }

    const includePermissionsSelect = () => {
        let permissions = document.querySelectorAll('#listPermission li');
        let template = ''
        permissions.forEach(permission => {
            template += `<input value="${permission.id}" type="hidden" name="permissions[]" />`
        })

        storePermissions.innerHTML = template;
    }

    const manageForm = (e) => {
        e.preventDefault();

        showLoader('Validando los datos');

        // Include select permissions for form
        includePermissionsSelect();

        inputName.disabled = false;
        const data = new FormData(form);

        if (!validateDataUser(data, fields)) {
            hideLoader();
            return;
        }
        showLoader('Guardando el usuario');

        Swal.fire(confirmDeleteAlert('¿Estas seguro?','Si estas seguro de guardar el usuario, presione el botón de Confirmar'))
            .then(
                result => {
                    result.isConfirmed && form.submit();
                }
            )

        

    }

    searchCode.addEventListener('click', manageSearchCode)
    form.addEventListener('submit', manageForm);



hideLoader();

}