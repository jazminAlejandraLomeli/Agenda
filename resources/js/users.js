import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";


import {confirmDeleteAlert, errorAlert, successAlert } from "./helpers/messagesSwalAlert.js";
import { requestDeleteUser } from "./helpers/requestDeleteUser.js";
import { requestResetPassword } from "./helpers/requestResetPassword.js";
import { gridUser } from "./components/gridUser.js";
import { hideLoader, showLoader } from './helpers/loader.js';

showLoader('Cargando vista');

const manageRequestDeleteUser = (id)=>{
    requestDeleteUser(id).then((response) => {
        const { title, message } = response;
    
        Swal.fire({
            ...successAlert(title, message)                            
        }).then(() => {
            location.reload();
        });
    }).catch((error) => {
        const { title, message } = error;
        Swal.fire({
            ...errorAlert(title, message)
        });
    });
}

const manageRequestResetPassword = (id) => {
    showLoader('Restableciendo contraseña...');
    requestResetPassword(id).then((response) => {
        
        const { title, message } = response;

        Swal.fire({
            ...successAlert(title, message)
        });
    }).catch((error) => {
        const { title, message } = error;
        Swal.fire({
            ...errorAlert(title, message)
        });
    }).finally(() => {
        hideLoader();
    })
}

const deleteUser = (id) => {

    Swal.fire({
        ...confirmDeleteAlert('¿Estás seguro?', 'Si eliminas este usuario no podrás recuperarlo'),
    }).then((result) => {
        result.isConfirmed && manageRequestDeleteUser(id);
    })
}

const resetPassword = (id) => {
    Swal.fire({
        ...confirmDeleteAlert('¿Estás seguro?', 'Si restableces la contraseña de este usuario, se eliminará la actual y se generará una nueva')        
    }).then((result) => {
        result.isConfirmed && manageRequestResetPassword(id);
    })
}

window.onload = ()=> {

    const table = document.getElementById("tableUsers");
    new Grid(
        gridUser(resetPassword, deleteUser)
    ).render(table);

    hideLoader();
}
