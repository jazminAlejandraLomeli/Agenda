import { Calendar } from "@fullcalendar/core";
import { configDefaultCalendar } from "./helpers/configCalendar.js";

import { showLoader, hideLoader } from "./helpers/loader.js";
import { calendarFullScreen } from "./helpers/calendarFullScreen.js";
import { showDetailsCalendarCTA } from "./helpers/showDetailsCalendarCTA.js";
import { formatDataCalendar } from "./helpers/formatDataCalendar.js";
import ChangeColorCalendar from "./helpers/changeColorCalendar.js";
import { deleteEvent } from "./components/deleteEvent.js";
import { handleAlerts } from "./helpers/handleAlerts.js";

let eventsDataCache = [];
let colorCalendar = '';

window.onload = () => {
    const calendarEl = document.getElementById("calendar");

    const changeColor = new ChangeColorCalendar();
    colorCalendar = changeColor.colorCalendar;



    // Hide alert if exists
    handleAlerts();

    // Filter
    const filterPlaces = document.getElementById("filterPlace");
    const manageDetailsEvent = async ({ event: { id } }) => {
        showLoader("Cargando los detalles del evento");
        try {
            const { data } = await axios.get(`/agenda/get-event/${id}`);

            if (!data) {
                return;
            }

            if (data.group?.type === "CTA") {
                showDetailsCalendarCTA(data);
                window.dispatchEvent(
                    new CustomEvent("open-modal", { detail: "details-cta" })
                );
            }
        } catch (error) {
            
        } finally {
            hideLoader();
        }
    };

    const manageEvents = async ({ startStr, endStr }, success, failure) => {
        showLoader("Cargando los eventos");

        const range_key = `${startStr}-${endStr}-${filterPlaces.value}`;

        if (eventsDataCache[range_key]) {
            hideLoader();
            success(eventsDataCache[range_key]);
            return;
        }

        try {
            const { data } = await axios.get(
                `/agenda/get-events?start=${startStr}&end=${endStr}&filter_place=${filterPlaces.value}`
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
    
    filterPlaces.addEventListener("change", () => {
        calendar.refetchEvents();
    });

        // Delete reserve classroom CTA
        deleteEvent();
    
    calendarFullScreen(calendar);
};
