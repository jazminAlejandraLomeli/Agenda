import Swal from "sweetalert2/dist/sweetalert2.js";
import { showLoader, hideLoader } from "../helpers/loader.js";
import { AlertInfo, errorAlert } from "../helpers/messagesSwalAlert.js";
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.default.css";
import { configTomSelect } from "../helpers/configTomSelect.js";

import { request_cta_data } from "./request/labs/getdata-labs.js";
import { request_chart_2 } from "./request/labs/get-data-chart.js";
import { placesChart } from "./charts/labs/places.js";
import { template_cards } from "./charts/labs/chart_details.js";

const programSelect = $("#program");
const Start = $("#date-start");
const End = $("#date-end");

const SdateStart = $("#date-start-semester");
const SdateEnd = $("#date-end-semester");

$(function () {
    const program = new TomSelect("#program", {
        ...configTomSelect,
    });

    showLoader();

    initialdata("");
    initaildata_chart2("");
    clickfilter();
    clickfilter_semester();
});

async function initialdata(data = {}) {
    try {
        const Data = await request_cta_data(data);
        const { places_chart, string_date } = Data;
        $(".date_string").text(string_date);

        placesChart(places_chart);
    } catch (error) {
        Swal.fire({
            ...errorAlert(
                "Error",
                "Error al carga los datos de la estadística "
            ),
        });
    }
}

async function initaildata_chart2(data = {}) {
    try {
        
        const Data = await request_chart_2(data);
      
        if (!Data.semesters || Data.semesters.length === 0) {
            return;
        }

        template_cards(Data);
    } catch (error) {
        Swal.fire({
            ...errorAlert(
                "Error",
                "Error al carga los datos de la estadística "
            ),
        });
    }
}

function clickfilter_semester() {
    $("#filter_semesters").off("click");
    $("#filter_semesters").click(function (e) {
        e.preventDefault();

        let datos = validateData(
            SdateStart.val().trim(),
            SdateEnd.val().trim(),
            SdateStart,
            SdateEnd
        );
        if (datos) {
            let filtros = {
                program: programSelect.val().trim(),
                start: SdateStart.val().trim(),
                end: SdateEnd.val().trim(),
            };
            initaildata_chart2(filtros);
        } else {
            return;
        }
    });
}

function clickfilter() {
    $("#filterButton").off("click");
    $("#filterButton").click(function (e) {
        e.preventDefault();

        $(".text-date").text("");
        // let Start = Start.val().trim();
        // let End = End.val().trim();

        let datos = validateData(
            Start.val().trim(),
            End.val().trim(),
            Start,
            End
        );
        if (datos) {
            let filtros = {
                // program: programSelect.val(),
                start: Start.val().trim(),
                end: End.val().trim(),
            };
            initialdata(filtros);
        } else {
            return;
        }
    });
}

function validateData(start, end, input_start, input_end) {
    input_start.removeClass("border-red-500");
    input_end.removeClass("border-red-500");

    let band = true;

    if (start.length === 0 && programSelect.val() === "") {
        band = false;

        Swal.fire({
            ...errorAlert("Sin datos", "No se ingresaron datos para filtrar"),
        });
    }

    if (start > end) {
        band = false;
        input_start.addClass("border-red-500");
        input_end.addClass("border-red-500");

        Swal.fire({
            ...errorAlert(
                "Datos incorrectos",
                "La fecha de inicio no puede ser mayor a la fecha final"
            ),
        });
    }

    return band;
}
