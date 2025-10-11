<x-app-layout>
    <x-slot name="header">
        <div class="flex dark:text-white items-center gap-3">
            {{-- <h2 class="text-2xl font-bold">Agenda</h2> --}}
            <x-tertiary-link-button href="{{route('agenda.index')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m9.55 12l7.35 7.35q.375.375.363.875t-.388.875t-.875.375t-.875-.375l-7.7-7.675q-.3-.3-.45-.675t-.15-.75t.15-.75t.45-.675l7.7-7.7q.375-.375.888-.363t.887.388t.375.875t-.375.875z" />
                </svg>
            </x-tertiary-link-button>
            <h2 class="ml-2 md:text-2xl text-xl font-bold">Agregar reservación</h2>
        </div>
    </x-slot>

    <x-slot name="styles">
        @vite('resources/css/tomSelect.css')
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow-lg max-w-7xl p-5 md:p-10 mx-auto mt-5 rounded">

        @if ($errors->any())
            <x-list-alert type="danger">
                <x-slot name="title">¡Ups!</x-slot>
                <x-slot name="subtitle">Algo salió mal.</x-slot>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </x-list-alert>
        @endif


        @if (session('error'))
            <x-alert type="danger">
                <x-slot name="title">¡Ups!</x-slot>
                {{ session('error') }}
            </x-alert>
        @endif



        <form class="grid grid-cols-1 md:grid-cols-2 grid-flow-row" action="{{ route('agenda.store.cta') }}" method="POST" id="form-create-event">
            @csrf
            <div  class="col-span-1 md:col-span-1 md:me-5">
                <x-group-form>
                    <x-slot name="label">Nombre del evento</x-slot>
                    <x-input-primary type="text" name="title" id="titleEvent"></x-input-primary>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2"
                        viewBox="0 0 48 48">
                        <g fill="none" stroke="#CD5700" stroke-linejoin="round" stroke-width="4">
                            <path
                                d="M5 19h38v21a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zM5 9a2 2 0 0 1 2-2h34a2 2 0 0 1 2 2v10H5z" />
                            <path stroke-linecap="round" d="M16 4v8m16-8v8m-4 22h6m-20 0h6m8-8h6m-20 0h6" />
                        </g>
                    </svg>
                </x-group-form>

                <x-group-form class="w-full">
                    <x-slot name="label">Responsable</x-slot>
                    <x-select-primary name="responsible" id="responsibles" >
                        <option value="">Seleccione una opción</option>
                        @foreach ($responsibles as $responsible)
                            <option value="{{ $responsible->id }}">{{ $responsible->name }}</option>
                        @endforeach
                    </x-select-primary>
                </x-group-form>
            
                <input type="hidden" name="group_id" id="group-id" value="{{ $group->id }}">
                
                <x-group-form>
                    <x-slot name="label">Correo</x-slot>
                    <x-input-primary type="email" name="email"></x-input-primary>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2 text-primary"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm3.519 0L12 11.671L18.481 6zM20 7.329l-7.341 6.424a1 1 0 0 1-1.318 0L4 7.329V18h16z" />
                    </svg>
                </x-group-form>

                <x-group-form>
                    <x-slot name="label">Tipo de evento</x-slot>
                    <x-select-primary name="event_type" id="eventType">
                        <option value="">Seleccione una opción</option>
                        @if (!$events_types->isEmpty())
                            @foreach ($events_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        @endif
                    </x-select-primary>
                </x-group-form>


                <x-group-form>
                    <x-slot name="label">Programa académico</x-slot>
                    <x-select-primary name="dependency_program" id="dependencyProgram">
                        <option value="">Seleccione una opción</option>
                        @if (!$dependencies->isEmpty())
                            @foreach ($dependencies as $dependency)
                                <option value="{{ $dependency->id }}">{{ $dependency->name }}</option>
                            @endforeach
                        @endif

                    </x-select-primary>
                </x-group-form>
            </div>
            <div class="md:ms-5 col-span-1 md:col-span-1">


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-group-form class="cols-span-1">
                        <x-slot name="label">Numero de participantes</x-slot>
                        <x-input-primary type="number" name="num_participants"></x-input-primary>
                    </x-group-form>

                    <x-group-form class="cols-span-1">
                        <x-slot name="label">Semestre</x-slot>
                        <x-select-primary name="semester">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @if (!$semesters->isEmpty())
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                @endforeach
                            @endif
                        </x-select-primary>
                    </x-group-form>
                </div>

                <x-group-form>
                    <x-slot name="label">Lugar</x-slot>
                    <x-select-primary name="place" id="place">
                        <option value="">Seleccione una opción</option>
                        @if (!$places->isEmpty())
                            @foreach ($places as $place)
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                            @endforeach
                        @endif
                    </x-select-primary>
                </x-group-form>

                

                @include('layouts.dates-repetition')

            </div>



            <div class="col-span-1 md:col-span-2 flex justify-end items-start gap-5 mt-5">

                <x-tertiary-button id="cancel">
                    Cancelar
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m12 13.4l2.9 2.9q.275.275.7.275t.7-.275t.275-.7t-.275-.7L13.4 12l2.9-2.9q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275L12 10.6L9.1 7.7q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7l2.9 2.9l-2.9 2.9q-.275.275-.275.7t.275.7t.7.275t.7-.275zm0 8.6q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                    </svg>
                </x-tertiary-button>

                <x-secondary-button type="submit">
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

        </form>
    </div>



    @vite(['resources/js/create-event-cta.js', 'resources/js/helpers/select2.min.js'])


</x-app-layout>
