import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

import { managePermissionsOfRole } from "./components/managePermissions";
import { hideLoader, showLoader } from "./helpers/loader";
import { validateDataUser } from "./validators/validateUpdateUser";
import { confirmDeleteAlert } from "./helpers/messagesSwalAlert";


showLoader('Cargando vista');
window.onload = () => {

    const storePermissions = document.querySelector('#permissions');
    const form = document.querySelector('#form');

    const fields = [];

    form.querySelectorAll('input, select').forEach(field => {
        fields[field.name] = field
    });

    // Handle permissions of role of user
    managePermissionsOfRole();

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
        
        const data = new FormData(form);

        if (!validateDataUser(data, fields)) {
            hideLoader();
            return;
        }
        showLoader('Guardando cambios del usuario');

        Swal.fire(confirmDeleteAlert('¿Estas seguro?', 'Si estas seguro de los cambios aplicados al usuario, presione el botón de Confirmar'))
            .then(
                result => {
                    if(result.isConfirmed){
                        form.submit();
                    }else{
                        hideLoader();
                    }
                     
                }
            )
    }

    form.addEventListener('submit', manageForm);

    hideLoader();
}