const filterPlaces = document.getElementById("filterPlace");
export const manageClassroomsFilter = (calendar) => {
    if (filterPlaces) {
        filterPlaces.addEventListener("change", () => {
            calendar.refetchEvents();
        });
    }
};
