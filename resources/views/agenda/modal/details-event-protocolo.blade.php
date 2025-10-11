<x-modal name="details-protocolo">
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
            <section class="w-full min-h-20 rounded mb-3 p-2 flex items-center" id="color-event">
                <h1 class="font-bold text-lg px-2 dark:text-white" id="title-event"></h1>
            </section>

            <section class="dark:text-white">

                <div class="px-2 mt-4">
                    <div class="flex flex-col">


                        <x-group-details-event id="date-event" class="text-xl dark:text-white font-bold">
                            <x-slot name="label">Fecha</x-slot>
                            <x-icon-details viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M8 14q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m4 0q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m4 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6z" />
                            </x-icon-details>
                        </x-group-details-event>

                        <x-group-details-event id="place-event" class="text-xl font-bold dark:text-white">
                            <x-slot name="label">Lugar</x-slot>
                            <x-icon-details viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 19.677q2.82-2.454 4.458-4.991t1.638-4.39q0-2.744-1.737-4.53Q14.62 3.981 12 3.981T7.641 5.766t-1.737 4.53q0 1.852 1.638 4.39T12 19.677m0 .879q-.235 0-.47-.077t-.432-.25q-1.067-.981-2.164-2.185q-1.096-1.203-1.99-2.493t-1.468-2.633t-.572-2.622q0-3.173 2.066-5.234Q9.037 3 12 3t5.03 2.062q2.066 2.061 2.066 5.234q0 1.279-.572 2.613q-.572 1.333-1.458 2.632q-.885 1.3-1.981 2.494T12.92 20.21q-.191.173-.434.26q-.244.086-.487.086m.004-8.825q.667 0 1.14-.476q.472-.475.472-1.143t-.476-1.14t-1.143-.472t-1.14.476t-.472 1.143t.475 1.14t1.144.472" />
                            </x-icon-details>
                        </x-group-details-event>


                    </div>
                    <hr class="border-gray-300 dark:border-gray-700 mt-2 mb-4" />

                    <div class="flex flex-col ">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 grid-flow-row">
                            <div class="col-span-1">
                                <x-group-details-event id="responsible-event" class="dark:text-white">
                                    <x-slot name="label">Responsable</x-slot>
                                    <x-icon-details viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12 2a5 5 0 1 0 5 5a5 5 0 0 0-5-5m0 8a3 3 0 1 1 3-3a3 3 0 0 1-3 3m9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z" />
                                    </x-icon-details>
                                </x-group-details-event>

                                <x-group-details-event id="phone-event" class="dark:text-white">
                                    <x-slot name="label">Teléfono o extensión</x-slot>
                                    <x-icon-details viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                            d="m449.366 89.648l-.685-.428l-86.593-42.661l-93.463 124.617l43 57.337a88.53 88.53 0 0 1-83.115 83.114l-57.336-43l-124.616 93.461l42.306 85.869l.356.725l.429.684a25.09 25.09 0 0 0 21.393 11.857h22.344a327.836 327.836 0 0 0 327.836-327.837v-22.345a25.08 25.08 0 0 0-11.856-21.393m-20.144 43.738c0 163.125-132.712 295.837-295.836 295.837h-18.08L87 371.76l84.18-63.135l46.867 35.149h5.333a120.535 120.535 0 0 0 120.4-120.4v-5.333l-35.149-46.866L371.759 87l57.463 28.311Z" />
                                    </x-icon-details>
                                </x-group-details-event>

                            </div>

                            <div class="col-span-1">
                                <x-group-details-event id="dependency-event" class="dark:text-white">
                                    <x-slot name="label">Dependencia</x-slot>
                                    <x-icon-details viewBox="0 0 24 24">
                                        <g fill="none" fill-rule="evenodd">
                                            <path
                                                d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                            <path fill="currentColor"
                                                d="M15 6a3 3 0 0 1-2 2.83V11h3a3 3 0 0 1 3 3v1.17a3.001 3.001 0 1 1-2 0V14a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v1.17a3.001 3.001 0 1 1-2 0V14a3 3 0 0 1 3-3h3V8.83A3.001 3.001 0 1 1 15 6m-3-1a1 1 0 1 0 0 2a1 1 0 0 0 0-2M6 17a1 1 0 1 0 0 2a1 1 0 0 0 0-2m12 0a1 1 0 1 0 0 2a1 1 0 0 0 0-2" />
                                        </g>
                                    </x-icon-details>
                                </x-group-details-event>

                                <x-group-details-event id="type-event" class="dark:text-white">
                                    <x-slot name="label">Tipo de evento</x-slot>
                                    <x-icon-details viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M7.5 13.5v-1h9v1zm0 4v-1h6v1zM4 21V5h3.385V2.77h1.077V5h7.154V2.77h1V5H20v16zm1-1h14v-9.384H5zM5 9.615h14V6H5zm0 0V6z" />
                                    </x-icon-details>
                                </x-group-details-event>
                            </div>
                        </div>




                        <hr class="border-gray-300 dark:border-gray-700 mt-2 mb-4" />

                        <x-group-details-event-textarea id="notes-protocolo" class="dark:text-white">
                            <x-slot name="label">Notas para Protocolo</x-slot>
                            <x-icon-details viewBox="0 0 24 24">
                                <path fill="currentColor" d="M3 18v-2h12v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                            </x-icon-details>
                        </x-group-details-event-textarea>


                        <x-group-details-event-textarea id="notes-cta" class="dark:text-white">
                            <x-slot name="label">Notas para CTA</x-slot>
                            <x-icon-details viewBox="0 0 24 24">
                                <path fill="currentColor" d="M3 18v-2h12v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                            </x-icon-details>
                        </x-group-details-event-textarea>

                        <x-group-details-event-textarea id="notes-general-services" class="dark:text-white">
                            <x-slot name="label">Notas para Servicios Generales</x-slot>
                            <x-icon-details viewBox="0 0 24 24">
                                <path fill="currentColor" d="M3 18v-2h12v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                            </x-icon-details>
                        </x-group-details-event-textarea>

                    </div>
                </div>




            </section>


        </main>

        <footer class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-0 grid-flow-row md:space-x-3 [&>div]:mt-2 border-t-2 border-gray-300 dark:border-gray-700">
            @if (auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin')))

                @if (auth()->user()->hasPermissionTo('delete event'))
                    <div class="col-span-1 flex flex-col gap-3">

                        <form action="" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <x-delete-button class="w-full" type="submit">
                                Eliminar
                            </x-delete-button>
                        </form>

                        <form action="" method="POST" id="deleteAllForm">
                            @csrf
                            @method('DELETE')
                            <x-delete-button type="submit" class="w-full">
                                Eliminar todos los eventos relacionados
                            </x-delete-button>
                        </form>                        
                    </div>
                @endif


                @if (auth()->user()->hasPermissionTo('update event'))
                    <div class="col-span-1 flex flex-col gap-3">
                        
                        <x-edit-link-button id="btn-edit-protocolo" class="full">
                            Editar evento
                        </x-edit-link-button>

                        <x-edit-link-button id="btn-edit-all-protocolo" class="full">
                            Editar todos los eventos relacionados
                        </x-edit-link-button>

                    </div>
                @endif

            @endif

        </footer>

    </div>


    </div>
</x-modal>
