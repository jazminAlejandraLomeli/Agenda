import Swal from "sweetalert2/dist/sweetalert2.js";
import { showLoader, hideLoader } from "../helpers/loader.js";
import { errorAlert } from "../helpers/messagesSwalAlert.js";
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.default.css";
import { configTomSelect } from "../helpers/configTomSelect.js";
import { mainChart } from "./charts/events/principal.js";
import { requestData } from "./request/events/getdata.js";

const placeSelect = $("#place");
const dateStart = $("#date-start");
const dateEnd = $("#date-end");

$(function () {
    const place = new TomSelect("#place", {
        ...configTomSelect,
        maxItems: $(".place_item").length,
        plugins: {
            remove_button: {
                title: "Eliminar lugar",
            },
        },
    });

    showLoader();

    initialdata("");
    clickfilter();
});

async function initialdata(data = {}) {
    try {
        const Data = await requestData(data);
        const { places_chart } = Data;

        mainChart(places_chart);
    } catch (error) {
        Swal.fire({
            ...errorAlert(
                "Error",
                "Error al carga ls datos de la estadística "
            ),
        });
    }
}

function clickfilter() {
    $("#filterButton").off("click");
    $("#filterButton").click(function (e) {
        e.preventDefault();

        $(".text-date").text("");
        let start = dateStart.val().trim();
        let end = dateEnd.val().trim();

        let datos = validateData(start, end);
        if (datos) {
            let filtros = {
                place: placeSelect.val(),
                start: start,
                end: end,
            };

            initialdata(filtros);
        } else {
            return;
        }
    });
}

function validateData(start, end) {
    dateStart.removeClass("border-red-500");
    dateEnd.removeClass("border-red-500");

    let band = true;

    if (start.length === 0 && placeSelect.val() === "") {
        band = false;

        Swal.fire({
            ...errorAlert("Sin datos", "No se ingresaron datos para filtrar"),
        });
    }

    if (start > end) {
        band = false;
        dateStart.addClass("border-red-500");
        dateEnd.addClass("border-red-500");

        Swal.fire({
            ...errorAlert(
                "Datos incorrectos",
                "La fecha de inicio no puede ser mayor a la fecha final"
            ),
        });
    }

    return band;
}
