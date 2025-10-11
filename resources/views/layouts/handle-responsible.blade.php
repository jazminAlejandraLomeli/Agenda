@props(['group','responsibles','event' => null])

<div class="flex flex-col">
    <div>
        <div id="alert-error"
            class="hidden flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Permiso eliminado de la lista</span>
            </div>
        </div>
        <div id="alert-success"
            class="hidden flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Responsable creado exitósamente</span>
            </div>
        </div>
    </div>

    <div class="flex space-x-3 items-end">
        <x-group-form class="w-full">
            <x-slot name="label">Responsable</x-slot>
            <x-select-primary name="responsible" id="responsibles">
                <option value="">Seleccione una opción</option>
                @foreach ($responsibles as $responsible)
                    @if ($event && ($event->responsible->id == $responsible->id))                    
                        <option selected value="{{ $responsible->id }}">{{ $responsible->name }}</option>
                    @else
                        <option value="{{ $responsible->id }}">{{ $responsible->name }}</option>
                    @endif
                @endforeach
            </x-select-primary>
        </x-group-form>
    
        <input type="hidden" name="group_id" id="group-id" value="{{ $group->id }}">
    
        <x-tertiary-button class="mb-6" id="add-responsible">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512">
                <path fill="currentColor" fill-rule="evenodd"
                    d="M426.667 320v64h64v42.667h-64v64H384v-64h-64V384h64v-64zm-176-85.333c60.31 0 109.485 49.03 111.906 110.451l.094 4.749v12.8H320v-12.8c0-38.933-29.192-70.302-65.425-72.42l-3.908-.113H176c-36.708 0-67.166 30.026-69.223 68.392l-.11 4.141V384h192v42.667H64v-76.8c0-62.033 47.668-112.614 107.383-115.104l4.617-.096zm-37.334-192c41.238 0 74.667 33.43 74.667 74.667c0 39.862-31.238 72.429-70.57 74.556l-4.097.11c-41.237 0-74.666-33.43-74.666-74.666c0-39.863 31.238-72.43 70.57-74.557zm0 42.667c-17.673 0-32 14.327-32 32s14.327 32 32 32s32-14.327 32-32s-14.327-32-32-32" />
            </svg>
        </x-tertiary-button>
    </div>
    
</div>

@include('modals.add-responsible')