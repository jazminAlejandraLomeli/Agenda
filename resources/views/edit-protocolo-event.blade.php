@section('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

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
            <h2 class="ml-2 text-xl md:text-2xl font-bold">Editar evento</h2>
        </div>
    </x-slot>

    <x-slot name="styles">
        @vite('resources/css/tomSelect.css')
    </x-slot>



    <div class="bg-white dark:bg-gray-800 shadow max-w-7xl p-10 mx-auto mt-5 rounded">

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

        <form class="grid grid-cols-1 grid-flow-row md:grid-cols-2"
            action="{{ isset($recursive_event) && $recursive_event ? route('agenda.update.protocolo.all', ['id' => $event->id]) : route('agenda.update.protocolo', ['id' => $event->id]) }}"
            method="POST" id="form-update-event">
            @csrf
            @method('PUT')
            <div class="me-5 col-span-1">
                <x-group-form>
                    <x-slot name="label">Nombre del evento</x-slot>
                    <x-select-primary name="title" id="titleEvent">
                        <option selected value="{{ $title->id }}">{{ $title->title }}</option>                    
                    </x-select-primary>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2"
                        viewBox="0 0 48 48">
                        <g fill="none" stroke="#CD5700" stroke-linejoin="round" stroke-width="4">
                            <path
                                d="M5 19h38v21a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zM5 9a2 2 0 0 1 2-2h34a2 2 0 0 1 2 2v10H5z" />
                            <path stroke-linecap="round" d="M16 4v8m16-8v8m-4 22h6m-20 0h6m8-8h6m-20 0h6" />
                        </g>
                    </svg>
                </x-group-form>

                <x-group-form>
                    <x-slot name="label">Tipo de evento</x-slot>
                    <x-select-primary name="event_type" id="eventType">
                        <option value="">Seleccione una opción</option>
                        @foreach ($events_types as $event_type)
                            @if ($event_type->id == $event->event_type->id)
                                <option selected value="{{ $event_type->id }}">{{ $event_type->name }}</option>
                            @else
                                <option value="{{ $event_type->id }}">{{ $event_type->name }}</option>
                            @endif
                        @endforeach
                    </x-select-primary>
                </x-group-form>


                <x-group-form>
                    <x-slot name="label">Dependencia</x-slot>
                    <x-select-primary name="dependency_program" id="dependencyProgram">
                        <option value="">Seleccione una opción</option>
                        @foreach ($dependencies as $dependency)
                            @if ($dependency->id == $event->dependency_program->id)
                                <option selected value="{{ $dependency->id }}">{{ $dependency->name }}</option>
                            @else
                                <option value="{{ $dependency->id }}">{{ $dependency->name }}</option>
                            @endif
                        @endforeach
                    </x-select-primary>
                </x-group-form>

                <x-group-form>
                    <x-slot name="label">Lugar</x-slot>
                    <x-select-primary name="place" id="place">
                        <option value="">Seleccione una opción</option>
                        @foreach ($places as $place)
                            @if ($place->id == $event->place->id)
                                <option selected value="{{ $place->id }}">{{ $place->name }}</option>
                            @else
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                            @endif
                        @endforeach
                    </x-select-primary>
                </x-group-form>

                <x-group-form class="w-full">
                    <x-slot name="label">Responsable</x-slot>
                    <x-select-primary name="responsible" id="responsibles">
                        <option selected value="{{ $event->responsible->id }}">{{ $event->responsible->name }}</option>                    
                    </x-select-primary>
                    {{-- <x-input-primary type="text" name="responsible" id="responsibles"
                        value="{{ $event->responsible->id }}"></x-input-primary> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2 text-primary"
                        viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </g>
                    </svg>
                </x-group-form>

                <input type="hidden" name="group_id" id="group-id" value="{{ $group->id }}">

                <x-group-form>
                    <x-slot name="label">Teléfono o extensión</x-slot>
                    <x-input-primary maxlength="10" name="phone"
                        value="{{ $event->protocolo->tel_extension }}"></x-input-primary>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2 text-primary"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M19.44 13c-.22 0-.45-.07-.67-.12a9.4 9.4 0 0 1-1.31-.39a2 2 0 0 0-2.48 1l-.22.45a12.2 12.2 0 0 1-2.66-2a12.2 12.2 0 0 1-2-2.66l.42-.28a2 2 0 0 0 1-2.48a10 10 0 0 1-.39-1.31c-.05-.22-.09-.45-.12-.68a3 3 0 0 0-3-2.49h-3a3 3 0 0 0-3 3.41a19 19 0 0 0 16.52 16.46h.38a3 3 0 0 0 2-.76a3 3 0 0 0 1-2.25v-3a3 3 0 0 0-2.47-2.9m.5 6a1 1 0 0 1-.34.75a1.05 1.05 0 0 1-.82.25A17 17 0 0 1 4.07 5.22a1.1 1.1 0 0 1 .25-.82a1 1 0 0 1 .75-.34h3a1 1 0 0 1 1 .79q.06.41.15.81a11 11 0 0 0 .46 1.55l-1.4.65a1 1 0 0 0-.49 1.33a14.5 14.5 0 0 0 7 7a1 1 0 0 0 .76 0a1 1 0 0 0 .57-.52l.62-1.4a14 14 0 0 0 1.58.46q.4.09.81.15a1 1 0 0 1 .79 1Z" />
                    </svg>
                </x-group-form>

                <input type="hidden" name="places[]" value="{{$place->id}}" />

            </div>
            <div class="ms-5 col-span-1">

                {{-- Handle dates --}}

                @if (isset($recursive_event) && $recursive_event)
                    <x-dates-repetition-edit :event="$event" :dates="$dates" />
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 ">
                        <div class="md:col-span-3 mb-3 dark:text-white">
                            <label class="text-lg font-bold">Fecha</label>
                            <hr class="border-primary" />
                        </div>
                        <div class="col-span-3">
                            <x-group-form>
                                <x-slot name="label">Fecha del evento</x-slot>
                                <x-input-primary type="text" placeholder="Selecciona una fecha" id="date-start"
                                    value="{{ $event->date->only_date_start }}" name="date_start"
                                    class="cursor-pointer"></x-input-primary>
                            </x-group-form>
                            {{-- <x-group-form>
                            <x-slot name="label">Duración</x-slot>
                            <x-select-primary name="duration" id="duration">
                                <option selected value="1">1 hora</option>
                                <option value="2">2 horas</option>
                                <option value="3">3 horas</option>
                                <option value="4">4 horas</option>
                                <option value="5">Personalizado</option>
                            </x-select-primary>
                        </x-group-form> --}}
                        </div>


                        <div class="col-span-3 grid grid-cols-2 gap-3">
                            <x-group-form class="col-span-1 ">
                                <x-slot name="label">Hora inicio (24/horas)</x-slot>
                                <x-input-primary type="time" id="hour-start" name="hour_start"
                                    value="{{ $event->date->only_hour_start }}" />
                            </x-group-form>

                            <x-group-form class="col-span-1">
                                <x-slot name="label">Hora fin (24/horas)</x-slot>
                                <x-input-primary type="time" name="hour_end" id="hour-end"
                                    value="{{ $event->date->only_hour_end }}" />
                            </x-group-form>
                        </div>


                    </div>
                @endif

                <div class="col-span-3 grid grid-cols-1">

                    <x-group-form class="col-span-1 ">
                        <x-slot name="label">Notas para Protocolo</x-slot>
                        <x-text-primary
                            name="notes_protocolo">{{ $event->protocolo->notes_protocolo }}</x-text-primary>

                    </x-group-form>

                    <x-group-form class="col-span-1 ">
                        <x-slot name="label">Notas para CTA</x-slot>
                        <x-text-primary name="notes_cta">{{ $event->protocolo->notes_cta }}</x-text-primary>

                    </x-group-form>

                    <x-group-form class="col-span-1 ">
                        <x-slot name="label">Notas para Servicios Generales</x-slot>
                        <x-text-primary
                            name="notes_general_services">{{ $event->protocolo->notes_general_service }}</x-text-primary>
                    </x-group-form>

                </div>

                {{-- End Handle dates --}}


            </div>

            {{-- @if (isset($recursive_event) && $recursive_event)
                <div class="col-span-2 grid grid-cols-1 md:grid-cols-2">

                    <x-group-form class="col-span-1  me-5">
                        <x-slot name="label">Notas para Protocolo</x-slot>
                        <x-text-primary
                            name="notes_protocolo">{{ $event->protocolo->notes_protocolo }}</x-text-primary>

                    </x-group-form>

                    <x-group-form class="col-span-1 md:col-span-1 ms-5">
                        <x-slot name="label">Notas para CTA</x-slot>
                        <x-text-primary name="notes_cta">{{ $event->protocolo->notes_cta }}</x-text-primary>

                    </x-group-form>

                    <x-group-form class="col-span-1 md:col-span-1">
                        <x-slot name="label">Notas para Servicios Generales</x-slot>
                        <x-text-primary
                            name="notes_general_services">{{ $event->protocolo->notes_general_service }}</x-text-primary>
                    </x-group-form>

                </div>
            @endif --}}



            <div class="col-span-1 md:col-span-2 flex justify-end items-start gap-5 mt-3">

                <x-tertiary-button type="button" id="cancelEdit">
                    Cancelar
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m12 13.4l2.9 2.9q.275.275.7.275t.7-.275t.275-.7t-.275-.7L13.4 12l2.9-2.9q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275L12 10.6L9.1 7.7q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7l2.9 2.9l-2.9 2.9q-.275.275-.275.7t.275.7t.7.275t.7-.275zm0 8.6q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                    </svg>
                </x-tertiary-button>

                <x-secondary-button type="submit">
                    Guardar cambios
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

    @if (isset($recursive_event) && $recursive_event)
        @vite(['resources/js/edit-events-protocolo.js'])
    @else
        @vite(['resources/js/edit-event-protocolo.js'])
    @endif


</x-app-layout>
