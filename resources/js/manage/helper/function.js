/* 
    Funcion para abrir o cerrar el modal 
*/

export function OpenCloseModal(option, id_modal) {
 window.dispatchEvent(new CustomEvent(option, { detail: id_modal }));
}

import { showHideAlert } from "../../helpers/show-hide-alerts.js";

/* Clic al boton de cancelar que ademas quita el borde de error si lo tiene  */
export function clicBtnCancel(Data) {
    /* Clic al boton */
    $(Data.Btn_cancel).off("click");
    $(Data.Btn_cancel).click(function (e) {
        OpenCloseModal("close-modal", Data.Id_modal); // Abrir modal
        $(Data.Input_name).parent().removeClass("border border-red-500");
        $(Data.select_name).parent().removeClass("border border-red-500");
        showHideAlert(2, Data.Cont_alerta, "", "");
    });
}
/* Funcion para mostrar los datos del registro seleccionado en el modal  */ 
export function ShowModalData(group, name) {
    $(".title-modal").text(name);
    $("#event-name").val(name);
    $("#Group").val(group);
}