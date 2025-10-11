import { h } from "gridjs";
import { translate } from "../../helpers/translate-gridjs-es";
import { showLoader, hideLoader } from "../../helpers/loader";

export const grid_event = (clicEdit, usertype) => {
    //let colum_hidden = usertype;   // Ocultar o mostrar la columa tipo
    try {
        return {
            columns: [
                {
                    id: "ID",
                    name: "ID",
                    hidden: true,
                },
                {
                    id: "id_type",
                    name: "id_type",
                    hidden: true,
                },
                {
                    id: "Tipo",
                    name: "Tipo",
                    hidden: usertype,
                },

                "Nombre",

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
                                            row.cells[3].data
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
                url: "/agenda/event-types/getEventTypes?",
                then: (data) => {
                    // Mapear los datos según tu lógica
                    return data.data.map((results) => [
                        results.id,
                        results.group_id,
                        results.group.type,
                        results.name,
                    ]);
                },
                total : (data) => data.total,

                catchError: (error) => {
                    console.log(error);
                },
            },
            className: {
                search: "flex justify-center",
            },
            language: translate,
        };
    } catch (error) {
        console.error(error);
    } finally {
        hideLoader();
    }
};
