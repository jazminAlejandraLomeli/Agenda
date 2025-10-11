import Swal from 'sweetalert2/dist/sweetalert2.js'
import { handleSearchInputs } from './components/handleSearchInputs.js';
import { publishDomPlaces } from './components/publishDomPlaces.js';
import { cancelForm } from './helpers/cancelForm.js';
import { manageDatesEvents } from './helpers/datesEvents.js';
import { hideLoader, showLoader } from './helpers/loader.js';
import { confirmDeleteAlert } from './helpers/messagesSwalAlert.js';
import { validateData } from './validators/validateCreateEventCTA.js'

showLoader('Cargando la vista');

window.onload = () => {

    const form = document.getElementById('form-create-event');
    const fields = [];

    // Handle TomSelect configuration
    const intancesSearchInputs = handleSearchInputs();

    cancelForm();


    // Get all fields from form and store them in fields object
    form.querySelectorAll('input, select, textarea').forEach((field) => {
        fields[field.name] = field;
    });

    // Manage dates configuration for events
    manageDatesEvents();


    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const data = new FormData(form);
        
        if (!
            (data, fields)) {
            hideLoader()
            return;
        }

        Swal.fire({
            ...confirmDeleteAlert('¿Esta seguro?', 'Si toda la información esta correcta presiona "Confirmar"')
        }).then(({ isConfirmed }) => {
            if (isConfirmed) {
                showLoader('Guardando la reservación del aula...')
                publishDomPlaces(data.getAll('place'), form);
                form.submit();
            }
        });


        

    })

    hideLoader();

}