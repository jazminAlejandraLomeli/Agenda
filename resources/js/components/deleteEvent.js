import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";
import { confirmDeleteAlert } from "../helpers/messagesSwalAlert";
import { showLoader } from "../helpers/loader";

const deleteForm = document.getElementById('deleteForm');
const deleteAllForm = document.getElementById('deleteAllForm');

const deleteEventCTA = document.getElementById('deleteFormCTA');
const deleteAllCTA = document.getElementById("deleteAllFormCTA");


export const deleteEvent = () => {

    const handleDeleteEvent = (e) => {
        
        e.preventDefault();

        Swal.fire(confirmDeleteAlert('¿Estas seguro?', 'Si estas seguro de eliminar el evento, presione el botón de Confirmar'))
            .then(
                result => {
                    if (result.isConfirmed) {
                        showLoader('Eliminado recurso...')
                        e.target.submit();
                    }
                })
            .catch(error => {
                console.error(error);
            });


    }

    const handleDeleteEvents = (e) => {
        e.preventDefault();

        Swal.fire(confirmDeleteAlert('¿Estas seguro?', 'Si estas seguro de eliminar los eventos relacionados, presione el botón de Confirmar'))
            .then(
                result => {
                    if (result.isConfirmed) {
                        showLoader('Eliminado recursos...')
                        e.target.submit();
                    }
                })
            .catch(error => {
                console.error(error);
            });
    }

    if(deleteForm){
        deleteForm.addEventListener('submit', handleDeleteEvent);
    }



    if(deleteAllForm){
        deleteAllForm.addEventListener('submit',handleDeleteEvents)
    }

    if(deleteEventCTA){
        deleteEventCTA.addEventListener('submit', handleDeleteEvent);
    }

    if(deleteAllCTA){
        deleteAllCTA.addEventListener('submit', handleDeleteEvents);
    }


}