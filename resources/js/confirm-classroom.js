import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";
import {
    confirmDeleteAlert,
    errorAlert,
    successAlert,
    AlertListError,
} from "./helpers/messagesSwalAlert.js";
import { requestConfirm } from "./confirm-classroom/request-confirm.js";
import { requestDeny } from "./confirm-classroom/request-deny.js";
import { showLoader, hideLoader } from "./helpers/loader.js";
import { OpenCloseModal } from "./manage/helper/function.js";
import { validarCampo } from "./helpers/validate-function.js";
import { regexText } from "./helpers/regex.js";
import { showHideAlert } from "./helpers/show-hide-alerts.js";

$(function () {
    ClickPublic();
    ClickDeny();
    hideLoader();
    //OpenCloseModal("open-modal", "deny-reservation");
});

function ClickPublic() {

    $(".Btn-public").off("click");
    $(".Btn-public").click(function (e) {
        e.preventDefault();
        let Id_event = $(this).data("id"); 
 console.log(Id_event);
        Swal.fire({
            ...confirmDeleteAlert(
                "¿Éstas seguro de publicar la reservación?",
                "La reservación será visible para todos"
            ),
        }).then(({ isConfirmed }) => {
            if (isConfirmed) {
                showLoader("Publicando reservación...");
                requestConfirm(Id_event)
                    .then((response) => {
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
                        console.log(error);

                        const { status } = error;
                        hideLoader();
                        if (status == 400) {
                            const { message } = error;
                            if ($(".cont-error").hasClass("hidden")) {
                                $(".cont-error").removeClass("hidden");
                                $("#text-error").text(message); // Mostrar el error, siempre sera 1
                            }
                        } else {
                            console.log("Entra a error ");
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
    });
}

function ClickDeny() {
    $(".Btn-deny").off("click");
    $(".Btn-deny").click(function (e) {
        var Id_event = $(".Btn-deny").data("id");
        var Event_name = $(".Btn-deny").data("name");

        $(".event_title").text(Event_name);

        OpenCloseModal("open-modal", "deny-reservation");

        clicBtnCancel();
        ClicConfirmDeny(Id_event);
    });
}

function ClicConfirmDeny(Id_event) {
    $("#btn-save").off("click");
    $("#btn-save").click(function (e) {
        let reason = $("#reason").val().trim();
        let V_reason = validarCampo(reason, regexText, "#reason");
        if (V_reason) {
            console.log("Correcto");
            ConfimDeny(Id_event, reason);
        } else {
            if (reason == "") {
                showHideAlert(
                    1,
                    "#cont-alert-add",
                    "¡Ooops!",
                    "Parece que no haz ingresado ningun dato."
                );
            } else {
                showHideAlert(
                    1,
                    "#cont-alert-add",
                    "¡Ooops!",
                    "Parece que haz agregado un caracter inválido."
                );
            }
        }
    });
}

function ConfimDeny(id, reason) {
    Swal.fire({
        ...confirmDeleteAlert(
            "¿Éstas seguro de NO publicar la reservación?",
            "La reservación será eliminada del sistema "
        ),
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            console.log("Si eliminar");
            showLoader();
            requestDeny(id, reason)
                .then((response) => {
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
                    console.log(error);
                    const { status } = error;
                    hideLoader();
                    if (status == 422) {
                        const { data } = error.response;
                        AlertListError(data);
                    } else {
                        const { title, message } = error.response.data;
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

function clicBtnCancel() {
    $("#btn-cancel").off("click");
    $("#btn-cancel").click(function (e) {
        OpenCloseModal("close-modal", "deny-reservation");
        $("#reason").val("");
    });
}
