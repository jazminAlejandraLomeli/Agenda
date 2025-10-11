<h5 class="flex items-center gap-2 text-gray-600 dark:text-white font-normal text-xl mb-3">

    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#65a30d" d="M10.5 16.3q-.2 0-.35-.137T10 15.8V8.2q0-.225.15-.362t.35-.138q.05 0 .35.15l3.625 3.625q.125.125.175.25t.05.275t-.05.275t-.175.25L10.85 16.15q-.075.075-.162.113t-.188.037"/></svg>

     Número de eventos por programa académico

     <b class="date_semester hidden sm:block"> </b>

</h5>




<div id="accordion" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
    data-inactive-classes="text-gray-500 dark:text-gray-400" class="mb-3">

    <h2 id="accordion-2">
        <button type="button"
            class="flex items-center justify-between w-full py-3 px-5 shadow-sm font-medium rtl:text-right text-gray-500  border-b border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800  dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
            data-accordion-target="#accordion-body-2" aria-expanded="false" aria-controls="accordion-body-2">
            <span class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="none" stroke="#cc5500" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5" d="M4.5 7h15M7 12h10m-7 5h4" />
                </svg>
                Buscar un programa académico
            </span>

            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5 5 1 1 5" />
            </svg>
        </button>

    </h2>

    <div id="accordion-body-2" class="hidden" aria-labelledby="accordion-2">



        <div class="p-3 border-b border-gray-200 dark:border-gray-700 dark:bg-gray-900 shadow-sm">

            <div class="flex justify-between">
                <div>
                    <p class="mt-2 mb-2 text-gray-500 dark:text-gray-400">Selecciona los filtros que consideres
                        necesarios y clic en <b>Filtrar</b>.
                    </p>
                </div>

                <div>

                    <button data-tooltip-target="tooltip-bottom" data-tooltip-placement="bottom" type="button"
                        class="ms-3 mb-2  transition duration-300 hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="21" fill="#2196F3" />
                            <path fill="#fff" d="M22 22h4v11h-4z" />
                            <circle cx="24" cy="16.5" r="2.5" fill="#fff" />
                        </svg>

                    </button>

                    <div id="tooltip-bottom" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                        Es posible filtrar únicamente por fechas, únicamente por programa académico o utilizar ambos criterios.
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-2">


                <div class=" p-0 sm:p-2">
                    <x-group-form>
                    <x-slot name="label">Programa académico</x-slot>
                    <x-select-primary name="program" id="program">
                        <option value="">Seleccione una opción</option>
                        @if (!$programs->isEmpty())
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        @endif

                    </x-select-primary>
                </x-group-form>


                </div>

                {{-- Contenedor donde se especifica el rango de fechas --}}
                <div class=" p-0 sm:p-2 ">
                    <label for="date-start" class="text-gray-600 dark:text-gray-100 text-md font-semibold">Selecciona un
                        rango de
                        fechas</label>

                    <div id="date-range" date-rangepicker class="flex items-center justify-between ">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="date-start-semester" name="start" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Inicio">
                        </div>
                        <span class="mx-4 text-gray-500">a</span>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="date-end-semester" name="end" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Final">
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex justify-center pt-3 sm:pt-0">
                <x-secondary-button type="button" id="filter_semesters">
                    Aplicar filtro
                    <svg class="ps-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 4h16v2.172a2 2 0 0 1-.586 1.414L15 12v7l-6 2v-8.5L4.52 7.572A2 2 0 0 1 4 6.227z" />
                    </svg>
                </x-secondary-button>
            </div>
        </div>

    </div>
</div>
