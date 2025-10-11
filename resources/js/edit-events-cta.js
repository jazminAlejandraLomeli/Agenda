import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

import { dateEvent } from "./helpers/dateEvent.js";
import { hideLoader, showLoader } from "./helpers/loader.js";
import { validateData } from './validators/validateCreateEventCTA.js';
import { confirmDeleteAlert } from "./helpers/messagesSwalAlert.js";
import { manageDatesEvents } from "./helpers/datesEvents.js";
import { handleSearchInputs } from "./components/handleSearchInputs.js";
import { publishDomPlaces } from "./components/publishDomPlaces.js";





window.onload = () => {

    const form = document.getElementById('form-update-event');
    const cancelEdit = document.getElementById('cancelEdit');
    const showDates = document.getElementById('showDates');
    const fields = [];



    // Get all fields from form and store them in fields object
    form.querySelectorAll('input, select, textarea').forEach((field) => {
        fields[field.name] = field;
    });

    // Handle function for date configuration for the event
    dateEvent();

    // Manage dates configuration for events
    manageDatesEvents();

    // Handle TomSelect configuration
    const intancesSearchInputs = handleSearchInputs();

    const handleShowDates = () => {
        window.dispatchEvent(
            new CustomEvent("open-modal", {
                detail: "details-dates",
            })
        );
    }

    const handleCancelEdit = () => {
        Swal.fire(confirmDeleteAlert('¿Estas seguro?', 'Todos los cambios realizados se perderán'))
            .then(result => {
                if (result.isConfirmed) {
                    location.href = '/agenda';
                }

            });
    }

    const handleFormEvents = (e) => {
        e.preventDefault();

        showLoader('Validando los datos');

        const data = new FormData(form);

        if (!validateData(data, fields)){
            hideLoader();
            return;
        }
        
        publishDomPlaces(data.getAll('place'),form);
        

        Swal.fire(confirmDeleteAlert('¿Estas seguro?', 'Si estas seguro de aplicar los cambios a los eventos, presione el botón de Confirmar'))
            .then(
                result => {
                    if (result.isConfirmed) {
                        showLoader('Guardando cambios del evento');
                        form.submit();
                    }

                }
            )
    }

    showDates.addEventListener('click', handleShowDates)
    form.addEventListener('submit', handleFormEvents);
    cancelEdit.addEventListener('click', handleCancelEdit)

    hideLoader();

}