import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import { showLoader, hideLoader } from "../helpers/loader.js";

import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";
import { showHideAlert } from "../helpers/show-hide-alerts.js";
import { validarCampo } from "../helpers/validate-function.js";
import { regexNumero, regexText } from "../helpers/regex.js";
import {
    OpenCloseModal,
    clicBtnCancel,
    ShowModalData,
} from "./helper/function.js";
import { requestEditEventType } from "./helper/request-edit-type-event.js";
import { requestAddEventType } from "./helper/request-add-type-even.js";
import {
    confirmDeleteAlert,
    errorAlert,
    successAlert,
    AlertListError,
} from "../helpers/messagesSwalAlert.js";
import { grid_event } from "./helper/grid-event-type.js";

/* 
Funcion para activar el clic al boton de editar tipo de evento 
*/
const clicEdit = (id, group, name) => {
    const Data = {
        Id: id,
        Old_group: group,
        Old_name: name,
        Option: 2,
        Id_button: "#btn-save",
        Input_group: "#Group",
        Input_name: "#event-name",
        Cont_alerta: "#cont-alert",
        Btn_cancel: "#btn-cancel",
        Id_modal: "edit-type-event",
    };
    ShowModalData(group, name);
    OpenCloseModal("open-modal", "edit-type-event"); // Abrir modal
    // Clic guardar cambios
    clicBtnSaveChanges(Data);
    // Cerra modal y limpiar inputs
    clicBtnCancel(Data);
};

$(function () {
    showLoader();
    initialData();
    clicAdd();
});

/*
    Funcion para activar el modal de agregar un nuevo tipo de evento, que activa el modal 
*/
function clicAdd() {
    $("#add-type-event").off("click");
    $("#add-type-event").click(function (e) {
        OpenCloseModal("open-modal", "add-type-event"); // Abrir modal

        const Data = {
            Id: "",
            Old_group: "",
            Old_name: "",
            Option: 1,
            Id_button: "#btn-save-add",
            Input_group: "#new_Group",
            Input_name: "#new_event-name",
            Cont_alerta: "#cont-alert-add",
            Btn_cancel: "#btn-cancel-add",
            Id_modal: "add-type-event",
        };

        clicBtnSaveChanges(Data);
        clicBtnCancel(Data);
    });
}

/* Funcion de clic al boton de guardar cambios para ambos modales  */
function clicBtnSaveChanges(Data) {
    // Arreglo con los Id del modal
    const {
        Id,
        Old_group,
        Old_name,
        Option,
        Id_button,
        Input_group,
        Input_name,
        Cont_alerta,
    } = Data;

    $(Id_button).off("click");
    $(Id_button).click(function (e) {
        // obtenemos los datos al hacer clic
        let new_name = $(Input_name).val().trim();
        let new_group = $(Input_group).val();
        if (Option == 1) {
            // Agregar
            if (new_name == "" || new_group == "") {
                // Datos vacios
              
                let v_name = validarCampo(new_name, regexText, Input_name);

                showHideAlert(
                    1,
                    Cont_alerta,
                    "¡Ooops!",
                    "Parece que no haz ingresado ningun dato."
                );
            } else {
                ValidateData(
                    Option,
                    Id,
                    new_group,
                    new_name,
                    Input_name,
                    Input_group
                );
            }
        } else {
            // Editar
            if (new_name == Old_name && new_group == Old_group) {
                // Verificar si hubo cambios
                showHideAlert(
                    1,
                    Cont_alerta,
                    "¡Ooops!",
                    "Parece que no haz realizado ningun cambio."
                );
            } else {
                // Hay cambios
                ValidateData(
                    Option,
                    Id,
                    new_group,
                    new_name,
                    Input_name,
                    Input_group
                );
                showHideAlert(2, Cont_alerta, "", "");
            }
        }
    });
}

/* Funcion para validar los datos que ingreso el usuario */
function ValidateData(Option, Id, Group, name, Input_name, Input_group) {
    // Obtenemos los nuevos datos y los validamos
    let v_group = validarCampo(parseInt(Group), regexNumero, Input_group);
    let v_name = validarCampo(name, regexText, Input_name);
    if (v_group && v_name) {
        // Datos corrctos llamar a funcion
        RequestEventType(Option, Id, Group, name);
    }
}

/* Funcion para obtener el texto para la alerta segun la opcion de editar o la de agregar  */
function ObtTextAlert(Type) {
    if (Type == 1) {
        // Agregar
        const data = {
            title: "¿Éstas seguro de agregar el nuevo dato?",
            text: "Una vez agregado No podra ser borrado del sistema",
            id_modal: "add-type-event",
        };
        return data;
    } else {
        // Editar
        const data = {
            title: "¿Éstas seguro de editar el dato?",
            text: "El registro se actualizará con los nuevos datos.",
            id_modal: "edit-type-event",
        };
        return data;
    }
}

/* Funcionpára hacer la request al controlador segun lo que guarde la varaible Option, 
    pueder ser agregar o editar un tipo de evento */
function RequestEventType(Option, Id, Group, name) {
    let TextAlert = ObtTextAlert(Option);
    const { text, title, id_modal } = TextAlert;

    Swal.fire({
        ...confirmDeleteAlert(title, text),
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            showLoader();
            // Ruta segun el Option (Editar o Agregar)
            const requestFunction =
                Option == 1 ? requestAddEventType : requestEditEventType;

            requestFunction(Id, Group, name)
                .then((response) => {
                    OpenCloseModal("close-modal", id_modal); // Cerra el modal correspondiente
                    const { title, message } = response;
                    hideLoader();
                    Swal.fire(successAlert(title, message))
                        .then((result) => {
                            location.reload(); // Recarga la página
                        })
                        .catch((e) => console.log(e));
                })
                .catch((error) => {
                    const { status } = error;
                    hideLoader();
                    if (status == 422) {
                        const { data } = error.response;
                        AlertListError(data);
                    } else {
                        const { title, message } = error;
                        Swal.fire(errorAlert(title, message))
                            .then((result) => {
                                location.reload(); // Recarga la página
                            })
                            .catch((e) => console.log(e));
                    }
                });
        }
    });
}

/* Funcion para mostrar el contenido de la tabla  */
function initialData() {
    let usertype = true;

    /*  Verificar el tipo de usuario es para mostrar o no la columna de tipo   */
    if (!$("#new_Group").hasClass("hidden")) {
        // Super Admin
        usertype = false;
    }

    const table = document.getElementById("tableEventsType");
    new Grid(grid_event(clicEdit, usertype)).render(table);
}
