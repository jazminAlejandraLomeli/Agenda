<x-modal name="details-cta">
    <div class="p-4">
        <header class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-lg px-2 dark:text-white">Detalles del evento</h2>
            <x-generic-button x-on:click="$dispatch('close')">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m7.05 5.636l4.95 4.95l4.95-4.95l1.414 1.414l-4.95 4.95l4.95 4.95l-1.415 1.414l-4.95-4.95l-4.949 4.95l-1.414-1.414l4.95-4.95l-4.95-4.95z" />
                </svg>
            </x-generic-button>
        </header>



        <main>
            <section class="w-full min-h-20 rounded mb-3 p-2 border-s border-s-8 flex items-center"
                id="color-event-cta">
                <h1 class="font-bold text-lg px-2" id="title-event-cta"></h1>
            </section>

            <section class="dark:text-white">

                <div class="px-2 mt-4">
                    <div class="flex flex-col">

                        <x-group-details-event id="date-event-cta" class="text-xl font-bold">
                            <x-slot name="label">Fecha</x-slot>
                            <x-icon-details viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0-18 0m9 0l-3-2m3-3v5" />
                            </x-icon-details>
                        </x-group-details-event>

                        <x-group-details-event id="place-event-cta" class="text-xl font-bold">
                            <x-slot name="label">Lugar</x-slot>
                            <x-icon-details viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 19.677q2.82-2.454 4.458-4.991t1.638-4.39q0-2.744-1.737-4.53Q14.62 3.981 12 3.981T7.641 5.766t-1.737 4.53q0 1.852 1.638 4.39T12 19.677m0 .879q-.235 0-.47-.077t-.432-.25q-1.067-.981-2.164-2.185q-1.096-1.203-1.99-2.493t-1.468-2.633t-.572-2.622q0-3.173 2.066-5.234Q9.037 3 12 3t5.03 2.062q2.066 2.061 2.066 5.234q0 1.279-.572 2.613q-.572 1.333-1.458 2.632q-.885 1.3-1.981 2.494T12.92 20.21q-.191.173-.434.26q-.244.086-.487.086m.004-8.825q.667 0 1.14-.476q.472-.475.472-1.143t-.476-1.14t-1.143-.472t-1.14.476t-.472 1.143t.475 1.14t1.144.472" />
                            </x-icon-details>
                        </x-group-details-event>

                    </div>
                    <hr class="border-gray-300 mt-2 mb-4 dark:border-gray-700" />

                    <div class="grid grid-cols-1 md:grid-cols-2 grid-flow-row md:gap-5">

                        <div class="col-span-1 space-y-4 md:space-y-0">
                            <x-group-details-event id="responsible-event-cta">
                                <x-slot name="label">Responsable</x-slot>
                                <x-icon-details viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 2a5 5 0 1 0 5 5a5 5 0 0 0-5-5m0 8a3 3 0 1 1 3-3a3 3 0 0 1-3 3m9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z" />
                                </x-icon-details>
                            </x-group-details-event>


                            <x-group-details-event id="email-event-cta">
                                <x-slot name="label">Correo</x-slot>
                                <x-icon-details viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm3.519 0L12 11.671L18.481 6zM20 7.329l-7.341 6.424a1 1 0 0 1-1.318 0L4 7.329V18h16z" />
                                </x-icon-details>
                            </x-group-details-event>

                            <x-group-details-event id="type-event-cta">
                                <x-slot name="label">Tipo de evento</x-slot>
                                <x-icon-details viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M7.5 13.5v-1h9v1zm0 4v-1h6v1zM4 21V5h3.385V2.77h1.077V5h7.154V2.77h1V5H20v16zm1-1h14v-9.384H5zM5 9.615h14V6H5zm0 0V6z" />
                                </x-icon-details>
                            </x-group-details-event>
                        </div>

                        <div class="col-span-1">
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

                            <x-group-details-event id="participants">
                                <x-slot name="label">Número de participantes</x-slot>
                                <x-icon-details viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0-8 0M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2m1-17.87a4 4 0 0 1 0 7.75M21 21v-2a4 4 0 0 0-3-3.85" />
                                </x-icon-details>
                            </x-group-details-event>

                            <x-group-details-event id="grade">
                                <x-slot name="label">Semestre</x-slot>
                                <x-icon-details viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                        d="M255 471L91.7 387V41h328.6v346zm-147.3-93.74L255 453l149.3-75.76V57H107.7zm187.61-168.34l-14.5-46l38.8-28.73l-48.27-.43L256 87.94l-15.33 45.78l-48.27.43l38.8 28.73l-14.5 46l39.31-28zM254.13 311.5l98.27-49.89v-49.9l-98.14 49.82l-94.66-48.69v50zm.13 32.66l-94.66-48.69v50l94.54 48.62l98.27-49.89v-49.9z" />
                                </x-icon-details>
                            </x-group-details-event>
                        </div>
                    </div>
                    
                </div>
            </section>


        </main>

        <footer
            class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-0 grid-flow-row md:space-x-3 [&>div]:mt-2 border-t-2 border-gray-300 dark:border-gray-700 mt-3">

            @if (auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin')))
                @if (auth()->user()->hasPermissionTo('delete reserve classroom'))
                    <div class="col-span-1 flex flex-col gap-3">

                        <form action="" method="POST" id="deleteFormCTA">
                            @csrf
                            @method('DELETE')
                            <x-delete-button class="w-full" type="submit">
                                Eliminar
                            </x-delete-button>
                        </form>

                        <form action="" method="POST" id="deleteAllFormCTA">
                            @csrf
                            @method('DELETE')
                            <x-delete-button type="submit" class="w-full">
                                Eliminar las relacionados
                            </x-delete-button>
                        </form>
                    </div>
                @endif

                @if (auth()->user()->hasPermissionTo('update reserve classroom'))
                    <div class="col-span-1 flex flex-col gap-3">

                        <x-edit-link-button id="btn-edit-cta">
                            Editar reservación
                        </x-edit-link-button>

                        <x-edit-link-button id="btn-edit-all-cta">
                            Editar las reservaciones relacionados
                        </x-edit-link-button>
                    </div>
                @endif
            @endif
        </footer>

    </div>


    </div>
</x-modal>
