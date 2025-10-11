<x-manage-data>
    <x-slot name="title">Tipo de eventos</x-slot>
    <x-slot name="button">
        <x-tertiary-button id="add-type-event">
            <span>Agregar tipo de evento</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="ms-3" width="25" height="25" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M11 13v3q0 .425.288.713T12 17t.713-.288T13 16v-3h3q.425 0 .713-.288T17 12t-.288-.712T16 11h-3V8q0-.425-.288-.712T12 7t-.712.288T11 8v3H8q-.425 0-.712.288T7 12t.288.713T8 13zm-6 8q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm0-2h14V5H5zM5 5v14z" />
            </svg>
        </x-tertiary-button>
    </x-slot>

    <x-slot name="program">  {{ $title_nav }}</x-slot>
  
 
    {{-- Modal para editar algun nombre del evento --}}
    @include('manage.modals.edit-type-event')
    {{-- Modal para agregar un nuevo tipo de evento --}}
    @include('manage.modals.add-type-event')
    
    <div id="tableEventsType"></div>

    <x-slot name="script">
        @vite('resources/js/manage/super-event-types.js')
    </x-slot>

</x-manage-data>
