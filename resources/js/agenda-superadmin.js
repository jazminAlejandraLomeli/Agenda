import { Calendar } from "@fullcalendar/core";
import { configDefaultCalendar } from "./helpers/configCalendar.js";

import { showLoader, hideLoader } from "./helpers/loader.js";
import { calendarFullScreen } from "./helpers/calendarFullScreen.js";

import ChangeColorCalendar from "./helpers/changeColorCalendar.js";
import { showDetailsCalendarCTA } from "./helpers/showDetailsCalendarCTA.js";
import { showDetailsCalendarProtocolo } from "./helpers/showDetailsCalendarProtocolo.js";
import { formatDataCalendar } from "./helpers/formatDataCalendar.js";
import { handleAlerts } from "./helpers/handleAlerts.js";
import { deleteEvent } from "./components/deleteEvent.js";

let eventsDataCache = [];
let colorCalendar = "";

showLoader('Cargando vista');

window.onload = () => {
    // Filter
    const filterEvents = document.getElementById("filterEvents");
    const filterEventsCTA = document.getElementById("filterPlace");

    const changeColor = new ChangeColorCalendar();
    colorCalendar = changeColor.colorCalendar;

    // Protocolo elements dom
    const calendarEl = document.getElementById("calendar");

    const contentPlaces = document.getElementById("content-places");


    // Delete data protocolo
    deleteEvent();

    // Hide alert if exists
    handleAlerts();

    const manageDetailsEvent = async ({ event: { id } }) => {
        showLoader('Cargando los detalles del evento');
        try {
            const { data } = await axios.get(`/agenda/get-event/${id}`);

            if (!data) {
                return;
            }

            if (data.group?.type === "Protocolo") {
                showDetailsCalendarProtocolo(data);
                window.dispatchEvent(
                    new CustomEvent("open-modal", {
                        detail: "details-protocolo",
                    })
                );
            } else {
                console.log("CTA");
                showDetailsCalendarCTA(data);
                window.dispatchEvent(
                    new CustomEvent("open-modal", { detail: "details-cta" })
                );
            }
        } catch (error) {
            console.error(error);
        } finally {
            hideLoader();
        }
    };

    const manageEvents = async ({ startStr, endStr }, success, failure) => {
        showLoader('Cargando eventos');

        const range_key = contentPlaces.classList.contains("hidden")
            ? `${startStr}-${endStr}-${filterEvents.value}`
            : `${startStr}-${endStr}-${filterEvents.value}-${filterEventsCTA.value}`;

        if (eventsDataCache[range_key]) {
            hideLoader();
            success(eventsDataCache[range_key]);
            return;
        }

        try {
            const { data } = await axios.get(
                `/agenda/get-events?start=${startStr}&end=${endStr}&filter_type=${filterEvents.value}&filter_place=${filterEventsCTA.value}`
            );

            const dataFormat = formatDataCalendar(data, colorCalendar);

            eventsDataCache[range_key] = dataFormat;
            success(dataFormat);
        } catch (error) {
            failure(error);
        } finally {
            hideLoader();
        }
    };

    const calendar = new Calendar(calendarEl, {
        ...configDefaultCalendar,
        events: manageEvents,
        eventClick: manageDetailsEvent,
    });

    calendar.render();

    filterEvents.addEventListener("change", () => {
        // btnAddEventProtocolo.classList.toggle('hidden');
        // btnAddEventCTA.classList.toggle('hidden');
        contentPlaces.classList.toggle("hidden");
        calendar.refetchEvents();
    });

    filterEventsCTA.addEventListener("change", () => {
        calendar.refetchEvents();
    });

    calendarFullScreen(calendar);
};
