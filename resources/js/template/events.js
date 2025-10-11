export const  templateResponsibles = (data)=>{

    let template = `<option value="">Seleccione una opción</option>`;
    
     template += data.map(responsible => {
        return `<option value="${responsible.id }">${ responsible.name }</option>`

    }).join('');

    return template

} 

export const templateTitleEvents = (data) => {
    let template = `<option value="">Seleccione una opción</option>`;

    template += data.map(title => {
        return `<option value="${title.id}">${title.title_event}</option>`;
    }).join('');

    return template;
}

export const templateTitleTomSelect = (data) => {
    return data.map(title => {
        return { value: title.id, text: title.title }
    });

}


export const templateResponsibleTomSelect = (data)=>{
    return data.map(responsible => {
        return { value : responsible.id, text : responsible.name}
    })
}