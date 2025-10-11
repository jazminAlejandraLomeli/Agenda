import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

import { dateEvent } from "./helpers/dateEvent.js";
import { hideLoader, showLoader } from "./helpers/loader.js";
import { validateData } from './validators/validateEditEventProtocolo.js';
import { confirmDeleteAlert } from "./helpers/messagesSwalAlert.js";
import { handleSearchInputs } from './components/handleSearchInputs.js';
import { publishDomPlaces } from "./components/publishDomPlaces.js";

showLoader('Cargando vista...');

window.onload = () => {

    const form = document.getElementById('form-update-event');
    const fields = [];

    // Handle TomSelect configuration
    const searchInputs = handleSearchInputs();

    const btnCancel = document.querySelector('#cancelEdit');

    // Get all fields from form and store them in fields object
    form.querySelectorAll('input, select, textarea').forEach((field) => {
        fields[field.name] = field;
    });

    // Handle function for date configuration for the event
    dateEvent();

    // Handle data form for validate and confirm if update event
    const handleUpdateForm = (e)=>{
        e.preventDefault();

        showLoader('Validando los datos');

        const data = new FormData(form);

        if(!validateData(data,fields)) {
            hideLoader();
            return;
        }

        showLoader('Guardando cambios del evento');

        publishDomPlaces(data.getAll('place'),form);

        Swal.fire(confirmDeleteAlert('¿Estas seguro?','Si estas seguro de editar el evento, presione el botón de Confirmar'))
            .then(
                result => {
                    console.log(result);
                    if(result.isConfirmed) {
                        form.submit();  
                    } else{
                        hideLoader();
                    }
                }
            )


    }

    const handleCancel = ()=>{
        Swal.fire(confirmDeleteAlert('¿Estas seguro?','Perderás toda la información'))
            .then(
                result => {                    
                    if(result.isConfirmed) {
                        location.href = '/agenda';
                    } 
                }
            )
    }
    

    form.addEventListener('submit',handleUpdateForm);
    btnCancel.addEventListener('click', handleCancel);

    hideLoader()
        

}