
import dayjs from 'dayjs';
import 'dayjs/locale/es';
dayjs.locale('es');

export const addHours = (hourStart, duration) => {
    return dayjs(`1970-01-01T${hourStart}`).add(duration, 'hour').format('HH:mm');
}

export const hourNow = () => {
    return dayjs().format('HH:mm');
}

