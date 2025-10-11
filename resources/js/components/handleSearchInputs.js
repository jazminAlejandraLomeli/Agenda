import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.default.css';
import { configTomSelect } from '../helpers/configTomSelect.js';
import { requestGetListTitleEvents } from '../helpers/requestGetListTitleEvents.js';
import { templateResponsibleTomSelect, templateTitleTomSelect } from '../template/events.js';
import { requestGetListResponsibles } from '../helpers/requestGetListResponsibles.js';
// import PerfectScrollbar from 'perfect-scrollbar';
// import 'perfect-scrollbar/css/perfect-scrollbar.css';


const groupId = document.querySelector("#group-id").value;
const newTitle = document.querySelector('#newTitle');

// const debounce = (fn, delay) => {
//     let timer;

//     return function (...args) {
//         clearTimeout(timer);
//         timer = setTimeout(() => {
//             fn.apply(this, args);
//         }, delay)
//     }
// }

// let loading = false;

export const handleSearchInputs = (maxItems = 10) => {


    const titleEvents = new TomSelect("#titleEvent",
        {
            ...configTomSelect,
            create: (query) => {
                return { value: query, text: query }
            },
            load: function (query, callback) {
                const self = this;

                requestGetListTitleEvents(query.trim(), groupId)
                    .then((data) => {
                        if (data.length === 0) {
                            callback([]);
                            return;
                        }

                        
                        callback(templateTitleTomSelect(data));
                        self.dropdown.querySelector('.ts-dropdown-content .create')?.classList.add('hidden-custom');

                    })
                    .catch((error) => {
                        callback([]);
                    })
            }
        }
    );
    const dependencyProgram = new TomSelect("#dependencyProgram", { ...configTomSelect });
    const place = new TomSelect("#place",
        {
            plugins: ['dropdown_input'],
            ...configTomSelect,
            maxItems: maxItems,
            persist: false,




        });
    const responsible = new TomSelect("#responsibles",
        {
            ...configTomSelect,
            create: (query) => {
                return { value: query, text: query }
            },
            load: function (query, callback) {
                const self = this;

        

                requestGetListResponsibles(query.trim(), groupId)
                    .then(data => {

                        
                        
                        if (data.length === 0) {
                            callback([]);
                            if (self.dropdown.querySelectorAll('.ts-dropdown-content .option').length > 0) {
                                self.dropdown.querySelector('.ts-dropdown-content .create')?.classList.add('hidden-custom');
                            }

                            return;
                        }
                        
                        callback(templateResponsibleTomSelect(data))

                        self.dropdown.querySelector('.ts-dropdown-content .create')?.classList.add('hidden-custom');

                    })
                    .catch((error) => {
                        callback([]);
                    })
            }

        });
    const typeEvent = new TomSelect("#eventType", { ...configTomSelect });


    return {
        typeEvent,
        dependencyProgram,
        place,
        responsible,
        titleEvents
    }
}