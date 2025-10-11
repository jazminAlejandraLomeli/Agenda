export const publishDomPlaces = (data, form) => {

    const hiddenPlaces = document.querySelectorAll('input[name="places[]"]');
    hiddenPlaces?.forEach(item => item.remove());

    data.forEach(place => {
        form.insertAdjacentHTML('beforeend', `<input type="hidden" name="places[]" value="${place}" />`)
    });


};