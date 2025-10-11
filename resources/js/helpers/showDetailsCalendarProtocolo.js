import Swal from "sweetalert2/dist/sweetalert2";
import "sweetalert2/dist/sweetalert2.css";
import { confirmDeleteAlert } from "./messagesSwalAlert";
import { showLoader } from "./loader";

const colorEventProtocolo = document.getElementById("color-event");
const titleEvetProtocolo = document.getElementById("title-event");
const dateEventProtocolo = document.getElementById("date-event");
const placeEventProtocolo = document.getElementById("place-event");
const responsibleEventProtocolo =
    document.getElementById("responsible-event");
const phoneEventProtocolo = document.getElementById("phone-event");
const dependencProgramEventProtocolo =
    document.getElementById("dependency-event");
const eventTypeEventProtocolo = document.getElementById("type-event");
const notesCTAEventProtocolo = document.getElementById("notes-cta");
const notesEventProtocolo = document.getElementById("notes-protocolo");
const notesGeneralServices = document.getElementById("notes-general-services");
const btnEditEventProtocolo = document.getElementById("btn-edit-protocolo");
const btnEditAllProtocolo = document.getElementById('btn-edit-all-protocolo');
const deleteForm = document.getElementById("deleteForm");
const deleteAllForm = document.getElementById("deleteAllForm");


// Insert data event Protocolo
export const showDetailsCalendarProtocolo = (data) => {
    const {
        id,
        title,
        place,
        protocolo,
        dependency_program,
        event_type,
        responsible,
        date,
        recursiveEvents
    } = data;


    const { color, name: name_place, text_color } = place;
    const { date_start_format, hour_start_format, hour_end_format } = date;
    const { name: name_responsible } = responsible;
    const {
        tel_extension,
        notes_cta,
        notes_general_service,
        notes_protocolo,
    } = protocolo;

    colorEventProtocolo.style.backgroundColor = `${color}`;
    colorEventProtocolo.style.borderColor = color;
    titleEvetProtocolo.textContent = title;
    titleEvetProtocolo.style.color = text_color;
    dateEventProtocolo.textContent = `${date_start_format} - ${hour_start_format} a ${hour_end_format}`;
    placeEventProtocolo.textContent = name_place;
    responsibleEventProtocolo.textContent = name_responsible;
    phoneEventProtocolo.textContent = tel_extension;
    dependencProgramEventProtocolo.textContent = dependency_program.name;
    eventTypeEventProtocolo.textContent = event_type.name;
    notesCTAEventProtocolo.textContent = notes_cta
        ? notes_cta
        : "Sin notas";
    notesEventProtocolo.textContent = notes_protocolo
        ? notes_protocolo
        : "Sin notas";
    notesGeneralServices.textContent = notes_general_service
        ? notes_general_service
        : "Sin notas";

    if (recursiveEvents == 1 && btnEditAllProtocolo) {
        btnEditAllProtocolo.href = `/agenda/edit/protocolo/all/${id}`;
        btnEditAllProtocolo.classList.remove('hidden');
    } else {
        if (btnEditAllProtocolo) {
            btnEditAllProtocolo.classList.add('hidden');
        }
    }

    if (btnEditEventProtocolo) {
        btnEditEventProtocolo.href = `/agenda/edit/protocolo/${id}`;
    }

    if (deleteForm) {
        deleteForm.action = `/agenda/delete/${id}`;
    }

    if (recursiveEvents == 1 && deleteAllForm) {
        deleteAllForm.action = `/agenda/delete/all/${id}`
        deleteAllForm.classList.remove('hidden');
        deleteAllForm.querySelector('button').disabled = false;
    } else {
        if (deleteAllForm) {
            deleteAllForm.classList.add('hidden');                        
            deleteAllForm.querySelector('button').disabled = true;
        }
    }

}