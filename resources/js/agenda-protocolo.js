import { Calendar } from "@fullcalendar/core";
import { configDefaultCalendar } from "./helpers/configCalendar.js";

import { showLoader, hideLoader } from "./helpers/loader.js";
import { showDetailsCalendarProtocolo } from "./helpers/showDetailsCalendarProtocolo.js";
import ChangeColorCalendar from "./helpers/changeColorCalendar.js";
import { formatDataCalendar } from "./helpers/formatDataCalendar.js";
import { calendarFullScreen } from "./helpers/calendarFullScreen.js";
import { deleteEvent } from "./components/deleteEvent.js";
import { handleAlerts } from "./helpers/handleAlerts.js";

let eventsDataCache = [];
let colorCalendar = '';

window.onload = () => {
    // Protocolo elements dom
    const calendarEl = document.getElementById("calendar");

    const changeColor = new ChangeColorCalendar();
    colorCalendar = changeColor.colorCalendar;


    // Delete data protocolo
    deleteEvent();

    // Hide alert if exists
    handleAlerts();

    // Insert data event protocolo

    const manageDetailsEvent = async ({ event: { id } }) => {
        showLoader("Cargando los detalles del evento");
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
            }
        } catch (error) {
            console.error(error);
        } finally {
            hideLoader();
        }
    };

    const manageEvents = async ({ startStr, endStr }, success, failure) => {
        showLoader("Cargando los eventos");

        const range_key = `${startStr}-${endStr}`;

        if (eventsDataCache[range_key]) {
            hideLoader();
            success(eventsDataCache[range_key]);
            return;
        }

        try {
            const { data } = await axios.get(
                `/agenda/get-events?start=${startStr}&end=${endStr}`
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

    calendarFullScreen(calendar);
};
