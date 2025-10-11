import Swal from 'sweetalert2/dist/sweetalert2.js'
import "sweetalert2/dist/sweetalert2.css";

import { confirmDeleteAlert } from './messagesSwalAlert';

export const cancelForm = (msgAlert = 'Se perderán los datos del formulario')=>{
    const cancel = document.querySelector('#cancel');

    if(cancel){

        const handleCancelForm = ()=>{
            Swal.fire({
                ...confirmDeleteAlert('¿Esta seguro?',msgAlert)
              }).then(({isConfirmed}) => {                
                if (isConfirmed) {
                  window.location = '/agenda';
                }
              });
        }

        cancel.addEventListener('click', handleCancelForm);
    }
}