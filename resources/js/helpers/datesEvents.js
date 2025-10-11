import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js";
import "flatpickr/dist/flatpickr.min.css";

import { addHours, hourNow } from './addHours.js';



export const manageDatesEvents = () => {
    const dateStartInput = document.getElementById('date-start');
    const dateEndInput = document.getElementById('date-end');

    const checkBoxRepetition = document.getElementById('repetition');
    const containerAdvancedOptions = document.getElementById('container-advanced-options');
    const checkListDays = document.querySelectorAll('.checklist-days');

    // const durationEvent = document.getElementById('duration');
    const hourStart = document.getElementById('hour-start');
    const hourEnd = document.getElementById('hour-end');



    const btnClearOptions = document.getElementById('clear-repetition');


    // Confiig flatpickr
    // Date start
    const flatDateStart = flatpickr(dateStartInput, {
        locale: Spanish,
        altInput: true,
        altFormat: "l j F, Y",
        dateFormat: "Y-m-d",
    });

    // Date end
    const flatDateEnd = flatpickr(dateEndInput, {
        locale: Spanish,
        altInput: true,
        altFormat: "l j F, Y",
        dateFormat: "Y-m-d",
    });

    const flatHourStart = flatpickr(hourStart, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minTime : '8:00',
        maxTime : '20:00'
    });

    const flatHourEnd = flatpickr(hourEnd, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minTime : '8:00',
        maxTime : '20:00'
    });




    const clearCheckboxListDates = () => {
        checkListDays.forEach(checkListDay => {
            checkListDay.checked = false;
        });

        flatDateEnd.clear();

    }

    // durationEvent.addEventListener('change', ({ target }) => {
    //     let duration = target.value;

    //     if (duration < 1) {
    //         target.value = 1;
    //     }

    //     if (duration >= 1 && duration <= 4) {
    //         if (hourStart.value == '') {
    //             hourStart.value = hourNow();
    //         }

    //         hourEnd.value = addHours(hourStart.value, duration);
    //     } else {

    //         hourStart.value = '';
    //         hourEnd.value = '';
    //     }
    // });



    btnClearOptions.addEventListener('click', clearCheckboxListDates);

    const manageCheckboxRepetition = ({ target }) => {
        if (target.checked) {
            containerAdvancedOptions.classList.remove('hidden');
            btnClearOptions.classList.remove('hidden');
        } else {
            containerAdvancedOptions.classList.add('hidden');
            btnClearOptions.classList.add('hidden');

            clearCheckboxListDates();

        }
    }

    checkBoxRepetition.addEventListener('change', manageCheckboxRepetition);







}