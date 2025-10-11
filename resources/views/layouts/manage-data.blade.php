<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between dark:text-white items-center">
            @if (isset($title))
                <h2 class="text-2xl font-bold">{{ $title }}</h2>
            @endif

            @if (isset($button))
                {{ $button }}
            @endif
        </div>
    </x-slot>

    <x-slot name="styles">
        @vite('resources/css/gridJs.css')
    </x-slot>


    <header class="bg-white dark:bg-gray-800 shadow max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 mt-5 rounded mb-5">
        <ul class="flex dark:text-white">
            <x-nav-link-secondary :href="route('agenda.event-types.index')" :active="request()->routeIs('agenda.event-types.index')">Tipo de eventos</x-nav-link-secondary>
            <x-nav-link-secondary :href="route('agenda.dependencies.index')" :active="request()->routeIs('agenda.dependencies.index')">{{ $program }}</x-nav-link-secondary>
            <x-nav-link-secondary :href="route('agenda.places.index')" :active="request()->routeIs('agenda.places.index')">Lugares</x-nav-link-secondary>
        </ul>
    </header> 

    <div class="bg-white dark:bg-gray-800 shadow max-w-7xl p-5 mx-auto mt-5 rounded">
        {{ $slot }}
    </div>

    @if (isset($script))
        {{ $script }}
    @endif

</x-app-layout>