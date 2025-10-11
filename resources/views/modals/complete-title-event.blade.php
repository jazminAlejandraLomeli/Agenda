<x-modal name="complete-title-modal" maxWidth="xl">
    <div class="p-4">
        <header class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-lg px-2">Títulos concurrentes</h2>
            <x-generic-button x-on:click="$dispatch('close')">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m7.05 5.636l4.95 4.95l4.95-4.95l1.414 1.414l-4.95 4.95l4.95 4.95l-1.415 1.414l-4.95-4.95l-4.949 4.95l-1.414-1.414l4.95-4.95l-4.95-4.95z" />
                </svg>
            </x-generic-button>
        </header>


        <main class="px-2">

            <div class="w-full">
                <div class="relative right-0">
                    <ul class="relative flex flex-wrap px-1.5 py-1.5 list-none rounded-md bg-slate-100"
                        role="list" id="listOptionsTitles">
                        <li class="z-30 flex-auto text-center">
                            <a class="z-30 flex items-center justify-center w-full px-0 py-2 text-sm mb-0 transition-all ease-in-out border-0 rounded-md cursor-pointer text-slate-600">
                                Seleccionar título
                            </a>
                        </li>
                        <li class="z-30 flex-auto text-center">
                            <a class="z-30 flex items-center justify-center w-full px-0 py-2 mb-0 text-sm transition-all ease-in-out border-0 rounded-lg cursor-pointer text-slate-600 ">
                                Guardar título
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="content-taps">
                <x-group-form class="{{ $countTitles <= 0 ? 'hidden' : '' }}">
                    <x-slot name="label">Títulos</x-slot>
                    <x-select-primary name="title_events" id="titleEvents">
                        <option value="">Seleccione una opción</option>
                    </x-select-primary>
                </x-group-form>
    
                <x-simple-alert type="info" msg="No tienes almacenado ningún título concurrente"
                    class="{{ $countTitles > 0 ? 'hidden' : '' }}" />
            </div>

            <div class="content-taps">
                <x-simple-alert type="danger" id="alertTitleEventError" class="hidden" />
                <x-simple-alert type="success" id="alertTitleEventSuccess" class="hidden" />
    
                <x-group-form class="w-full">
                    <x-slot name="label">Nombre del evento</x-slot>
                    <x-input-primary type="text" name="titleEventComplete" id="titleEventComplete"
                        value=""></x-input-primary>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2"
                        viewBox="0 0 48 48">
                        <g fill="none" stroke="#CD5700" stroke-linejoin="round" stroke-width="4">
                            <path d="M5 19h38v21a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zM5 9a2 2 0 0 1 2-2h34a2 2 0 0 1 2 2v10H5z" />
                            <path stroke-linecap="round" d="M16 4v8m16-8v8m-4 22h6m-20 0h6m8-8h6m-20 0h6" />
                        </g>
                    </svg>
                </x-group-form>
            </div>

            

            {{-- <hr class="borde border-gray-300 my-4" /> --}}





            

            <div class="flex justify-end">
                <x-secondary-button id="save-title-event">Guardar <svg xmlns="http://www.w3.org/2000/svg" class="ms-3"
                        width="25" height="25" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12 21q-3.775 0-6.387-1.162T3 17V7q0-1.65 2.638-2.825T12 3t6.363 1.175T21 7v10q0 1.675-2.613 2.838T12 21m0-11.975q2.225 0 4.475-.638T19 7.025q-.275-.725-2.512-1.375T12 5q-2.275 0-4.462.638T5 7.025q.35.75 2.538 1.375T12 9.025M12 14q1.05 0 2.025-.1t1.863-.288t1.675-.462T19 12.525v-3q-.65.35-1.437.625t-1.675.463t-1.863.287T12 11t-2.05-.1t-1.888-.288T6.4 10.15T5 9.525v3q.625.35 1.4.625t1.663.463t1.887.287T12 14m0 5q1.15 0 2.338-.175t2.187-.462t1.675-.65t.8-.738v-2.45q-.65.35-1.437.625t-1.675.463t-1.863.287T12 16t-2.05-.1t-1.888-.288T6.4 15.15T5 14.525V17q.125.375.788.725t1.662.638t2.2.462T12 19" />
                    </svg></x-secondary-button>
            </div>



        </main>

        <hr class="borde border-gray-300 my-4" />

        <footer class=" flex justify-end space-x-3 px-2">

            <x-tertiary-button x-on:click="$dispatch('close')">Cancelar</x-tertiary-button>
            <x-secondary-button id="selectTitle">Seleccionar</x-secondary-button>

        </footer>

    </div>
</x-modal>
