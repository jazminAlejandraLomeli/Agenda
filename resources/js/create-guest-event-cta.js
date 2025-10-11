import Swal from 'sweetalert2/dist/sweetalert2.js'
import { handleSearchInputs } from "./components/handleSearchInputs";
import { cancelForm } from "./helpers/cancelForm";
import { dateEvent } from "./helpers/dateEvent";
import { hideLoader, showLoader } from "./helpers/loader";
import { confirmDeleteAlert } from "./helpers/messagesSwalAlert";
import { validateData } from "./validators/validateEditEventCTA";

showLoader('Cargando la vista');
window.onload = () => {

    const form = document.getElementById('form-create-event');
    const fields = [];

    // Handle TomSelect configuration
    const intancesSearchInputs = handleSearchInputs(1);

    // Get all fields from form and store them in fields object
    form.querySelectorAll('input, select, textarea').forEach((field) => {
        fields[field.name] = field;
    });

    // Cancel form submission
    cancelForm();


    // Manage dates configuration for events
    dateEvent();

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const data = new FormData(form);

        if (!validateData(data, fields)) {
            hideLoader()
            return;
        }

        Swal.fire({
            ...confirmDeleteAlert('¿Esta seguro?', 'Si toda la información esta correcta presiona "Confirmar"')
        }).then(({ isConfirmed }) => {
            if (isConfirmed) {
                showLoader('Guardando la reservación del aula...')                
                form.submit();
            }
        });




    })


    hideLoader();
}