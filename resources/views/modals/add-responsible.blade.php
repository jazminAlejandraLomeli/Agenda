<x-modal name="add-responsible-modal" maxWidth="xl">
    <div class="p-4">
        <header class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-lg px-2">Agregar responsable</h2>
            <x-generic-button x-on:click="$dispatch('close')">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m7.05 5.636l4.95 4.95l4.95-4.95l1.414 1.414l-4.95 4.95l4.95 4.95l-1.415 1.414l-4.95-4.95l-4.949 4.95l-1.414-1.414l4.95-4.95l-4.95-4.95z" />
                </svg>
            </x-generic-button>
        </header>



        <main class="px-2">

            
            <x-group-form class="w-full">
                <x-slot name="label">Responsable</x-slot>
                <x-input-primary type="text" id="responsible-store"></x-input-primary>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2 text-primary"
                    viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </g>
                </svg>
            </x-group-form>
        </main>

        <footer class=" flex justify-end space-x-3 px-2">

            <x-tertiary-button x-on:click="$dispatch('close')">Cancelar</x-tertiary-button>
            <x-secondary-button id="save-responsible">Guardar</x-secondary-button>

        </footer>

    </div>
</x-modal>
