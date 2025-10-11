import { className, h } from "gridjs";
import { translate } from "../../helpers/translate-gridjs-es";
import { showLoader, hideLoader } from "../../helpers/loader";

export const grid_event = (clicEdit, usertype) => {
    let colum_hidden = usertype; //
    try {
        return {
            columns: [
                {
                    id: "ID",
                    name: "ID",
                    hidden: true,
                },
                {
                    id: "id_group",
                    name: "id_group",
                    hidden: true,
                },
                {
                    id: "Tipo",
                    name: "Tipo",
                    hidden: colum_hidden,
                },
                "Nombre",
                {
                    id: "color",
                    name: "Color",
                    formatter: (cell, row) => {
                        const textColor = row.cells[5].data; // Obtén el valor de text_color de la celda correspondiente

                        return h(
                            "div",
                            {
                                class: "shadow-md w-15 h-8 rounded border border-gray-100 flex justify-center items-center",
                                style: `background-color: ${cell};`,
                                title: cell,
                            },
                            h(
                                "span",
                                {
                                    class: "hidden sm:inline text-xs text-white font-semibold ", // Clase para estilizar el texto
                                    style: `color: ${textColor};`, // Margen opcional entre el texto y el borde style: `color: ${cell}
                                },
                                " Color del texto"
                            ) // Aquí pasamos la variable `cell` como contenido del span
                        );
                    },
                },

                {
                    id: "Acciones",
                    name: "Acciones",
                    formatter: (_, row) => {
                        return h(
                            "div",
                            {
                                className: "flex justify-center",
                            },
                            h(
                                "button",
                                {
                                    className:
                                        "mx-2 dark:text-blue-500 text-blue-500",
                                    onClick: () =>
                                        clicEdit(
                                            row.cells[0].data,
                                            row.cells[1].data,
                                            row.cells[3].data,
                                            row.cells[4].data,
                                            row.cells[5].data
                                        ),
                                },
                                h(
                                    "svg",
                                    {
                                        xmlns: "http://www.w3.org/2000/svg",
                                        width: "25",
                                        height: "25",
                                        viewBox: "0 0 32 32",
                                    },
                                    [
                                        h("path", {
                                            fill: "currentColor",
                                            d: "M2 26h28v2H2zM25.4 9c.8-.8.8-2 0-2.8l-3.6-3.6c-.8-.8-2-.8-2.8 0l-15 15V24h6.4zm-5-5L24 7.6l-3 3L17.4 7zM6 22v-3.6l10-10l3.6 3.6l-10 10z",
                                        }),
                                    ]
                                )
                            )
                        );
                    },
                    sort: false,
                },
            ],
            pagination: {
                limit: 10,
                server: {
                    url: (prev, page, limit) =>
                        `${prev}&limit=${limit}&offset=${page * limit}`,
                },
            },
            search: {
                enabled: true,
                placeholder: "Buscar...",
                debounceTimeout: 1000,
                server: {
                    url: (prev, keyword) => `${prev}&search=${keyword}`,
                },
            },
            server: {
                url: "/agenda/places/getPlaces?",
                then: (data) => {
                    // Mapear los datos según tu lógica
                    return data.data.map((results) => [
                        results.id,
                        results.group_id,
                        results.group.type,
                        results.name,
                        results.color,
                        results.text_color,
                    ]);
                },
                total: (data) => data.total,
            },
            
            language: translate,
        };
    } catch (error) {
        console.error(error);
    } finally {
        hideLoader();
    }
};
