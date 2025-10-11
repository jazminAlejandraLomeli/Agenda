@props(['event', 'dates'])

<div class="grid grid-cols-1 md:grid-cols-3 ">

    <div class="md:col-span-3 mb-3 " >
        <label class="text-lg font-bold dark:text-white">Fecha</label>
        <hr class="border-primary" />
    </div>

    <div class="col-span-1 md:col-span-3">
        
        <x-group-form>
            <x-slot name="label">Fecha del evento</x-slot>
            <x-input-primary type="text" placeholder="Selecciona una fecha" id="date-start" name="date_start"
                class="cursor-pointer" value="{{ $event->date->only_date_start }}"></x-input-primary>
        </x-group-form>        
    </div>

    <div class="col-span-3 grid grid-cols-2 gap-3">
        <x-group-form class="col-span-1">
            <x-slot name="label">Hora inicio (24/horas)</x-slot>
            <x-input-primary type="time" id="hour-start" name="hour_start"
                value="{{ $event->date->only_hour_start }}" />
        </x-group-form>

        <x-group-form class="col-span-1">
            <x-slot name="label">Hora fin (24/horas)</x-slot>
            <x-input-primary type="time" name="hour_end" id="hour-end" value="{{ $event->date->only_hour_end }}" />
        </x-group-form>

    </div>


    <div class="col-span-3">
        <hr class="border-gray-300 dark:border-gray-700 mb-4" />


        <x-tertiary-button type="button" id="showDates">
            Ver fechas establecidas
            <svg xmlns="http://www.w3.org/2000/svg" class="ms-3" width="25" height="25" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M4.616 19q-.691 0-1.153-.462T3 17.384V6.616q0-.691.463-1.153T4.615 5h14.77q.69 0 1.152.463T21 6.616v10.769q0 .69-.463 1.153T19.385 19zm7.884-1h3.25V6H12.5zm-4.25 0h3.25V6H8.25zm-3.634 0H7.25V6H4.616q-.27 0-.443.173T4 6.616v10.769q0 .269.173.442t.443.173m12.134 0h2.635q.269 0 .442-.173t.173-.442V6.615q0-.269-.173-.442T19.385 6H16.75z" />
            </svg>
        </x-tertiary-button>
        <hr class="border-gray-300 dark:border-gray-700 mt-4" />
    </div>

    <div class="border border-gray-200 rounded dark:border-gray-700 col-span-3 p-4 my-4">

        <div class="flex justify-between items-center">
            <div class="w-4 h-4 flex items-center ">
                <input type="hidden" name="repetition" value="0">
                <input id="repetition" type="checkbox" name="repetition" value="1"
                    class="text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="repetition"
                    class="w-full py-4 ms-3 font-medium text-gray-900 dark:text-gray-300">Repeticiones</label>

            </div>

            <button type="button"
                class="dark:text-gray-200 text-gray-500 rounded-full dark:bg-gray-700 bg-gray-200 p-2 hidden animate__animated animate__bounceIn"
                id="clear-repetition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M9 1h6v8.5h6V23H3V9.5h6zm2 2v8.5H5V14h14v-2.5h-6V3zm8 13H5v5h9v-3h2v3h3z" />
                </svg>
            </button>
        </div>


        <div class="mb-4 hidden mt-4 animate__animated animate__fadeInUp" id="container-advanced-options">

            <x-group-form>
                <x-slot name="label">Fecha de finalización</x-slot>
                <x-input-primary type="text" placeholder="Selecciona una fecha" id="date-end" name="date_end"
                    class="cursor-pointer"></x-input-primary>
            </x-group-form>



            <div class="flex space-x-4 mb-3">
                <x-slot name="label">Dias que desea repetir</x-slot>
                <x-check-rounded label="L" value="1" name="days[]"
                    class="checklist-days">Lunes</x-check-rounded>
                <x-check-rounded label="M" value="2" name="days[]"
                    class="checklist-days">Martes</x-check-rounded>
                <x-check-rounded label="X" value="3" name="days[]"
                    class="checklist-days">Miércoles</x-check-rounded>
                <x-check-rounded label="J" value="4" name="days[]"
                    class="checklist-days">Jueves</x-check-rounded>
                <x-check-rounded label="V" value="5" name="days[]"
                    class="checklist-days">Viernes</x-check-rounded>
                <x-check-rounded label="S" value="6" name="days[]"
                    class="checklist-days">Sábado</x-check-rounded>
                <x-check-rounded label="D" value="0" name="days[]"
                    class="checklist-days">Domingo</x-check-rounded>
            </div>
            <span class="text-red-500 pt-1 border-t-2 hidden" id="error-days"></span>
        </div>
    </div>

    <x-modal name="details-dates">
        <div class="p-4">
            <header class="flex justify-between items-center mb-4">
                <h2 class="font-semibold dark:text-white text-lg px-2">Fechas establecidas</h2>
                <x-generic-button x-on:click="$dispatch('close')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m7.05 5.636l4.95 4.95l4.95-4.95l1.414 1.414l-4.95 4.95l4.95 4.95l-1.415 1.414l-4.95-4.95l-4.949 4.95l-1.414-1.414l4.95-4.95l-4.95-4.95z" />
                    </svg>
                </x-generic-button>
            </header>

            <hr class="border-gray-300 mb-4 dark:border-gray-700" />



            <main>
                <ul>
                    @foreach ($dates as $date)
                        <li class="py-2 px-3 bg-neutral-100 dark:bg-gray-700 dark:text-white mb-2 rounded ">{{ $date->date_format }}</li>
                    @endforeach
                </ul>

            </main>

        </div>


    </x-modal>





</div>
