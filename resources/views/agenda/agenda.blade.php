<x-app-layout>

    <x-slot name="styles">
        @vite('resources/css/calendar.css')
    </x-slot>


    {{-- Show roles user authenticated --}}


    <div class="py-4 lg:px-6">

        @if (session('error'))
            <x-alert class="alerts" type="danger">
                <x-slot name="title">¡Ups!</x-slot>
                {{ session('error') }}
            </x-alert>
        @endif

        @if (session('success'))
            <x-alert class="alerts" type="success">
                <x-slot name="title">Éxito ...</x-slot>
                {{ session('success') }}
            </x-alert>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg dark:text-white">

            <div class="p-6 dark:border-gray-700">
                <div
                    class="flex flex-col md:gap-0 md:flex-row {{ (auth()->check() && auth()->user()->hasRole('superadmin')) || (auth()->check() && (Auth::user()->group->type == 'CTA' || Auth::user()->group->type == 'Superadmin') && $events > 0) ? 'md:justify-between' : 'md:justify-end' }} items-end md:items-center">
                    <div class="flex flex-col-reverse md:flex-row md:gap-4 items-end w-full md:w-auto md:items-center">
                        @role('superadmin')
                            <div class="w-full md:w-auto"> 
                                <x-group-form class="w-full md:w-60" class="mb-0">
                                    <x-slot name="label">Filtros</x-slot>
                                    <x-select-primary id="filterEvents">
                                        @foreach ($groups as $group)
                                            @if ($group->type == 'Protocolo')
                                                <option value="{{ $group->id }}" selected>Eventos {{ $group->type }}
                                                </option>
                                            @else
                                                <option value="{{ $group->id }}">Aulas {{ $group->type }}</option>
                                            @endif
                                        @endforeach
                                    </x-select-primary>
                                </x-group-form>
                            </div>
                        @endrole

                        @if (auth()->check() && (Auth::user()->group->type == 'CTA' || Auth::user()->group->type == 'Superadmin') && $events > 0)
                            <div class="mt-2 md:mt-0">
                                <div class="relative group inline-block">
                                    <abbr class="cursor-help">
                                        <a href="{{ route('agenda.confirm-classroom.index') }}">
                                            <span
                                                class="bg-red-100 text-red-800 text-sm font-medium px-2 py-1 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                Pendientes: <strong class="text-base "> {{ $events }} </strong>
                                            </span></a>
                                    </abbr>
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block px-4 py-1 bg-gray-600 text-white text-sm rounded shadow-lg z-50 w-40 text-center">
                                        Ver reservaciones pendientes
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>



                    <div class="flex space-x-4 items-end flex-col md:flex-row w-full md:w-auto gap-3 md:gap-0">
                        @if (
                            (!auth()->check() && (isset($guest) && $guest && $group && $group->type == 'CTA')) ||
                                (auth()->check() && auth()->user()->group->type != 'Protocolo'))
                            <div class="w-full md:w-auto">
                                <x-group-form
                                    class="w-full md:w-60 {{ auth()->check() && auth()->user()->hasRole('superadmin') ? 'hidden' : '' }} !mb-0"
                                    id="content-places">
                                    <x-slot name="label">Aulas</x-slot>
                                    <x-select-primary id="filterPlace">
                                        <option value="all">Todos</option>
                                        @if (isset($places))
                                            @foreach ($places as $place)
                                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                                            @endforeach
                                        @endif
                                    </x-select-primary>
                                </x-group-form>

                            </div>
                        @endif
                        <div>
                            <div class="flex space-x-4">
                                <div class="relative group inline-block"> {{-- Contendor para el abbr  --}}
                                    <abbr class="cursor-help">
                                        <button id="calendar-full-screen"
                                            class="text-gray-400 p-1 rounded border-2 border-gray-200 dark:border-gray-700 mb-1"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                viewBox="0 0 24 24">

                                                <path fill="currentColor" fill-rule="evenodd"
                                                    d="M14.5 4.5a1 1 0 0 1 1-1h2a3 3 0 0 1 3 3v2a1 1 0 1 1-2 0v-2a1 1 0 0 0-1-1h-2a1 1 0 0 1-1-1m-11 4a1 1 0 1 0 2 0v-2a1 1 0 0 1 1-1h2a1 1 0 0 0 0-2h-2a3 3 0 0 0-3 3zm17 7a1 1 0 1 0-2 0v2a1 1 0 0 1-1 1h-2a1 1 0 1 0 0 2h2a3 3 0 0 0 3-3zm-12 5a1 1 0 1 0 0-2h-2a1 1 0 0 1-1-1v-2a1 1 0 1 0-2 0v2a3 3 0 0 0 3 3z"
                                                    clip-rule="evenodd" />
                                            </svg></button>
                                    </abbr>
                                    {{-- Contenido del abbr --}}
                                    <div
                                        class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block px-4 py-1 bg-gray-600 text-white text-sm rounded shadow-lg z-50 w-40 text-center">
                                        Ctrl + Enter para pantalla completa
                                    </div>
                                </div>

                                <x-dropdown align="right" width="60">
                                    <x-slot name="trigger">
                                        <button
                                            class="text-gray-400 p-1 rounded border-2 border-gray-200 dark:border-gray-700 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12.005 11.995v.01m0-4.01v.01m0 7.99v.01" />
                                            </svg>
                                        </button>

                                    </x-slot>

                                    <x-slot name="content">
                                        <ul class="p-3 text-sm text-gray-700 dark:text-gray-200" id="options-design"
                                            aria-labelledby="List options">
                                            <li>
                                                <div
                                                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <input id="design-solid" type="checkbox" value="designSolid"
                                                        class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-secondary dark:focus:ring-secondary dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="design-solid"
                                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Diseño
                                                        sólido</label>
                                                </div>
                                            </li>

                                            <li>
                                                <div
                                                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <input id="design-opacity" type="checkbox" value="designOpacity"
                                                        class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-secondary dark:focus:ring-secondary dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                    <label for="design-opacity"
                                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Diseño
                                                        con opacidad</label>
                                                </div>
                                            </li>

                                            @if (!auth()->check())
                                                <div class="border-t-2 border-gray-300 dark:border-gray-600 mt-2">
                                                    @php
                                                        $url =
                                                            Request::path() == 'agenda/guest/events'
                                                                ? '/agenda/guest/classrooms'
                                                                : '/agenda/guest/events';
                                                        $text =
                                                            Request::path() == 'agenda/guest/events'
                                                                ? 'Agenda de aulas'
                                                                : 'Agenda de eventos';

                                                    @endphp
                                                    <a class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600 mt-2"
                                                        href="{{ $url }}"><svg
                                                            xmlns="http://www.w3.org/2000/svg" class="me-3"
                                                            width="25" height="25" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M19 21q-.975 0-1.75-.562T16.175 19H11q-1.65 0-2.825-1.175T7 15t1.175-2.825T11 11h2q.825 0 1.413-.587T15 9t-.587-1.412T13 7H7.825q-.325.875-1.088 1.438T5 9q-1.25 0-2.125-.875T2 6t.875-2.125T5 3q.975 0 1.738.563T7.825 5H13q1.65 0 2.825 1.175T17 9t-1.175 2.825T13 13h-2q-.825 0-1.412.588T9 15t.588 1.413T11 17h5.175q.325-.875 1.088-1.437T19 15q1.25 0 2.125.875T22 18t-.875 2.125T19 21M5 7q.425 0 .713-.288T6 6t-.288-.712T5 5t-.712.288T4 6t.288.713T5 7" />
                                                        </svg>{{ $text }}</a>
                                                </div>
                                            @endif

                                        </ul>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>


                    </div>





                </div>





                <hr class="my-5 border-gray-200 dark:border-gray-700">

                <div id="container-calendar">
                    <div>
                        <div class="w-full flex justify-end mb-4 hidden">
                            <button id="close-screen-full" class="text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path
                                            d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464C22 4.93 22 7.286 22 12s0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"
                                            opacity=".5" />
                                        <path stroke-linecap="round" d="m14.5 9.5l-5 5m0-5l5 5" />
                                    </g>
                                </svg>
                            </button>
                        </div>
                        <div id="calendar" class="grow-1"></div>
                    </div>
                </div>

                @if (isset($guest) && $guest)
                    <input type="hidden" id="type-event-guest" value="{{ $group->id ?? 0 }}" />
                @endif

            </div>
        </div>
    </div>

    @if (
        (auth()->check() && (Auth::user()->group->type == 'Protocolo' || Auth::user()->group->type == 'Superadmin')) ||
            (!auth()->check() && (isset($guest) && $guest && $group && $group->type == 'Protocolo')))
        @include('agenda.modal.details-event-protocolo')
    @endif

    @if (
        (auth()->check() && (Auth::user()->group->type == 'CTA' || Auth::user()->group->type == 'Superadmin')) ||
            (!auth()->check() && (isset($guest) && $guest && $group && $group->type == 'CTA')))
        @include('agenda.modal.details-event-cta')
    @endif

    @if (auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin')))
        @if (auth()->user()->hasPermissionTo('delete event'))
            @vite('resources/js/components/deleteEvent.js')
        @endif
    @endif


    @role('superadmin')
        @vite('resources/js/agenda-superadmin.js')
    @endrole

    @if (auth()->check() && Auth::user()->group->type == 'Protocolo')
        @vite('resources/js/agenda-protocolo.js')
    @elseif(auth()->check() && Auth::user()->group->type == 'CTA')
        @vite('resources/js/agenda-cta.js')
    @endif

    @if (!auth()->check() && (isset($guest) && $guest))
        @vite('resources/js/agenda-guest.js')
    @endif



</x-app-layout>
