<x-modal name="deny-reservation" maxWidth="lg" :show="false">
    <h2 class="text-lg font-bold  text-center">
        <div class="dark:bg-primary bg-primary px-4 py-3 text-white title-modal">
            No publicar reservación
        </div>
    </h2>
    <div class="px-4 mt-3">

        <div class="text-center">
            <h5 class="ml-3 dark:text-slate-400 text-slate-600 text-md font-semibold">
                Nombre de la reservación
            </h5>
            <h5 class="ml-3 dark:text-slate-300 text-slate-800 text-2xl font-semibold event_title">
                Evento evento
            </h5>
        </div>
        
        <p class="mt-3 text-sm/6 dark:text-gray-400 text-gray-600">Escribe el motivo por el cual <strong> no </strong> se publicará a
            reservación y haz clic en <strong>Confirmar</strong>. </p>

        {{-- Alerta personalizada --}}
        <x-alert-manage id="cont-alert-add" type="warning" title="Error" message="Este es un mensaje de error.">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="m21.171 15.398l-5.912-9.854C14.483 4.251 13.296 3.511 12 3.511s-2.483.74-3.259 2.031l-5.912 9.856c-.786 1.309-.872 2.705-.235 3.83C3.23 20.354 4.472 21 6 21h12c1.528 0 2.77-.646 3.406-1.771s.551-2.521-.235-3.831M12 17.549c-.854 0-1.55-.695-1.55-1.549c0-.855.695-1.551 1.55-1.551s1.55.696 1.55 1.551c0 .854-.696 1.549-1.55 1.549m1.633-7.424c-.011.031-1.401 3.468-1.401 3.468c-.038.094-.13.156-.231.156s-.193-.062-.231-.156l-1.391-3.438a1.8 1.8 0 0 1-.129-.655c0-.965.785-1.75 1.75-1.75a1.752 1.752 0 0 1 1.633 2.375" />
            </svg>
        </x-alert-manage>

        <div class="bg-white dark:bg-gray-800 mx-auto mt-5 mb-5">
            <input class="hidden" type="hidden" id="No_reservation" value="">

       

             <x-group-form>
                    <x-slot name="label">Describe el motivo</x-slot>
                    <x-text-primary name="reason" id="reason"></x-text-primary>
                </x-group-form>

            <div class="col-span-2 flex justify-end items-start gap-5">

                <x-tertiary-button id="btn-cancel">
                    Cancelar
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m12 13.4l2.9 2.9q.275.275.7.275t.7-.275t.275-.7t-.275-.7L13.4 12l2.9-2.9q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275L12 10.6L9.1 7.7q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7l2.9 2.9l-2.9 2.9q-.275.275-.275.7t.275.7t.7.275t.7-.275zm0 8.6q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                    </svg>
                </x-tertiary-button>

                <x-secondary-button id="btn-save">
                    Confirmar
                   <svg class="ms-3" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                </x-secondary-button>

            </div>

            {{-- </div> --}}
        </div>

    </div>
</x-modal>
