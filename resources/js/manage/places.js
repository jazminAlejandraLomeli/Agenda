import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";
import { grid_event } from "./helper/grid-places.js";
import { OpenCloseModal } from "./helper/function.js";
import { showHideAlert } from "../helpers/show-hide-alerts.js";
import { validarCampo } from "../helpers/validate-function.js";
import { regexNumero, regexText } from "../helpers/regex.js";
import {
    confirmDeleteAlert,
    errorAlert,
    successAlert,
    AlertListError,
} from "../helpers/messagesSwalAlert.js";
import { requestEditPlace } from "./helper/request-edit-places.js";
import { requestAddPlace } from "./helper/request-add-place.js";
import { showLoader, hideLoader } from "../helpers/loader.js";

// INSERT INTO `Alumnos` (`Codigo`, `Nombre`, `Genero`, `Carrera`, `Ciclo_ingreso`, `Estado`, `Correo`) VALUES ('218574896', 'RAMIREZ GUTIERREZ NATALY', 'F', '34', '2025A', '1', NULL);
const clicEdit = (id, group, name, color, text_color) => {
    const Data = {
        Id: id,
        Old_group: group,
        Old_name: name,
        Old_color: color,
        Old_text_color: text_color,  
        Option: 2,
        Id_button: "#btn-save",
        Input_group: "#Group",
        Input_name: "#name",
        Input_text_color: "#text_color",
        Input_color_hx: "#color-hex",
        Input_color: "#color",
        Input_cont: "#cont-color-edit",
        Cont_alerta: "#cont-alert",
    };

    $(".title-modal").text(name);

    showDataEditModal(Data, group, name, color, text_color);
    listenNamePlace(Data);
    listenColorText(Data);
    listen_color(Data);
    OpenCloseModal("open-modal", "edit-places"); // Abrir modal
    // Clic guardar cambios
    clicBtnSaveChanges(Data);
    // Cerra modal y limpiar inputs
    clicBtnCancel(Data, "edit-places", "#btn-cancel");
};

$(function () {
    showLoader();
    initialData();
    // OpenCloseModal("open-modal", "edit-places"); // Abrir modal
    clicAdd();
});

function showDataEditModal(Data, group, name, color, text_color) {
    let opt_color = text_color === "#000000" ? "1" : "2";
    // Datos viejos
    $(Data.Input_name).val(name);
    $(Data.Input_group).val(group);
    $(Data.Input_color_hx).val(color);
    $(Data.Input_color).val(color);
    $(Data.Input_text_color).val(opt_color);

    $(".show-color-text").text(name);
    $(".show-color-text").css("color", text_color);
    $(Data.Input_cont).css("background-color", color); // Pintar el contenedor
}
/*
    Funcion para activar el modal de agregar un nuevo tipo de evento, que activa el modal 
*/
function clicAdd() {
    $("#add-places").off("click");
    $("#add-places").click(function (e) {
        OpenCloseModal("open-modal", "add-places"); // Abrir modal
        const Data = {
            Id: "",
            Old_group: "",
            Old_name: "",
            Old_color: "",
            Old_text_color: "",
            Option: 1,
            Id_button: "#btn-save-add",
            Input_group: "#new_Group",
            Input_name: "#new_name",
            Input_text_color: "#new_text_color",
            Input_color_hx: "#new_color-hex",
            Input_color: "#new_color",
            Cont_alerta: "#cont-alert-add",
            Input_cont: "#cont-color",
        };
        //id="btn-save-add"
        $(".title-modal").text("Nombre del lugar");
        listenNamePlace(Data);
        listenColorText(Data);
        listen_color(Data);
        clicBtnSaveChanges(Data);
        clicBtnCancel(Data, "add-places", "#btn-cancel-add");
    });
}


function listenNamePlace(Data) {
    const { Input_name } = Data;
    $(Input_name).off("change");
    $(Input_name).on("change", function () {
        const text = $(this).val(); // Obtén el valor del input de tipo color
        $(".show-color-text").text(text);
    });
}

function listenColorText(Data) {
    const { Input_text_color } = Data;
    $(Input_text_color).off("change");
    $(Input_text_color).on("change", function () {
        let text_color = $(this).val() === "2" ? "#ffffff" : "#000000";
        $(".show-color-text").css("color", text_color);
    });
}

/* Actualizar los inputs de color ya sea por medio del Hexadecimal o el tipo color */
function listen_color(Data) {
    const { Input_text_color, Input_color, Input_color_hx, Input_cont } = Data;

    $(Input_color).off("input");
    $(Input_color).on("input", function () {
        const colorValue = $(this).val(); // Obtén el valor del input de tipo color
        $(Input_color_hx).val(colorValue); // Actualiza el campo de texto con el valor hexadecimal
        $(Input_cont).css("background-color", colorValue); // Pintar el contenedor
    });

    $(Input_color_hx).off("input");
    $(Input_color_hx).on("input", function () {
        let colorValue = $(this).val(); // Obtén el valor del campo de texto

        // Verifica si el valor tiene exactamente 6 caracteres y no contiene '#'
        if (colorValue.length === 6 && !colorValue.startsWith("#")) {
            colorValue = "#" + colorValue; // Agrega el '#'
        } else if (colorValue.startsWith("#") && colorValue.length > 7) {
            // Si hay más de un '#' o el texto supera los 7 caracteres
            colorValue = "#" + colorValue.replace(/#/g, "").substr(0, 6);
        }
        // Actualiza los campos
        $(Input_color_hx).val(colorValue);
        $(Input_color).val(colorValue);
        $(Input_cont).css("background-color", colorValue); // Pintar el contenedor
    });
}

function clicBtnCancel(Data, id_modal, id_button) {
    /* Clic al boton */

    $(id_button).off("click");
    $(id_button).click(function (e) {
        OpenCloseModal("close-modal", id_modal); // Abrir modal
        $(Data.Input_name).parent().removeClass("border border-red-500");
        $(Data.Input_group).parent().removeClass("border border-red-500");
        $(Data.Input_text_color).parent().removeClass("border border-red-500");
          showHideAlert(2, Data.Cont_alerta, "", "");
    });
}

/* Funcion de clic al voton de guardar cambios  */
function clicBtnSaveChanges(Data) {
    // Arreglo con los Id del modal
    const {
        Id,
        Old_name,
        Old_group,
        Old_color,
        Old_text_color,
        Option,
        Id_button,
        Input_group,
        Input_name,
        Input_text_color,
        Input_color_hx,
        Input_color,
        Input_cont,
    } = Data;


    /* Clic al boton */
    $(Id_button).off("click");
    $(Id_button).click(function (e) {
        // obtenemos los datos al hacer clic
        let new_name = $(Input_name).val().trim();
        let new_group = $(Input_group).val();
        let new_color = $(Input_color_hx).val();
        let new_text_color = $(Input_text_color).val();
        let opt_text_color = Old_text_color === "#000000" ? "1" : "2";

        if (Option == 1) {
            // Agregar
            if (
                new_name == "" ||
                new_group == null ||
                new_text_color == null ||
                new_text_color == "0"
            ) {
                // Forzamos errores
                let a = validarCampo(
                    parseInt(new_group),
                    regexNumero,
                    Input_group
                );
                let b = validarCampo(
                    new_text_color,
                    regexNumero,
                    Input_text_color
                );
                let c = validarCampo(new_name, regexText, Input_name);

                // Datos vacios
                showHideAlert(
                    1,
                    "#cont-alert-add",
                    "¡Ooops!",
                    "Parece que no haz ingresado ningun dato."
                );
            } else {
                ValidateData(
                    Option,
                    Id,
                    new_group,
                    new_name,
                    new_color,
                    new_text_color,
                    Input_name,
                    Input_group,
                    Input_text_color
                );
                showHideAlert(2, "#cont-alert-add", "", "");
            }
        } else {
            // Editar
            if (
                new_name == Old_name &&
                new_group == Old_group &&
                new_color == Old_color &&
                new_text_color == opt_text_color
            ) {
                // Verificar si hubo cambios
                showHideAlert(
                    1,
                    "#cont-alert",
                    "¡Ooops!",
                    "Parece que no haz realizado ningun cambio."
                );
            } else {
                ValidateData(
                    Option,
                    Id,
                    new_group,
                    new_name,
                    new_color,
                    new_text_color,
                    Input_name,
                    Input_group,
                    Input_text_color
                );
                showHideAlert(2, "#cont-alert", "", "");
            }
        }
    });
}

/* Funcion para validar los datos que ingreso el usuario */
function ValidateData(
    Option,
    Id,
    Group,
    name,
    color,
    text_color,
    Input_name,
    Input_group,
    input_color,
    Input_text_color
) {
    // Obtenemos los nuevos datos y los validamos
    let v_group = validarCampo(parseInt(Group), regexNumero, Input_group);
    let v_name = validarCampo(name, regexText, Input_name);
    let v_text_color = validarCampo(text_color, regexNumero, Input_text_color);

    if (v_group && v_name && v_text_color) {
        // Datos corrctos llamar a funcion
        Request(Option, Id, Group, name, color, text_color);
    }
}

function Request(option, id, group, name, color, text_color) {
    let TextAlert = ObtTextAlert(option);
    const { text, title, id_modal } = TextAlert;
    Swal.fire({
        ...confirmDeleteAlert(title, text),
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            // Ruta segun el Option (Editar o Agregar)
            showLoader();
            const requestFunction =
                option == 1 ? requestAddPlace : requestEditPlace;
            requestFunction(id, group, name, color, text_color)
                .then((response) => {
                    OpenCloseModal("close-modal", id_modal); // Cerra el modal correspondiente
                    const { title, message } = response;
                    hideLoader();
                    Swal.fire(successAlert(title, message))
                        .then((result) => {
                            // Recarga la página
                            location.reload();
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
                                //location.reload(); // Recarga la página
                            })
                            .catch((e) => console.log(e));
                    }
                });
        }
    });
}

/* Funcion para obtener el texto para la alerta segun la opcion de editar o la de agregar  */
function ObtTextAlert(Type) {
    if (Type == 1) {
        // Agregar
        const data = {
            title: "¿Estas seguro de agregar el nuevo lugar?",
            text: "Una vez agregado No podra ser borrado del sistema",
            id_modal: "",
        };
        return data;
    } else {
        // Editar
        const data = {
            title: "¿Estas seguro de editar los datos del lugar?",
            text: "El registro se actualizara con los nuevos datos.",
            id_modal: "edit-places",
        };
        return data;
    }
}

/* Funcion para mostrar el contenido de la tabla  */
function initialData() {
    let usertype = true;

    /*  Verificar el tipo de usuario es para mostrar o no la columna de tipo   */
    if (!$("#Group").hasClass("hidden")) {
        // Super Admin
        usertype = false;
    }
    const table = document.getElementById("tablePlace");
    new Grid(grid_event(clicEdit, usertype)).render(table);
}
