<x-app-layout>

    <x-slot name="header">

        <div class="flex dark:text-white items-center gap-3">
            {{-- <h2 class="text-2xl font-bold">Agenda</h2> --}}
            <x-tertiary-link-button href="{{ route('agenda.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m9.55 12l7.35 7.35q.375.375.363.875t-.388.875t-.875.375t-.875-.375l-7.7-7.675q-.3-.3-.45-.675t-.15-.75t.15-.75t.45-.675l7.7-7.7q.375-.375.888-.363t.887.388t.375.875t-.375.875z" />
                </svg>
            </x-tertiary-link-button>
            <h2 class="ml-2 text-2xl font-bold">Estadística de eventos </h2>
        </div>
    </x-slot>

    <x-slot name="styles">

        @vite('resources/css/tomSelect.css')

    </x-slot>


    <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg dark:text-white max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 mt-5">

        @include('statistics.events.cards')




        {{-- Contenedor para la grafica  --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-4">

            <div class="col-span-2 rounded-md shadow-md p-4 ">


                <h5 class="flex items-center gap-2 text-gray-600 dark:text-white font-normal text-xl mt-4">

                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                        <path fill="#65a30d"
                            d="M10.5 16.3q-.2 0-.35-.137T10 15.8V8.2q0-.225.15-.362t.35-.138q.05 0 .35.15l3.625 3.625q.125.125.175.25t.05.275t-.05.275t-.175.25L10.85 16.15q-.075.075-.162.113t-.188.037" />
                    </svg>

                    Número de eventos realizados por lugar

                    <b class="text-dateg hidden sm:block"> {{ date('Y') }} </b>

                </h5>
                
                @include('statistics.events.filtros')
                {{-- Grafica de lugares --}}
                <canvas id="placesChart" width="200" height="100"></canvas>
            </div>
        </div>



    </div>


    @vite(['resources/js/statistics/events.js'])

</x-app-layout>
