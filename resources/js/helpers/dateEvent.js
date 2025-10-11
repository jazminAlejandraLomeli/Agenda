import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js";
import "flatpickr/dist/flatpickr.min.css";

import { addHours, hourNow } from './addHours.js';

export const dateEvent = () => {
    const dateStartInput = document.getElementById('date-start');
    const hourStart = document.getElementById('hour-start');
    const hourEnd = document.getElementById('hour-end');

    const flatDateStart = flatpickr(dateStartInput, {
        locale: Spanish,
        altInput: true,
        altFormat: "l j F, Y",
        dateFormat: "Y-m-d",
    });

    const flatHourStart = flatpickr(hourStart, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    
        const flatHourEnd = flatpickr(hourEnd, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });


    // durationEvent.addEventListener('change', ({ target }) => {
    //     let duration = target.value;

    //     if (duration < 1) {
    //         target.value = 1;
    //     }

    //     if (duration >= 1 && duration <= 4) {
    //         if (hourStart.value == '') {
    //             hourStart.value = hourNow()
    //         };
    //         hourEnd.value = addHours(hourStart.value, duration);
    //     } else {

    //         hourStart.value = '';
    //         hourEnd.value = '';
    //     }
    // });
}