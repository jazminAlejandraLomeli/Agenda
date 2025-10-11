import { h } from "gridjs";
import { translate } from '../helpers/translate-gridjs-es.js';

export const gridUser = (resetPassword, deleteUser) => {
    return {
        columns: [{
            id: "id",
            name: "ID",
            hidden: true
        }, "Nombre", "Nombre de usuario",
            {
                id: "status",
                name: "Estatus",
                formatter: (cell) => {

                    let status = null;

                    if (cell === 1) {
                        status = h('span', {
                            class: 'bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900/10 dark:text-green-500'
                        }, 'Activo');
                    } else {
                        status = h('span', {
                            class: 'bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900/10 dark:text-red-500'
                        }, 'Inactivo');
                    }
                    return status;
                }
            },
            {
                id: "role",
                name: "Rol",
                formatter: (cell) => cell.toUpperCase()
            },
            , {
                id: "group",
                name: "Grupo",
                formatter: (cell) => cell.toUpperCase()
            },
            {
                id: 'actions',
                name: "Acciones",
                formatter: (_, row) => {
                    const actions = h('div', {
                        className: 'flex justify-center'
                    }, [
                        h('button', {
                            className: 'mx-2 dark:text-sky-500 text-sky-500',
                            onclick: () => resetPassword(row.cells[0].data)
                        },
                            h('svg', {
                                xmlns: "http://www.w3.org/2000/svg",
                                width: "35",
                                height: "35",
                                viewBox: "0 0 24 24",
                                fill: "none",
                                stroke: "currentColor",
                                'stroke-width': "1.5"
                            }, [
                                h('path', {
                                    'stroke-linecap': "round",
                                    'stroke-linejoin': "round",
                                    d: "M21 13V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h7"
                                }),
                                h('path', {
                                    d: "M20.879 16.917c.494.304.463 1.043-.045 1.101l-2.567.291l-1.151 2.312c-.228.459-.933.234-1.05-.334l-1.255-6.116c-.099-.48.333-.782.75-.525z",
                                    'clip-rule': "evenodd"
                                }),
                                h('path', {
                                    'stroke-linecap': "round",
                                    'stroke-linejoin': "round",
                                    d: "m12 11.01l.01-.011m3.99.011l.01-.011M8 11.01l.01-.011"
                                })
                            ])
                        ),
                        h('a', {
                            className: 'mx-2 dark:text-blue-500 text-blue-500',
                            href: `/users/edit/${row.cells[0].data}`
                        },
                            h('svg', {
                                xmlns: "http://www.w3.org/2000/svg",
                                width: "25",
                                height: "25",
                                viewBox: "0 0 32 32"
                            }, [
                                h('path', {
                                    fill: "currentColor",
                                    d: "M2 26h28v2H2zM25.4 9c.8-.8.8-2 0-2.8l-3.6-3.6c-.8-.8-2-.8-2.8 0l-15 15V24h6.4zm-5-5L24 7.6l-3 3L17.4 7zM6 22v-3.6l10-10l3.6 3.6l-10 10z"
                                })
                            ])
                        ),
                        h('button', {
                            className: 'mx-2 dark:text-red-500 text-red-500',
                            onclick: () => deleteUser(row.cells[0].data)
                        },
                            h('svg', {
                                xmlns: "http://www.w3.org/2000/svg",
                                width: "30",
                                height: "30",
                                viewBox: "0 0 24 24"
                            }, [
                                h('path', {
                                    fill: "none",
                                    stroke: "currentColor",
                                    'stroke-linecap': "round",
                                    'stroke-linejoin': "round",
                                    'stroke-width': "1.5",
                                    d: "M4.687 6.213L6.8 18.976a2.5 2.5 0 0 0 2.466 2.092h3.348m6.698-14.855L17.2 18.976a2.5 2.5 0 0 1-2.466 2.092h-3.348m-1.364-9.952v5.049m3.956-5.049v5.049M2.75 6.213h18.5m-6.473 0v-1.78a1.5 1.5 0 0 0-1.5-1.5h-2.554a1.5 1.5 0 0 0-1.5 1.5v1.78z"
                                })
                            ])
                        ),


                    ]);

                    return actions;
                }
            }],
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
            url: '/users/getUsers?',
            then: ({ data }) => data.map(user => [user.id, user.name, user.user_name, user.status, user.roles[0]?.name ?? 'No tiene rol', user.group.type, null]),
            total: ({ total }) => total
        },
        className: {
            search: 'flex justify-center'
        },
        language: translate
    }
}