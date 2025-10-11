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
            <h2 class="ml-2 text-2xl font-bold">Mi perfil </h2>
        </div>
    </x-slot>




    <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg dark:text-white max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 mt-5">
        <div class="hidden cont-error">
            <x-alert type="danger">
                <x-slot name="title">¡Ups! paraece que algo salio mal</x-slot>
                <p id="text-error"> .... </p>
            </x-alert>

        </div>
        <div class="dark:border-gray-700 user-data">
            <p class="text-xl ms-4 font-bold mb-2">Detalles de mi perfil</p>

            <hr class="mb-4 border-gray-500 dark:border-gray-700 ms-3" />

            <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mt-5 mb-5">
                {{-- border-2 border-indigo-600 --}}
                <div class="md:col-span-1 col-span-2">

                    <x-group-details-event id="name">
                        <x-slot name="label">Nombre</x-slot>

                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            viewBox="0 0 24 24">
                            <path fill="#6B749C"
                                d="M12 4.75a2.25 2.25 0 1 0 0 4.5a2.25 2.25 0 0 0 0-4.5M8.25 7a3.75 3.75 0 1 1 7.5 0a3.75 3.75 0 0 1-7.5 0m1.064 5.819c.132.098.302.213.505.327c.513.29 1.265.59 2.18.59s1.668-.3 2.181-.59c.203-.114.373-.229.505-.327q.282.075.559.166l.96.315c.72.237 1.264.812 1.458 1.523l.397 2.864c.075.544-.21.939-.606 1.033c-1.047.25-2.812.53-5.453.53s-4.407-.28-5.454-.53c-.395-.094-.68-.489-.606-1.033l.397-2.864A2.23 2.23 0 0 1 7.796 13.3l.96-.315q.276-.09.558-.166m.71-1.355l-.291-.287l-.402.092q-.526.12-1.044.291l-.96.315a3.72 3.72 0 0 0-2.454 2.616l-.01.04l-.408 2.95c-.161 1.164.462 2.393 1.744 2.698c1.17.279 3.052.571 5.8.571c2.749 0 4.631-.292 5.801-.57c1.282-.306 1.906-1.535 1.745-2.698l-.409-2.95l-.01-.04a3.72 3.72 0 0 0-2.455-2.617l-.959-.315q-.517-.17-1.044-.29l-.402-.093l-.29.286l-.001.001a2 2 0 0 1-.12.101a3 3 0 0 1-.41.274a2.96 2.96 0 0 1-1.445.397a2.96 2.96 0 0 1-1.445-.397a3.2 3.2 0 0 1-.53-.375" />
                        </svg>
                    </x-group-details-event>

                    <p class="ms-11 mb-7"> {{ Auth::user()->name }}</p>



                    <x-group-details-event id="date">
                        <x-slot name="label">Fecha de ingreso</x-slot>

                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            viewBox="0 0 24 24">
                            <path fill="#6B749C"
                                d="M22 2.25h-3.25V.75a.75.75 0 0 0-1.5-.001V2.25h-4.5V.75a.75.75 0 0 0-1.5-.001V2.25h-4.5V.75a.75.75 0 0 0-1.5-.001V2.25H2a2 2 0 0 0-2 1.999v17.75a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V4.249a2 2 0 0 0-2-1.999M22.5 22a.5.5 0 0 1-.499.5H2a.5.5 0 0 1-.5-.5V4.25a.5.5 0 0 1 .5-.499h3.25v1.5a.75.75 0 0 0 1.5.001V3.751h4.5v1.5a.75.75 0 0 0 1.5.001V3.751h4.5v1.5a.75.75 0 0 0 1.5.001V3.751H22a.5.5 0 0 1 .499.499z" />
                            <path fill="#6B749C"
                                d="M5.25 9h3v2.25h-3zm0 3.75h3V15h-3zm0 3.75h3v2.25h-3zm5.25 0h3v2.25h-3zm0-3.75h3V15h-3zm0-3.75h3v2.25h-3zm5.25 7.5h3v2.25h-3zm0-3.75h3V15h-3zm0-3.75h3v2.25h-3z" />
                        </svg>

                    </x-group-details-event>
                    <p class="ms-10">
                        {{ ucfirst(\Carbon\Carbon::parse(Auth::user()->created_at)->locale('es')->isoFormat('dddd, LL')) }}
                    </p>

                </div>

                <div class="md:col-span-1 col-span-2">
                    <x-group-details-event id="user-name">
                        <x-slot name="label">Nombre de usuario</x-slot>

                        <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            viewBox="0 0 24 24">
                            <g fill="none" stroke="#6B749C" stroke-width="1.5">
                                <circle cx="12" cy="9" r="3" />
                                <path stroke-linecap="round"
                                    d="M17.97 20c-.16-2.892-1.045-5-5.97-5s-5.81 2.108-5.97 5" />
                                <path stroke-linecap="round"
                                    d="M7 3.338A9.95 9.95 0 0 1 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12c0-1.821.487-3.53 1.338-5" />
                            </g>
                        </svg>

                    </x-group-details-event>
                    <p class="ms-10 mb-7"> {{ Auth::user()->user_name }}</p>

                    <div class="flex">

                        <x-secondary-button id="Btn-change">
                            Contraseña
                            <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                viewBox="0 0 15 15">
                                <path fill="none" stroke="#ffffff"
                                    d="M12.5 8.5v-1a1 1 0 0 0-1-1h-10a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-1m0-4h-4a2 2 0 1 0 0 4h4m0-4a2 2 0 1 1 0 4m-9-6v-3a3 3 0 0 1 6 0v3m2.5 4h1m-3 0h1m-3 0h1" />
                            </svg>
                        </x-secondary-button>

                    </div>
                </div>

            </div>

        </div>





        @include('profile.modal-change-password')

    </div>


    @vite('resources/js/profile/profile.js')

</x-app-layout>
