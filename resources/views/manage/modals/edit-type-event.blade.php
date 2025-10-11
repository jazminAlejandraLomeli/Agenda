<x-modal name="edit-type-event" maxWidth="lg" :show="false">
    <h2 class="text-lg font-bold  text-center">
        <div class="dark:bg-primary bg-primary px-4 py-3 text-white title-modal">
            Nombre del tipo de evento
        </div>
    </h2>
    <div class="px-4 mt-3">
        <p class="mt-1 text-sm/6 text-gray-600 mb-2">Corrige los datos erróneos, después haz clic en<strong>
                Guardar</strong>.

            {{-- Alerta personalizada --}}
            <x-alert-manage id="cont-alert" type="warning" title="Error" message="Este es un mensaje de error.">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m21.171 15.398l-5.912-9.854C14.483 4.251 13.296 3.511 12 3.511s-2.483.74-3.259 2.031l-5.912 9.856c-.786 1.309-.872 2.705-.235 3.83C3.23 20.354 4.472 21 6 21h12c1.528 0 2.77-.646 3.406-1.771s.551-2.521-.235-3.831M12 17.549c-.854 0-1.55-.695-1.55-1.549c0-.855.695-1.551 1.55-1.551s1.55.696 1.55 1.551c0 .854-.696 1.549-1.55 1.549m1.633-7.424c-.011.031-1.401 3.468-1.401 3.468c-.038.094-.13.156-.231.156s-.193-.062-.231-.156l-1.391-3.438a1.8 1.8 0 0 1-.129-.655c0-.965.785-1.75 1.75-1.75a1.752 1.752 0 0 1 1.633 2.375" />
                </svg>
            </x-alert-manage>

        <div class="bg-white dark:bg-gray-800 mx-auto mt-5 mb-5">
            {{-- <div class="grid grid-cols-1 md:grid-cols-2"> --}}


            @if ($Groups && !$Groups->isEmpty())
                <x-group-form>
                    <x-slot name="label">Grupo de usuarios</x-slot>
                    <x-select-primary id="Group">
                        @foreach ($Groups as $Group)
                            <option value="{{ $Group->id }}">{{ $Group->type }}</option>
                        @endforeach
                    </x-select-primary>
                </x-group-form>
            @else
                <input class="hidden" type="hidden" id="Group" value="">
            @endif

            <x-group-form>
                <x-slot name="label">Nombre del evento</x-slot>
                <x-input-primary name="responsible" id="event-name"></x-input-primary>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2 text-primary"
                    viewBox="0 0 24 24">
                    <path fill="#CD5700"
                        d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h5v-2H5V8h14v1h2V5a2 2 0 0 0-2-2m2.7 10.35l-1 1l-2.05-2l1-1c.2-.21.54-.22.77 0l1.28 1.28c.19.2.19.52 0 .72M12 18.94l6.07-6.06l2.05 2L14.06 21H12z" />
                </svg> </x-group-form>

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
                    Guardar
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3"
                        viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path
                                d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor"
                                d="M18 14a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 1 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1M16 3a1 1 0 0 1 1 1v1h2a2 2 0 0 1 2 2v4a1 1 0 0 1-1 1H5v7h6a1 1 0 1 1 0 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2V4a1 1 0 0 1 2 0v1h6V4a1 1 0 0 1 1-1m3 4H5v3h14z" />
                        </g>
                    </svg>
                </x-secondary-button>

            </div>

            {{-- </div> --}}
        </div>

    </div>
</x-modal>
