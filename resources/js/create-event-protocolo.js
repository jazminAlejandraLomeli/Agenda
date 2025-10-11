import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

import { manageDatesEvents } from './helpers/datesEvents.js';
import { validateData } from './validators/validateCreateEventProtocolo.js';
import { handleSearchInputs } from './components/handleSearchInputs.js';
import { hideLoader, showLoader } from './helpers/loader.js';
import { publishDomPlaces } from './components/publishDomPlaces.js';
import { confirmDeleteAlert } from "./helpers/messagesSwalAlert.js";

window.onload = () => {

    const form = document.getElementById('form-create-event');
    const fields = {};

    const btnCancel = document.querySelector('#cancel');

    // Manage dates configuration for events
    manageDatesEvents();  
    
    // Handle TomSelect configuration
    const searchInputs = handleSearchInputs();


    // Get all fields from form and store them in fields object
    form.querySelectorAll('input, select, textarea').forEach((field) => {
        fields[field.name] = field;
    });

    

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const data = new FormData(form);

        showLoader('Validando los datos');
        
        if(!validateData(data, fields)){
            hideLoader();
            return;
        }

        showLoader('Guardado el evento');

        publishDomPlaces(data.getAll('place'),form);

        form.submit();
    })

    

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

    btnCancel.addEventListener('click', handleCancel);

    hideLoader();
    

}