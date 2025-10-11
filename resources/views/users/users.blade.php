<x-app-layout>
    <x-slot name="header">
        <div class="flex dark:text-white items-center gap-3 justify-between">
            <h2 class="ml-2 text-2xl font-bold">Lista de usuarios</h2>

            <x-tertiary-link-button href="{{ route('users.create') }}">
                <span>Agregar usuario</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19c0-2.21-2.686-4-6-4s-6 1.79-6 4m16-3v-3m0 0v-3m0 3h-3m3 0h3M9 12a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                </svg>
            </x-tertiary-link-button>
            {{-- <x-tertiary-button>
                <a href="{{ route('users.create') }}">Agregar usuario</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19c0-2.21-2.686-4-6-4s-6 1.79-6 4m16-3v-3m0 0v-3m0 3h-3m3 0h3M9 12a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                </svg>
            </x-tertiary-button> --}}
        </div>
    </x-slot>

    {{-- Estilos Para la tabla --}} 
    @vite('resources/css/gridJs.css')

    <div class="bg-white dark:bg-gray-800 shadow max-w-7xl p-10 mx-auto mt-5 rounded">

        @if (session('success'))
            <x-alert type="success">
                <x-slot name="title">¡Éxito!</x-slot>
                {{ session('success') }}
            </x-alert>
        @endif

        <div id="tableUsers"></div>
    </div>

    @vite('resources/js/users.js')
    

</x-app-layout>
