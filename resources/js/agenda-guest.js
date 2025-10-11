import { Calendar } from "@fullcalendar/core";
import { configDefaultCalendar } from "./helpers/configCalendar.js";

import { showLoader, hideLoader } from "./helpers/loader.js";
import { calendarFullScreen } from "./helpers/calendarFullScreen.js";
import { showDetailsCalendarCTA } from "./helpers/showDetailsCalendarCTA.js";
import { formatDataCalendar } from "./helpers/formatDataCalendar.js";
import ChangeColorCalendar from "./helpers/changeColorCalendar.js";
import { manageClassroomsFilter } from "./manage-classrooms.js";
import { showDetailsCalendarProtocolo } from "./helpers/showDetailsCalendarProtocolo.js";

let eventsDataCache = [];
let colorCalendar = "";
let filterPlacesValue = "";
let urlRequest = '';

showLoader("Cargando la vista");

window.onload = () => {
    const calendarEl = document.getElementById("calendar");

    const changeColor = new ChangeColorCalendar();
    colorCalendar = changeColor.colorCalendar;

    // Type event
    const typeEvent = document.querySelector("#type-event-guest");

    // Filter
    const filterPlaces = document.getElementById("filterPlace");

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

            if (data.group?.type === "CTA") {
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
        showLoader("Cargando los eventos");

        const range_key = typeEvent.value == 1 ? `${startStr}-${endStr}` : `${startStr}-${endStr}-${filterPlaces?.value}`;

        if (eventsDataCache[range_key]) {
            hideLoader();
            success(eventsDataCache[range_key]);
            return;
        }

        try {

            if (typeEvent.value == 1) {
                urlRequest = `/agenda/guest/get-events?start_date=${startStr}&end_date=${endStr}&type_event=${typeEvent.value}`;
            } else {
                urlRequest = `/agenda/guest/get-events?start_date=${startStr}&end_date=${endStr}&type_event=${typeEvent.value}&filter_place=${filterPlaces?.value}`;
            }

            const { data } = await axios.get(urlRequest);
            

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

    // if (filterPlaces) {
    //     filterPlaces.addEventListener('change', () => {
    
    //         calendar.refetchEvents();
    //     })
    // }
    // If type event is the classrooms load the file manage classroom filter
    if (typeEvent.value == 2) {
        
        manageClassroomsFilter(calendar);
    }



};
