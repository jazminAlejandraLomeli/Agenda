import dayjs from "dayjs"

const now = dayjs();
const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

export const  formatDataCalendar = (data, colorCalendar)=>{



    const dataFormat = data.map((event) => {

        const dateStart = dayjs(event.date.date_start)
        const dateEnd = dayjs(event.date.date_end);
        let bgColor = '';
        let borderColor = '';
        let textColor = '';

        if(now.isAfter(dateStart) && now.isAfter(dateEnd)){
                bgColor = '22';
                borderColor = '22'
                textColor = '50';
        }

        const bg = bgColor !== '' ? `${event.place.color}${bgColor}`  : `${event.place.color}${colorCalendar}`;
        const border = `${event.place.color}${borderColor}`;
        let text = (colorCalendar === '' ? `${event.place.text_color}${textColor}` : `${event.place.color}${textColor}`) ;

        if(isDarkMode){
            if(textColor == '50'){
                text = (colorCalendar === '' ? `${event.place.text_color}${'90'}` : `${event.place.color}${textColor}`)
            }else{
                text = (colorCalendar === '' ? `${event.place.text_color}` : `${event.place.color}`)
            }
        }else{
            if(textColor == '50'){
                text = (colorCalendar === '' ? `${event.place.color}${'70'} ` : `${event.place.color}${'40'}`)                
            }else{
                text = (colorCalendar === '' ? `${event.place.text_color} ` : `${event.place.color}`)                
            }
        }

        return {
            id: event.id,
            title: event.title,
            start: event.date.date_start,
            end: event.date.date_end,
            backgroundColor: bg,
            borderColor: border,
            textColor: text,
        };
    });

    return dataFormat;


}