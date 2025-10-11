export const configTomSelect = {
    plugins: ['dropdown_input'],
    sortField: {
        field: "text",
        direction: "asc"
    },
    create: false,
    hideSelected: true,
    maxItems: 1,
    shouldLoad: (query) => {
        if (query === '') return false;
        if (query.length < 3) return false
        return true;

    },

    onDropdownOpen: function (dropdown) {

        // Agrega clases de animación al abrir
        dropdown.classList.add('dropdown-enter');
        setTimeout(() => {
            dropdown.classList.add('dropdown-enter-active');
        }, 10); // Permite que se inicie la animación
    },
    onDropdownClose: function (dropdown) {

        // Agrega clases de animación al cerrar
        dropdown.classList.remove('dropdown-enter-active');
        dropdown.classList.add('dropdown-leave');
        setTimeout(() => {
            dropdown.classList.add('dropdown-leave-active');
            setTimeout(() => {
                dropdown.classList.remove('dropdown-leave', 'dropdown-leave-active');
            }, 300); // Duración de la animación
        }, 10);
    },
    render: {
        no_results: function (data, escape) {
            return '<div class="no-results">No se encontraron resultados para "' + escape(data.input) + '"</div>';
        },

        option_create: function (data, escape) {
            return '<div class="create">Agregar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
        }


    }
    // maxOptions : 10,
}