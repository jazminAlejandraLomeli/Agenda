const colorEventCTA = document.getElementById("color-event-cta");
const titleEventCTA = document.getElementById("title-event-cta");
const dateEventCTA = document.getElementById("date-event-cta");
const placeEventCTA = document.getElementById("place-event-cta");
const responsibleEventCTA = document.getElementById("responsible-event-cta");
const emailEventCTA = document.getElementById("email-event-cta");
const eventTypeEventCTA = document.getElementById("type-event-cta");
const academyProgramEventCTA = document.getElementById("academic-program");
const participants = document.getElementById("participants");
const grade = document.getElementById("grade");
const btnEditEventCTA = document.getElementById("btn-edit-cta");
const btnEditEventCTAAll = document.getElementById('btn-edit-all-cta')
const deleteForm = document.getElementById("deleteFormCTA");
const deleteAllForm = document.getElementById("deleteAllFormCTA");


// Insert data event CTA
export const showDetailsCalendarCTA = (data)=>{

    const {
        id,
        title,
        place,
        cta,
        dependency_program,
        event_type,
        responsible,
        date,
        recursiveEvents
    } = data;

    const { color, name: name_place, text_color } = place;
    const { date_start_format, hour_start_format, hour_end_format } = date;
    const { name: name_responsible } = responsible;
    const { email, num_participants, semester } = cta;

    colorEventCTA.style.backgroundColor = `${color}`;
    colorEventCTA.style.borderColor = color;
    titleEventCTA.style.color = text_color;
    titleEventCTA.textContent = title;
    dateEventCTA.textContent = `${date_start_format} - ${hour_start_format} a ${hour_end_format}`;
    placeEventCTA.textContent = name_place;
    responsibleEventCTA.textContent = name_responsible;
    emailEventCTA.textContent = email;
    eventTypeEventCTA.textContent = event_type.name;
    academyProgramEventCTA.textContent = dependency_program.name;
    participants.textContent = num_participants;
    grade.textContent = semester.name;

    if(recursiveEvents == 1 && btnEditEventCTAAll){
        btnEditEventCTAAll.href = `/agenda/edit/cta/all/${id}`;
        btnEditEventCTAAll.classList.remove('hidden');
    }else{
        if(btnEditEventCTAAll){
            btnEditEventCTAAll.classList.add('hidden');
        }
    }

    if(btnEditEventCTA){
        btnEditEventCTA.href = `/agenda/edit/cta/${id}`;
    }

    if(deleteForm){
        deleteForm.action = `/agenda/delete/${id}`;
    }

    if(recursiveEvents == 1 && deleteAllForm){
        deleteAllForm.action = `/agenda/delete/all/${id}`;
        deleteAllForm.classList.remove('hidden');
        deleteAllForm.querySelector('button').disabled = false;
    }else{
        if(deleteAllForm){
            deleteAllForm.classList.add('hidden');
            deleteAllForm.querySelector('button').disabled = true;
        }
    }
    
}