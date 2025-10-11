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
            <h2 class="ml-2 text-2xl font-bold">Reservaciones pendientes </h2>
        </div>
    </x-slot>


    <div class="py-4 lg:px-6">
        @if (session('error'))
            <x-alert class="alerts" type="danger">
                <x-slot name="title">¡Ups!</x-slot>
                {{ session('error') }}
            </x-alert>
        @endif


        {{-- <div class="hidden cont-error">
            <x-alert type="danger">
                <x-slot name="title">¡Ups! paraece que algo salio mal</x-slot>
                <p id="text-error"> .... </p>
            </x-alert>
        </div> --}}

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg dark:text-white max-w-7xl mx-auto">
            <div class="p-6 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($events as $event)
                        <div
                            class="p-5 max-w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex items-center mb-4">
                                <!-- Titulo -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                    viewBox="0 0 24 24">
                                    <path fill="{{ $event->place->color }}"
                                        d="M23 2H1a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h22a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1m-1 18h-2v-1h-5v1H2V4h20zM10.29 9.71A1.71 1.71 0 0 1 12 8c.95 0 1.71.77 1.71 1.71c0 .95-.76 1.72-1.71 1.72s-1.71-.77-1.71-1.72m-4.58 1.58c0-.71.58-1.29 1.29-1.29a1.29 1.29 0 0 1 1.29 1.29c0 .71-.58 1.28-1.29 1.28S5.71 12 5.71 11.29m10 0A1.29 1.29 0 0 1 17 10a1.29 1.29 0 0 1 1.29 1.29c0 .71-.58 1.28-1.29 1.28s-1.29-.57-1.29-1.28M20 15.14V16H4v-.86c0-.94 1.55-1.71 3-1.71c.55 0 1.11.11 1.6.3c.75-.69 2.1-1.16 3.4-1.16s2.65.47 3.4 1.16c.49-.19 1.05-.3 1.6-.3c1.45 0 3 .77 3 1.71" />
                                </svg>
                                <h5 class="ml-3 dark:text-slate-200 text-slate-800 text-2xl font-semibold">
                                    {{ $event->title }}
                                </h5>
                            </div>

                            {{-- Descripcion 
                                <h5 class="mb-2 text-md font-normal tracking-tight text-gray-600 dark:text-white">
                                    {{ $event->description }}
                                </h5> --}}

                            <hr class="border-gray-300 mt-2 mb-4" />

                            <div class="flex flex-col">

                                <div class="mb-2">
                                    <x-group-details-event id="date-event-cta" class="text-xl font-bold">
                                        <x-slot name="label">Fecha</x-slot>
                                        <x-icon-details viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0-18 0m9 0l-3-2m3-3v5" />
                                        </x-icon-details>
                                    </x-group-details-event>
                                    @php
                                        $f_inicio = ucfirst(
                                            \Carbon\Carbon::parse($event->date->date_start)
                                                ->locale('es')
                                                ->isoFormat('dddd, LL'),
                                        );
                                        $aux = \Carbon\Carbon::parse($event->date->date_start)->format('H:i');
                                        $aux2 = \Carbon\Carbon::parse($event->date->date_end)->format('H:i');

                                    @endphp

                                    {{ $f_inicio . ' - ' . $aux . ' a ' . $aux2 }}

                                </div>

                                <div class="mb-2">
                                    <x-group-details-event id="place-event-cta" class="text-xl font-bold">
                                        <x-slot name="label">Lugar</x-slot>
                                        <x-icon-details viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M12 19.677q2.82-2.454 4.458-4.991t1.638-4.39q0-2.744-1.737-4.53Q14.62 3.981 12 3.981T7.641 5.766t-1.737 4.53q0 1.852 1.638 4.39T12 19.677m0 .879q-.235 0-.47-.077t-.432-.25q-1.067-.981-2.164-2.185q-1.096-1.203-1.99-2.493t-1.468-2.633t-.572-2.622q0-3.173 2.066-5.234Q9.037 3 12 3t5.03 2.062q2.066 2.061 2.066 5.234q0 1.279-.572 2.613q-.572 1.333-1.458 2.632q-.885 1.3-1.981 2.494T12.92 20.21q-.191.173-.434.26q-.244.086-.487.086m.004-8.825q.667 0 1.14-.476q.472-.475.472-1.143t-.476-1.14t-1.143-.472t-1.14.476t-.472 1.143t.475 1.14t1.144.472" />
                                        </x-icon-details>

                                    </x-group-details-event>
                                    {{ $event->place->name }}

                                </div>
                            </div>
                            <hr class="border-gray-300 mt-2 mb-4" />

                            <div class="gap-5 grid grid-cols-1 md:grid-cols-2">

                                <div class="col-span-1">
                                    <div class="mb-2">
                                        <x-group-details-event id="responsible-event-cta" class="">
                                            <x-slot name="label">Responsable</x-slot>
                                            <x-icon-details viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M12 2a5 5 0 1 0 5 5a5 5 0 0 0-5-5m0 8a3 3 0 1 1 3-3a3 3 0 0 1-3 3m9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z" />
                                            </x-icon-details>
                                        </x-group-details-event>
                                        {{ $event->responsible->name }}


                                    </div>
                                    <div class="mb-2">
                                        <x-group-details-event id="email-event-cta">
                                            <x-slot name="label">Correo</x-slot>
                                            <x-icon-details viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm3.519 0L12 11.671L18.481 6zM20 7.329l-7.341 6.424a1 1 0 0 1-1.318 0L4 7.329V18h16z" />
                                            </x-icon-details>
                                        </x-group-details-event>

                                        {{ $event->cta->email }}

                                    </div>
                                    <x-group-details-event id="type-event-cta">
                                        <x-slot name="label">Tipo de evento</x-slot>
                                        <x-icon-details viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M7.5 13.5v-1h9v1zm0 4v-1h6v1zM4 21V5h3.385V2.77h1.077V5h7.154V2.77h1V5H20v16zm1-1h14v-9.384H5zM5 9.615h14V6H5zm0 0V6z" />
                                        </x-icon-details>
                                    </x-group-details-event>
                                    {{ $event->event_type->name }}

                                </div>

                                <div class="col-span-1">
                                    <div class="mb-2">
                                        <x-group-details-event id="academic-program">
                                            <x-slot name="label">Programa Académico</x-slot>
                                            <x-icon-details viewBox="0 0 24 24">
                                                <g fill="none" fill-rule="evenodd">
                                                    <path
                                                        d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                    <path fill="currentColor"
                                                        d="M15 6a3 3 0 0 1-2 2.83V11h3a3 3 0 0 1 3 3v1.17a3.001 3.001 0 1 1-2 0V14a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v1.17a3.001 3.001 0 1 1-2 0V14a3 3 0 0 1 3-3h3V8.83A3.001 3.001 0 1 1 15 6m-3-1a1 1 0 1 0 0 2a1 1 0 0 0 0-2M6 17a1 1 0 1 0 0 2a1 1 0 0 0 0-2m12 0a1 1 0 1 0 0 2a1 1 0 0 0 0-2" />
                                                </g>
                                            </x-icon-details>
                                        </x-group-details-event>
                                        {{ $event->dependency_program->name }}

                                    </div>
                                    <div class="mb-2">
                                        <x-group-details-event id="participants">
                                            <x-slot name="label">Número de participantes</x-slot>
                                            <x-icon-details viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0-8 0M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2m1-17.87a4 4 0 0 1 0 7.75M21 21v-2a4 4 0 0 0-3-3.85" />
                                            </x-icon-details>
                                        </x-group-details-event>
                                        {{ $event->cta->num_participants . '  Participantes' }}

                                    </div>
                                    <x-group-details-event id="grade">
                                        <x-slot name="label">Semestre</x-slot>
                                        <x-icon-details viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M255 471L91.7 387V41h328.6v346zm-147.3-93.74L255 453l149.3-75.76V57H107.7zm187.61-168.34l-14.5-46l38.8-28.73l-48.27-.43L256 87.94l-15.33 45.78l-48.27.43l38.8 28.73l-14.5 46l39.31-28zM254.13 311.5l98.27-49.89v-49.9l-98.14 49.82l-94.66-48.69v50zm.13 32.66l-94.66-48.69v50l94.54 48.62l98.27-49.89v-49.9z" />
                                        </x-icon-details>
                                    </x-group-details-event>
                                    {{ $event->cta->semester->name }}
                                </div>
                            </div>
                            <hr class="border-gray-300 mt-2 mb-4" />


                            <div class="flex justify-end gap-3">

                                <x-tertiary-button class="Btn-deny" data-id="{{ $event->id }}"
                                    data-name="{{ $event->title }}">
                                    No publicar
                                    <svg class="ms-1" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 20 20">
                                        <path fill="currentColor"
                                            d="m12.12 10l3.53 3.53l-2.12 2.12L10 12.12l-3.54 3.54l-2.12-2.12L7.88 10L4.34 6.46l2.12-2.12L10 7.88l3.54-3.53l2.12 2.12z" />
                                    </svg>
                                </x-tertiary-button>

                                <x-secondary-button class="Btn-public" data-id="{{ $event->id }}">
                                    Publicar
                                    <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="25"
                                        height="25" viewBox="0 0 1024 1024">
                                        <path fill="#ffffff"
                                            d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z" />
                                    </svg>
                                </x-secondary-button>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if (count($events) === 0)
                <div class="flex flex-col items-center justify-center pt-0 pb-5">
                    <p class="text-2xl mb-4">Parece que no tienes reservaciones pendientes</p>
                    {{-- max-w-xl  --}}

                    {{-- <img class="min-h-18 min-w-18 max-h-full max-w-full h-auto w-auto rounded-lg shadow-lg" --}}
                    <div class="relative w-full max-w-md mx-auto aspect-[8/8] bg-gray-200">

                        <img class="w-full h-auto rounded-lg shadow-lg " src="{{ asset('img/no_data.webp') }}"
                            alt="No tienes reservaciones pendientes">
                    </div>


                    <div class="mt-5">
                        <x-tertiary-button>
                            <a href="{{ route('agenda.index') }}">Regresar</a>
                            <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19 4h-1V3c0-.6-.4-1-1-1s-1 .4-1 1v1H8V3c0-.6-.4-1-1-1s-1 .4-1 1v1H5C3.3 4 2 5.3 2 7v1h20V7c0-1.7-1.3-3-3-3M2 19c0 1.7 1.3 3 3 3h14c1.7 0 3-1.3 3-3v-9H2zm15-7c.6 0 1 .4 1 1s-.4 1-1 1s-1-.4-1-1s.4-1 1-1m0 4c.6 0 1 .4 1 1s-.4 1-1 1s-1-.4-1-1s.4-1 1-1m-5-4c.6 0 1 .4 1 1s-.4 1-1 1s-1-.4-1-1s.4-1 1-1m0 4c.6 0 1 .4 1 1s-.4 1-1 1s-1-.4-1-1s.4-1 1-1m-5-4c.6 0 1 .4 1 1s-.4 1-1 1s-1-.4-1-1s.4-1 1-1m0 4c.6 0 1 .4 1 1s-.4 1-1 1s-1-.4-1-1s.4-1 1-1" />
                            </svg>

                        </x-tertiary-button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('agenda.modal.deny-reservation')

    @vite('resources/js/confirm-classroom.js')
</x-app-layout>
