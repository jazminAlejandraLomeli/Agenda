import Swal from "sweetalert2/dist/sweetalert2.js";
import "sweetalert2/dist/sweetalert2.css";

export const confirmDeleteAlert = (title = " ", text = "") => {
    return {
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#999",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
    };
};

export const successAlert = (title = "", text = "") => {
    return {
        title: title,
        text: text,
        icon: "success",
        confirmButtonText: "Aceptar",
    };
};

export const errorAlert = (title = "", text = "") => {
    return {
        title: title,
        text: text,
        icon: "error",
        confirmButtonText: "Aceptar",
    };
};

export function AlertListError(response) {
    const { message, errors } = response;
    // lista de errores
    const errorList = Object.entries(errors)
        .map(([field, messages]) => {
            const fieldErrors = messages.map(
                (err) => `<li class="mb-1">${err}</li>`
            );
            return `<strong>${field}:</strong>
                    <ul class="pl-5 space-y-1">${fieldErrors}</ul>`;
        })
        .join("<br>");

    // Mostramos la alerta
    Swal.fire({
        title: "Errores de validación",
        html: errorList,
        icon: "error",
        confirmButtonText: "Aceptar",
    });
}

export const AlertListErrorHtml = (template) => {
    // Mostramos la alerta
    Swal.fire({
        title: "Errores de validación",
        html: template,
        icon: "error",
        confirmButtonText: "Aceptar",
    });
};

export const AlertInfo = (title = "", msg = "") => {
    return {
        title: title,
        text: msg,
        icon: "info",
        confirmButtonText: "Aceptar",
        // confirmButtonColor : '#D77933'
    };
};
