import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

import { OpenCloseModal } from "../manage/helper/function.js";
import { validarCampo } from "../helpers/validate-function.js";
import { regexPassword } from "../helpers/regex.js";
import { requestVerify, requestChangePassword } from "./request-verify-pass.js";
import { showLoader, hideLoader } from "../helpers/loader.js";
import { showHideAlert } from "../helpers/show-hide-alerts.js";
import { clicSeePass } from "./seePassword/seepassword.js";
import {
    successAlert,
    errorAlert,
    confirmDeleteAlert,
} from "../helpers/messagesSwalAlert.js";

$(function () {
    ClicPassword();
    hideLoader();
});

/*
 Funcion del boton de clic para cambiar la contraseña
*/
function ClicPassword() {
    $("#Btn-change").off("click");
    $("#Btn-change").click(function (e) {
        OpenCloseModal("open-modal", "modal_pass"); // Abrir modal
        clicVerifyPass();
        cancelChange();
        clicSeePass("#seepass", "#current-pass");
    });
}

/*
    Funcion al boton de verificar la contraseña, que a su vez hace una consulta al controlador y verifica que si sea la contraseña actual
*/
function clicVerifyPass() {
    $("#Btn-verify").off("click");
    $("#Btn-verify").click(function (e) {
        let current_pass = $("#current-pass").val().trim();
        let V_pass = validarCampo(current_pass, regexPassword, "#current-pass");

        console.log(current_pass, V_pass);

        if (V_pass) {
            verifyPassword(current_pass);
        } 
    });
}

/*
    Funcion para cerrar el modal y mostrar el paso uno 
*/
function cancelChange() {
    $("#btn-cancel").off("click");
    $("#btn-cancel").click(function (e) {
        $("#current-pass").val("");
        OpenCloseModal("close-modal", "modal_pass"); // Abrir modal
        ShowStep2("hidde");
    });
}

/*
        Funcion que hace una consulta al controlador y verifica que si sea la contraseña actual
*/
function verifyPassword(current_pass) {
    // Mostrar el loader
    showLoader('Verificando contraseña...');
    requestVerify(current_pass)
        .then((response) => {
            // Ocultar el loader al recibir la respuesta
            hideLoader();
            const { status } = response;
            showHideAlert(2, "#cont-alert", "", ""); // ocultar alerta
            ShowStep2("show"); // mostrar paso 2
            // Ver contraseña en texto plano
            clicSeePass("#new_pass_see", "#new-pass");
            clicSeePass("#conf_pass_see", "#confirm-pass");
            newPass();
        })
        .catch((error) => {
            // Ocultar el loader y manejar el error
            hideLoader();
            const { status } = error;

            if (status == 404) {
                const { errors } = error.response.data;
                showHideAlert(1, "#cont-alert", "¡Ooops!", errors.Pass[0]);
            } else {
                const { data } = error.response;
                showHideAlert(1, "#cont-alert", "¡Error!", data.msg);
            }
        });
}

/*
    Funcion que muestra el paso 2 en el procedimiento de cambiar la contraseña 
*/
function ShowStep2(Option) {
    if (Option == "hidde") {
        // Hidde step two
        if ($(".step_one").hasClass("hidden")) {
            $(".step_one").removeClass("hidden");
        }

        if (!$(".step_two").hasClass("hidden")) {
            $(".step_two").addClass("hidden");
        }
    } else {
        // Hidde step two
        if (!$(".step_one").hasClass("hidden")) {
            $(".step_one").addClass("hidden");
        }

        if ($(".step_two").hasClass("hidden")) {
            $(".step_two").removeClass("hidden");
        }
    }
}

/*
    Funcion para el boton de clic al cambiar la contraseña, valida que cumpla con una estructura y que ambas coincidan 

*/
function newPass() {
    $("#Btn-save").off("click");
    $("#Btn-save").click(function (e) {
        let new_pass = $("#new-pass").val().trim();
        let confirm_pass = $("#confirm-pass").val().trim();

        if (new_pass == "" || confirm_pass == "") {
            let V_new = validarCampo(new_pass, regexPassword, "#new-pass");
            let V_conf = validarCampo(
                confirm_pass,
                regexPassword,
                "#confirm-pass"
            );
            showHideAlert(
                1,
                "#cont-alert",
                "¡Ooops!",
                "Parece que hay un dato vacío en el formulario."
            );
        } else {

            let V_new = validarCampo(new_pass, regexPassword, "#new-pass");
            let V_conf = validarCampo(
                confirm_pass,
                regexPassword,
                "#confirm-pass"
            );

            if (V_new && V_conf) {
                if (new_pass != confirm_pass) {
                    let a = validarCampo("", regexPassword, "#new-pass");
                    let x = validarCampo("", regexPassword, "#confirm-pass");
                    showHideAlert(
                        1,
                        "#cont-alert",
                        "¡Ooops!",
                        "Las contraseñas no coinciden"
                    );
                } else {
                    showHideAlert(2, "#cont-alert", "", "");
                    changePassword(new_pass);
                }
            } else {
                showHideAlert(
                    1,
                    "#cont-alert",
                    "¡Ooops!",
                    "La contraseña no tiene la estructura válida."
                );
            }
        }
    });
}

/*
    Funcion que hace una confirmacion acerca de si realmente esta seguro de realizar la accion
*/
function changePassword(new_pass) {
    Swal.fire({
        ...confirmDeleteAlert(
            "¿Estas seguro de cambiar la contraseña?",
            "Al iniciar sesión deberás usar la nueva contraseña"
        ),
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            showLoader('Guardando cambios...'); // Mostrar el loader

            requestChangePassword(new_pass)
                .then((response) => {
                    // Ocultar el loader al recibir la respuesta
                    hideLoader();
                    const { title, message } = response;
                    Swal.fire(successAlert(title, message))
                        .then((result) => {
                            location.reload();
                        })
                        .catch((e) => console.log(e));
                })
                .catch((error) => {
                    //  Ocultar el loader y manejar el error
                    hideLoader();
                    const { title, message } = error;
                    Swal.fire(errorAlert(title, message))
                        .then((result) => {})
                        .catch((e) => console.log(e));
                });
        }
    });
}
