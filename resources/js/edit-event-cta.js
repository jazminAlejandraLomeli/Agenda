import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

import { dateEvent } from "./helpers/dateEvent.js";
import { hideLoader, showLoader } from "./helpers/loader.js";
import { validateData } from './validators/validateEditEventCTA.js';
import { confirmDeleteAlert } from "./helpers/messagesSwalAlert.js";
import { cancelForm } from './helpers/cancelForm.js';
import { handleSearchInputs } from "./components/handleSearchInputs.js";
import { publishDomPlaces } from "./components/publishDomPlaces.js";



window.onload = () => {

    const form = document.getElementById('form-update-event');
    const fields = [];

    cancelForm('Todos los cambios realizados se perderán');

    // Get all fields from form and store them in fields object
    form.querySelectorAll('input, select, textarea').forEach((field) => {
        fields[field.name] = field;
    });

    // Handle function for date configuration for the event
    dateEvent();

    // Handle TomSelect configuration
    const intancesSearchInputs = handleSearchInputs();


    const handleFormUpdate = (e) => {
        e.preventDefault();

        const data = new FormData(form);

        if (!validateData(data, fields)) {
            hideLoader();
            return;
        }

        showLoader('Guardando cambios de la reservación de la aula');

        Swal.fire(confirmDeleteAlert('¿Estas seguro?', 'Si estas seguro de editar la reservación del aula, presione el botón de Confirmar'))
            .then(
                result => {
                    if (result.isConfirmed) {
                        showLoader('Guardando cambios de la reservación de la aula');
                        publishDomPlaces(data.getAll('place'), form);
                        form.submit();
                    } else {
                        hideLoader();
                    }
                }
            )
    }

    dateEvent();
    form.addEventListener('submit', handleFormUpdate);

    hideLoader();

}