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
            <h2 class="ml-2 text-2xl font-bold">Estadística de las reservaciones de laboratorios </h2>
        </div>
    </x-slot>

    <x-slot name="styles">

        @vite('resources/css/tomSelect.css')

    </x-slot>


    <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg dark:text-white max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 mt-5">

        @include('statistics.laboratory.cards')

        <div class="grid grid-cols-1 gap-4 px-3 mt-5">

            <div class="col-span-1 rounded-md shadow-md p-2 ">

                {{-- Filtro de rango de fechas  --}}
                @include('statistics.laboratory.places-chart')
                {{-- Grafica de chart js --}}
                <canvas id="places" width="100" height="50" class="max-h-[500px]"></canvas>
            </div>

        </div>


        <div class="col-span-1 rounded-sm shadow-sm p-2 mt-6">

            @include('statistics.laboratory.cards-semesters-filter')

            <div class="flex justify-between mb-4">
                <p class="font-semibold text-lg text-gray-700"> Programa acádemico / carrera: <span
                        class="text-gray-800 promgram"> 
                    </span></p>

                <p class="font-semibold text-lg text-gray-700 "> Totales: <span class="count"> 0</span></p>

            </div>


            <div id="grid-container" class="grid grid-cols-12 gap-4 mb-4">
            </div>





        </div>






    </div>


    @vite(['resources/js/statistics/laboratory.js'])

</x-app-layout>
