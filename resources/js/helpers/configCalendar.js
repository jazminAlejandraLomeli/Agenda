import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

let initialView = "timeGridWeek";

const widthScreen = screen.width;
if (widthScreen <= 768) {
    initialView = "timeGridDay";
}




export const configDefaultCalendar = {
    locale: 'es',
    headerToolbar: {
        left: 'prev,next,today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    buttonText: {
        today: 'Hoy',
        day: 'Día',
        month: 'Mes',
        week: 'Semana',
        list: 'Lista'
    },
    slotLabelFormat: {
        hour: '2-digit', // Hora en formato de 2 dígitos
        minute: '2-digit', // Minutos en formato de 2 dígitos
        hour12: true // Usa formato 24 horas; si es true, formato 12 horas con AM/PM
    },
    eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        meridiem: true // Ocultar AM/PM (opcional)
    },
    eventOverlap: true,
    slotMinTime: '08:00:00', // Hora mínima
    slotMaxTime: '20:00:00', // Hora máxima
    allDaySlot: false, // Ocultar el slot de todo el día
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
    initialView,
    expandRows: true, // Ocupa todo el espacio vertical disponible              
    height: 'auto',   
    firstDay: 1
    // contentHeight: 'auto',      // Opcional: Ajusta dinámicamente
}